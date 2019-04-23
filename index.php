<?php
include_once("header.php");

$p = 0;

if(isset($_SESSION["usuario"])) {

    if (isset($_GET["p"])) {
        $p = $_GET["p"];
        if ($p < 0 || $p > 6) {
            $p = 1;
        }
    } else {
        $p = 1;
    } 

    switch($p) {
        case 1: 
            include_once("panel_principal.php");
            break;
        case 2:
            include_once("mensajes.php");
            break;
        case 3:
            include("notificaciones.php");
            break;
        case 4:
            include("configuracion.php");
            break;
        case 5:
            include("solicitud_asistencia.php");
            break;
        case 6: 
            include("cerrar_sesion.php");
            break;
    }
} else  {

    if (isset($_GET["p"])) {
        $p = $_GET["p"];
        if ($p < 0 || $p > 3) {
            $p = 0;
        }
    }   

    switch($p) {
        case 0: include_once("presentacion_inicio.php");
            break;
        case 1: include_once("iniciar_sesion.php");
            break;
        case 2: include_once("registro_usuario.php");
            break;
        case 3: include_once("registro_empleado.php");
            break;
    }
}

include_once("footer.php");
?>