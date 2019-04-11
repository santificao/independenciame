<?php
session_start();

include("modelo/db_abstract_model.php");
include("modelo/modelo_usuario.php");
include("modelo/modelo_trabajador.php");
include("libreria_de_clases/utilidades.php");

    $grado = $_SESSION["usuario"]["grado_dependencia"];
    $tipo_asistencia = $_GET["tipo"];

        $listado = array();
        $pos = 0;

        $direccion_paciente = formatear_direccion($_SESSION["usuario"]["direccion"], $_SESSION["usuario"]["ciudad"]);
        $geo_paciente = obtener_longitud_latitud($direccion_paciente);

        $trabajador=new Trabajador();
        $trabajadores = $trabajador->get_Todos();
        
        if(count($trabajadores)>0) {
            $listado[$pos++] = Array ("nombre" => "tipo_asistencia" ,"tipo" => $tipo_asistencia);
            foreach ($trabajadores as $trabajador){
                //Lo primero comprobar si está visible
                if ($trabajador["visible"] == 1) {
                    //Comprobamos que se cumplan requisitos
                    $tipo_trabajador = $trabajador["tipo_trabajador"];
                    if (($tipo_asistencia <= 2) || $tipo_asistencia > 2 && $tipo_trabajador != 1)   {
                        //Comprobamos la distancia con la geolocalización
                        $direccion = formatear_direccion($trabajador["direccion"], $ciudad = $trabajador["ciudad"]); 
                
                        $geo_trabajador = obtener_longitud_latitud($direccion);

                        if ($geo_trabajador["latitud"] >= $geo_paciente["latitud"] - 0.20 && $geo_trabajador["latitud"] <= $geo_paciente["latitud"] + 0.20 && $geo_trabajador["longitud"] >= $geo_paciente["longitud"] - 0.20 && $geo_trabajador["longitud"] <= $geo_paciente["longitud"] + 0.20) {                     

                            $distancia = obtener_distancia_km($geo_paciente["latitud"],$geo_paciente["longitud"],$geo_trabajador["latitud"],$geo_trabajador["longitud"]);
                            $listado[$pos++] = array("nombre" => $trabajador["nombre"]." ".$trabajador["apellido_1"], "direccion" => $trabajador["direccion"], "ciudad" => $trabajador["ciudad"], "distancia" => $distancia, "id"=>$trabajador["id_usuario"],"imagen" => $trabajador["url_imagen"]);
                        
                        }
                    } 
                }
            }
        }
        echo json_encode ($listado);
?>