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
	public $gestionado;
	
	function __construct() {
		$this->db_name = 'independenciame';	
	}

	public function get_usuario_por_id($id) {
		$this->query = "
		SELECT *
		FROM datos_usuario
		WHERE id_usuario = '$id'
		";
		$this->get_results_from_query();

		if(count($this->rows) == 1) {
			foreach ($this->rows[0] as $propiedad=>$valor){
				$this->$propiedad = $valor;
			}
        } 
	}

	public function get_usuario_por_dni($dni) {
		$this->query = "
		SELECT *
		FROM datos_usuario
		WHERE dni = '$dni' AND gestionado != -1
		";
		$this->get_results_from_query();

		if(count($this->rows) != 0) {
			foreach ($this->rows[0] as $propiedad=>$valor){
				$this->$propiedad = $valor;
			}
        } 
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
	
	public function get_solicitudes_usuarios_nuevos() {
		$this->query = "
		SELECT *
		FROM datos_usuario WHERE gestionado = 0";
		$this->get_results_from_query();
		return $this->rows;
	}

	public function get_hay_nuevas_solicitudes_usuarios() {
		$this->query = "
		SELECT *
		FROM datos_usuario WHERE gestionado = 0";
		$this->get_results_from_query();
		
		if(count($this->rows) > 0) {
			return true;
		} 
		return false;
	}

	public function get_todos() {
		$this->query = "
		SELECT *
		FROM datos_usuario";
		$this->get_results_from_query();
		return $this->rows;
	}

	public function get_url_imagen($id) {
		$this->query = "
		SELECT url_imagen
		FROM datos_usuario WHERE id_usuario = $id";
		$this->get_results_from_query();
		return $this->rows;
	}
	
	public function set($usuario_nuevo=array()) {
		$this->get_usuario_por_dni($usuario_nuevo['dni']);

		if($usuario_nuevo['dni'] != $this->dni) {
			foreach ($usuario_nuevo as $campo=>$valor) {
				$$campo = $valor;
			}
			$this->query = "
			INSERT INTO datos_usuario (apellido_1, apellido_2, ciudad, contrasenia, direccion, dni, email, fecha_nacimiento, nombre, telefono, tipo_usuario, usuario, url_imagen) 
			VALUES ('$apellido_1', '$apellido_2', '$ciudad', '$contrasenia','$direccion', '$dni', '$email', '$fecha_nacimiento', '$nombre', '$telefono', '$tipo_usuario', '$usuario', 'img/fotos_perfil/default.jpg')
			";
			$this->execute_single_query();
			return 'Ok';
		} else {
			$msg = 'El usuario que intentas dar de alta ya existe';
			return $msg;
		}
		
	}

	public function gestionar_solicitud($accion) {
		$this->query = "
		UPDATE datos_usuario
		SET gestionado = $accion
		WHERE id_usuario = $this->id_usuario
		";
		$this->execute_single_query();
	}

	public function modifica_foto($url, $id_usuario) {
		$this->query = "
		UPDATE datos_usuario
		SET url_imagen = '$url'
		WHERE id_usuario = $id_usuario
		";
		$this->execute_single_query();
	}

	public function modifica_contrasenia($contrasenia, $id_usuario) {
		$this->query = "
		UPDATE datos_usuario
		SET contrasenia = '$contrasenia'
		WHERE id_usuario = $id_usuario
		";
		$this->execute_single_query();
	}

	public function edit($prod_data=array()) {
		foreach ($prod_data as $campo=>$valor):
			$$campo = $valor;
		endforeach;
		$this->query = "
			UPDATE datos_usuario
			SET ciudad='$ciudad',
			direccion='$direccion',
			telefono='$telefono',
			email='$email'
			WHERE id_usuario = $id_usuario
		";
		$this->execute_single_query();
		}
        
	/**Hay que probar*/
	public function delete($id='') {
		$this->query = "
		DELETE FROM mensaje
		WHERE id_origen = $id OR id_destino = $id
		";
		$this->execute_single_query();

		$this->query = "
		DELETE FROM solicitud_asistencia
		WHERE id_paciente = $id OR id_trabajador = $id
		";
		$this->execute_single_query();

		$this->query = "
		DELETE FROM trabajador
		WHERE id_usuario = $id
		";
		$this->execute_single_query();

		$this->query = "
		DELETE FROM paciente
		WHERE id_usuario = $id
		";
		$this->execute_single_query();

		$this->query = "
		DELETE FROM datos_usuario
		WHERE id_usuario = $id
		";
		$this->execute_single_query();
	}

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