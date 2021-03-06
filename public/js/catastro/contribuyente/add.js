function add_contribuyente()
{
    save_method = 'add';
    $('#btnGuardar').show();
    $('#btnGuardar').removeClass('invisible');
    $('#contribuyente_form')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // clear error class
    $('.text-danger').empty(); // clear error string
    $("#contribuyente_form :input").prop("disabled", false);
    $('#myModal').modal('show'); // show bootstrap modal
    $('.modal-title').text('Agregar'); // Set Title to Bootstrap modal title
    $('#form_update').attr('id','contribuyente_form');

    if(save_method == 'add') {
    $("#contribuyente_form").submit(function(event){
        event.preventDefault();
        var URL = 'contribuyente/agregar';
        //Ajax Load data from ajax
        $.ajax({
            url: URL,
            type: 'POST',
            dataType: 'JSON',
            async: true,
            data: $("#contribuyente_form").serialize(),
            success: function (data) {
                if(data.status) //if success close modal and reload ajax table
                {
                    location.reload();
                    $('#myModal').modal('hide'); // show bootstrap modal when complete loaded
                } else {
                    $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // clear error class
                    $('.text-danger').empty(); // clear error string
                    $.each(data.errors, function(key, value) {
                        $('[name="'+ key +'"]').addClass('is-invalid');
                        for(var i in value) {
                            $('[name="'+ key +'"]').parents('.form-group').find('.text-danger').append('<li>' + value[i] + '</li>');
                        }
                    });
                }
                $('#btnGuardar').val('Guardar'); //change button text
                $('#btnGuardar').attr('disabled',false); //set button enable
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(data);
                alert('Error get data from ajax');
            }
        });
    });
    }
}
