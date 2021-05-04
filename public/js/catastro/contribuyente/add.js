
'use strict';
$(document).on('keydown', '.js-select2-persona', function(e) {
    if (e.originalEvent && e.which == 40) {
        e.preventDefault();
        $(this).siblings('select').select2('open');
    }
});

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


    $('.custom-file input').change(function (e) {
        var files = [];
        for (var i = 0; i < $(this)[0].files.length; i++) {
            files.push($(this)[0].files[i].name);
        }
        $(this).next('.custom-file-label').html(files.join(', '));
    });

    function formatRepo(repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'>" + repo.item_select_name + "</div>";

        return markup;
    }
    tipoPersonaCambia();

    $("#tipo_persona").change(function() {
        tipoPersonaCambia();
    });

    function formatRepoSelection(repo) {
        return repo.item_select_name || repo.text;
    }

    $(".js-select2-persona").select2({
        selectOnClose: true,
        language: {
            errorLoading:function(){return"La carga falló"},
            inputTooLong:function(e){var t=e.input.length-e.maximum,n="Por favor, elimine "+t+" car";return t==1?n+="ácter":n+="acteres",n},
            inputTooShort:function(e){var t=e.minimum-e.input.length,n="Por favor, introduzca "+t+" car";return t==1?n+="ácter":n+="acteres",n},
            loadingMore:function(){return"Cargando más resultados…"},
            maximumSelected:function(e){var t="Sólo puede seleccionar "+e.maximum+" elemento";return e.maximum!=1&&(t+="s"),t},
            noResults:function(){return"No se encontraron resultados"},
            searching:function(){return"Buscando…"}
        },
        width: '100%',
        ajax: {
            url: "/contribuyente/buscar-persona",
            dataType: 'JSON',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;

                return {
                    //results: data.items2,
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatRepo, // omitted for brevity, see the source of this page
        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });

    $('.js-select2-persona').change(function(){
        var id = $(this).val();
        var url = '/contribuyente/autorellenaPersona/'+id;
        // AJAX request
        $.ajax({
        url: url,
        method: 'POST',
        dataType: 'JSON',
        async: true,
        success: function(data)
        {
            console.log(data);
            $('[name ="input1"]').val(data.contribuyente_id);
            $('[name ="nombre"]').val(data.nombre);
            $('[name ="apellido_paterno"]').val(data.apellido_paterno);
            $('[name ="apellido_materno"]').val(data.apellido_materno);
            $('[name ="tipo_persona"]').val(data.tipo_persona);
            $('[name ="rfc"]').val(data.rfc);
            $('[name ="curp"]').val(data.curp);
            $('[name ="razon_social"]').val(data.razon_social);
            $('[name ="correo"]').val(data.correo);
            $('[name ="telefono"]').val(data.telefono);
            $('[name ="genero"]').val(data.genero);
        },
        error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(data);
            }
        });
    });
});
