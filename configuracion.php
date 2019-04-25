<article class="configuracion">
    <div class="contenido configuracion">

<?php

//Bloque de if para realizar una acción y generar una alerta de éxito u error
if (isset($_POST["modificar_usuario"])) {
    $ciudad = $_POST["ciudad"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $id_usuario = $_SESSION["usuario"]["id"];

    if ($ciudad != "" && $direccion != "" && $telefono != "" && $email != "") {
        $datos = array("ciudad" => $ciudad, "direccion" => $direccion, "telefono" => $telefono, "email" => $email, "id_usuario" => $id_usuario);
        
        $usuario = new Usuario();
        $usuario->edit($datos);

        if (isset($_SESSION["usuario"]["visible"])) {
            $visible = $_POST["visible"];
            $trabajador = new Trabajador();
            $trabajador->modificar_visible($visible, $_SESSION["usuario"]["id"]);
            $alerta = generar_alerta("Estado modificado", "exito");
        }

        $alerta = generar_alerta("Sus datos han sido modificados", "exito");

    } else {
        $alerta = generar_alerta("No puede quedar ningún campo vacio", "error");
    }
    
} 

if (isset($_POST["cambia_foto"])) {
    if (is_uploaded_file($_FILES["subir-foto"]["tmp_name"])) {
        $permitidos = array("jpg", "png");
        $extension = explode(".", $_FILES['subir-foto']['name']);
        $pos = count($extension);

        if (in_array($extension[$pos - 1], $permitidos)) {
            $ruta_y_nombre = "img/fotos_perfil/" . time() . $_FILES["subir-foto"]["name"];

            if (move_uploaded_file($_FILES["subir-foto"]["tmp_name"], $ruta_y_nombre)) {
                $usuario = new Usuario();
                $usuario->modifica_foto($ruta_y_nombre, $_SESSION["usuario"]["id"]);
                $alerta = generar_alerta("Imagen de perfil modificada con éxito", "exito");
            } else {
                $alerta = generar_alerta("No se ha podido subir el archivo", "error");
            }
        } else {
            $alerta = generar_alerta("Extensión no permitida", "error");
        }
    }
} 

if (isset($_POST["cambia_contrasenia"])) {
    $contraseniaNueva1 = $_POST["contrasenia_nueva"];
    $contraseniaNueva2 = $_POST["contrasenia_nueva2"];
    $contraseniaActual = $_POST["contrasenia_anterior"];

    $usuario = new Usuario();
    $usuario->get($_SESSION["usuario"]["usuario"], $contraseniaActual);
    
    
    if ($usuario->nombre == "") {  
        $alerta = generar_alerta("Contraseña incorrecta", "error");
    } else if ($contraseniaNueva1 != $contraseniaNueva2) {
        $alerta = generar_alerta("Los campos referentes a la nueva contraseña no coinciden", "error");
    } else if ($contraseniaNueva1 == $contraseniaActual) {
        $alerta = generar_alerta("La contraseña nueva no puede ser igual que la anterior", "error");
    } else {
        $usuario->modifica_contrasenia($contraseniaNueva1, $_SESSION["usuario"]["id"]);
        $alerta = generar_alerta("Su contraseña ha sido modificada", "exito");
    }

} 

//Bloque de if else para mostrar un formulario u otro
if (isset($_POST["modificacion_contrasenia"])) {
    ?>
    <div class="columna1">
        <form class="formulario formulario-cambiar-contrasenia" action="<?php $_SERVER["PHP_SELF"] ?>" method="post">

        <legend>Cambiar contraseña</legend>

        <label for="contraseña">Contraseña actual </label> <input type="password" name="contrasenia_anterior" id="contraseña_anterior">
        <label for="contraseña_repite">Contraseña nueva </label> <input type="password" name="contrasenia_nueva" id="contraseña_nueva">
        <label for="contraseña_repite2">Confirma la nueva contraseña </label> <input type="password" name="contrasenia_nueva2" id="contraseña_nueva2">

        <input class="boton-submit" type="submit" value="Cambiar" name="cambia_contrasenia">
        </form>
    </div>
    <?php

} else if (isset($_POST["modificacion_foto"])) {
    ?>
    <div class="columna1">
        <form class="formulario formulario-cambiar-contrasenia foto-perfil-form" action="<?php $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">

        <legend>Cambiar foto de perfil</legend>

        <input class="file" type="file" name="subir-foto" id="subir-foto">
        <input class="boton-submit" type="submit" value="Subir" name="cambia_foto">
        </form>
    </div>
    <?php

} else {
    $id = $_SESSION["usuario"]["id"];
    $usuario = new Usuario();
    $usuario->get_usuario_por_id($id);

    $email = $usuario->email;
    
    if ($usuario->tipo_usuario != "C") {
        $usuario = new Trabajador();
        $usuario->datos_trabajador($id);
        $visible = $usuario->visible;
    }

    $nombre = $usuario->nombre;
    $apellidos = $usuario->apellido_1." ".$usuario->apellido_2;
    $ciudad = $usuario->ciudad;
    $direccion =  $usuario->direccion;
    $telefono =  $usuario->telefono;
    $usuario = $usuario->usuario;
    
  
    if (isset($alerta)) {
        echo $alerta;
    }

    ?>
        <p>TUS DATOS</p> 

        <form class="formulario" action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
            
            <div class="columna1">
                <legend>Datos personales</legend>

                <label for="nombre">Nombre </label> <input class="readonly" type="text" name="nombre" id="nombre" value="<?php echo $nombre ?>" readonly>
                <label for="apellidos">Apellidos </label> <input class="readonly"  type="text" name="apellidos" id="apellidos" value="<?php echo $apellidos ?>" readonly>
                <label for="ciudad">Ciudad </label> <input type="text" name="ciudad" id="ciudad" value="<?php echo $ciudad ?>">
                <label for="direccion">Dirección </label> <input type="text" name="direccion" id="direccion" value="<?php echo $direccion ?>">
                <label for="telefono">Teléfono </label> <input type="phone" name="telefono" id="telefono" value="<?php echo $telefono ?>"> 
            </div>
            
            <div class="columna2">
                <legend>Datos de la cuenta</legend>

                <label for="usuario">Usuario </label> <input class="readonly" type="text" name="usuario" id="usuario" value="<?php echo $usuario ?>" readonly>
                <label for="email">Email </label> <input type="email" name="email" id="email" value="<?php echo $email ?>">
                <?php
                if (isset($visible)) {
                    ?>
                <label for="visible">Estado </label>
                    <select name="visible" id="visible">
                        <option value="1" <?php if(isset($visible)){if ($visible == 1) {echo "selected";}}?>>Visible</option>
                        <option value="0"<?php if(isset($visible)){if ($visible == 0) {echo "selected";}}?>>No disponible</option>
                    </select>
                <?php

            }
            ?>

                <input class="boton botones-configuracion" type="submit" value="Cambiar contraseña" name="modificacion_contrasenia">

                <input class="boton botones-configuracion" type="submit" value="Cambiar foto de perfil" name="modificacion_foto">

            </div>

            <input class="boton-submit" type="submit" value="Modificar" name="modificar_usuario">
        </form>
        
    </div>
    <?php

}
?>
</article>