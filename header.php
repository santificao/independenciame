<?php
require("modelo/db_abstract_model.php");
require("modelo/modelo_usuario.php");
require("modelo/modelo_trabajador.php");
require("modelo/modelo_paciente.php");
require("libreria_de_clases/utilidades.php");
require("libreria_de_clases/sesion.php");

session_start();

if (isset($_POST["inicia_sesion"])) {
    $nombreUsuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    $usuario = new Usuario();
    $usuario->get($nombreUsuario, $contraseña);
    
    if ($usuario->nombre != "") {  
        Sesion::inicia_sesion($usuario);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <title>IndependenciaMe</title>
</head>

<body>
    <header>
        <div class="barra contenido">
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
                    <li><a href="index.php?p=2">Mensajes</a></li>
                    <li><a href="index.php?p=3">Notificaciones</a></li>
                    <li><a href="index.php?p=4">Configuración</a></li>

                    <?php
                    if ($_SESSION["usuario"]["tipo_usuario"] == "C") {
                    ?>  
                     <li><a href="index.php?p=5">Solicitar ayuda</a></li>
                    <?php
                    }
                    ?>

                    <li><a href="index.php?p=6">Cerrar sesión</a></li>
                </ul>
                <span class="menu-movil"><img src="<?php echo $_SESSION["usuario"]["url_imagen"]?>"> <i class="fas fa-angle-down"></i></span> 
                <?php
                }
                ?>
            </nav>
        </div>
    </header>
<main>