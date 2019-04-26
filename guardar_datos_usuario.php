<?php
require("modelo/db_abstract_model.php");
require("modelo/modelo_usuario.php");
require("modelo/modelo_trabajador.php");
require("modelo/modelo_paciente.php");

$nombre = $_POST['nombre'];
$apellido1 = $_POST['apellido1'];
$apellido2 = $_POST['apellido2'];
$fecha = $_POST['fecha'];
$ciudad = $_POST['ciudad'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$dni = $_POST['dni'];
$tipo = $_POST['tipo'];
$email = $_POST['email'];

if($tipo == 'paciente') {
    $tipo = 'C';
} else {
    $tipo = 'B';
}
$usuario = $_POST['usuario'];
$contrasenia = $_POST['contrasenia'];

$usuarioGuardar = array('nombre' => $nombre, 'apellido_1' => $apellido1, 'apellido_2' => $apellido2, 'fecha_nacimiento' => $fecha, 'ciudad' => $ciudad, 'direccion' => $direccion, 'telefono' => $telefono, 'email' => $email, 'dni' => $dni, 'usuario' => $usuario, 'contrasenia' => $contrasenia, 'tipo_usuario' => $tipo);

$usuario = new Usuario();

$usuario->set($usuarioGuardar);


?>