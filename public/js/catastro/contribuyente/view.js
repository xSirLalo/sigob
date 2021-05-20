'use strict'
function tipoPersonaCambia() {
    var tipoPersonaSeleccionado = $('#tipo_persona').find(":selected").val();

    if(tipoPersonaSeleccionado=='M') {
            $('#pNombre').removeClass('col-md-3');
            $('#pNombre').addClass('col-md-9');
            $('#aMaterno').hide();
            $('#aPaterno').hide();
            $('#pFisica').hide();
    } else if(tipoPersonaSeleccionado=='F') {
            $('#pNombre').removeClass('col-md-9');
            $('#pNombre').addClass('col-md-3');
            $('#aMaterno').show();
            $('#aPaterno').show();
            $('#pFisica').show();
    }
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
        uploadUrl: '/biblioteca/guardar-archivo',
        uploadAsync: true,
        uploadExtraData: function (previewId, index) {
            var info = {
                'id_archivo_categoria':$("#id_archivo_categoria").val(),
                'input1':$('[name="input1"]').val(),
                'relacion': "ArchivoContribuyente"
            };
            return info;
        }
    }).on("filebatchselected", function (event, files) {
        $("#archivo").fileinput("upload");
    });

    $("#archivo").on('fileuploaded', function(event, data, previewId, index) {
        var data = data.response;
        // console.log(data);
        if(data.response == "ok"){
            $('#subirArchivoForm')[0].reset();
            $("#archivosList").load(" #archivosList");
            $('#subirArchivoModal').modal('hide');
        }else{
            alert("Error: " + data.error);
        }
    });

    tipoPersonaCambia();

    $("#tipo_persona").change(function() {
        tipoPersonaCambia();
    });

    $('input').blur(function () {
        if( !$(this).val() ) {
            $(this).addClass('is-invalid');
        } else if ($(this).val()) {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).parents('.form-group').find('.text-danger').empty();
        }
    });
});

function notify(from, align, icon, title, message, type, animIn, animOut) {
    $.notify({
        icon: icon,
        title: title,
        message: message,
        url: ''
    }, {
        element: 'body',
        type: type,
        allow_dismiss: true,
        placement: {
            from: from,
            align: align
        },
        offset: {
            x: 30,
            y: 30
        },
        spacing: 10,
        z_index: 999999,
        delay: 2500,
        timer: 1000,
        url_target: '_blank',
        mouse_over: false,
        animate: {
            enter: animIn,
            exit: animOut
        },
        icon_type: 'class',
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                        '<span data-notify="icon"></span> ' +
                        '<span data-notify="title">{1}</span> ' +
                        '<span data-notify="message">{2}</span>' +
                        '<div class="progress" data-notify="progressbar">' +
                            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                        '</div>' +
                        '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    '</div>'
    });
};


function editar(id) {
    $('#contribuyente_form')[0].reset(); // Reinicia formulario del modal
    $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // Remueve todas las clases de error
    $('.text-danger').empty(); // Vacia los errores tipo texto
    $.ajax({
    url : "/contribuyente/verAjax/" + id,
    type: "POST",
    dataType: "JSON",
    contentType: "application/json; charset=utf-8",
    success: function(data)
        {
            console.log(data);
            $('[name ="input1"]').val(data.id);
            $('[name ="nombre"]').val(data.nombre);
            $('[name ="apellido_paterno"]').val(data.apellido_paterno);
            $('[name ="apellido_materno"]').val(data.apellido_materno);
            console.log(data.fecha_nacimiento);
            if (data.fecha_nacimiento) {
                const dateTime = data.fecha_nacimiento['date'];
                let dateTimeParts = dateTime.split(/[- :]/); // regular expression split that creates array with: year, month, day, hour, minutes, seconds values
                dateTimeParts[1]--; // monthIndex begins with 0 for January and ends with 11 for December so we need to decrement by one
                const dateObject = new Date(...dateTimeParts); // our Date object
                $('[name ="year"]').val(dateTimeParts[0]);
                
                var month = parseInt(dateTimeParts[1]) + parseInt(1);
                if (month <= 9) month = "0" + month
                $('[name ="month"]').val(month);

                var days = dateTimeParts[2];
                if (days <= 9) days = "0" + days
                $('[name ="day"]').val(days);
            }
            $('[name ="estado_civil"]').val(data.estado_civil);
            $('[name ="genero"]').val(data.genero);
            $('[name ="tipo_persona"]').val(data.tipo_persona);
            
            tipoPersonaCambia();

            $("#tipo_persona").change(function() {
                tipoPersonaCambia();
            });

            $('[name ="rfc"]').val(data.rfc);
            $('[name ="curp"]').val(data.curp);
            $('[name ="razon_social"]').val(data.razon_social);
            $('[name ="correo"]').val(data.correo);
            $('[name ="telefono"]').val(data.telefono);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function guardar() {
    var url = '/contribuyente/editar';
    var data = $("#contribuyente_form").serialize();
    $('#btnGuardar').attr('disabled', true); // Deshabilita el boton
    $('#btnGuardar').val('Guardando...'); // Cambia el texto del boton
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: data,
        success: function (data) {
            console.log(data);
            if(data.status) //if success close modal and reload ajax table
            {
                $("#tablaDatos").load(" #tablaDatos");
                $('#editarModal').modal('hide'); // Oculta el modal cuando devuelva verdadero
                $('#btnGuardar').attr('disabled', false); // Habilita el boton
                $('#btnGuardar').val('Guardar'); // Cambia el texto del boton
            } else {
                $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // Remueve todas las clases de error
                $('.text-danger').empty(); // Vacia los texto errores
                $.each(data.errors, function(key, value) {
                    $('[name="'+ key +'"]').addClass('is-invalid');
                    for(var i in value) {
                        $('[name="'+ key +'"]').parents('.form-group').find('.text-danger').append('<li>' + value[i] + '</li>');
                        $('[name="'+ key +'"]').focus();
                        notify('top', 'right', '', $('label[for="'+ key +'"]').text(), value[i], 'inverse', 'animated fadeIn', 'animated fadeOut');
                    }
                });
                $('#btnGuardar').attr('disabled', false); // Habilita el boton
                $('#btnGuardar').val('Guardar'); // Cambia el texto del boton
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
            $('#btnGuardar').attr('disabled', false); // Habilita el boton
            $('#btnGuardar').val('Guardar'); // Cambia el texto del boton
        }
    });
}