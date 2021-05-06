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
$(document).ready(function () {
    $("#archivo").fileinput({
        browseClass: 'btn btn-xs btn-secondary',
        language: "es",
        showCaption: true,
        showRemove: false,
        showUpload: false,
        showPreview: false,
        maxFileCount: 1,
        browseLabel: '',
        browseIcon: '<i class="fa fa-folder"></i>',
        allowedFileExtensions: ["png", "jpeg", "jpg", "bmp", "pdf"],
        uploadUrl: '/biblioteca/guardar-archivo-contribuyente',
        uploadAsync: true,
        uploadExtraData: function (previewId, index) {
            var info = {
                'id_archivo_categoria':$("#id_archivo_categoria").val(),
                'input1':$('[name="input1"]').val()
            };
            return info;
        }
    }).on("filebatchselected", function (event, files) {
        $("#archivo").fileinput("upload");
    });
});
