<?php

/**En esta página se concentra el kit del proyecto
 * Nos encontramos con 2 posibilidades:
 * 1) Rellenar el Seleccionar el tipo de solicitud que necesita el paciente
 * 2) Enviar la solicitud
 */


// 2) Se envía la solicitud
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
        $solicitud->set($prod_data);
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
    //1) Select desplegable para seleccionar el tipo de asistencia que se necesita
?>
<article id="ventana-asistencia" class="solicitud-asistencia contenido">
        <h2><?php echo $_SESSION["usuario"]["nombre"]?>, ¿qué tipo de asistencia necesitas?</h2>

        <form class="formulario formulario-solicitud-asistencia" onSubmit="solicitarAsistencia(event)" action="<?php $_SERVER["PHP_SELF"]?>" method="post">
            <label for="tipo_asistencia">Selecciona la opción más adecuada a tus necesidades:</label>
            <select name="tipo_asistencia" id="select-tipo-asistencia">
                <option value="1">Teleasistencia</option>
                <option value="2">Básica (recados, ayuda hogar...)</option>
                <option value="3">Intermedia (asistencia higiénico/sanitaria)</option>
                <option value="4">Alta (pacientes con gran dependencia)</option>            
            </select>

            <input class="boton-submit" type="submit" value="Iniciar busqueda" name="inicia_solicitud">
        </form>    
</article>
<?php
}
?>