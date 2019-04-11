<?php
    $id_usuario = $_SESSION["usuario"]["id"];
    $tipo_usuario = $_SESSION["usuario"]["tipo_usuario"];

    //Para rellenar la lista de contactos y pintarlos
    $listado_contactos = array();
    $repetido = false;

    $solicitud = new Solicitud();
    $solicitudes_aceptadas = $solicitud->get_listado_solicitudes_aceptadas($id_usuario, $tipo_usuario);

    if ($tipo_usuario == "C") {
        foreach($solicitudes_aceptadas as $solicitud_aceptada) {
            $id_trabajador = $solicitud_aceptada["id_trabajador"];
            foreach($listado_contactos as $contacto) {
                if (in_array($id_trabajador,$contacto)) {
                    $repetido = true;
                }
            }
            if($repetido == false) {
                $usuario = new Usuario();
                $usuario->get_usuario_por_id($id_trabajador);
                array_push($listado_contactos, array("nombre"=>$usuario->nombre, "ciudad" => $usuario->ciudad, "imagen"=>$usuario->url_imagen, "id"=>$usuario->id_usuario));
            }
           $repetido = false; 
        }
    } else {
        foreach($solicitudes_aceptadas as $solicitud_aceptada) {
            $id_paciente = $solicitud_aceptada["id_paciente"];         
            foreach($listado_contactos as $contacto) {
                if (in_array($id_paciente,$contacto)) {
                    $repetido = true;
                }
            }
            if($repetido == false) {
                $usuario = new Usuario();
                $usuario->get_usuario_por_id($id_paciente);
                array_push($listado_contactos, array("nombre"=>$usuario->nombre, "ciudad" => $usuario->ciudad, "imagen"=>$usuario->url_imagen, "id"=>$usuario->id_usuario));
            }
           $repetido = false; 
        }
    }

    //Para rellenar la lista de mensajes y pintarlos

    $listado_mensajes = array();

    $mensaje = new Mensaje();
    $mensajesDB = $mensaje->get($id_usuario);

    foreach($mensajesDB as $mensaje_nuevo) {
       if ($mensaje_nuevo["id_origen"] == $id_usuario) {
           $needle = "id_destino";
       } else {
            $needle = "id_origen";
       }
       if (!in_array($mensaje_nuevo[$needle], $listado_mensajes)) {
           array_push($listado_mensajes, $mensaje_nuevo[$needle]);
       }
    } 
?>

<div class="panel contenido contactos-mensajes">
        <article class="tablon-mensajes contenido">
            <h2>Mis conversaciones</h2>
            <?php
            if (empty($listado_mensajes)) {
                echo "No tienes ninguna conversación";
            } else {
                foreach($listado_mensajes as $mensaje) {
                    $usuario = new Usuario();
                    $usuario->get_usuario_por_id($mensaje);
                    echo "<a href='#'><p class='hilo-mensajes'>$usuario->nombre<span>$mensaje</span></p></a>";
                }
            }
            ?>
        </article>

        <aside class="datos contenido contenido-contactos">
            <h2>Mis contactos</h2>
            <?php 
            if (empty($listado_contactos)) {
                ?>
                <p class="alerta-mensajes">Todavía no tienes ningún contacto. Al iniciar una relación asistente/paciente tu contacto aparecerá en la lista automáticamente.</p>
                <?php
            } else {
                foreach($listado_contactos as $contacto) {
            ?>
            <a href="#">
            <div class="tarjeta-contacto">
                <p><?php echo $contacto["nombre"]?></p>    
                <p><img class="imagen-listado-contacto" src="<?php echo $contacto["imagen"]?>" alt="Imagen de contacto"></p>
            </div>
            </a>
            <?php
            }
        }
            ?>
        </aside>
</div>
