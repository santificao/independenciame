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

    public function get_todos() {
		$this->query = "
		SELECT *
		FROM solicitud_asistencia";
		$this->get_results_from_query();
		return $this->rows;
    }
    
    public function get() {}
    public function delete() {}
    public function edit() {}
    
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