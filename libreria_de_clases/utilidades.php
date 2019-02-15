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

function formatear_direccion($direccion, $ciudad) {
    $direccion = str_replace("á", "a", $direccion);
    $direccion = str_replace("é", "e", $direccion);
    $direccion = str_replace("í", "i", $direccion);
    $direccion = str_replace("ó", "o", $direccion);
    $direccion = str_replace("ú", "u", $direccion);
    $direccion = str_replace("Á", "a", $direccion);
    $direccion = str_replace("É", "e", $direccion);
    $direccion = str_replace("Í", "i", $direccion);
    $direccion = str_replace("Ó", "o", $direccion);
    $direccion = str_replace("Ú", "u", $direccion);
    $direccion = str_replace(" ", "%20", $direccion);
    $direccion = str_replace(",", "%20", $direccion);
    
    $direccion.="%20".$ciudad;

    return $direccion;
}

function obtener_longitud_latitud($direccion) {
    $key = "50d660e7c8de47a183b05ea29a9c4bfe";
    $url = "https://api.opencagedata.com/geocode/v1/json?q=$direccion&key=$key&language=es&pretty=1";

    $ch = curl_init();

    // defino la URL a la que hacemos la petición
    curl_setopt($ch, CURLOPT_URL,$url);

    // indico el tipo de petición: GET
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
     
    // recibimos la respuesta y la guardamos en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $remote_server_output = curl_exec ($ch);
    curl_close ($ch);

    $respuesta = json_decode($remote_server_output);

    $datos = array("latitud"=> $respuesta->results[0]->geometry->lat, "longitud" => $respuesta->results[0]->geometry->lng);

    return $datos; 

}

function obtener_distancia_km ($lat1, $long1, $lat2, $long2) {
$tierra = 6371; //km de diámetro


//Coordenadas punto 1
$lat1 = deg2rad($lat1);
$long1= deg2rad($long1);

//Coordenadas punto 2
$lat2 = deg2rad($lat2);
$long2= deg2rad($long2);

//Formula
$dlong=$long2-$long1;
$dlat=$lat2-$lat1;

$senoLatitud=sin($dlat/2);
$senoLongitud=sin($dlong/2);

$a=($senoLatitud*$senoLatitud)+cos($lat1)*cos($lat2)*($senoLongitud*$senoLongitud);

$c=2*asin(min(1,sqrt($a)));

$distancia=round($tierra*$c, 1);

return $distancia;
}

?>