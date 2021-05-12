$(document).ready(function() {
    $("#btnGuardar").click( function() {

    })
});

function agregarCategoria()
{
    metodo = 'agregar';
    $('#bilioteca_categoria_form')[0].reset(); // Reinicia formulario del modal
    $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // Remueve todas las clases de error
    $('.text-danger').empty(); // Vacia los errores tipo texto
    $('#modalCategoria').modal('show'); // Muestra el modal
    $('.modal-title').text('Agregar categoria'); // Establece el titulo del modal
    
    if(metodo == 'agregar') {
        $("#bilioteca_categoria_form").submit(function(event){
            event.preventDefault();
            var url = 'categoria/agregar';
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
        });
    }
}

function editarCategoria(id)
{
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
            $('[name="nombre"]').val(data.nombre);
            $('#modalCategoria').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar categoria'); // Set Title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

    if(metodo == 'actualizar') {
        $("#bilioteca_categoria_form").submit(function(event){
            event.preventDefault();
            var url = 'categoria/editar/' + id;
            var data =  $("#bilioteca_categoria_form").serialize();
            $('#btnGuardar').attr('disabled', true); // Deshabilita el boton
            $('#btnGuardar').val('Guardando...'); // Cambia el texto del boton
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                async: true,
                data: data,
                success: function (data) {
                if(data.status) //if success close modal and reload ajax table
                {
                    $("#tablaCategorias").load(" #tablaCategorias");
                    $('#modalCategoria').modal('hide'); // show bootstrap modal when complete loaded
                    $('#btnGuardar').attr('disabled', false); // Habilita el boton
                    $('#btnGuardar').val('Guardar'); // Cambia el texto del boton
                } else {
                        $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // clear error class
                        $('.text-danger').empty(); // clear error string
                        $.each(data.errors, function(key, value) {
                            $('[name="'+ key +'"]').addClass('is-invalid');
                            for(var i in value) {
                                $('[name="'+ key +'"]').parents('.form-group').find('.text-danger').append('<li>' + value[i] + '</li>');
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
        });
    }
}
