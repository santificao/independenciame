<?php

function calcularEdad($fecha) {
    $cumpleaños = new Datetime($fecha);
    $hoy = new DateTime();
    $edad = $hoy->diff($cumpleaños);
    
    return $edad->y;
}

?>