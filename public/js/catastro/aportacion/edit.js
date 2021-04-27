/////////Ver Aportacion//////////
$(document).ready(function() {
    $("#trhidden").hide();

    $('#besicwizard').bootstrapWizard({
        withVisible: false,
        'nextSelector': '.button-next',
        'previousSelector': '.button-previous',
        'firstSelector': '.button-first',
        'lastSelector': '.button-last'
    });

let edit_aportacion = function(id)
{

    // id = $('#hdn_id_cont').val()
    $.ajax({
    url : "/aportacion/editar-aportacion/" + id,
    type: "POST",
    dataType: "JSON",
    contentType: "application/json; charset=utf-8",
    success: function(data)
        {
            console.log(data);
             //Predio////
            $('[id="parcela"]').val(data.parcela);
            $('[id="manzana"]').val(data.manzana);
            $('[id="lote"]').val(data.lote);
            $('[id="local"]').val(data.local);
            $('[id="categoria"]').val(data.condicion);
            $('[id="condicion"]').val(data.condicion);
            $('[id="titular"]').val(data.titular);
            $('[id="ubicacion"]').val(data.ubicacion);
            $('[id="localidad"]').val(data.localidad);
            $('[id="antecedentes"]').val(data.antecedentes);
            $('[id="claveCatastral"]').val(data.claveCatastral);
            $('[id="regimenPropiedad"]').val(data.regimenPropiedad);
            $('[id="fechaAdquicision"]').val(data.fechaAdquicision);
            $('[id="titularAnterior"]').val(data.titularAnterior);
            $('[id="documentoPropiedad"]').val(data.documentoPropiedad);
            $('[id="folio"]').val(data.folio);
            $('[id="fechaDocumento"]').val(data.fechaDocumento);
            $('[id="loteConflicto"]').val(data.loteConflicto);
            $('[id="observaciones"]').val(data.observaciones);
             ///Contiribuyente//
            $('[id="Contribuyente"]').val(data.contribuyente);
            $('[id="factura"]').val(data.factura);
            $('[id="giroComercial"]').val(data.giroComercial);
            $('[id="nombreComercial"]').val(data.nombreComercial);
            $('[id="tenencia"]').val(data.tenencia);
            $('[id="rfcContribuyente"]').val(data.rfContribuyente);
            $('[id="usoDestino"]').val(data.usoDestino);
            /////Aportacion////////////
            $('[id="vig"]').val(data.vig);
            $('[id="terreno"]').val(data.metrosTerreno);
            $('[id="valor_zona"]').val(data.valorMZona);
            $('[id="v_terreno"]').val(formatter.format(data.valorTerreno));
            $('[id="sup_m"]').val(data.metrosConstruccion);
            $('[id="valor"]').val(data.valorMConstruccion);
            $('[id="valor_c"]').val(data.valorMConstruccion);
            $('[id="v_in"]').val(data.valorMConstruccion);
            $('[id="v_c"]').val(formatter.format(data.valorConstruccion));
            $('[id="ejercicio_fiscal"]').val(data.ejercicioFiscal);
            $('[id="ejercicio_fiscal_final"]').val(data.ejercicioFiscalFinal);
            $('[id="tasa_i"]').val(data.tasa);
            $('[id="a_total"]').val(formatter.format(data.avaluo));
            $('[id="pago_a"]').val(formatter.format(data.pago));

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

}

edit_aportacion($('#id_aportacion').val());

/////////DataTable///////////

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


/////////Editar Aportacion metodo post////////////
$(document).ready(function() {
    let actualizarAportacion  = function(){

       ////ID APORTACION PARA VALIDAR///
        this.Idaportacion = $("#id_aportacion").val();
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

            //window.location = "/aportacion";


		});


});
///////////////////////////
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
        document.getElementById("v_terreno").value = 0;
        document.getElementById("a_total").value = 0;
        document.getElementById("avaluo_hidden").value = 0;
    }
    // //valida si el campo valor m2 zona esta vacio
    if (m_valorZona.length == 0) {
        document.getElementById("v_terreno").value = 0;
        document.getElementById("a_total").value = 0;
        document.getElementById("avaluo_hidden").value = 0;
    }
    //valida si el campo metros Construccion esta vacio
    if (m_construnccion.length == 0) {
        document.getElementById("v_c").value = 0;
        document.getElementById("a_total").value = 0;
        document.getElementById("avaluo_hidden").value = 0;
    }
   //valida si el campo oculto no tiene valor
    if (valor_oculto.length == 0) {
        document.getElementById("v_c").value = 0;
        document.getElementById("v_in").value = 0;
        document.getElementById("a_total").value = 0;
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
        document.getElementById("v_c").value = 0;
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
        document.getElementById("v_terreno").value = 0;
        document.getElementById("a_total").value = 0;
        document.getElementById("avaluo_hidden").value = 0;
    }
    //valida si el campo valor m2 zona esta vacio
    if (m_valorZona.length == 0) {
        document.getElementById("v_terreno").value = 0;
        document.getElementById("a_total").value = 0;
        document.getElementById("avaluo_hidden").value = 0;
    }
    //valida si el campo metros Construccion esta vacio
    if (m_construnccion.length == 0) {
        document.getElementById("v_c").value = 0;
        document.getElementById("a_total").value = 0;
        document.getElementById("avaluo_hidden").value = 0;
    }
   //valida si el campo oculto no tiene valor
    if (valor_oculto.length == 0) {
        document.getElementById("v_c").value = 0;
        document.getElementById("v_in").value = 0;
        document.getElementById("a_total").value = 0;
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


