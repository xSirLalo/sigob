
'use strict';
$(document).ready(function () {
    function formatRepo(repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'>" + repo.palabra_respuesta + "</div>";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.palabra_respuesta || repo.text;
    }

    $(".js-select2-persona").select2({
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

    // $('#persona').on('select2:select', function (e) {
    //     console.log('asd');
    // });

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
                $('[name ="cve_persona"]').val(data.cve_persona);
                $('[name ="nombre"]').val(data.nombre);
                $('[name ="apellido_paterno"]').val(data.apellido_paterno);
                $('[name ="apellido_materno"]').val(data.apellido_matero);
                $('[name ="rfc"]').val(data.rfc);
                $('[name ="curp"]').val(data.curp);
                $('[name ="razon_social"]').val(data.razon_social);
                $('[name ="correo"]').val(data.correo);
                $('[name ="telefono"]').val(data.telefono);
                $('[name ="genero"]').val(data.genero);
                $('[name ="input1"]').val(data.cve_persona);

        },
        error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(data);
                // $('#modal_alert').modal('show'); // show bootstrap modal
            }
        });
    });
});
