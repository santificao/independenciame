<?php
if (isset($_POST["aceptar_solicitud"]) || isset($_POST["rechazar_solicitud"])) {
    if (isset($_POST["aceptar_solicitud"])) {
        $accion = "aceptar";
    } else {
        $accion = "rechazar";
    }
    
    $id_solicitud = $_POST["id_solicitud"];

    $solicitud = new solicitud();

    $solicitud->edit($id_solicitud, $accion);

} else if (isset($_POST["leido"])) {
    $id_solicitud = $_POST["id_solicitud"];

    $solicitud = new solicitud();
    $accion = 'leida';

    $solicitud->edit($id_solicitud, $accion);
} 

    $solicitud = new solicitud();
    $cont = 0;
    $listado_solicitudes = array();

    $solicitudes = $solicitud->get_solicitudes_nuevas( $_SESSION["usuario"]["id"],  $_SESSION["usuario"]["tipo_usuario"]);

    if ($_SESSION["usuario"]["tipo_usuario"] != "C") {
        foreach($solicitudes as $solicitud) {
            $listado_solicitudes[$cont++] = array("id_paciente" => $solicitud["id_paciente"], "tipo_solicitud" => $solicitud["tipo_solicitud"], "fecha" => $solicitud["fecha_solicitud"], "id_solicitud" =>$solicitud["id_solicitud"]);
        }
?>
<!--Se pintan las notificaciones nueva que haya si el tipo usuario es trabajador-->
<article class="notificaciones contenido">
<?php
    if (empty($listado_solicitudes)) {
        echo "<h2>No tiene ninguna notificación</h2>";
    } else {
        echo "<h2>Solicitudes pendientes</h2>";
        foreach($listado_solicitudes as $solicitud) {
            $paciente = new Paciente();
            $paciente->datos_paciente($solicitud["id_paciente"]);
            ?>
            <div class="solicitud">
                <p><span>Paciente: </span> <?php echo $paciente->nombre." ".$paciente->apellido_1?></p>        
                <p><span>Domicilio: </span> <?php echo $paciente->ciudad.", ".$paciente->direccion?></p>
                <p><span>Fecha de solicitud: </span> <?php echo $solicitud["fecha"]?></p>
                <p><span>Tipo de solicitud: </span>    
                <?php 
                    switch($solicitud["tipo_solicitud"]) {
                        case 1:
                            echo "Teleasistencia";
                            break;
                        case 2:
                            echo "Ayuda hogar, tramites burocráticos, ...";
                            break;
                        case 3:
                            echo "Asistencia de cuidados o médica";
                            break;
                    }
                ?></p>
                <form class="formulario" action="<?php $_SERVER["PHP_SELF"]?>" method="post">
                    <input type="hidden" name="id_solicitud" value="<?php echo $solicitud["id_solicitud"]?>">
                    <input class="boton-submit boton-extrecho aceptar" type="submit" value="Aceptar" name="aceptar_solicitud">
                    <input class="boton-submit boton-extrecho rechazar" type="submit" value="Rechazar" name="rechazar_solicitud">
                </form>
            </div>
        <?php
            }
        }   
    } else {
        foreach($solicitudes as $solicitud) {
            $listado_solicitudes[$cont++] = array("id_trabajador" => $solicitud["id_trabajador"], "tipo_solicitud" => $solicitud["tipo_solicitud"], "fecha" => $solicitud["fecha_solicitud"], "resolucion" =>$solicitud["aceptada"],  "id_solicitud" =>$solicitud["id_solicitud"]);
        }
        ?>
    <!--Se pintan las notificaciones nueva que haya si el tipo usuario es paciente-->
    <article class="notificaciones contenido">
    <?php

    if (empty($listado_solicitudes)) {
        echo "<h2>No tienes ninguna notificación</h2>";
    } else {
        echo "<h2>Tus notificaciones</h2>";
        foreach($listado_solicitudes as $solicitud) {
            $trabajador = new Trabajador();
            $trabajador->datos_trabajador($solicitud["id_trabajador"]);
            ?>
            <div class="solicitud">
                <p><span>El trabajador <?php echo $trabajador->nombre." ".$trabajador->apellido_1?> que vive en <?php echo $trabajador->ciudad.", ".$trabajador->direccion?> ha </span><?php if ($solicitud["resolucion"] == 1) echo "aceptado"; else echo "<span class='rechazada'>rechazado</span>"?> <span> su solicitud</span></p>
                <p><span>Fecha de solicitud: <?php echo $solicitud["fecha"]?></span></p>
                <p><span>Tipo de solicitud:  
                <?php 
                    switch($solicitud["tipo_solicitud"]) {
                        case 1:
                            echo "Teleasistencia";
                            break;
                        case 2:
                            echo "Ayuda hogar, tramites burocráticos, ...";
                            break;
                        case 3:
                            echo "Asistencia sanitaria/cuidados médicos";
                            break;
                    }
                ?></span></p>
                <form class="formulario" action="<?php $_SERVER["PHP_SELF"]?>" method="post">
                    <input type="hidden" name="id_solicitud" value="<?php echo $solicitud["id_solicitud"]?>">
                    <input class="boton-submit boton-extrecho aceptar" type="submit" value="Leido" name="leido">
             </form>
            </div>
            <?php
            }
        }

}

?>
</article>