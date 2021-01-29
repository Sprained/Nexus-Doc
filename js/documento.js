$('select[name="plano"]').change(function() {
    $.ajax({
        type: "POST",
        url: "classes/session.php",
        data: {
            plano: $(this).val()
        }
    })
});