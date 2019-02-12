<?php

function calcular_edad($fecha) {
    $cumpleaños = new Datetime($fecha);
    $hoy = new DateTime();
    $edad = $hoy->diff($cumpleaños);
    
    return $edad->y;
}

function generar_alerta($mensaje, $clase){
    $alerta = "<p class='$clase'>$mensaje</p>";
    return $alerta;
}

?>