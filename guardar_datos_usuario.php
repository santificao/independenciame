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
$formacion = '';

if($tipo == 'paciente') {
    $tipo = 'C';
    $grado = $_POST['grado'];
} else {
    $tipo = 'B';
    $tipo_asistente = $_POST['tipoAsistente'];
    if ($tipo_asistente == 2) {
        $formacion = $_POST['formacion'];
    }
}
$usuario = $_POST['usuario'];
$contrasenia = $_POST['contrasenia'];

$usuario_guardar = array('nombre' => $nombre, 'apellido_1' => $apellido1, 'apellido_2' => $apellido2, 'fecha_nacimiento' => $fecha, 'ciudad' => $ciudad, 'direccion' => $direccion, 'telefono' => $telefono, 'email' => $email, 'dni' => $dni, 'usuario' => $usuario, 'contrasenia' => $contrasenia, 'tipo_usuario' => $tipo);

$user = new Usuario();
$msg = $user->set($usuario_guardar);

if ($msg == 'Ok') {
    $user = new Usuario();
    $user->get($usuario, $contrasenia);
    
    if ($tipo == 'C') {
        $paciente = new Paciente();
        $paciente->set_grado($user->id_usuario, $grado);
    } else {
        $trabajador = new Trabajador();
        $trabajador->set_tipo($user->id_usuario, $tipo_asistente, $formacion);
    }
    echo $msg;
} else {
    echo $msg;
}

?>