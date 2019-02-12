<?php

class Paciente extends Usuario {

    public $id_usuario;
    public $grado_dependencia;

    public function datos_paciente($id_usuario) {
		$this->query = "
			SELECT grado_dependencia FROM paciente
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