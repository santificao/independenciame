<article class="registro-usuario">
    <div class="contenido registro-usuario">
        <h2>¡Hola!</h2> 
        <p>Estás a unos minutos de formar parte de nuestra comunidad</p> 

        <form class="formulario" action="<?php $_SERVER["PHP_SELF"]?>" method="post">
            
            <div class="columna1">
                <legend>Datos personales</legend>
                <label for="nombre">Nombre </label> <input type="text" name="nombre" id="nombre">
                <label for="apellido1">Apellido 1 </label> <input type="text" name="apellido_1" id="apellido_1">
                <label for="apellido2">Apellido 2 </label> <input type="text" name="apellido_2" id="apellido_2">
                <label for="nacimiento">Fecha de nacimiento </label> <input type="date" name="fecha_nacimiento" id="fecha_nacimiento">
                <label for="direccion">Dirección </label> <input type="text" name="direccion" id="direccion">
                <label for="telefono">Teléfono </label> <input type="phone" name="telefono" id="telefono">
                <label for="dni">DNI </label> <input type="text" name="dni" id="dni">
            </div>
            
            <div class="columna2">
                <legend>Datos de la cuenta</legend>
                <label for="usuario">Usuario </label> <input type="text" name="usuario" id="usuario">
                <label for="email">Email </label> <input type="email" name="email" id="email">
                <label for="contraseña">Contraseña </label> <input type="password" name="contraseña" id="contraseña">
                <label for="contraseña_repite">Repita contraseña </label> <input type="password" name="contraseña_comprueba" id="contraseña_comprueba">

                <legend>Grado de dependencia</legend>

                <label for="grado">Grado </label>
                    <select name="grado" id="grado">
                        <option value="1">Dependencia moderada</option>
                        <option value="2">Dependencia severa</option>
                        <option value="3">Gran dependencia</option>
                    </select>
            </div>

            <input class="boton-submit" type="submit" value="Regístrame" name="registrar_usuario">
        </form>      
    </div>
</article>