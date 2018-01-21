$(document).ready(function () {

    $('.delete_button').each(function () {

        $(this).click(function () {
            $('.container_loader').css('display', 'block');
            var idaccount = $(this).attr('idaccount');

            $.ajax({
                url:'DeleteAccount',
                type: "POST",
                data: {
                    "idaccount": idaccount
                },
                success: function (data)
                {

                    location.reload();

                }
            });

        });

    });

    $('.button_admin_enable').each(function () {

        $(this).click(function () {
            $('.container_loader').css('display', 'block');
            var idaccount = $(this).attr('idaccount');

            $.ajax({
                url:'EnableAccount',
                type: "POST",
                data: {
                    "idaccount": idaccount
                },
                success: function (data)
                {

                    location.reload();

                }
            });

        });
    });


});
