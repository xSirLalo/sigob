$(document).ready(function () {
    $('#besicwizard').bootstrapWizard({
        withVisible: false,
        'nextSelector': '.button-next',
        'previousSelector': '.button-previous',
        'firstSelector': '.button-first',
        'lastSelector': '.button-last'
    });

    $(".js-example-basic-single").select2();

});
    $('.btn-ok').on('click', function(e) {
        event.preventDefault(e);
        var form = $(this).parents('form');
        swal({
                title: "Good job!",
                text: "Aportación generada!",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log('Subimit...');
                    if (willDelete) form.submit();
                    swal("Descargando...", {
                        icon: "success",
                    }).then((willOk) => {
                        console.log('Redirect...');
                        if (willOk)  window.location = "/aportacion";
                    });
                } else {
                    swal("Fin!", {
                        icon: "error",
                    }).then((willCancel) => {
                        if (willCancel)  window.location = "/";
                    });
                }
            });
    });
    function Calcular() {

        //
        var te = 0;
        te = parseFloat(document.getElementById("terreno").value);
        var re = te * 100;
        document.getElementById("v_terreno").value = re;
        //  Calculo valor Construccion
        var inv = 0;
        var supm = 0;
        inv = parseFloat(document.getElementById("v_in").value);
        supm = parseFloat(document.getElementById("sup_m").value);
        var res = supm * inv;
        document.getElementById("v_c").value = res;
        //Avaluo Total
        //var at = re + res ;
        //document.getElementById("a_total").value = at;
        var at = re + res;
        document.getElementById("a_total").value = at;
        var vat = document.getElementById("terreno").value;
        if (vat.length == 0) {
            document.getElementById("v_terreno").value = 0;
        }
        var vac = document.getElementById("sup_m").value;
        var vai = document.getElementById("v_in").value;
        if (vac.length == 0) {
            document.getElementById("v_c").value = 0;
            document.getElementById("a_total").value = 0;
        }
        if (vai.length == 0) {
            document.getElementById("v_c").value = 0;
            document.getElementById("a_total").value = 0;
        }
    }
    function valorC() {

        //var x= parseFloat(document.getElementById("xd").value);
        var d = document.getElementById("valor_c");
        var displaytext = d.options[d.selectedIndex].value;
        //var w = parseFloat(displaytext)+x;
        document.getElementById("v_in").value = displaytext;
        var xd = parseFloat(document.getElementById("sup_m").value);
        var w = displaytext * xd;
        document.getElementById("v_c").value = w;
        //-->
        var te = parseFloat(document.getElementById("terreno").value);
        var re = te * 100;
        document.getElementById("v_terreno").value = re;
        //  Calculo valor Construccion
        var inv = parseFloat(document.getElementById("v_in").value);
        var supm = parseFloat(document.getElementById("sup_m").value);
        var res = supm * inv;
        document.getElementById("v_c").value = res;
        //Avaluo Total
        //var at = re + res ;
        //document.getElementById("a_total").value = at;
        var at = re + res;
        document.getElementById("a_total").value = at;
        //<--
        var vai = document.getElementById("v_in").value;
        if (vai.length == 0) {
            document.getElementById("v_c").value = 0;
            document.getElementById("a_total").value = 0;
        }
        var vas = document.getElementById("sup_m").value;
        if (vas.length == 0) {
            document.getElementById("v_c").value = 0;
            document.getElementById("a_total").value = 0;
        }
    }
    //select Tasa impositiva
    function timpositiva() {
        //var x= parseFloat(document.getElementById("xd").value);
        var d = document.getElementById("tasa_i");
        var displaytext = d.options[d.selectedIndex].value;
        //var w = parseFloat(displaytext)+x;
        //document.getElementById("v_in").value=displaytext;
        var xd = parseFloat(document.getElementById("a_total").value);
        var w = displaytext * xd;
        document.getElementById("pago_a").value = w;
        document.getElementById("p_hide").value = w;
        //document.getElementById("pago_as").value = w;
    }

//Funcion Solo numeros con 1 punto y maximo dos decimales
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
//Bloquear Button de Imprimir si estan vacios los input
}
function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
    if(preg.test(__val__) === true){
        return true;
    }else{
        return false;
    }

}
//validar solo numero
function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
    return true;
    }
    return false;
}

function esvacio()
{

if (
document.getElementById('terreno').value=="" ||
document.getElementById('sup_m').value=="" ||
document.getElementById('ejercicio_f').value=="" ||
document.getElementById('p_hide').value==""

)
{
document.getElementById('btn-ok').disabled=true;
}
else {
document.getElementById('btn-ok').disabled=false;
}

}

//Selec Ajax

$(document).ready(function () {
function formatRepo(repo) {
    if (repo.loading) return repo.text;

    var markup = "";
    if (repo.titular) {
        markup += "<div class='select2-result-repository__description'>" + repo.titular + "</div>";
    }

    return markup;
}

function formatRepoSelection(repo) {
    return repo.titular || repo.text;
}
// [ Single Select ]
$(".js-example-basic-single2").select2({
        width: '100%',
});

$(".js-data-example-ajax2").select2({
    width: '100%',
    ajax: {
       //url: "/aportacion/buscar_ajax",
        url: "/aportacion/buscarCatastral",
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
    var url = '/aportacion/autorellenaCatastral/'+id;
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
            $('[name ="cvepredio"]').val(data.cvepredio);
         // Mostrar campos ocultas si encontraste algo en la base de datos
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
       $('#modal_alert').modal('show'); // show bootstrap modal
        }
    });
});
//enviar id por referencia en Javascript
$("#asd").click(function(e){
    e.preventDefault();
    var combo = document.getElementById("contribuyente_id");
    var selected = combo.options[combo.selectedIndex].value;
    window.location.href ="aportacion/agregar2/" + selected;
})

$("#formato").hide();

//Funcion Ocultar modal
$('#MyModal').on('hide.bs.modal', function(event) {
//limpiar los input del Modal
//$(this).find('form')[0].reset();
$('#agregar_form')[0].reset();
//Limpiar el selec del modal
$('.js-data-example-ajax2').empty();
$('.js-data-example-ajax2').select2("val", "");
//Oculatar la parte del calculo
$("#formato").hide();
//$(this).find('form')[0].reset();


})
});
