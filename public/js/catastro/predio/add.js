'use strict';
$(document).ready(function () {
    function formatRepo(repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'>" + repo.titular + "</div>";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.titular || repo.text;
    }

    $(".js-data-example-ajax2").select2({
        width: '100%',
        ajax: {
        //url: "/aportacion/buscar_ajax",
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

    $('.js-data-example-ajax2').change(function(){
        var id = $(this).val();
        var url = '/predio/autorellenaCatastral/'+id;
        // AJAX request
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'JSON',
            async: true,
        success: function(data)
        {
                console.log(data);
                $('[name ="titular"]').val(data.titular);
                $('[name ="ubicacion"]').val(data.ubicacion);
                $('[name ="titular_anterior"]').val(data.titular_anterior);
                $('[name ="con_norte"]').val(data.con_norte);
                $('[name ="con_sur"]').val(data.con_sur);
                $('[name ="con_este"]').val(data.con_este);
                $('[name ="con_oeste"]').val(data.con_oeste);
                $('[name ="norte"]').val(data.norte);
                $('[name ="sur"]').val(data.sur);
                $('[name ="este"]').val(data.este);
                $('[name ="oeste"]').val(data.oeste);
        },
        error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(data);
                // $('#modal_alert').modal('show'); // show bootstrap modal
            }
        });
    });
});
