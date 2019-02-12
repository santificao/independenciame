<?php

class Sesion {

    static function inicia_sesion($usuario) {
        $_SESSION["usuario"]["nombre"] = $usuario->nombre;
        $_SESSION["usuario"]["apellidos"] = $usuario->apellido_1." ".$usuario->apellido_2;
        $_SESSION["usuario"]["ciudad"] = $usuario->ciudad;
        $_SESSION["usuario"]["direccion"] = $usuario->direccion;
        $_SESSION["usuario"]["dni"] = $usuario->dni;
        $_SESSION["usuario"]["email"] = $usuario->email;
        $_SESSION["usuario"]["telefono"] = $usuario->telefono;
        $_SESSION["usuario"]["edad"] =  calcularEdad($usuario->fecha_nacimiento);
        $_SESSION["usuario"]["tipo_usuario"] = $usuario->tipo;
        $_SESSION["usuario"]["url_imagen"] = $usuario->url_imagen;  
    }

    static function cierra_sesion() {
        session_unset();
        session_destroy();
    }

}
?>