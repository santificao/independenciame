<?php

class Trabajador extends Usuario {

    public $id_usuario;
    public $tipo_trabajador;
    public $visible;

    public function datos_trabajador($id_usuario) {
		$this->query = "
			SELECT * FROM trabajador
			WHERE id_usuario = '$id_usuario'
		";

        $this->get_results_from_query();
        
		if(count($this->rows) == 1) {
			foreach ($this->rows[0] as $propiedad=>$valor){
				$this->$propiedad = $valor;
			}
        } 
	}
}
?>