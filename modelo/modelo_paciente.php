<?php

class Paciente extends Usuario {

    public $id_usuario;
    public $grado_dependencia;

    public function datos_paciente($id_usuario) {
		$this->query = "
			SELECT * FROM paciente INNER JOIN datos_usuario
			ON paciente.id_usuario = datos_usuario.id_usuario
			WHERE paciente.id_usuario = '$id_usuario'
		";

        $this->get_results_from_query();
        
		if(count($this->rows) == 1) {
			foreach ($this->rows[0] as $propiedad=>$valor){
				$this->$propiedad = $valor;
			}
        } 
	}

	public function set_grado($id, $grado) {
		$this->query = "
        INSERT INTO paciente (id_usuario, grado_dependencia) 
        VALUES ($id, $grado)
		";
		$this->execute_single_query();
	}
}
?>