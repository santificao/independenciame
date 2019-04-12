<?php

class mensaje extends DBAbstractModel {
    private $id_mensaje;
    private $id_origen;
    private $id_destino;
    private $contenido;
    private $fecha_mensaje;

    function __construct() {
        $this->db_name = 'independenciame';	
    }

    public function getHilo($id_mia, $id_remota) {
        $this->query = "
        SELECT * FROM mensaje
        WHERE id_origen = $id_mia AND id_destino = $id_remota OR id_origen = $id_remota AND id_destino = $id_mia
        ";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getHiloNuevos($id_mia, $id_remota, $time) {

    }

    public function get($id_usuario = ""){
        $this->query = "
        SELECT * FROM mensaje
        WHERE id_destino = $id_usuario OR id_origen = $id_usuario
        ";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function set($id_remota = "", $id_mia = "", $contenido = "") {
        $this->query = "
        INSERT INTO mensaje (id_origen, id_destino, contenido, fecha_mensaje) 
        VALUES ($id_mia, $id_remota, '$contenido', '2019-12-04')
        ";
        $this->execute_single_query();
    }
    
    public function edit() {

    }
    
	public function delete(){

    }

}


?>