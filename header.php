<?php
require_once("modelo/db_abstract_model.php");
require_once("modelo/modelo_usuario.php");
require_once("modelo/modelo_trabajador.php");
require_once("modelo/modelo_solicitud.php");
require_once("modelo/modelo_paciente.php");
require_once("modelo/modelo_mensaje.php");
require_once("libreria_de_clases/utilidades.php");
require_once("libreria_de_clases/sesion.php");

session_start();

if (isset($_POST["inicia_sesion"])) {
    $nombreUsuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    $usuario = new Usuario();
    $usuario->get($nombreUsuario, $contraseña);
    
    
    if ($usuario->nombre != "") { 
        if ($usuario->gestionado == 1) {
            Sesion::inicia_sesion($usuario);
        } else if ($usuario->gestionado == -1) {
            $alerta = generar_alerta("Lo sentimos, tu solicitud ha sido cancelada...", "error");
        } else {
            $alerta = generar_alerta("Se está gestionando tu solicitud, en breve pasarás a formar parte de nuestra comunidad", "error");
        }  
    } else {
        $alerta = generar_alerta("Usuario o contraseña incorrectos", "error");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css?family=Oswald|PT+Sans|Schoolbell" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/lightbox.min.css">
    <link rel="icon" href="img/favicon.png" type="image/png">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <meta name="description" content="Independénciame es un sitio creado para ayudar a personas en situación de dependencia a ponerse en contacto con asistentes voluntarios y profesionales que les ayuden a superar su vida diaria" />
    <title>IndependenciaMe</title>
</head>

<body>
    <header>
        <div class="<?php
                if (isset($_SESSION["usuario"])) {
                echo "barra ";
                }
                ?>barra-inicio contenido">
            <div class="logo">
                <a href="index.php"><h1><span>In</span>dependencia<span>me</span>.org</h1></a> 
            </div>

            <nav>
                <?php
                if (!isset($_SESSION["usuario"])) {
                ?>
                <!--Menú de iniciar sesión-->
                <ul class="menu">
                    <li><a href="index.php?p=1">Iniciar sesión</a></li>
                    <li><a href="index.php?p=2">Crear cuenta persona dependiente</a></li>
                    <li><a href="index.php?p=3">Trabaja con nosotros</a></li>
                </ul>
                <span class="menu-movil"><i class="fas fa-bars"></i></span>
                <?php
                } else {
                ?>
                <!--Menú de sesión iniciada-->
                <ul class="menu menu-sesion">
                    <li><a href="index.php?p=1">Inicio</a></li>
                    <li><a href="index.php?p=2">Mensajes/Contactos</a></li>
                    <li><a href="index.php?p=3">Notificaciones</a></li>
                    <li><a href="index.php?p=4">Configuración</a></li>

                    <?php
                    if ($_SESSION["usuario"]["tipo_usuario"] == "C") {
                    ?>  
                     <li><a href="index.php?p=5">Solicitar asistencia</a></li>
                    <?php
                    } else if ($_SESSION["usuario"]["tipo_usuario"] == "A") {
                    ?>  
                     <li><a href="index.php?p=5">Nuevas solicitudes de usuario <?php
                     $usuario = new Usuario();
                     $nuevas = $usuario->get_hay_nuevas_solicitudes_usuarios();
                     if($nuevas) {
                         echo "<i class='far fa-bell'></i>";
                     }
                     ?></a></li>
                    <?php 
                    }
                    ?>

                    <li><a href="index.php?p=6">Cerrar sesión</a></li>
                </ul>
                <span class="menu-movil"><img src="<?php $usuario = new usuario(); echo $usuario->get_url_imagen($_SESSION["usuario"]["id"])[0]["url_imagen"]?>"> <i class="fas fa-angle-down"></i></span> 
                <?php
                }
                ?>
            </nav>
        </div>
    </header>
<main>