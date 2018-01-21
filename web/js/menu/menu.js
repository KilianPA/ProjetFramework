$(document).ready(function () {

    console.log("test");




    if (typeof $('.input_login_button').attr('data-content') == 'undefined'){


    } else {

        $('#ShowErreurLoginModal').modal('show');
       $('.erreur_login').html($('.input_login_button').attr('data-content'));

       var compteur =  $('.compteur').attr('data-content');
    console.log(compteur);
       if (!isNaN(compteur)) {

           if (compteur == 2) {
               $('.compteur_login').html( 'Dernier essai avant que votre compte soit désactivé');
           }

           else if (compteur == 4) {
               $('.erreur_login').html("Le compte est désactivé.");
           }
           else if (compteur == 0) {

           }

           else {
               compteur = 3 - compteur;
               $('.compteur_login').html( 'Il vous reste ' + compteur + ' essai(s)');
           }

       } else {


       }







    }


    $(".show_photo_menu").click(function(){
        $('.container_loader').css('display', 'block');
        $.ajax({
            url: 'showphoto',
            type: 'GET',
            success: function(data) {
                if (data) {
                    $('.container_photos').html(data);

                    console.log($('.photo_case').length);

                    if ($('.photo_case').length == 0){

                        $('.button_select_photo_galerie').hide();

                    } else {

                        $('.button_select_photo_galerie').show();

                    }

                    $('.delete_photo_grid').each(function () {

                        $(this).click(function () {

                            var id_photo = $(this).attr('photoid');
                            console.log(id_photo);


                            $('#ShowDeleteModal').modal('show');


                            $('.delete_photo_modal_button').click(function () {

                                $.ajax({
                                    url: 'DeletePhoto',
                                    type: 'POST',
                                    context: $('.delete_photo_grid'),
                                    data: {id_photo : id_photo} ,
                                    success: function (data) {
                                        $('#ShowDeleteModal').modal('hide');
                                        $('.delete_photo_grid').parent('.photo_grid_each').hide('slow');
                                        $(this).parent('.photo_grid_each').remove();
                                        console.log(data);

                                    }
                                });

                            });




                        });

                    });


                    $(".photo_grid_each").each(function () {
                        $(this).click(function () {
                            if ($(this).hasClass("clickedTrue")) {
                                $(this).removeClass("clickedTrue");
                                $(this).children('.validate_icon').hide( "slow" );
                            } else {
                                $(this).children('.validate_icon').show( "slow" );
                                $(this).addClass("clickedTrue");
                            }
                        });
                    });


                } else {

                    console.log('False');
                }


                var array = [];
                $('.button_select_photo_galerie').click(function () {
                    $('.container_loader').css('display', 'block');
                    $('.container_grid_photo').hide("slide");
                    $(this).css('display', 'none');


                    $(".photo_grid_each").each(function () {
                        if ($(this).hasClass("clickedTrue")) {
                            var id = $(this).attr('photoid');
                            array.push($(this).attr('photoid'));

                        }

                    });

                    $.ajax({
                        url:'choosePhoto',
                        type: "POST",
                        data: {
                            "array_photo": array
                        },
                        success: function (data)
                        {

                            // console.log(data);
                            $('.button_add_photo_galerie').css('display', 'block');
                            $('.show_photo2').show();
                            $('.show_photo2').html(data);
                            $('.container_loader').css('display', 'none');


                            var array_choice = [];
                            $('.button_add_photo_galerie').click(function () {
                                var idgalerie = $('.container_grid_galerie').attr('idgalerie');
                                $('.container_loader').css('display', 'block');
                                $('.photo_gridchoose_each').each(function () {

                                    var id_photo = $(this).attr('photoid');
                                    var order = $(this).next('.container_input_ordre ').children('.container_input').children('.order_choose').val();

                                    if( !order ) {

                                    } else {
                                        array_choice.push({id_photo:id_photo, order:order});
                                    }



                                });

                                console.log(idgalerie);

                                $.ajax({
                                    url:'addPhotoToGalerie',
                                    type: "POST",
                                    data: {
                                        "array_photo": array_choice,
                                        "idgalerie" : idgalerie
                                    },
                                    success: function (data)
                                    {

                                        location.reload();

                                    }
                                });

                            });

                        }
                    });



                })

            }
        });


        $.ajax({
            url: 'showgalerie',
            type: 'GET',
            success: function(data){
                if(data){
                    $('.container_loader').css('display', 'none');
                    $('.container_grid_galerie').html(data);

                    $(".delete_click_photo").each(function () {

                        $(this).click(function () {
                            $(this).parent('.photo_grid_each').parent('.photo_galerie').hide('slow');
                            id_photo = $(this).attr('photoid');

                            $.ajax({
                                url: 'DeletePhotoFromGalerie',
                                type: 'POST',
                                data: {id_photo: id_photo},
                                success: function (data) {

                                }

                            });

                        });


                    });

                }else {


                }
            }
        });


    });

    $('.register_menu').click(function () {
        $('#RegisterModal').modal('show');
    });

    $('.ajouter_photo_menu').click(function () {
        $('#AddPhotoModal').modal('show');
    });

    $('.show_photo_menu').click(function () {
        $('#ShowPhotoModal').modal('show');
    });

    $('.fos_user_registration_form').submit(function(event) {
        $('.container_loader').css('display', 'block');
        $('.erreur_login').removeClass('alert-success');
        $('.erreur_login').removeClass('alert-danger');
        $('.erreur_login').html('');
        event.preventDefault();
        var formData = $('.fos_user_registration_form').serialize();

        $.ajax({
            type: 'POST',
            url: $('.fos_user_registration_form').attr('action'),
            data: new FormData($('.fos_user_registration_form')[0]),
            processData: false,  contentType: false,  cache: false,
            success: function (response) {
                $('.erreur_register').css('display', 'block');
                var str = response;

                var res = str.replace(new RegExp('ERROR:', 'gi'), '');
                var res = res.replace(new RegExp('email:', 'gi'), '');
                var res = res.replace(new RegExp('username:', 'gi'), '');
                var res = res.replace(new RegExp('captcha:', 'gi'), '');

                if (str.indexOf("L'utilisateur a été créé avec succès") !=-1) {

                    $('.erreur_register').addClass('alert-success');
                    $('.erreur_register_h ').html(res);
                    $('.container_loader').css('display', 'none');

                } else {

                    $('.erreur_register').addClass('alert-danger');
                    $('.erreur_register_h ').html(res);
                    $('.container_loader').css('display', 'none');

                }


            }
        });

    });




});