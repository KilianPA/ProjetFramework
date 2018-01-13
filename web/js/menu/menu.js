$(document).ready(function () {

    $('.register_menu').click(function () {
        $('#RegisterModal').modal('show');
    });

    $('.ajouter_photo_menu').click(function () {
        $('#AddPhotoModal').modal('show');
    });

    $( ".fos_user_registration_form" ).click(function( event ) {
        event.preventDefault();
        console.log('STOP')
    });

});