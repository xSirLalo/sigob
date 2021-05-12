'use strict';
$(document).on('keydown', '.js-select2-predio', function(e) {
    if (e.originalEvent && e.which == 40) {
        e.preventDefault();
        $(this).siblings('select').select2('open');
    }
});

$(document).ready(function () {
    function formatRepo(repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'>" + repo.item_select_name + "</div>";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.item_select_name || repo.text;
    }

    $(".js-select2-predio").select2({
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
            url: "/predio/buscarCatastral",
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

    $('.js-select2-predio').change(function(){
        var id = $(this).val();
        var url = '/predio/autorellenaCatastral/' + id;
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'JSON',
            async: true,
        success: function(data)
        {
            console.log(data);

            $('[name ="input1"]').val(data.predio_id);
            $('[name ="ultimo_ejercicio_pagado"]').val(data.ultimo_ejercicio_pagado);
            $('[name ="ultimo_periodo_pagado"]').val(data.ultimo_periodo_pagado);
            $('[name ="localidad"]').val(data.localidad);
            $('[name ="municipio"]').val(data.municipio);
            $('[name ="colonia"]').val(data.colonia);
            $('[name ="calle"]').val(data.calle);
            $('[name ="numero_interior"]').val(data.numero_interior);
            $('[name ="numero_exterior"]').val(data.numero_exterior);
            $('[name ="titular"]').val(data.titular);
            $('[name ="titular_anterior"]').val(data.titular_anterior);
        },
        error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(data);
            }
        });
    });
});

