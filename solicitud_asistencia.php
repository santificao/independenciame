<?php

/**En esta página se concentra el kit del proyecto
 * Nos encontramos con 3 posibilidades:
 * 1) Rellenar el Seleccionar el tipo de solicitud que necesita el paciente
 * 2) Cruzar datos del paciente con los trabajadores registrados (distancia, tipo de perfil de cada uno, disponibilidad ...)
 * 3) Enviar la solicitud
 */


// 3) Se envía la solicitud y nos redirige a la página de inicio
if(isset($_POST["envia_solicitud"])) {
    $id_paciente = $_SESSION["usuario"]["id"];
    $id_trabajador = $_POST["id_trabajador"];
    $tipo_asistencia = $_POST["tipo_asistencia"];
    $fecha = date("Y-m-d");

    $prod_data = array("id_paciente" => $id_paciente, "id_trabajador" => $id_trabajador, "fecha_solicitud" => $fecha, "tipo_solicitud" => $tipo_asistencia);

    $solicitud = new solicitud();

    if (isset($_COOKIE["solicitud_enviada"]) && $_COOKIE["solicitud_enviada"] == $id_paciente) {
    ?>
    <article class="solicitud-enviada-informacion">
        <div class="error-solicitud">
            <h2>Tienes que esperar 1 minuto antes de poder enviar una nueva solicitud</h2>

            <input class="boton" id="volver" type="button" value="Volver">
        </div>
    </article>
    <?php
    } else {
        //$solicitud->set($prod_data);
        setcookie("solicitud_enviada", $id_paciente, time() + 5);
    ?>
    <article class="solicitud-enviada-informacion">
        <div class="solicitud-enviada">
            <div class="mensaje-solicitud">
                <h2>Solicitud enviada</h2>

                <input class="boton" id="volver" type="button" value="Volver">
            </div>
        </div>
    </article>
    <?php
    }
} else {

    //2) Cruzamos datos paciente trabajador
if (isset($_POST["inicia_solicitud"])) {
    $grado = $_SESSION["usuario"]["grado_dependencia"];
    $tipo_asistencia = $_POST["tipo_asistencia"];

    if ($grado == 3) {
        //Mostramos textarea para rellenar y se genera PDF del resumen de la solicitud con datos del usuario
    
    } else {
        $listado = array();
        $pos = 0;

        $direccion_paciente = formatear_direccion($_SESSION["usuario"]["direccion"], $_SESSION["usuario"]["ciudad"]);
        $geo_paciente = obtener_longitud_latitud($direccion_paciente);

        $trabajador=new Trabajador();
        $trabajadores = $trabajador->get_Todos();
        
        if(count($trabajadores)>0) {
            foreach ($trabajadores as $trabajador){
                //Lo primero comprobar si está visible
                if ($trabajador["visible"] == 1) {
                    //Comprobamos que se cumplan requisitos
                    $tipo_trabajador = $trabajador["tipo_trabajador"];
                    if (($tipo_asistencia <= 2) || $tipo_asistencia > 2 && $tipo_trabajador != 1)   {
                        //Comprobamos la distancia con la geolocalización
                        $direccion = formatear_direccion($trabajador["direccion"], $ciudad = $trabajador["ciudad"]); 
                
                        $geo_trabajador = obtener_longitud_latitud($direccion);

                        if ($geo_trabajador["latitud"] >= $geo_paciente["latitud"] - 0.20 && $geo_trabajador["latitud"] <= $geo_paciente["latitud"] + 0.20 && $geo_trabajador["longitud"] >= $geo_paciente["longitud"] - 0.20 && $geo_trabajador["longitud"] <= $geo_paciente["longitud"] + 0.20) {                     

                            $distancia = obtener_distancia_km($geo_paciente["latitud"],$geo_paciente["longitud"],$geo_trabajador["latitud"],$geo_trabajador["longitud"]);
                            $listado[$pos++] = array("nombre" => $trabajador["nombre"]." ".$trabajador["apellido_1"], "direccion" => $trabajador["direccion"], "ciudad" => $trabajador["ciudad"], "distancia" => $distancia, "id"=>$trabajador["id_usuario"],"imagen" => $trabajador["url_imagen"]);
                        
                        }
                    } 
                }
            }
        }  
        ?>

    <!--Muestra si hay o no trabajadores disponibles-->
    <article class="trabajadores-disponibles contenido ">
        <h2>PASO 2</h2>
    
    <?php
        if (empty($listado)) {
            $alerta = generar_alerta("Lo sentimos... no hemos encontrado ningún asistente cerca disponible, nos pondremos en contacto contigo lo antes posible", "error");
            echo $alerta;
        } else {
    ?>
            <h2>¡Bien! Hemos encontrado <?php echo count($listado) ?> asistente/s disponible/s cerca de tí</h2>
            <article class="trabajadores-disponibles-listado contenido">
    <?php
            foreach($listado as $trabajador) {
    ?>
            <div class="datos-trabajador-disponible">
                <img src="<?php echo $trabajador["imagen"] ?>" alt="asistente de personas con dependencia">
                <p><span>Nombre: </span><?php echo $trabajador["nombre"] ?></p>
                <p><span>Direccion: </span><?php echo $trabajador["direccion"] ?></p>
                <p><span>Ciudad: </span><?php echo $trabajador["ciudad"] ?></p>
                <p><span>Distancia aproximada: </span><?php echo $trabajador["distancia"] ?> Km</p>
                <form class="formulario" action="<?php $_SERVER["PHP_SELF"]?>" method="post">
                    <input type="hidden" name="tipo_asistencia" value="<?php echo $tipo_asistencia?>">
                    <input type="hidden" name="id_trabajador" value="<?php echo $trabajador["id"]?>">
                    <input class="boton-submit boton-extrecho" type="submit" value="Enviar solicitud" name="envia_solicitud">
                </form>
            </div>
    <?php
            }
        }
    echo "</article>";
    echo "</article>";
    }
} else {
    //1) Select desplegable para seleccionar el tipo de asistencia que se necesita
?>
<article class="solicitud-asistencia contenido">
        <h2>PASO 1</h2>
        <h2><?php echo $_SESSION["usuario"]["nombre"]?>, ¿qué tipo de asistencia necesitas?</h2>

        <form class="formulario" action="<?php $_SERVER["PHP_SELF"]?>" method="post">
            <label for="tipo_asistencia">Selecciona la opción más adecuada a tus necesidades:</label>
            <select name="tipo_asistencia" id="select-tipo-asistencia">
                <option value="1">Teleasistencia</option>
                <option value="2">Básica (recados, ayuda hogar...)</option>
                <option value="3">Intermedia (cuidados higiénicos/médicos)</option>
                <option value="4">Alta (cuidados gran dependencia)</option>            
            </select>

            <input class="boton-submit" type="submit" value="Iniciar busqueda" name="inicia_solicitud">
        </form>    
</article>
<?php
}
}
?>