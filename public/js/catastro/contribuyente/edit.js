function edit_contribuyente(id)
{
    save_method = 'update';
    $('#btnGuardar').show();
    $('#btnGuardar').removeClass('invisible');
    $('#contribuyente_form')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // clear error class
    $('.text-danger').empty(); // clear error string
    $("#contribuyente_form :input").prop("disabled", false);
    //Ajax Load data from ajax
    $.ajax({
    url : "contribuyente/ver/" + id,
    type: "POST",
    dataType: "JSON",
    contentType: "application/json; charset=utf-8",
    success: function(data)
        {
            $('[name="id_contribuyente"]').val(data.id_contribuyente);
            $('[name="nombre"]').val(data.nombre);
            $('[name="apellido_paterno"]').val(data.apellido_paterno);
            $('[name="apellido_materno"]').val(data.apellido_materno);
            $('[name="rfc"]').val(data.rfc);
            $('[name="curp"]').val(data.curp);
            $('[name="genero"]').val(data.genero);
            $('#myModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar'); // Set Title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

    if(save_method == 'update') {
        $("#contribuyente_form").submit(function(event){
            event.preventDefault();
            var id = $("#id_contribuyente").val();
            var url = 'contribuyente/editar/' + id;
            $.ajax({
                url: url,
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
