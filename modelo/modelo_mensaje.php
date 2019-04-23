<?php

class mensaje extends DBAbstractModel {
    private $id_mensaje;
    private $id_origen;
    private $id_destino;
    private $contenido;
    private $fecha_mensaje;
    private $timestamp;

    function __construct() {
        $this->db_name = 'independenciame';	
    }

    public function get_hilo($id_mia, $id_remota) {
        $this->query = "
        SELECT * FROM mensaje
        WHERE id_origen = $id_mia AND id_destino = $id_remota OR id_origen = $id_remota AND id_destino = $id_mia
        ";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function get_hilos_nuevos($id_mia, $id_remota) {
        $this->query = "
        SELECT * FROM mensaje
        WHERE id_origen = $id_remota AND id_destino = $id_mia AND leido = 0
        ";
        $this->get_results_from_query();
        return $this->rows;
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
        INSERT INTO mensaje (id_origen, id_destino, contenido, fecha_mensaje, leido) 
        VALUES ($id_mia, $id_remota, '$contenido', '2019-12-04', 0)
        ";
        $this->execute_single_query();
    }

    public function edit_leido($id) {
        $this->query = "
        UPDATE mensaje SET leido = 1 WHERE id_mensaje = $id
        ";
        $this->execute_single_query();
    }

    public function get_cuantos_mensajes_nuevos($id_mia) {
        $this->query = "
        SELECT DISTINCT id_origen FROM mensaje WHERE id_destino = $id_mia AND leido = 0 
        ";
        $this->get_results_from_query();

        return count($this->rows);
    }
    
    public function edit() {

    }
    
	public function delete(){

    }

}


?>