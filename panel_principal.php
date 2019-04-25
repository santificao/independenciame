
<div class="panel contenido">
        <article class="tablon-anuncios contenido">
            <div class="alerta-notificaciones">
                <p><span><i class="far fa-bell"></i></span> Notificaciones ( <span class="nuevas-notificaciones"><?php
                    $solicitud = new solicitud();           
                    $solicitudes = $solicitud->get_cuantas_solicitudes_nuevas($_SESSION["usuario"]["id"], $_SESSION["usuario"]["tipo_usuario"]);

                    if ($solicitudes > 0 ) {
                        echo "<a class='enlace' href='index.php?p=3'>$solicitudes</a>";
                    } else {
                        echo $solicitudes;
                    }
                ?></span> )</p>
            </div>

            <div class="alerta-mensajes">
                <p><span><i class="far fa-envelope"></i></span> Nuevos mensajes ( <span class="nuevos-mensajes"><?php
                    $mensaje = new mensaje();           
                    $mensajes = $mensaje->get_cuantos_mensajes_nuevos($_SESSION["usuario"]["id"]);

                    if ($mensajes > 0 ) {
                        echo "<a class='enlace' href='index.php?p=3'>$mensajes</a>";
                    } else {
                        echo $mensajes;
                    }
                ?></span> )</p>

                <a href="index.php?p=2" class="enlace">ver todos los mensajes</a>
            </div>
        </article>

        <aside class="datos contenido">
            <h2>Resumen del perfil</h2>
            <div class="personales">
                <p><img src="<?php $usuario = new usuario(); echo $usuario->get_url_imagen($_SESSION["usuario"]["id"])[0]["url_imagen"]?>"></p>
                <p><span class="eti">Nombre:</span> <?php echo $_SESSION["usuario"]["nombre"]?></p>
                <p><span class="eti">Apellidos:</span> <?php echo $_SESSION["usuario"]["apellidos"]?></p>
                <p><span class="eti">Población:</span> <?php $usuario = new Usuario(); $usuario->get_usuario_por_id($_SESSION["usuario"]["id"]); echo $usuario->ciudad?></p>
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
                    }
                    $usuario = new Trabajador();
                    $usuario->datos_trabajador($_SESSION["usuario"]["id"]);
                    $visible = $usuario->visible;
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
                    switch($grado_dependencia) {
                        case 1: 
                            $grado_dependencia = "Moderada";
                            break;
                        case 2:
                            $grado_dependencia = "Severa";
                            break;
                        case 3:
                            $grado_dependencia = "Gran dependencia";
                            break;
                    }
                ?>

                <p><span class="eti">Tipo de usuario:</span> <?php echo $tipo_usuario?></p>
                <p><span class="eti">Grado de dependencia:</span> <?php echo $grado_dependencia?></p>

                <?php
                }
                ?>
            </div>
        </aside>
</div>
