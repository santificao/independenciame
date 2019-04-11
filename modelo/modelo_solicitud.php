<?php

class solicitud extends DBAbstractModel {
    public $fecha_solicitud;
    public $id_paciente;
    public $id_solicitud;
    public $id_trabajador;
    public $tipo_solicitud;
    public $aceptada;
    public $leida;


    function __construct() {
        $this->db_name = 'independenciame';	
    }

    public function get_cuantas_solicitudes_nuevas($id, $tipo_usuario) {
        if ($tipo_usuario == "C") {
            $this->query = "
            SELECT *
            FROM solicitud_asistencia
            WHERE id_paciente = $id AND aceptada != 0 AND leida = 0";
        } else {
            $this->query = "
            SELECT *
            FROM solicitud_asistencia
            WHERE id_trabajador = $id AND aceptada = 0";
        }
      
        $this->get_results_from_query();
        
		return count($this->rows);
    }

    public function get_solicitudes_nuevas($id, $tipo_usuario) {
		if ($tipo_usuario == "C") {
            $this->query = "
            SELECT *
            FROM solicitud_asistencia
            WHERE id_paciente = $id AND aceptada != 0 AND leida = 0";
        } else {
            $this->query = "
            SELECT *
            FROM solicitud_asistencia
            WHERE id_trabajador = $id AND aceptada = 0";
        }
		$this->get_results_from_query();
		return $this->rows;
    }

    public function get_listado_solicitudes_aceptadas($id, $tipo_usuario) {
        if ($tipo_usuario == "C") {
            $this->query = "
            SELECT *
            FROM solicitud_asistencia
            WHERE id_paciente = $id AND aceptada = 1";
        } else {
            $this->query = "
            SELECT *
            FROM solicitud_asistencia
            WHERE id_trabajador = $id AND aceptada = 1";
        }
		$this->get_results_from_query();
		return $this->rows; 
    }
    
    public function get() {}
    public function delete() {}
    public function edit($id_solicitud = "", $accion = "") {
        switch($accion) {
            case "aceptar":
                $respuesta = 1;
                break;
            case "rechazar":
                $respuesta = 2;
                break;
        }
        if ($accion == 'aceptar' || $accion == 'rechazar') {
            $this->query = "
                UPDATE solicitud_asistencia SET aceptada = $respuesta WHERE id_solicitud = $id_solicitud
            ";
        } else {
            $this->query = "
                UPDATE solicitud_asistencia SET leida = 1 WHERE id_solicitud = $id_solicitud
            "; 
        }
        
        $this->execute_single_query();
    }
    
    public function set($prod_data=array()) {
            foreach ($prod_data as $campo=>$valor) {
                $$campo = $valor;
            }
            $this->query = "
            INSERT INTO solicitud_asistencia (fecha_solicitud, id_paciente, id_trabajador, tipo_solicitud) 
            VALUES ('$fecha_solicitud', '$id_paciente', '$id_trabajador', '$tipo_solicitud')
            ";

            $this->execute_single_query();
    }

}

?>