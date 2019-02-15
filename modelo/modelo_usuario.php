<?php

class Usuario extends DBAbstractModel {
	public $id_usuario;
	public $nombre;
	public $apellido_1;
    public $apellido_2;
    public $fecha_nacimiento;
    public $ciudad;
    public $direccion;
    public $telefono;
    public $email;
    public $dni;
    public $usuario;
    public $contrasenia;
    public $tipo_usuario;
    public $url_imagen;

	function __construct() {
		$this->db_name = 'independenciame';	
	}


	public function get($usuario='', $contrasenia = '') {
		if($usuario != '' && $contrasenia != '') {
			$this->query = "
			SELECT *
			FROM datos_usuario
			WHERE usuario = '$usuario' AND contrasenia = '$contrasenia'
			";
			$this->get_results_from_query();
        }

		if(count($this->rows) == 1) {
			foreach ($this->rows[0] as $propiedad=>$valor){
				$this->$propiedad = $valor;
			}
        } 
	}
	
	public function get_todos() {
		$this->query = "
		SELECT *
		FROM datos_usuario";
		$this->get_results_from_query();
		return $this->rows;
	}
	
	/**Hay que corregirlo */
	public function set($prod_data=array()) {
		if(array_key_exists('dni', $dni)) {
            
			$this->get($prod_data['cod_prod']); //leemos el producto por si existe, no crearlo de nuevo
			
			if($prod_data['cod_prod'] != $this->cod_prod) {
				foreach ($prod_data as $campo=>$valor) {
					$$campo = $valor;
                }
				$this->query = "
                INSERT INTO datos_usuario (apellido_1, apellido_2, ciudad, contrasenia, direccion, dni, email, fecha_nacimiento, nombre, telefono, tipo_usuario, usuario) 
                VALUES ('$apellido_1', '$apellido_2', '$ciudad', '$contrasenia','$direccion', '$dni', '$email', '$fecha_nacimiento', '$nombre', '$telefono', '$tipo_usuario', '$usuario')
				";
				$this->execute_single_query();
            }
        }
	}


    /**Hay que corregirlo */
	public function edit($prod_data=array()) {
		foreach ($prod_data as $campo=>$valor):
			$$campo = $valor;
		endforeach;
		$this->query = "
			UPDATE productos
			SET pvp='$pvp',
			descripcion='$descripcion',
			existencias='$existencias'
			WHERE cod_prod = '$cod_prod'
		";
		$this->execute_single_query();
		}
        
	/**Hay que corregirlo*/
	public function delete($cod_prod='') {
		$this->query = "
		DELETE FROM productos
		WHERE cod_prod = '$cod_prod'
		";
		$this->execute_single_query();
	}
	/**Hay que corregirlo*/
	public function buscar($nombre) {
		$this->query = "
			SELECT * FROM datos_usuario
			WHERE nombre LIKE '%$nombre%'
		";
		$this->get_results_from_query();
		return $this->rows;
	}
}
?>