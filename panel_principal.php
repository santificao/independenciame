
<div class="panel contenido">
        <article class="tablon-anuncios contenido">
            <div class="alerta-notificaciones">
                <p><span><i class="far fa-bell"></i></span> Notificaciones (<span class="nuevas-notificaciones">0</span>)</p>
            </div>

            <div class="alerta-mensajes">
                <p><span><i class="far fa-envelope"></i></span> Nuevos mensajes (<span class="nuevos-mensajes">0</span>)</p>

                <p class="ver-todos">ver todos los mensajes</p>
            </div>
        </article>

        <aside class="datos contenido">
            <h2>Resumen del perfil</h2>
            <div class="personales">
                <p><img src="<?php echo $_SESSION["usuario"]["url_imagen"]?>"></p>
                <p><span class="eti">Nombre:</span> <?php echo $_SESSION["usuario"]["nombre"]?></p>
                <p><span class="eti">Apellidos:</span> <?php echo $_SESSION["usuario"]["apellidos"]?></p>
                <p><span class="eti">Población:</span> <?php echo $_SESSION["usuario"]["ciudad"]?></p>
                <p><span class="eti">Edad:</span> <?php echo $_SESSION["usuario"]["edad"]?></p>

                <?php
                if ($_SESSION["usuario"]["tipo_usuario"] == "A" || $_SESSION["usuario"]["tipo_usuario"] == "B") {
                    switch($_SESSION["usuario"]["tipo_usuario"]) {
                        case "A":
                            $tipo_usuario = "Administrador";
                            break;
                        case "B":
                            $tipo_usuario = "Trabajador";
                            break;
                    }
                    $tipo_trabajador = $_SESSION["usuario"]["tipo_trabajador"];
                    switch($tipo_trabajador) {
                        case 1:
                            $tipo_trabajador = "Voluntario";
                            break;
                        case 2:
                            $tipo_trabajador = "Trabajador";
                            break;
                        case 3:
                            $tipo_trabajador = "Trabajador +";
                            break;
                    }
                    $visible = $_SESSION["usuario"]["visible"];
                    if ($visible == 1) {
                        $visible = "Si";
                    } else {
                        $visible = "No";
                    }
                ?>

                <p><span class="eti">Tipo de usuario:</span> <?php echo $tipo_usuario?></p>
                <p><span class="eti">Perfil del usuario:</span> <?php echo $tipo_trabajador?></p>
                <p><span class="eti">Visible:</span> <?php echo $visible?></p>

                <?php
                } else {
                    $tipo_usuario = "Paciente";
                    $grado_dependencia = $_SESSION["usuario"]["grado_dependencia"];
                ?>

                <p><span class="eti">Tipo de usuario:</span> <?php echo $tipo_usuario?></p>
                <p><span class="eti">Dependencia:</span> Grado <?php echo $grado_dependencia?></p>

                <?php
                }
                ?>
            </div>
        </aside>
</div>
