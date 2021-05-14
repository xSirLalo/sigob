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
//     let id = $(event.relatedTarget).attr('data-id');
//     $('.modal-title').text('Eliminar ' + id);
//     $(this).find(".btn-ok").click(function() {
//         $.ajax({
//             url: 'categoria/eliminar/' + id,
//             type: 'POST',
//             cache:false,
//             success: function () {
//                 $("#tablaCategorias").load(" #tablaCategorias");
//                 $('#modalEliminar').trigger("reset");
//                 $(this).removeData('bs.modal');
//                 $('#modalEliminar').modal('hide'); // show bootstrap modal when complete loaded
//             },
//             error: function ()
//             {
//                 console.log();
//                 alert('Error get data from ajax');
//             }
//         });
//         return false;
//     });
// });

// $('#modalEliminar').on('show.bs.modal', function(e) {
//     $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
//     $('.debug-url').html('URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
// });

// $('#modalEliminar').click(function(){
//     var ID = $(this).data('id');
//     $('#btn-ok').data('id', ID); //set the data attribute on the modal button
//     $('.debug-url').html('URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
// });

// $('#btn-ok').click(function(){
//     var ID = $(this).data('id');
//     $.ajax({
//         url: 'categoria/eliminar/' + ID
//     });
// });
function eliminar(id)
{
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

    $("#eliminar_form").submit(function(event){
        event.preventDefault();
        var url = 'categoria/eliminar/' + id;
        var data =  $("#eliminar_form").serialize();
        $('#btnEliminar').attr('disabled', true); // Deshabilita el boton
        $('#btnEliminar').val('Eliminando..'); // Cambia el texto del boton
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            async: true,
            data: data,
            success: function (data) {
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modalCategoria').modal('hide'); // show bootstrap modal when complete loaded
                $("#tablaCategorias").load(" #tablaCategorias");
                $('#btnEliminar').attr('disabled', false); // Habilita el boton
                $('#btnEliminar').val('Confirmar'); // Cambia el texto del boton
            } else {
                    $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // clear error class
                    $('.text-danger').empty(); // clear error string
                    $.each(data.errors, function(key, value) {
                        $('[name="'+ key +'"]').addClass('is-invalid');
                        for(var i in value) {
                            $('[name="'+ key +'"]').parents('.form-group').find('.text-danger').append('<li>' + value[i] + '</li>');
                        }
                    });
                    $('#btnEliminar').attr('disabled', false); // Habilita el boton
                    $('#btnEliminar').val('Confirmar'); // Cambia el texto del boton
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
                $('#btnGuardar').attr('disabled', false); // Habilita el boton
                $('#btnGuardar').val('Confirmar'); // Cambia el texto del boton
            }
        });
    });
};
