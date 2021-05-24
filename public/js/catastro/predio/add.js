'use strict';
$(document).on('keydown', '.js-select2-predio', function(e) {
    if (e.originalEvent && e.which == 40) {
        e.preventDefault();
        $(this).siblings('select').select2('open');
    }
});

$(document).ready(function () {
    //obtenemos el valor de los input
    $('#adicionar').click(function() {
        var puntoCardinal = document.getElementById("puntoCardinal").value;
        var colindaCon = document.getElementById("colindaCon").value;
        var medidasMetro = document.getElementById("medidasMetro").value;
        var observacionesColindancias = document.getElementById("observacionesColindancias").value;
        
        var i = 1; //contador para asignar id al boton que borrara la fila
        var fila = '<tr id="row' + i + '"><td>' + puntoCardinal + '</td><td>' + colindaCon + '</td><td>' + medidasMetro + '</td><td>' + observacionesColindancias + '</td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Quitar</button></td></tr>'; //esto seria lo que contendria la fila

        i++;

        $('#mytable tr:first').after(fila);
        $("#adicionados").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
        var nFilas = $("#mytable tr").length;
        $("#adicionados").append(nFilas - 1);
        //le resto 1 para no contar la fila del header
        document.getElementById("medidasMetro").value ="";
        document.getElementById("observacionesColindancias").value = "";
        document.getElementById("colindaCon").value = "";
        document.getElementById("puntoCardinal").value = "";
        
        $('#AgregarColindanciaModal').modal('hide');
    });

    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        //cuando da click obtenemos el id del boton
        $('#row' + button_id + '').remove(); //borra la fila
        //limpia el para que vuelva a contar las filas de la tabla
        $("#adicionados").text("");
        var nFilas = $("#mytable tr").length;
            $("#adicionados").append(nFilas - 1);
    });

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



function filterFloat(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{
            return true;
        }
    }else{
        if(key == 8 || key == 13 || key == 0) {
            return true;
        }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{
                    return true;
                }
        }else{
            return false;
        }
    }

}

function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,5})$/;
    if(preg.test(__val__) === true){
        return true;
    }else{
        return false;
    }
}