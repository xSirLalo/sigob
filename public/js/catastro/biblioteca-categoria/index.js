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
    $("#btnGuardar").click( function() {

    })
});

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
                                $.notify({
                                        icon: '',
                                        title: key,
                                        message: value[i],
                                        url: ''
                                    }, {
                                        element: 'body',
                                        type: "inverse",
                                        allow_dismiss: false,
                                        placement: {
                                            from: "top",
                                            align: "right"
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
                                            enter: "animated fadeIn",
                                            exit: "animated fadeOut"
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

// $('#modalEliminar').on('show.bs.modal', function (event) {
//     var button = $(event.relatedTarget)
//     var id = button.data('id')
//     var url = 'categoria/eliminar/' + id;
//     $('.modal-title').text('Eliminar')
//     $(this).find( ".btn-ok" ).click(function() {
//         $.ajax({
//             url: url,
//             type: 'POST',
//             dataType: 'JSON',
//             async: true,
//             success: function () {
//                 $("#tablaCategorias").load(" #tablaCategorias");
//                 $('#modalEliminar').modal('hide'); // show bootstrap modal when complete loaded
//             },
//             error: function (jqXHR, textStatus, errorThrown)
//             {
//                 console.log();
//                 alert('Error get data from ajax');
//             }
//         });
//     });
// })

$('#modalEliminar').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    $('.debug-url').html('URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
});
