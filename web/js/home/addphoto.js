$('#formAddPhoto').submit(function(event) {

    $('.response_photo').removeClass('alert alert-sucess');
    $('.response_photo').removeClass('alert alert-danger');
    event.preventDefault();
    var formData = $('#formAddPhoto').serialize();
    // console.log(formData);
    $.ajax({
        type: 'POST',
        url: $('#formAddPhoto').attr('action'),
        data: new FormData($('#formAddPhoto')[0]),
        processData: false,  contentType: false,  cache: false,
        success: function (response) {


            if (response.indexOf("ERROR") >= 0) {


                $('.response_photo').css('display', 'block');
                $('.response_photo').html(response.slice(16));
                $('.response_photo').addClass('alert alert-danger');


            } else {

                $('.response_photo').css('display', 'block');
                $('.response_photo').html(response);
                $('.response_photo').addClass('alert alert-success');


            }

        }
    });
});

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$(".upload_photo").change(function() {
    readURL(this);
    $('.image_preview').css('display', 'block');
});