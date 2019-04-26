/**
 * CONJUNTO DE FUNCIONES PARA EL CHAT 
 */

//Variable global para iniciar y detener la conexión asíncrona para iniciar y cerrar el chat
var iniciaChat;

//Función para cerrar chat
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("cerrar")) {
        var chat = document.querySelector(".chat");
        chat.parentNode.removeChild(chat);
        location.reload();
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
                $(".conversacion-del-chat").animate({ scrollTop: $('.conversacion-del-chat')[0].scrollHeight }, 3);

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

//-----> Fin funciones del chat <-----//

/**
 * FUNCIONES PARA VALIDAR FORMULARIOS
 */

function validarFormulario(e) {
    var validaFormulario = true;
    e.preventDefault();
    var tipo;
    var campo = 0;
    if (e.target.classList.contains("cuenta-paciente")) {
        tipo = 'paciente';
    } else if (e.target.classList.contains("cuenta-empleado")) {
        tipo = 'asistente';
    }
    var nombre = e.target[campo++].value;
    var apellido1 = e.target[campo++].value;
    var apellido2 = e.target[campo++].value;
    var fecha = e.target[campo++].value;
    var edad = calcularEdad(fecha);
    var ciudad = e.target[campo++].value;
    var direccion = e.target[campo++].value;
    var telefono = e.target[campo++].value;
    var dni = e.target[campo++].value;
    if (tipo == 'asistente') {
        campo += 2;
    }
    var usuario = e.target[campo++].value;
    var email = e.target[campo++].value;
    var contrasenia = e.target[campo++].value;
    var contrasenia2 = e.target[campo++].value;

    if (tipo == 'paciente') {
        var grado = e.target[campo].options[e.target[campo].selectedIndex].value;
    }
    if (tipo == 'asistente') {
        var tipoAsistente = e.target[8].options[e.target[8].selectedIndex].value;
        if (tipoAsistente == 2) {
            var formacion = e.target[9].value;
        }
    }

    var camposTexto = comprobarQueCamposTenganTexto(nombre, apellido1, apellido2, ciudad, direccion, usuario);
    var dniCorrecto = comprobarDni(dni);
    var telefonoCorrecto = comprobarTelefono(telefono);
    var emailCorrecto = comprobarEmail(email);
    var contraseniaCorrecta = comprobarContrasenia(contrasenia);

    $('.error-validacion').remove();
    $('main').append('<div class="error-validacion"></div>');

    if (!camposTexto) {
        $('.error-validacion').append('<p>Datos personales y nombre de usuario obligatorio</p>');
        validarFormulario = false;
    }
    if (!dniCorrecto) {
        $('.error-validacion').append('<p>Dni incorrecto</p>');
        validarFormulario = false;
    }
    if (!telefonoCorrecto) {
        $('.error-validacion').append('<p>Formato teléfono incorrecto</p>');
        validarFormulario = false;
    }
    if (!emailCorrecto) {
        $('.error-validacion').append('<p>Email incorrecto</p>');
        validarFormulario = false;
    }
    setTimeout(function() {
        $('.error-validacion').remove();
    }, 2000);

    if (validarFormulario) {
        $.ajax({
            type: 'POST',
            url: 'guardar_datos_usuario.php',
            data: { 'nombre': nombre, 'apellido1': apellido1, 'apellido2': apellido2, 'fecha': fecha, 'ciudad': ciudad, 'direccion': direccion, 'telefono': telefono, 'dni': dni, 'email': email, 'tipo': tipo, 'usuario': usuario, 'contrasenia': contrasenia, 'grado': grado, 'tipoAsistente': tipoAsistente },
            success: function() {
                $('main').append('<p>Usuario creado</p>');
            }
        });
    }

}

function calcularEdad(fecha) {
    var hoy = new Date();
    var cumpleanos = new Date(fecha);
    var edad = hoy.getFullYear() - cumpleanos.getFullYear();
    var m = hoy.getMonth() - cumpleanos.getMonth();

    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad--;
    }

    return edad;
}

function comprobarQueCamposTenganTexto(nombre, apellido1, apellido2, ciudad, direccion, usuario) {
    if (nombre != '' && apellido1 != '' && apellido2 != '' && ciudad != '' && direccion != '' && usuario != '') {
        return true;
    }
    return false;
}

function comprobarDni(dni) {
    var numero,
        letDni, letra;
    var expRegDni = /^[XYZ]?\d{5,8}[A-Z]$/;

    dni = dni.toUpperCase();

    if (expRegDni.test(dni)) {
        numero = dni.substr(0, dni.length - 1);
        numero = numero.replace('X', 0);
        numero = numero.replace('Y', 1);
        numero = numero.replace('Z', 2);
        letDni = dni.substr(dni.length - 1, 1);
        numero = numero % 23;
        letra = 'TRWAGMYFPDXBNJZSQVHLCKET';
        letra = letra.substring(numero, numero + 1);
        if (letra !=
            letDni) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function comprobarTelefono(telefono) {
    var expRegTelf = /^[9|6|7|8]{1}([\d]{2}[-]*){3}[\d]{2}$/;
    if (expRegTelf.test(telefono)) {
        return true;
    }
    return false;
}

function comprobarEmail(email) {
    var expRegMail = /^[\w]+@{1}[\w]+\.+[a-z]{2,3}$/;
    if (expRegMail.test(email)) {
        return true;
    }
    return false;
}

function comprobarContrasenia(contrasenia) {

}

/**
 * FUNCIONES PARA LA SOLICITUD DE ASISTENCIA
 */

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

//-----> Fin funciones de envío de solicitud <-----//


/**
 * FUNCIONES PARA VALIDAR FORMULARIOS
 */


//-----> Fin funciones para validar formularios <-----//



/** 
 * FUNCIONES Y ANIMACIONES EXCLUSIVAS JQuery 
 **/

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