<?php
session_start();

include("modelo/db_abstract_model.php");
include("modelo/modelo_mensaje.php");

$id_mia = $_SESSION["usuario"]["id"];
$id_remota = $_GET["idRemota"];

if (isset($_GET["mensaje"])) {
    $contenido = $_GET["mensaje"];
    $mensaje = new Mensaje();
    $mensaje->set($id_remota, $id_mia, $contenido);
} else {
    $mensajes2JSON = array();

    $mensaje = new Mensaje();
    $mensajes = $mensaje->getHilo($id_mia, $id_remota);
    
    foreach ($mensajes as $mensaje) {
        if ($mensaje["id_origen"] == $id_mia) {
            array_push($mensajes2JSON, array("ubicar" => "R", "contenido" => $mensaje["contenido"]));
        } else {
            array_push($mensajes2JSON, array("ubicar" => "L", "contenido" => $mensaje["contenido"]));
        }
    }
    echo (json_encode($mensajes2JSON));
}
?>