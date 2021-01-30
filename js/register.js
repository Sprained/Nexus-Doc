$('input[name ="cep"]').keyup(function (e) {
    if ($(this).val().length == 8) {
        $.ajax({
            type: "POST",
            url: "classes/viacep.php",
            data: {
                cep: $(this).val()
            },
            success: function (res) {
                const json = JSON.parse(res);
                $('input[name ="rua"]').val(json.logradouro);
                $('input[name ="cidade"]').val(json.localidade);
                $('input[name ="uf"]').val(json.uf);
                $('input[name ="municipio"]').val(json.bairro);
            },
            error: function (res) {
                toastr.options = {
                    "positionClass": "toast-top-center"
                };
    
                toastr["error"](res);
            }
        });
    }
});

$('form').on('submit', function (e) {
    e.preventDefault();
    $('#submitButton').attr('disabled', true);

    const formValues = $(this).serialize();

    $.ajax({
        type: "POST",
        url: "classes/cadastro.php",
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