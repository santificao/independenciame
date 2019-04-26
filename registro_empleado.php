<article class="registro-empleado">
    <div class="contenido registro-empleado">
        <h2>¡Bienvenido!</h2> 
        <p>Muchísimas gracias por interesarte en nuestro proyecto y querer formar parte de él. Necesitamos que nos facilites alguna información personal para ponernos manos a la obra y comenzar con el proceso de inscripción.</p> 

        <form class="formulario cuenta-empleado" action="<?php $_SERVER["PHP_SELF"]?>" method="post" onSubmit="validarFormulario(event)">
            
            <div class="columna1">
                <legend>Datos personales</legend>
                <label for="nombre">Nombre </label> <input type="text" name="nombre" id="nombre">
                <label for="apellido1">Apellido 1 </label> <input type="text" name="apellido_1" id="apellido_1">
                <label for="apellido2">Apellido 2 </label> <input type="text" name="apellido_2" id="apellido_2">
                <label for="nacimiento">Fecha de nacimiento </label> <input type="date" name="fecha_nacimiento" id="fecha_nacimiento">
                <label for="ciudad">Ciudad </label> <input type="text" name="ciudad" id="ciudad">
                <label for="direccion">Dirección </label> <input type="text" name="direccion" id="direccion">
                <label for="telefono">Teléfono </label> <input type="phone" name="telefono" id="telefono">
                <label for="dni">DNI </label> <input type="text" name="dni" id="dni">
            </div>
            
            <div class="columna2">             
                <legend>Solicito formar parte de la comunidad en calidad de</legend>
                <label for="tipo">Seleccione </label>
                    <select name="tipo_empleado" id="tipo_empleado">
                        <option value="1">Voluntario</option>
                        <option value="2">Trabajador cualificado</option>
                    </select>
                <div class="formacion">
                    <legend>Formación académica</legend>
                    <label for="formacion">Título </label> <input type="text" name="titulo_formativo" id="titulo_formativo">
                </div>

                <legend>Datos de la cuenta</legend>
                <label for="usuario">Usuario </label> <input type="text" name="usuario" id="usuario">
                <label for="email">Email </label> <input type="email" name="email" id="email">
                <label for="contraseña">Contraseña </label> <input type="password" name="contraseña" id="contraseña">
                <label for="contraseña_repite">Repita contraseña </label> <input type="password" name="contraseña_comprueba" id="contraseña_comprueba">
            </div>

            <input class="boton-submit" type="submit" value="Regístrame" name="registrar_empleado">
        </form>      
    </div>
</article>