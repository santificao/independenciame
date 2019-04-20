/** JavaScript */

//Variable global para iniciar y detener la conexión asíncrona para iniciar y cerrar el chat
var iniciaChat;


//Función para cerrar chat
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("cerrar")) {
        var chat = document.querySelector(".chat");
        chat.parentNode.removeChild(chat);
        clearInterval(iniciaChat);
    }
});

document.addEventListener("click", function(e) {
    if (e.target.classList.contains("enviar-mensaje-chat")) {
        var mensaje = $(".texto-mensaje").val();
        var id = $(".id-remota-para-mensajes").html();

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "acciones_mensajes.php?mensaje=" + mensaje + "&idRemota=" + id, true);
        xhr.onload = function() {
            if (this.status === 200) {
                var template = `<p class='R'><span class='remarcar'>${mensaje}</span></p>`;
                $(".conversacion-del-chat").append(template);
            }
            $(".conversacion-del-chat").animate({ scrollTop: $('.conversacion-del-chat')[0].scrollHeight }, 1000);
        }
        xhr.send();
        $(".texto-mensaje").val("");
    }
});

//Función para ir a mensajes de usuario concreto
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("hilo-mensajes")) {
        var id = e.target.children[0].textContent;

        const xhr = new XMLHttpRequest();

        xhr.open("GET", "acciones_mensajes.php?idRemota=" + id, true);

        xhr.onload = function() {
            if (this.status === 200) {
                const respuesta = JSON.parse(xhr.responseText);
                var template = `<div class='chat'><span class='cerrar'>&times</span><span class='id-remota-para-mensajes'>${id}</span>
                                <div class='conversacion-del-chat'>`;

                respuesta.forEach(msg => {
                    var posMsg = msg.ubicar;
                    if (posMsg == 'R') {
                        template += `
                        <p class='${posMsg}'><span class='remarcar'>${msg.contenido}</span></p>
                    `;
                    } else {
                        template += `
                        <p class='${posMsg} remarcar-otro'> ${msg.contenido}</p>
                    `;
                    }
                })
                template += `
                    </div>
                    <div class='mensaje-chat-envia'>
                        <textarea class='texto-mensaje'></textarea>
                        <input class='boton enviar-mensaje-chat' type='button' value='enviar'>
                    </div>
                </div>
                `;
                $("main").append(template);
                $(".conversacion-del-chat").animate({ scrollTop: $('.conversacion-del-chat')[0].scrollHeight }, 1000);

                //Pendiente crear isset($_GET("ahora")) en acciones_mensajes
                iniciaChat = setInterval(function() {
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "acciones_mensajes.php?idRemota=" + id + "&recargar=true", true);
                    xhr.onload = function() {
                        if (this.status === 200) {
                            template = '';
                            const respuesta = JSON.parse(xhr.responseText);
                            respuesta.forEach(msg => {
                                template += `
                                    <p class='L remarcar-otro'>${msg.contenido}</p>
                                `;
                            })
                            $(".conversacion-del-chat").append(template);
                            $(".conversacion-del-chat").animate({ scrollTop: $('.conversacion-del-chat')[0].scrollHeight }, 1000);
                        }
                    }
                    xhr.send();
                }, 3000);

            }
        }

        xhr.send();
    }
});

//Función llamada desde el formulario de solicitar el tipo de asistencia con el tipo de evento "onSubmit"
function solicitarAsistencia(e) {
    e.preventDefault();

    var contenido = document.getElementById("ventana-asistencia");

    var select = document.getElementById("select-tipo-asistencia");
    var tipo = select.options[select.selectedIndex].value;

    //Crear el objeto
    const xhr = new XMLHttpRequest();

    //Abrir la conexión
    xhr.open("GET", "buscar_asistentes.php?tipo=" + tipo, true);

    //Pasar los datos
    xhr.onload = function() {
        if (this.status === 200) {
            //Leemos la respuesta de PHP (modelo-contacto.php)
            const respuesta = JSON.parse(xhr.responseText);

            if (respuesta.length == 1) {
                template = `
                    <p class="error">Lo sentimos... no hemos encontrado ningún asistente cerca disponible, nos pondremos en contacto contigo lo antes posible</p>
                `;
                contenido.innerHTML = template;
            } else {
                var tipo;
                document.querySelector(".solicitud-asistencia").style.height = 'auto';
                template = `
                    <h2>¡Bien! Hemos encontrado ${respuesta.length-1} asistente/s disponible/s cerca de tí</h2>
                    <article class="contenido trabajadores-disponibles-listado">  
                `;
                respuesta.forEach(trabajador => {
                    if (trabajador.nombre == "tipo_asistencia") {
                        tipo = trabajador.tipo;
                    } else {
                        template += `
                        <div class="datos-trabajador-disponible">
                            <img src="${trabajador.imagen}" alt="asistente de personas con dependencia">
                            <p><span>Nombre: </span>${trabajador.nombre}</p>
                            <p><span>Direccion: </span>${trabajador.direccion}</p>
                            <p><span>Ciudad: </span>${trabajador.ciudad}</p>
                            <p><span>Distancia aproximada: ${trabajador.distancia} Km</p>
                            
                            <form class="formulario" method="post">
                                <input type="hidden" name="tipo_asistencia" value="${tipo}">
                                <input type="hidden" name="id_trabajador" value="${trabajador.id}">
                                <input class="boton-submit boton-extrecho" type="submit" value="Enviar solicitud" name="envia_solicitud">
                            </form>
                        `;
                        template += '</div>';
                    }
                });
                template += '</article>';
                contenido.innerHTML = template;
            }
        } else {
            alert("Ha ocurrido un error en el servidor");
        }
    }

    //Enviar los datos
    xhr.send();

    contenido.innerHTML = `
        <img src='img/buscando.gif'></img>
    `;
}


/** JQuery */
$(document).ready(function() {

    /**Efectos personalizados para plugin lightBox */
    lightbox.option({
        'albumLabel': "Imagen %1 de %2"
    });

    /**Efecto para mostrar/ocultar menú móvil*/
    $(".menu-movil").click(function() {
        $(".menu").slideToggle(300);
    });

    $("select[name='tipo_empleado']").change(function() {
        var tipo = $("select[name='tipo_empleado']").val();
        if (tipo != 1) {
            $(".formacion").slideDown(400);
            $(".formacion").css("display", "flex");
        } else {
            $(".formacion").slideUp(400);
        }
    });

    $("#volver").click(function() {
        window.location.assign("index.php");
    })

});