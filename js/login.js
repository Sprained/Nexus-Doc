$('form').on('submit', function (e) {
    e.preventDefault();
    $('#submitButton').attr('disabled', true);

    const formValues = $(this).serialize();

    $.ajax({
        type: "POST",
        url: "classes/login.php",
        data: formValues,
        success: function (res) {

            $('#submitButton').attr('disabled', false);

            $('form').each(function () {
                this.reset();
            });

            toastr.options = {
                "positionClass": "toast-top-center"
            };

            toastr["success"](res);
        },
        error: function (res) {
            toastr.options = {
                "positionClass": "toast-top-center"
            };

            toastr["warning"](res.responseText);
        }
    });
});