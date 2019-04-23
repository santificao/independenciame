<article class="configuracion">
    <div class="contenido configuracion">

<?php
if(isset($_POST["modificar_usuario"])) {
    echo "modificando usuario";
} else if (isset($_POST["cambia_foto"])) {
    if (is_uploaded_file($_FILES["subir-foto"]["tmp_name"])) {
        $permitidos = array("jpg","png");
        $extension = explode(".", $_FILES['subir-foto']['name']);
        $pos = count($extension);

        if (in_array($extension[$pos-1], $permitidos)) {
            $ruta_y_nombre = "img/fotos_perfil/".time().$_FILES["subir-foto"]["name"];

            if (move_uploaded_file($_FILES["subir-foto"]["tmp_name"],$ruta_y_nombre)) {
                $usuario = new Usuario();
                $usuario->modifica_foto($ruta_y_nombre, $_SESSION["usuario"]["id"]);
                header("Location: index.php");
            } else {
                echo "<h2>No se ha podido subir el archivo</h2>";
            }
        } else {
           echo "<h2>Extensión no permitida</h2>";
        }
    }
} else if (isset($_POST["cambia_contrasenia"])) {
    echo "cambiada";
} else if(isset($_POST["modificacion_contrasenia"])) {
    ?>
    <div class="columna1">
        <form class="formulario formulario-cambiar-contrasenia" action="<?php $_SERVER["PHP_SELF"]?>" method="post">

        <legend>Cambiar contraseña</legend>

        <label for="contraseña">Contraseña actual </label> <input type="password" name="contraseña_anterior" id="contraseña_anterior">
        <label for="contraseña_repite">Contraseña nueva </label> <input type="password" name="contraseña_nueva" id="contraseña_nueva">
        <label for="contraseña_repite2">Confirma la nueva contraseña </label> <input type="password" name="contraseña_nueva2" id="contraseña_nueva2">

        <input class="boton-submit" type="submit" value="Cambiar" name="cambia_contrasenia">
        </form>
    </div>
    <?php
} else if (isset($_POST["modificacion_foto"])) {
    ?>
    <div class="columna1">
        <form class="formulario formulario-cambiar-contrasenia foto-perfil-form" action="<?php $_SERVER["PHP_SELF"]?>" method="post" enctype="multipart/form-data">

        <legend>Cambiar foto de perfil</legend>

        <input class="file" type="file" name="subir-foto" id="subir-foto">
        <input class="boton-submit" type="submit" value="Subir" name="cambia_foto">
        </form>
    </div>
    <?php

} else {

    $nombre = $_SESSION["usuario"]["nombre"];
    $apellidos = $_SESSION["usuario"]["apellidos"];
    $ciudad = $_SESSION["usuario"]["ciudad"];
    $direccion = $_SESSION["usuario"]["direccion"];
    $telefono = $_SESSION["usuario"]["telefono"];
    $usuario = $_SESSION["usuario"]["usuario"];
    $email = $_SESSION["usuario"]["email"];

    if (isset($_SESSION["usuario"]["visible"])) {
        $visible = $_SESSION["usuario"]["visible"];
    }

?>
        <p>TUS DATOS</p> 

        <form class="formulario" action="<?php $_SERVER["PHP_SELF"]?>" method="post">
            
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
                        <option value="1">Visible</option>
                        <option value="0">No disponible</option>
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