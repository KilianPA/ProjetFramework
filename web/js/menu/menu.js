$(document).ready(function () {

    $('.register_menu').click(function () {
        $('#RegisterModal').modal('show');
    });

    $('.ajouter_photo_menu').click(function () {
        $('#AddPhotoModal').modal('show');
    });

    $('.fos_user_registration_form').submit(function(event) {
        event.preventDefault();
        var formData = $('.fos_user_registration_form').serialize();

        $.ajax({
            type: 'POST',
            url: $('.fos_user_registration_form').attr('action'),
            data: new FormData($('.fos_user_registration_form')[0]),
            processData: false,  contentType: false,  cache: false,
            success: function (response) {
                console.log(response);
            }
        });

    });

});