//JQuery
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
        console.log(tipo);
        if (tipo != 1) {
            $(".formacion").slideDown(400);
            $(".formacion").css("display", "flex");
        } else {
            $(".formacion").slideUp(400);
        }
    });

});