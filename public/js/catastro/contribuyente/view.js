function view_contribuyente(id)
{
    $('#btnGuardar').hide();
    $('#btnGuardar').addClass('invisible');
    $('#contribuyente_form')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // clear error class
    $('.text-danger').empty(); // clear error string
    $("#contribuyente_form :input").prop("disabled", true);

    $("#btnClose").prop("disabled", false);
    //Ajax Load data from ajax
    $.ajax({
    url : "/contribuyente/ver/" + id,
    type: "POST",
    dataType: "JSON",
    contentType: "application/json; charset=utf-8",
    success: function(data)
        {
            $('[name="nombre"]').val(data.nombre);
            $('[name="apellido_paterno"]').val(data.apellido_paterno);
            $('[name="apellido_materno"]').val(data.apellido_materno);
            $('[name="rfc"]').val(data.rfc);
            $('[name="curp"]').val(data.curp);
            $('[name="genero"]').val(data.genero);
            $('#myModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Detalle'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            console.log(data);
            alert('Error get data from ajax');
        }
    });
}
