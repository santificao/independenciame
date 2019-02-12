
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
                <p><img src="img/foto.jpg"></p>
                <p><span class="eti">Nombre:</span> <?php echo $_SESSION["usuario"]["nombre"]?></p>
                <p><span class="eti">Apellidos:</span> <?php echo $_SESSION["usuario"]["apellidos"]?></p>
                <p><span class="eti">Población:</span> <?php echo $_SESSION["usuario"]["ciudad"]?></p>
                <p><span class="eti">Edad:</span> <?php echo $_SESSION["usuario"]["edad"]?></p>

                <!--Según sea paciente o trabajador-->
                <p><span class="eti">Tipo de trabajador:</span> Voluntario</p>
                <p><span class="eti">Visible:</span> Si</p>
            </div>
        </aside>
</div>
