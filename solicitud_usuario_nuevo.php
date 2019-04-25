<?php
if(isset($_POST["generar_pdf"])) {

} else if (isset($_POST["aceptar_solicitud"]) || isset($_POST["rechazar_solicitud"])) {
    if (isset($_POST["aceptar_solicitud"])) {
        $accion = 1;
    } else {
        $accion = -1;
    }
    
    $id_usuario = $_POST["id_usuario"];
    $usuario = new Usuario();
    $usuario->get_usuario_por_id($id_usuario);
    $usuario->gestionar_solicitud($accion);

    $alerta = generar_alerta("La solicitud de $usuario->nombre ha sido procesada con éxito", "exito");
}

$usuario = new Usuario();    
$cont = 0;  
$listado_solicitudes = array();
    
$usuarios = $usuario->get_solicitudes_usuarios_nuevos();

    
foreach($usuarios as $usuario_solicitud) {     
    array_push($listado_solicitudes, array("id_usuario" => $usuario_solicitud["id_usuario"]));
}

?>
<!--Se pintan las solicitudes nuevas que haya-->
<article class="notificaciones contenido">
<?php
    if (isset($alerta)) {
        echo $alerta;
    }

    if (empty($listado_solicitudes)) {
        echo "<h2>No tienes ninguna nueva solicitud</h2>";
    } else {
        echo "<h2>Solicitudes pendientes</h2>";
        foreach($listado_solicitudes as $solicitud) {
            $usuario = new Usuario();
            $usuario->get_usuario_por_id($solicitud["id_usuario"]);
            ?>
            <div class="solicitud usuarios-nuevos">
                <p><span>Usuario: </span> <?php echo $usuario->nombre." ".$usuario->apellido_1?></p>        
                <p><span>Domicilio: </span> <?php echo $usuario->ciudad.", ".$usuario->direccion?></p>

                <form class="formulario" action="<?php $_SERVER["PHP_SELF"]?>" method="post">
                    <input type="hidden" name="id_usuario" value="<?php echo $solicitud["id_usuario"]?>">
                    <a class="boton-submit boton-extrecho boton-pdf" href="generar_pdf.php?id=<?php echo $solicitud["id_usuario"] ?>" target="_blank">Ver PDF</a>
                    <input class="boton-submit boton-extrecho aceptar" type="submit" value="Aceptar" name="aceptar_solicitud">
                    <input class="boton-submit boton-extrecho rechazar" type="submit" value="Rechazar" name="rechazar_solicitud">
                </form>
            </div>
        <?php
            }
        }   
        ?>
</article>