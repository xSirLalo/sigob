'use strict'
var metodo;

$(document).ready(function() {
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
    metodo = 'actualizar';
    $('#bilioteca_categoria_form')[0].reset(); // Reinicia formulario del modal
    $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // Remueve todas las clases de error
    $('.text-danger').empty(); // Vacia los errores tipo texto
    $.ajax({
    url : "categoria/ver/" + id,
    type: "POST",
    dataType: "JSON",
    contentType: "application/json; charset=utf-8",
    success: function(data)
        {
            $('[name="input1"]').val(data.input1);
            $('[name="nombre"]').val(data.nombre);
            $('#modalCategoria').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar categoria'); // Set Title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function agregar() {
    metodo = 'agregar';
    $('#bilioteca_categoria_form')[0].reset(); // Reinicia formulario del modal
    $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // Remueve todas las clases de error
    $('.text-danger').empty(); // Vacia los errores tipo texto
    $('#modalCategoria').modal('show'); // Muestra el modal
    $('.modal-title').text('Agregar categoria'); // Establece el titulo del modal
}

function guardar() {
    if(metodo == 'agregar') {
        var url = 'categoria/agregar';
    } else {
        var url = 'categoria/editar';
    }
    var data = $("#bilioteca_categoria_form").serialize();
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
                $("#tablaCategorias").load(" #tablaCategorias");
                $('#modalCategoria').modal('hide'); // Oculta el modal cuando devuelva verdadero
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

function eliminar(id)
{
    metodo = 'eliminar';
    $('#eliminar_form')[0].reset(); // Reinicia formulario del modal
    $('.modal-title').text('Eliminar'); // Set Title to Bootstrap modal title
    $.ajax({
    url : "categoria/ver/" + id,
    type: "POST",
    dataType: "JSON",
    contentType: "application/json; charset=utf-8",
    success: function(data)
        {
            $('#modalEliminar').modal('show'); // show bootstrap modal when complete loaded
            $('[name="input1"]').val(data.input1);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

    if (metodo == 'eliminar') {
        $("#eliminar_form").submit(function(event){
            event.preventDefault();
            // var url = 'categoria/eliminar/' + id;
            // var url = 'categoria/eliminar';
            // var data =  $("#eliminar_form").serialize();
            $('[name="btnEliminar"]').attr('disabled', true); // Deshabilita el boton
            $('[name="btnEliminar"]').val('Eliminando..'); // Cambia el texto del boton
            $.ajax({
                // url: 'categoria/eliminar/' + id,
                url: 'categoria/eliminar',
                type: 'POST',
                dataType: 'JSON',
                async: true,
                data: $("#eliminar_form").serialize(),
                success: function (data) {
                console.log(data);
                if(data.status) //if success close modal and reload ajax table
                {
                    $('#modalEliminar').modal('hide'); // show bootstrap modal when complete loaded
                    $("#tablaCategorias").load(" #tablaCategorias");
                    $('[name="btnEliminar"]').attr('disabled', false); // Habilita el boton
                    $('[name="btnEliminar"]').val('Confirmar'); // Cambia el texto del boton
                } else {
                        $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // clear error class
                        $('.text-danger').empty(); // clear error string
                        $.each(data.errors, function(key, value) {
                            $('[name="'+ key +'"]').addClass('is-invalid');
                            for(var i in value) {
                                $('[name="'+ key +'"]').parents('.form-group').find('.text-danger').append('<li>' + value[i] + '</li>');
                            }
                        });
                        $('[name="btnEliminar"]').attr('disabled', false); // Habilita el boton
                        $('[name="btnEliminar"]').val('Confirmar'); // Cambia el texto del boton
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    // alert('Error get data from ajax');
                    $('[name="btnEliminar"]').attr('disabled', false); // Habilita el boton
                    $('[name="btnEliminar"]').val('Confirmar'); // Cambia el texto del boton
                }
            });
        });
    }
};
