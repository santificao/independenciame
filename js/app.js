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

});