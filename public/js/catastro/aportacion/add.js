$(document).ready(function () {
    $("#trhidden").hide();

    $('#besicwizard').bootstrapWizard({
        withVisible: false,
        'nextSelector': '.button-next',
        'previousSelector': '.button-previous',
        'firstSelector': '.button-first',
        'lastSelector': '.button-last'
    });



    // $(".js-example-basic-single").select2(




});
    $('.btn-ok').on('click', function(e) {
        event.preventDefault(e);

        let fechaAdquicision = document.getElementById("fecha_adquisicion").value;
        let fecha = document.getElementById("vig").value;
        let norte = document.getElementById("norte").value;
        let sur = document.getElementById("sur").value;
        let este = document.getElementById("este").value;
        let oeste = document.getElementById("oeste").value;
        if (fechaAdquicision.length == 0) {
            alert("Se requiere agregar una Fecha de adquicision");
            return false;
        }else if(fecha.length == 0) {
            alert("Se requiere agregar una Fecha");
            return false;
        }else if(norte.length == 0|| sur.length == 0 || este.length == 0 || oeste.length == 0) {
            alert("Se requiere agregar datos de las colindancias");
            return false;
        }

    else{
        var form = $(this).parents('form');
        swal({
                title: "Buen trabajo!",
                text: "Aportación generada!",
                icon: "info",
                buttons: true,
                dangerMode: true,
                closeOnClickOutside: false,
                closeOnEsc: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log('Subimit...');
                    if (willDelete) form.submit();
                    swal("Descargando...", {
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        icon: "success",
                    }).then((willOk) => {
                        console.log('Redirect...');
                        if (willOk)  window.location = "/aportacion";
                    });
                } else {
                    swal("Aportacion cancelada!", {
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        icon: "error",
                    }).then((willCancel) => {
                        // if (willCancel)  window.location = "/aportacion";
                    });
                }
            });
        }

    });

//formato moneda
var formatter = new Intl.NumberFormat('en-US', {
style: 'currency',
currency: 'USD',
});
//funcion Calular Aportacion-Inicio
    function Calcular()
{
    let metros_terreno = parseFloat(document.getElementById("terreno").value);
    let valor_m2_zona = parseFloat(document.getElementById("valor_zona").value);
    let valor_terreno = metros_terreno * valor_m2_zona;
    document.getElementById("v_terreno").value = formatter.format(valor_terreno);
    //  Calculo valor Construccion
    let inv = parseFloat(document.getElementById("v_in").value);
    let metros_construccion = parseFloat(document.getElementById("sup_m").value);
    let valor_construnccion = metros_construccion * inv;
    document.getElementById("v_c").value = formatter.format(valor_construnccion);
    //Avaluo Total
    let avaluo_total = valor_terreno + valor_construnccion;
    document.getElementById("a_total").value = formatter.format(avaluo_total);
    document.getElementById("avaluo_hidden").value = avaluo_total;
    //validaciones
    let m_terreno = document.getElementById("terreno").value;
    let m_valorZona = document.getElementById("valor_zona").value;
    let m_construnccion = document.getElementById("sup_m").value;
    let valor_oculto = document.getElementById("v_in").value;
    //valida si el campo metros Terreno esta vacio
    if (m_terreno.length == 0) {
        document.getElementById("v_terreno").value = formatter.format(0);
        document.getElementById("a_total").value = formatter.format(0);
        document.getElementById("avaluo_hidden").value = 0;
    }
    // //valida si el campo valor m2 zona esta vacio
    if (m_valorZona.length == 0) {
        document.getElementById("v_terreno").value = formatter.format(0);
        document.getElementById("a_total").value = formatter.format(0);
        document.getElementById("avaluo_hidden").value = 0;
    }
    //valida si el campo metros Construccion esta vacio
    if (m_construnccion.length == 0) {
        document.getElementById("v_c").value = formatter.format(0);
        document.getElementById("a_total").value = formatter.format(0);
        document.getElementById("avaluo_hidden").value = 0;
    }
   //valida si el campo oculto no tiene valor
    if (valor_oculto.length == 0) {
        document.getElementById("v_c").value = formatter.format(0);
        document.getElementById("v_in").value = 0;
        document.getElementById("a_total").value = formatter.format(0);
        document.getElementById("avaluo_hidden").value = 0;
    }
     //Tasa_impositiva
    let select_tasa = document.getElementById("tasa_i");
    let valor_tasa = select_tasa.options[select_tasa.selectedIndex].value;
    let a_total = parseFloat(document.getElementById("avaluo_hidden").value);
    const año_default = 1;
    let  año_inicial = parseFloat($("#ejercicio_fiscal").val());
    let  año_final = parseFloat($("#ejercicio_fiscal_final").val());
    let pago_aportacion = valor_tasa * a_total;
    let resultado =  año_final-año_inicial+año_default;
    let aportacionFinal = resultado * pago_aportacion;
    document.getElementById("pago_a").value = formatter.format(aportacionFinal);
    document.getElementById("p_hide").value = pago_aportacion;

}

function valorC() {
    let  select_valores_construccion = document.getElementById("valor_c");
    let valores_construccion = select_valores_construccion.options[select_valores_construccion.selectedIndex].value;
    document.getElementById("v_in").value = valores_construccion;
    document.getElementById("valor").value = valores_construccion;
    let metros_construccion = parseFloat(document.getElementById("sup_m").value);
    let valor_construnccion = valores_construccion * metros_construccion;
    let valor_c = document.getElementById("sup_m").value;
    if(valor_c.length == 0){
        metros_construccion = 0;
        document.getElementById("v_c").value = formatter.format(0);
    }else{
        document.getElementById("v_c").value = formatter.format(valor_construnccion);
    }
    //Calculo Valor Terreno
    let metros_terreno = parseFloat(document.getElementById("terreno").value);
    let valor_m2_zona = parseFloat(document.getElementById("valor_zona").value);
    let valor_terreno = metros_terreno * valor_m2_zona;
    document.getElementById("v_terreno").value = formatter.format(valor_terreno);
    //Calculo valor Construccion
    let inv = parseFloat(document.getElementById("v_in").value);
    let mts_construccion = parseFloat(document.getElementById("sup_m").value);
    let val_construnccion = mts_construccion * inv;
    document.getElementById("v_c").value = formatter.format(val_construnccion);
    //Avaluo Total
    let avaluo_total = valor_terreno + valor_construnccion;
    document.getElementById("a_total").value = formatter.format(avaluo_total);
    document.getElementById("avaluo_hidden").value = avaluo_total;
    //validaciones
    let m_terreno = document.getElementById("terreno").value;
    let m_valorZona = document.getElementById("valor_zona").value;
    let m_construnccion = document.getElementById("sup_m").value;
    let valor_oculto = document.getElementById("v_in").value;
    //valida si el campo metros Terreno esta vacio
    if (m_terreno.length == 0) {
        document.getElementById("v_terreno").value = formatter.format(0);
        document.getElementById("a_total").value = formatter.format(0);
        document.getElementById("avaluo_hidden").value = 0;
    }
    //valida si el campo valor m2 zona esta vacio
    if (m_valorZona.length == 0) {
        document.getElementById("v_terreno").value = formatter.format(0);
        document.getElementById("a_total").value = formatter.format(0);
        document.getElementById("avaluo_hidden").value = 0;
    }
    //valida si el campo metros Construccion esta vacio
    if (m_construnccion.length == 0) {
        document.getElementById("v_c").value = formatter.format(0);
        document.getElementById("a_total").value = formatter.format(0);
        document.getElementById("avaluo_hidden").value = 0;
    }
   //valida si el campo oculto no tiene valor
    if (valor_oculto.length == 0) {
        document.getElementById("v_c").value = formatter.format(0);
        document.getElementById("v_in").value = 0;
        document.getElementById("a_total").value = formatter.format(0);
        document.getElementById("avaluo_hidden").value = 0;
    }
    //Tasa_impositiva
    let select_tasa = document.getElementById("tasa_i");
    let valor_tasa = select_tasa.options[select_tasa.selectedIndex].value;
    let a_total = parseFloat(document.getElementById("avaluo_hidden").value);
    const año_default = 1;
    let  año_inicial = parseFloat($("#ejercicio_fiscal").val());
    let  año_final = parseFloat($("#ejercicio_fiscal_final").val());
    let pago_aportacion = valor_tasa * a_total;
    let resultado =  año_final-año_inicial+año_default;
    let aportacionFinal = resultado * pago_aportacion;
    document.getElementById("pago_a").value = formatter.format(aportacionFinal);
    document.getElementById("p_hide").value = pago_aportacion;
}

//select Tasa impositiva
function timpositiva() {
    let select_tasa = document.getElementById("tasa_i");
    let valor_tasa = select_tasa.options[select_tasa.selectedIndex].value;
    document.getElementById("tasa_hidden").value = valor_tasa;
    let avaluo_total = parseFloat(document.getElementById("avaluo_hidden").value);
    let valor_avaluo = document.getElementById("a_total").value;
    if(valor_avaluo.length == 0){
        document.getElementById("pago_a").value = formatter.format(0);
        document.getElementById("p_hide").value = 0;
    }else{
    const año_default = 1;
    let  año_inicial = parseFloat($("#ejercicio_fiscal").val());
    let  año_final = parseFloat($("#ejercicio_fiscal_final").val());
    let pago_aportacion = valor_tasa * avaluo_total;
    let resultado =  año_final-año_inicial+año_default;
    let aportacionFinal = resultado * pago_aportacion;
    document.getElementById("pago_a").value = formatter.format(aportacionFinal);
    document.getElementById("p_hide").value = pago_aportacion;
    // document.getElementById("p_hide").value = formatter.format(pago_aportacion);
    }

}

function CalcularAño(){
    const año_default = 1;
    let  año_inicial = parseFloat($("#ejercicio_fiscal").val());
    let  año_final = parseFloat($("#ejercicio_fiscal_final").val());
    let  p_hide = parseFloat($("#p_hide").val());
    let  p_hide_legth = $("#p_hide").val();
    if (p_hide_legth.length == 0) {
        $("#pago_a").val(formatter.format(0));
    }else{
    let resultado =  año_final-año_inicial+año_default;
    let aportacionFinal = resultado * p_hide;
    $("#pago_a").val(formatter.format(aportacionFinal));
    }

    }

//funcion Calular-Fin

//Funcion Solo numeros con 1 punto y maximo tres decimales
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
///Fin-Funcion Solo numeros con 1 punto y maximo dos decimales

//validar solo numero
function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
    return true;
    }
    return false;
}

// function esvacio()
// {
// if (
// document.getElementById('terreno').value=="" ||
// document.getElementById('sup_m').value=="" ||
// document.getElementById('ejercicio_f').value=="" ||
// document.getElementById('p_hide').value==""
// )
// {
// document.getElementById('btn-ok').disabled=true;
// }
// else {
// document.getElementById('btn-ok').disabled=false;
// }

// }

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
// $(".js-example-basic-single2").select2({
//         width: '100%',
// });

$('#searchAportacion').select2({
    width: '100%',
    ajax: {
       //url: "/aportacion/buscar_ajax",
        url: "/aportacion/buscarAportacion",
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

$('#searchAportacion').change(function(){
    var id = $(this).val();
    var url = '/aportacion/autorellenaAportacion/'+id;
    // AJAX request
    $.ajax({
    url: url,
    method: 'POST',
    dataType: 'JSON',
    async: true,
    success: function(data)
    {
    console.log(data);
            // $('[name ="titular"]').val(data.titular);
            // $('[name ="ubicacion"]').val(data.ubicacion);
            // $('[name ="titular_anterior"]').val(data.titular_anterior);
            // $('[name ="con_norte"]').val(data.con_norte);
            // $('[name ="con_sur"]').val(data.con_sur);
            // $('[name ="con_este"]').val(data.con_este);
            // $('[name ="con_oeste"]').val(data.con_oeste);
            // $('[name ="norte"]').val(data.norte);
            // $('[name ="sur"]').val(data.sur);
            // $('[name ="este"]').val(data.este);
            // $('[name ="oeste"]').val(data.oeste);
            // $('[name ="cvepredio"]').val(data.cvepredio);
            $('[name ="contribuyente"]').val(data.contribuyente);
         // Mostrar campos ocultas si encontraste algo en la base de datos
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
    //    $('#modal_alert').modal('show'); // show bootstrap modal
    alert("No hay Datos");
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

//////Select Buscar Contribuyente/////

function formatRepo(repo) {
    if (repo.loading) return repo.text;

    var markup = "";
    if (repo.titular) {
        markup += "<div class='select2-result-repository__description'>" + repo.titular + "</div>";
    }
console.log(repo);
    return markup;
}
///select///

function formatRepoSelection(repo) {
    return repo.titular || repo.text;
}

$('#contribuyenteId').select2({
    language: {
    inputTooShort:function(e){
    var t=e.minimum-e.input.length,n="Por favor, introduzca "+t+" car";return t==1?n+="ácter":n+="acteres",n
    },
    noResults: function() {
    return "No hay resultado";
    },
    searching: function() {
    return "Buscando..";
    }
    },
    width: '100%',
    // dropdownParent: $("#MyModal"),
    ajax: {
        url: "/aportacion/buscarRfc",
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

$('#contribuyenteId').change(function(){
    var id = $(this).val();
    var url = '/aportacion/autorellaRfc/' + id;

    // AJAX request
    $.ajax({
    url: url,
    method: 'POST',
    dataType: 'JSON',
    async: true,
    success: function(data)
    {
    console.log(data);
        $('[name ="rfc"]').val(data.rfc);
        //$('[name ="contribuyente"]').val(data.contribuyente);
        $('[name ="contribuyente"]').val(data.contribuyente);
        $('[id ="idContribuyente"]').val(data.idcontribuyente);
        $('[name ="cvlCatastral"]').val(data.cvlCatastral);
        //$('[id ="id_aportacion"]').val(data.idaportacion);
        $("#formato").show();

    },
    error: function (jqXHR, textStatus, errorThrown)
    {
       $('#modal_alert').modal('show'); // show bootstrap modal
    }
    });
});

///Inicio Funcion Persona Moral/Fisica
// $(document).ready(function () {
// $("#personaMoral").hide();
// });

function tipoPersona(){
    let tipo_Persona =  $("#tipoContribuyente").val();

    if(tipo_Persona == "M"){
        $('#div_nombre').removeClass('col-sm-4');
        $('#div_nombre').addClass('col-sm-12');
        $('#div_correoElectronico').removeClass('col-sm-4');
        $('#div_correoElectronico').addClass('col-sm-6');
        $('#div_telefono').removeClass('col-sm-4');
        $('#div_telefono').addClass('col-sm-6');
        $('#div_razonSocial').show();
        $('#div_razonSocial').removeClass('col-sm-4');
        $('#div_razonSocial').addClass('col-sm-6');
        $('#div_apellidoPaterno').hide();
        $('#div_apellidoMaterno').hide();
        $('#div_fechaNacimeinto').hide();
        $('#div_genero').hide();
        $('#div_mes').hide();
        $('#div_año').hide();
        $('#div_curp').hide();
        $('#br_año').hide();
        $('#br_mes').hide();
    }
    else if(tipo_Persona == "F"){
        $('#div_nombre').removeClass('col-sm-12');
        $('#div_nombre').addClass('col-sm-4');
        $('#div_correoElectronico').removeClass('col-sm-6');
        $('#div_correoElectronico').addClass('col-sm-4');
        $('#div_telefono').removeClass('col-sm-6');
        $('#div_telefono').addClass('col-sm-4');
        $('#div_razonSocial').hide();
        $('#div_rfc').removeClass('col-sm-4');
        $('#div_rfc').addClass('col-sm-6');
        $('#div_curp').removeClass('col-sm-4');
        $('#div_curp').addClass('col-sm-6');
        $('#div_apellidoPaterno').show();
        $('#div_apellidoMaterno').show();
        $('#div_fechaNacimeinto').show();
        $('#div_genero').show();
        $('#div_mes').show();
        $('#div_año').show();
        $('#div_curp').show();
        $('#br_año').show();
        $('#br_mes').show();



    }

};
///Fin Funcion Persona Moral/Fisica

//DataTable-Medidas Colindancias////
// $('#colindacias').dataTable( {
//     responsive: false,
//     searching: false,
//     paging: false,
//     info: false,
//     // columns: [
//     //             {data: "id"},
//     //             {data: "puntosCardinales"},
//     //             {data: "metrosLinales"},
//     //             {data: "colindancia"},
//     //             {data: "observaciones"},
//     //             {data: "opciones"},
//     //         ],
// } );


// $(document).ready(function() {
//     var table = $('#colindacias').DataTable();
//     //Agregar Colindancias///
//     $('#addRow').on( 'click', function () {

//         table.row.add( [
//             contador +'',
//             counter = $("#puntoCardinal").val(),
//             counter = $("#colindaCon").val(),
//             counter = $("#medidasMetros").val(),
//             counter = $("#observacionesColindacias").val(),
//             counter = `<button id="editarColindancias" class="btn btn-warning" data-toggle="modal" data-target="#addColindancia">Editar</button><button id="eliminarColindancia" class="btn btn-danger">Eliminar</button>`,

//         ] ).draw(false);

//         counter++;
//         contador++;
//         $('#addColindancia').modal('hide');
//     });
//     ////Editar Colindancias////
//     $('#tbody').on( 'click', 'tr', '#editarColindancias', function () {
//         let Id = table.row(this).data()[0];
//         let puntosCardinales = table.row(this).data()[1];
//         let metrosLinales = table.row(this).data()[2];
//         let colindancias = table.row(this).data()[3];
//         let observaciones = table.row(this).data()[4];
//         $("#IdColindancia").val(Id);
//         $("#puntoCardinal").val(puntosCardinales);
//         $("#medidasMetros").val(metrosLinales);
//         $("#colindaCon").val(colindancias);
//         $("#observacionesColindacias").val(observaciones);


//        // console.log( puntosCardinales );
//         $("#addRow").hide();
//         $("#updateRow").show();

//     } );

//     $('#updateRow').on( 'click', function () {
//         let Id  =  $("#IdColindancia").val();
//         let puntosCardinales =  $("#puntoCardinal").val();
//         let metrosLinales = $("#medidasMetros").val();
//         let colindancias =  $("#colindaCon").val();
//         let observaciones = $("#observacionesColindacias").val();

//         newData = [ Id, puntosCardinales, metrosLinales, colindancias, observaciones, `<button id="editarColindancias" class="btn btn-warning" data-toggle="modal" data-target="#addColindancia">Editar</button><button id="eliminarColindancia" class="btn btn-danger">Eliminar</button>` ];
//         table.row(Id).data(newData).draw();
//         $('#addColindancia').modal('hide');

//     } );

//     //////Eliminar Colindancias////

//     $('#tbody').on( 'click', '#eliminarColindancia', function () {
//         table
//             .row( $(this).parents('tr') )
//             .remove()
//             .draw(false);
//     } );


//     var counter = 1;
//     var contador = 1;



// } );



// $(document).ready(function() {
//     $('#modalColindancias').on( 'click', function () {
//         $("#updateRow").hide();
//         $("#addRow").show();
//         $('#addColindancia').modal('show');
//         $("#medidasMetros").val("");
//         $("#colindaCon").val("");
//         $("#observacionesColindacias").val("");


//     });
// });

/////Fin Modal Add Colindancias///






/////////Guardar Contribuyente metodo post////////////
$(document).ready(function() {
    let Contribuyente  = function(){
        this.Idaportacion        = $("#id_aportacion").val();
        this.Idcontribuyente     = $("#idContribuyente").val();
        this.tipoContribuyente   = $("#tipoContribuyente").val();
        this.nombreContribuyente = $("#nombreContribuyente").val();
        this.apellidoPaterno     = $("#apellidoPaterno").val();
        this.apellidoMaterno     = $("#apellidoMaterno").val();
        this.rfc                 = $("#rfc").val();
        this.razonSocial         = $("#razonSocial").val();
        this.curp                = $("#curp").val();
        this.dia                 = $("#dia").val();
        this.mes                 = $("#mes").val();
        this.año                 = $("#año").val();
        this.correoElectronico   = $("#correoElectronico").val();
        this.telefono            = $("#telefono").val();
        this.genero              = $("#genero").val();
        }

    let guardarContribuyente = function(contribuyente){

		$.post('/aportacion/guardarContribuyente', {c:contribuyente}, function(data){

			if(data != null){

                if(data.resp =="okno"){
                    alert("No se puede guardar porque el RFC ya existe en la Base de datos");

                }
				else if(data.resp == "ok"){
                // if(data.resp == "ok"){

                    $("#id_aportacion").val(data.id_objeto);
                    $("#Contribuyente").val(data.nombre);
                    $('#addContribuyente').modal('hide');
				}else{

					alert(data.msg);
				}
			}

		}, 'json');
	};


    $("#btn_guardar").click(function(){


    if($("#tipoContribuyente").val()==="F"){
    let = nombreContribuyente = $("#nombreContribuyente").val();
    let = apellidoPaterno = $("#apellidoPaterno").val();
    let = apellidoMaterno = $("#apellidoMaterno").val();
    let = rfc = $("#rfc").val();
    let = curp = $("#curp").val();
    let = dia = $("#dia").val();
    let = mes = $("#mes").val();
    let = año = $("#año").val();
    let = correoElectronico = $("#correoElectronico").val();
    let = telefono = $("#telefono").val();
    let = genero = $("#genero").val();
    if(nombreContribuyente == 0) {
        $.notify({

            message: 'Por favor Ingrese el Nombre del Contribuyente'
        },
        {
            type: 'danger',
            z_index: 999999,
        });

    }
    else if(apellidoPaterno.length == 0) {
        $.notify({

            message: 'Por favor Ingrese el Apellido Paterno'
        },
        {
            type: 'danger',
            z_index: 999999,
        });

    }
    else if(apellidoMaterno.length == 0) {
        $.notify({

            message: 'Por favor Ingrese el Apellido Materno'
        },
        {
            type: 'danger',
            z_index: 999999,
        });

    }
    else if(rfc.length == 0) {
        $.notify({

            message: 'Por favor Ingrese el R.F.C'
        },
        {
            type: 'danger',
            z_index: 999999,
        });
    }
    else if(rfc.length > 0){
        //////////////validar RFC/////////////////
    //Función para validar un RFC
    // Devuelve el RFC sin espacios ni guiones si es correcto
    // Devuelve false si es inválido
    // (debe estar en mayúsculas, guiones y espacios intermedios opcionales)
    function rfcValido(rfc, aceptarGenerico = true) {
        const re       = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
        var   validado = rfc.match(re);

        if (!validado)  //Coincide con el formato general del regex?
            return false;

        //Separar el dígito verificador del resto del RFC
        const digitoVerificador = validado.pop(),
            rfcSinDigito      = validado.slice(1).join(''),
            len               = rfcSinDigito.length,

        //Obtener el digito esperado
            diccionario       = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
            indice            = len + 1;
        var   suma,
            digitoEsperado;

        if (len == 12) suma = 0
        else suma = 481; //Ajuste para persona moral

        for(var i=0; i<len; i++)
            suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
        digitoEsperado = 11 - suma % 11;
        if (digitoEsperado == 11) digitoEsperado = 0;
        else if (digitoEsperado == 10) digitoEsperado = "A";

        //El dígito verificador coincide con el esperado?
        // o es un RFC Genérico (ventas a público general)?
        if ((digitoVerificador != digitoEsperado)
        && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
            return false;
        else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
            return false;
        return rfcSinDigito + digitoVerificador;
    }

        var rfc =  $("#rfc").val();

        var rfcCorrecto = rfcValido(rfc);   // ⬅️ Acá se comprueba

            if (!rfcCorrecto) {
                $.notify({

                message: 'El R.F.C Ingresado no es valido Por favor Intente de Nuevo'
            },
            {
                type: 'danger',
                z_index: 999999,
            });

        }
    }
    else if(curp.length == 0){
        $.notify({

            message: 'Por favor Ingrese el C.U.R.P.'
        },
        {
            type: 'danger',
            z_index: 999999,
        });


    }else if(curp.length > 0){

        //Función para validar una CURP
    function curpValida(curp) {
        var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
            validado = curp.match(re);

        if (!validado)  //Coincide con el formato general?
        return false;

        //Validar que coincida el dígito verificador
        function digitoVerificador(curp17) {
            //Fuente https://consultas.curp.gob.mx/CurpSP/
            var diccionario  = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
                lngSuma      = 0.0,
                lngDigito    = 0.0;
            for(var i=0; i<17; i++)
                lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
            lngDigito = 10 - lngSuma % 10;
            if (lngDigito == 10) return 0;
            return lngDigito;
        }

        if (validado[2] != digitoVerificador(validado[1]))
        return false;

        return true; //Validado
    }


    //Handler para el evento cuando cambia el input
    //Lleva la CURP a mayúsculas para validarlo
    let = curp = $("#curp").val();

        if (!curpValida(curp)) { // ⬅️ Acá se comprueba
            $.notify({

                message: 'El C.U.R.P. Ingresado no es valido Por favor Intente de Nuevo'
            },
            {
                type: 'danger',
                z_index: 999999,
            });


    }









}

}else if($("#tipoContribuyente").val()==="M"){
    alert("es moral");
}



});


//////////////validar RFC/////////////////
//Función para validar un RFC
// Devuelve el RFC sin espacios ni guiones si es correcto
// Devuelve false si es inválido
// (debe estar en mayúsculas, guiones y espacios intermedios opcionales)
// function rfcValido(rfc, aceptarGenerico = true) {
//     const re       = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
//     var   validado = rfc.match(re);

//     if (!validado)  //Coincide con el formato general del regex?
//         return false;

//     //Separar el dígito verificador del resto del RFC
//     const digitoVerificador = validado.pop(),
//         rfcSinDigito      = validado.slice(1).join(''),
//         len               = rfcSinDigito.length,

//     //Obtener el digito esperado
//         diccionario       = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
//         indice            = len + 1;
//     var   suma,
//         digitoEsperado;

//     if (len == 12) suma = 0
//     else suma = 481; //Ajuste para persona moral

//     for(var i=0; i<len; i++)
//         suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
//     digitoEsperado = 11 - suma % 11;
//     if (digitoEsperado == 11) digitoEsperado = 0;
//     else if (digitoEsperado == 10) digitoEsperado = "A";

//     //El dígito verificador coincide con el esperado?
//     // o es un RFC Genérico (ventas a público general)?
//     if ((digitoVerificador != digitoEsperado)
//     && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
//         return false;
//     else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
//         return false;
//     return rfcSinDigito + digitoVerificador;
// }

//     var rfc =  $("#rfc").val();

//     var rfcCorrecto = rfcValido(rfc);   // ⬅️ Acá se comprueba

//     if (rfcCorrecto) {
//         alert("Es valido");
//     } else {
//     alert("No es valido");
//     }



/////////////////////////////////////////


////Si pasa todas las validaciones hacer eso////
// let addContribuyente = new Contribuyente();

// guardarContribuyente(new Array(addContribuyente));



    ///Modal Contribuyente////////////
    $('#ModalContribuyente').on( 'click', function () {
        $('#addContribuyente').modal('show');
        $("#tipoContribuyente").val("F")
        ///Empezar como persona Fisica/////
        $('#div_nombre').removeClass('col-sm-12');
        $('#div_nombre').addClass('col-sm-4');
        $('#div_correoElectronico').removeClass('col-sm-6');
        $('#div_correoElectronico').addClass('col-sm-4');
        $('#div_telefono').removeClass('col-sm-6');
        $('#div_telefono').addClass('col-sm-4');
        $('#div_razonSocial').hide();
        $('#div_rfc').removeClass('col-sm-4');
        $('#div_rfc').addClass('col-sm-6');
        $('#div_curp').removeClass('col-sm-4');
        $('#div_curp').addClass('col-sm-6');
        $('#div_apellidoPaterno').show();
        $('#div_apellidoMaterno').show();
        $('#div_fechaNacimeinto').show();
        $('#div_genero').show();
        $('#div_mes').show();
        $('#div_año').show();
        $('#div_curp').show();
        $('#br_año').show();
        $('#br_mes').show();
        //////////////////////////////////
        $('#nombreContribuyente').val("");
        $('#apellidoPaterno').val("");
        $('#apellidoMaterno').val("");
        $('#rfc').val("");
        $('#razonSocial').val("");
        $('#curp').val("");
        $('#dia').val("");
        $('#mes').val("");
        $('#año').val("");
        $('#correoElectronico').val("");
        $('#telefono').val("");
        $('#genero').val("Hombre");


    });




});

/////////Guardar Aportacion metodo post////////////
$(document).ready(function() {
    let Aportacion  = function(){
        ////ID APORTACION PARA VALIDAR///
        this.Idaportacion    = $("#id_aportacion").val();
        this.Idcontribuyente = $("#idContribuyente").val();
        ///Tabla Contribuyente////
        this.Contribuyente   = $("#Contribuyente").val();
        this.factura         = $("#factura").val();
        this.giroComercial   = $("#giroComercial").val();
        this.nombreComercial = $("#nombreComercial").val();
        this.tenencia        = $("#tenencia").val();
        this.rfContribuyente = $("#rfContribuyente").val();
        this.usoDestino      = $("#usoDestino").val();
        ///Tabla Predio////
        this.parcela            = $("#parcela").val();
        this.manzana            = $("#manzana").val();
        this.lote               = $("#lote").val();
        this.local              = $("#local").val();
        this.categoria          = $("#categoria").val();
        this.condicion          = $("#condicion").val();
        this.titular            = $("#titular").val();
        this.ubicacion          = $("#ubicacion").val();
        this.localidad          = $("#localidad").val();
        this.antecedentes       = $("#antecedentes").val();
        this.claveCatastral     = $("#claveCatastral").val();
        this.regimenPropiedad   = $("#regimenPropiedad").val();
        this.fechaAdquicision   = $("#fechaAdquicision").val();
        this.titularAnterior    = $("#titularAnterior").val();
        this.documentoPropiedad = $("#documentoPropiedad").val();
        this.folio              = $("#folio").val();
        this.fechaDocumento     = $("#fechaDocumento").val();
        this.loteConflicto      = $("#loteConflicto").val();
        this.observaciones      = $("#observaciones").val();
        ///Tabla Aportacion////
        this.fecha                = $("#vig").val();
        this.metrosTerreno        = $("#terreno").val();
        this.valorMZona           = $("#valor_zona").val();
        this.metrosConstruccion   = $("#sup_m").val();
        this.valorMConstruccion   = $("#valor").val();
        this.tasa                 = $("#tasa_i").val();
        this.ejercicioFiscal      = $("#ejercicio_fiscal").val();
        this.ejercicioFiscalFinal = $("#ejercicio_fiscal_final").val();
	}

    let guardarAportacion = function(aportacion){

		$.post('/aportacion/guardarAportacion', {a:aportacion}, function(data){

			if(data != null){

				if(data.resp == "ok"){

                    window.location = "/aportacion";

				}else{

					alert(data.msg);
				}
			}

		}, 'json');
	};


    $("#btn_guardarAportacion").click(function(){


			let addAportacion = new Aportacion();

			guardarAportacion(new Array(addAportacion));
		});


});
/////////Button Volver atras ////////////
$(document).ready(function() {

    $("#btn_volver").click(function(){

            window.location = "/aportacion";

		});

});

/////////Editar Aportacion metodo post////////////
$(document).ready(function() {
    let actualizarAportacion  = function(){

        this.Idaportacion = $("#hdn_id_cont").val();
        this.parcela = $("#parcela").val();
	}

    let guardarCambios = function(aportacion){

		$.post('/aportacion/actualizarAportacion', {a:aportacion}, function(data){

			if(data != null){

				if(data.resp == "ok"){

                    //$("#hdn_id_cont").val(data.id_objeto);
				}else{

					alert(data.msg);
				}
			}

		}, 'json');
	};


    $("#btn_guardarCambios").click(function(){

			let updateAportacion = new actualizarAportacion();

			guardarCambios(new Array(updateAportacion));

            window.location = "/aportacion";


		});


});


$(document).ready(function() {

        // [ Configuration Option ]


            //let id = $("#id_predio").val();
            let table = $('#colindacias').DataTable({
            responsive: true,
            info: false,
            searching: false,
            autoWidth: false,
            scrollX: true,
            scroller: {
                loadingIndicator: true
            },
            processing: true,
            // serverSide: true,
            deferRender: true,
            paging: false,
            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            pageLength: 10,
            order: [],
            ajax: {
                url: "/aportacion/datatable-colindancias/"+$("#id_predio").val(),
                //url: "/aportacion/datatable-colindancias/",
               // url: "/aportacion/datatable-colindancias/",
                type: "POST",
                data:function(d){

                    var busqueda = new objetoBusqueda();

                    return busqueda;
                },

                error: function(){
                    $(".colindacias-error").html("");
                    $("#colindacias").append('<tbody class="aportaciones-error"><tr class="text-center"><th colspan="6">No se encontraron datos en el servidor. </th></tr></tbody>');
                    $(".dataTables_empty").css("display","none");
                    $("#colindacias_processing").css("display","none");
                },
                "complete": function(response) {
                    console.log(response);
                }
            },
            initComplete: function () {
                $('#lv-links').hide();
                if ($(this).find('tbody tr').length<=1) {
                    $(this).parent().show();
                }
            },
            columns: [
                {data: 'idColindancia',},
                {data: 'puntoCardinal'},
                {data: 'metrosLineales'},
                {data: 'colindancia'},
                {data: 'observaciones'},
                {data: 'Opciones', orderable: false, searchable: false },
                ],
            columnDefs: [
                {
                    targets: 5,
                    orderable: false,
                    render: function(data, type, row, meta){

                        $actionBtn =`<button id="editarColindancias" class="btn btn-warning" value="` + row['idColindancia'] + `">Editar</button>
                        <button id="eliminarColindancia" class="btn btn-danger" value="` + row['idColindancia'] + `">Eliminar</button>`;

                        return $actionBtn;
                    },
                },
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.6/i18n/Spanish.json"
            },




        });

        let objetoBusqueda = function(){
			this.id_predio = $("#id_predio").val();
		}




        // [ New Constructor ]
        // var newcs = $('#new-cons').DataTable();

        // new $.fn.dataTable.Responsive(newcs);

        // [ Immediately Show Hidden Details ]
        $('#show-hide-res').DataTable({
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate,
                    type: ''
                }
            }
        });
///////Modal Colindancias///////////
$('#modalColindancias').on( 'click', function () {
        $("#updateRow").hide();
        $("#addRow").show();
        $('#addColindancia').modal('show');
        $("#puntoCardinal").val("Norte");
        $("#medidasMetros").val("");
        $("#colindaCon").val("");
        $("#observacionesColindacias").val("");


    });


/////Add Datatbale row////////
    let Colindancias = function(){
        this.Idaportacion = $("#id_aportacion").val();
        ///Colindancias///
        this.puntoCardinal            = $("#puntoCardinal").val();
        this.colindaCon               = $("#colindaCon").val();
        this.medidasMetros            = $("#medidasMetros").val();
        this.observacionesColindacias = $("#observacionesColindacias").val();

	}

    let guardarColindancia = function(colindancias){

		$.post('/aportacion/addcolindancias', {c:colindancias}, function(data){

			if(data != null){

				if(data.resp == "ok"){

                    $("#id_aportacion").val(data.id_objeto);
                    $("#id_predio").val(data.id_predio);
                    table.ajax.reload();

				}else{

					alert(data.msg);
				}
			}

		}, 'json');
	};

    $('#addRow').click(  function () {
        let addColindancia = new Colindancias();

		guardarColindancia(new Array(addColindancia));

        $('#addColindancia').modal('hide');
    });

    /////////Eliminar Colindancias///////////////
    let EliminarColindancia = function(colindancias){

		$.post('/aportacion/deletecolindancias', {c:colindancias}, function(data){

			if(data != null){

				if(data.resp == "ok"){

                    table.ajax.reload();

				}else{

					alert(data.msg);
				}
			}

		}, 'json');
	};

    $('#tbody').on( 'click', '#eliminarColindancia', function () {

        let deleteColindancias = $(this).val();

		EliminarColindancia(new Array(deleteColindancias));

    });
///////Modal  Editar Colindancias///////////
    $('#tbody').on( 'click', '#editarColindancias', function () {
        $("#updateRow").show();
        $("#addRow").hide();
        $('#addColindancia').modal('show');
        $("#puntoCardinal").val("Norte");
        $("#medidasMetros").val("");
        $("#colindaCon").val("");
        $("#observacionesColindacias").val("");


    let id = $(this).val();
    $.ajax({
    url : "/aportacion/editar-colindancia/" + id,
    type: "POST",
    dataType: "JSON",
    contentType: "application/json; charset=utf-8",
    success: function(data)
        {
            console.log(data);
            $('[id="idPredioColindancias"]').val(data.idPredioColindancias);
            $('[id="puntoCardinal"]').val(data.puntoCardinal);
            $('[id="colindaCon"]').val(data.colindaCon);
            $('[id="medidasMetros"]').val(data.medidasMetros);
            $('[id="observacionesColindacias"]').val(data.observacionesColindacias);

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });


    });

//}
//////////Actualizar Cambios Datatbale Colindancias////////
let ActualizarColindancia = function(colindancias){

		$.post('/aportacion/updatecolindancias', {c:colindancias}, function(data){

			if(data != null){

				if(data.resp == "ok"){

                table.ajax.reload();

				}else{

					alert(data.msg);
				}
			}

		}, 'json');
	};


    $("#updateRow").click(function(){

		let updateColindacia = {

            id:$('#idPredioColindancias').val(),
            puntoCardinal:$("#puntoCardinal").val(),
            colindaCon:$("#colindaCon").val(),
            medidasMetros: $("#medidasMetros").val(),
            observacionesColindacias:$("#observacionesColindacias").val(),

        };

		ActualizarColindancia(new Array(updateColindacia));
        $('#addColindancia').modal('hide');

		});

});


/////Contar filas DataTable/////////
$('#button').on('click',function()
{
    var table = $('#colindacias').DataTable();
    //Muestro la cantidad de filas
    console.log("Filas: " + table.rows().count());

    //Muestro la cantidad de columnas
    console.log("Columnas: " + table.columns().count());
});


/////NOTIFICACION//////

// 'use strict';
// $(window).on('load', function() {
//     function notify(message, type) {
//         $.notify({
//             message: message
//         }, {
//             type: type,
//             allow_dismiss: false,
//             label: 'Cancel',
//             className: 'btn-xs btn-inverse',
//             placement: {
//                 from: 'bottom',
//                 align: 'right'
//             },
//             delay: 2500,
//             animate: {
//                 enter: 'animated fadeInRight',
//                 exit: 'animated fadeOutRight'
//             },
//             offset: {
//                 x: 30,
//                 y: 30
//             }
//         });
//     };
//     notify('Bienvenido', 'inverse');
// });


























