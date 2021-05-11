$(document).ready(function() {
    $("#btnGuardar").click( function() {

    })
});

function agregarCategoria()
{
    metodo = 'agregar';
    $('#btnGuardar').show();
    $('#btnGuardar').removeClass('invisible');
    $('#bilioteca_categoria_form')[0].reset(); // Reinicia formulario del modal
    $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // Remueve todas las clases de error
    $('.text-danger').empty(); // Vacia los texto errores
    $("#bilioteca_categoria_form :input").prop("disabled", false);
    $('#modalAgregar').modal('show'); // Muestra el modal
    $('.modal-title').text('Agregar nueva categoria'); // Establece el titulo del modal
    $('#form_update').attr('id','bilioteca_categoria_form');
    
    if(metodo == 'agregar') {
        $("#bilioteca_categoria_form").submit(function(event){
            $('#btnGuardar').attr('disabled', true); // Deshabilita el boton
            $('#btnGuardar').val('Guardando...'); // Cambia el texto del boton
            var url = 'categoria/agregar';
            var data = $("#bilioteca_categoria_form").serialize();
            event.preventDefault();
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
                        $('#modalAgregar').modal('hide'); // Oculta el modal cuando devuelva verdadero
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
                    console.log(data);
                    alert('Error get data from ajax');
                    $('#btnGuardar').attr('disabled', false); // Habilita el boton
                    $('#btnGuardar').val('Guardar'); // Cambia el texto del boton
                }
            });
        });
    }
}