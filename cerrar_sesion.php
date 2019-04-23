<?php
    if (isset($_POST["cerrar"])) {
        Sesion::cierra_sesion();
        header("Location: index.php");
    } else if (isset($_POST["no_cerrar"])){
        header("Location: index.php");
    }

?>

<article class='cierre-sesion contenido'>

    <form class="formulario" action="<?php $_SERVER["PHP_SELF"] ?>" method="POST">
        <h2>¿Seguro que desea salir?</h2>

        <input class="boton-submit boton-extrecho aceptar" type="submit" value="Salir" name="cerrar">
        <input class="boton-submit boton-extrecho rechazar" type="submit" value="No" name="no_cerrar">
    </form>

</article>