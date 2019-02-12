
<article class="inicio-sesion">
    <div class="contenido inicio-sesion">
        <h2>¡Bienvenido/a de nuevo!</h2>

        <form class="formulario" action="<?php $_SERVER["PHP_SELF"]?>" method="post">
            <label for="usuario">Usuario </label> <input type="text" name="usuario" id="usuario">
            <label for="contraseña">Contraseña </label> <input type="password" name="contraseña" id="contraseña">

            <input class="boton-submit" type="submit" value="Iniciar sesión" name="inicia_sesion">
        </form>      
    </div>
</article>