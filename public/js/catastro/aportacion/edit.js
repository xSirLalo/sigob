/////////Ver Aportacion//////////
$(document).ready(function() {
    $("#trhidden").hide();

    $('#besicwizard').bootstrapWizard({
        withVisible: false,
        'nextSelector': '.button-next',
        'previousSelector': '.button-previous',
        'firstSelector': '.button-first',
        'lastSelector': '.button-last',
        onNext: function(tab, navigation, index) {
                if (index == 1) {
                    let categoria = $("#categoria").val();
                    let condicion = $("#condicion").val();
                    let localidad = $("#localidad").val();
                    let regimenPropiedad = $("#regimenPropiedad").val();
                    let documentoPropiedad   = $("#documentoPropiedad").val();
                    let giroComercial        = $("#giroComercial").val();
                    let usoDestino           = $("#usoDestino").val();
                    var table = $('#colindacias').DataTable();
                    let filas = parseInt(table.rows().count());

                    if (!$('#parcela').val()) {
                        $.notify({

                                message: 'Por favor, Ingrese una Parcela'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#parcela').focus();
                        $('#parcela').addClass('is-invalid');

                        return false;
                    }
                    else if($('#parcela').val()){
                        $('#parcela').removeClass('is-invalid');
                    }
                    if (categoria.length == 0) {
                        $.notify({

                                message: 'Por favor, Seleccione una Categoria'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#categoria').focus();
                        $('#categoria').addClass('is-invalid');

                        return false;
                    }
                    else if(categoria.length > 0){
                        $('#categoria').removeClass('is-invalid');
                    }
                    if (condicion.length == 0) {
                        $.notify({

                                message: 'Por favor, Seleccione una Condicion'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#condicion').focus();
                        $('#condicion').addClass('is-invalid');

                        return false;
                    }
                    else if(condicion.length > 0){
                        $('#condicion').removeClass('is-invalid');
                    }
                    if (!$("#titular").val()) {
                        $.notify({

                                message: 'Por favor, Ingrese un Titular'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#titular').focus();
                        $('#titular').addClass('is-invalid');

                        return false;
                    }
                    else if($('#titular').val()){
                        $('#titular').removeClass('is-invalid');
                    }
                    if (!$("#ubicacion").val()) {
                        $.notify({

                                message: 'Por favor, Ingrese una Ubicación'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#ubicacion').focus();
                        $('#ubicacion').addClass('is-invalid');

                        return false;
                    }
                    else if($('#ubicacion').val()){
                        $('#ubicacion').removeClass('is-invalid');
                    }
                    if (localidad.length == 0) {
                        $.notify({

                                message: 'Por favor, Seleccione una Localidad'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#localidad').focus();
                        $('#localidad').addClass('is-invalid');

                        return false;
                    }
                    else if(localidad.length > 0){
                        $('#localidad').removeClass('is-invalid');
                    }
                    if (!$('#antecedentes').val()) {
                        $.notify({

                                message: 'Por favor, Ingrese los Antecedentes'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#antecedentes').focus();
                        $('#antecedentes').addClass('is-invalid');

                        return false;
                    }
                    else if($('#antecedentes').val()){
                        $('#antecedentes').removeClass('is-invalid');
                    }
                    if (regimenPropiedad.length == 0) {
                        $.notify({

                                message: 'Por favor, Seleccione un Regimen de Propiedad'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#regimenPropiedad').focus();
                        $('#regimenPropiedad').addClass('is-invalid');

                        return false;
                    }
                    else if(regimenPropiedad.length > 0){
                        $('#regimenPropiedad').removeClass('is-invalid');
                    }
                    if (!$('#titularAnterior').val()) {
                        $.notify({

                                message: 'Por favor, Ingrese El Titular Anterior'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#titularAnterior').focus();
                        $('#titularAnterior').addClass('is-invalid');

                        return false;
                    }
                    else if($('#titularAnterior').val()){
                        $('#titularAnterior').removeClass('is-invalid');
                    }
                    if (documentoPropiedad.length == 0) {
                        $.notify({

                                message: 'Por favor, Seleccione un Documento de Propiedad'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#documentoPropiedad').focus();
                        $('#documentoPropiedad').addClass('is-invalid');

                        return false;
                    }
                    else if(documentoPropiedad.length > 0){
                        $('#documentoPropiedad').removeClass('is-invalid');
                    }
                    if (!$('#folio').val()) {
                        $.notify({

                                message: 'Por favor, Ingrese un Folio'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#folio').focus();
                        $('#folio').addClass('is-invalid');

                        return false;
                    }
                    else if($('#folio').val()){
                        $('#folio').removeClass('is-invalid');
                    }
                    if (!$('#Contribuyente').val()) {
                        $.notify({

                                message: 'Por favor, Ingrese El Contribuyente'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#Contribuyente').focus();
                        $('#Contribuyente').addClass('is-invalid');

                        return false;
                    }
                    else if($('#Contribuyente').val()){
                        $('#Contribuyente').removeClass('is-invalid');
                    }
                    if (giroComercial.length == 0) {
                        $.notify({

                                message: 'Por favor, Seleccione el Giro Comercial'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#giroComercial').focus();
                        $('#giroComercial').addClass('is-invalid');

                        return false;
                    }
                    else if(giroComercial.length > 0){
                        $('#giroComercial').removeClass('is-invalid');
                    }

                    if (!$('#nombreComercial').val()) {
                        $.notify({

                                message: 'Por favor, Ingrese El Nombre Comercial'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#nombreComercial').focus();
                        $('#nombreComercial').addClass('is-invalid');

                        return false;
                    }
                    else if($('#nombreComercial').val()){
                        $('#nombreComercial').removeClass('is-invalid');
                    }
                    if (!$('#tenencia').val()) {
                        $.notify({

                                message: 'Por favor, Ingrese Una Tenencia'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#tenencia').focus();
                        $('#tenencia').addClass('is-invalid');

                        return false;
                    }
                    else if($('#tenencia').val()){
                        $('#tenencia').removeClass('is-invalid');
                    }
                    if (!$('#rfContribuyente').val()) {
                        $.notify({

                                message: 'Por favor, Ingrese Un R.F.C Buscando un Contribuyente o Agregando un Nuevo Contribuyente'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#rfContribuyente').focus();
                        $('#rfContribuyente').addClass('is-invalid');

                        return false;
                    }
                    else if($('#rfContribuyente').val()){
                        $('#rfContribuyente').removeClass('is-invalid');
                    }
                    if (usoDestino.length == 0) {
                        $.notify({

                                message: 'Por favor, Seleccione El Uso Destino.'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                        });

                        $('#usoDestino').focus();
                        $('#usoDestino').addClass('is-invalid');

                        return false;
                    }
                    else if(usoDestino.length > 0){
                        $('#usoDestino').removeClass('is-invalid');
                    }
                    if(filas < 4){
                        $.notify({

                                message: 'El minimo de colindancias agregados debe ser de 4'
                            },
                            {
                                type: 'danger',
                                z_index: 999999,
                            });
                            return false;
                    }
                }
            }


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
            $('[id="categoria"]').val(data.categoria);
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
            $('[id="idContribuyente"]').val(data.idcontribuyente);
            $('[id="Contribuyente"]').val(data.contribuyente);
            $('[id="factura"]').val(data.factura);
            $('[id="giroComercial"]').val(data.giroComercial);
            $('[id="nombreComercial"]').val(data.nombreComercial);
            $('[id="tenencia"]').val(data.tenencia);
            $('[id="rfContribuyente"]').val(data.rfContribuyente);
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
            $('[id="tasa_hidden"]').val(data.tasa);
            $('[id="a_total"]').val(formatter.format(data.avaluo));
            $('[id="avaluo_hidden"]').val(data.avaluo);
            $('[id="p_hide"]').val(data.pago);
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

        var table = $('#colindacias').DataTable();
        let filas = parseInt(table.rows().count());
        if(filas < 4){
            $("#div_colindanciasDefaul").show();
            $("#div_Colindancias").hide();
        }else{
            $("#div_colindanciasDefaul").hide();
            $("#div_Colindancias").show();
        }

        $("#updateRow").hide();
        $("#addRow").show();
        $('#addColindancia').modal('show');
        // $("#puntoCardinal").val("Norte");
        $("#medidasMetros").val("");
        $("#colindaCon").val("");
        $("#observacionesColindacias").val("");


    });


/////Add Datatbale row////////
    let Colindancias = function(){
        let table = $('#colindacias').DataTable();
        let filas = parseInt(table.rows().count());

        this.Idaportacion = $("#id_aportacion").val();
        ///Colindancias///
        if(filas < 4){
        this.puntoCardinal            = $("#puntoCardinal").val();
        }else{
        this.puntoCardinal            = $("#puntoCardinales").val();
        }
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
            /////Validaciones/////////////
    let  colindaCon  = $("#colindaCon").val();
    let  medidasMetros  = $("#medidasMetros").val();
    if(isNaN(medidasMetros)){
        $.notify({

                message: 'Este campo solo debe contener números.'
            },
            {
                type: 'danger',
                z_index: 999999,
            });

            $('#medidasMetros').addClass('is-invalid');
            $('#medidasMetros').focus();

            return false;

    }
    else{
        $('#medidasMetros').removeClass('is-invalid');
    }
    if(colindaCon.length == 0){
        $.notify({

            message: 'Por favor llene los campos'
        },
        {
            type: 'danger',
            z_index: 999999,
        });

        $('#colindaCon').addClass('is-invalid');
        $('#colindaCon').focus();

        return false;

    }
    else{
        $('#colindaCon').removeClass('is-invalid');
    }

    if( medidasMetros.length == 0){
        $.notify({

            message: 'Por favor llene los campos'
        },
        {
            type: 'danger',
            z_index: 999999,
        });

        $('#medidasMetros').addClass('is-invalid');
        $('#medidasMetros').focus();

        return false;

    }
    else {
        $('#colindaCon').removeClass('is-invalid');
    }

    if(colindaCon.length > 0 && medidasMetros.length > 0)
    {
        let puntosCardinales = $("#puntoCardinal").val();
        let addColindancia = new Colindancias();

		guardarColindancia(new Array(addColindancia));

        $('#addColindancia').modal('hide');

        $("#puntoCardinal").find("option[value='"+puntosCardinales+"']").remove();
    }

    });

    /////////Eliminar Colindancias///////////////
    let EliminarColindancia = function(colindancias){

		$.post('/aportacion/deletecolindancias', {c:colindancias}, function(data){

			if(data != null){

				if(data.resp == "ok"){

                    table.ajax.reload();
                    if(data.return_valorColindancia == "Norte"|| data.return_valorColindancia == "Sur" || data.return_valorColindancia == "Este" || data.return_valorColindancia == "Oeste" ){
                    $('#puntoCardinal').append('<option value="'+data.return_valorColindancia+'" selected="selected">'+data.return_valorColindancia+'</option>');
                    }

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
        //$("#puntoCardinal").val("Norte");
        $("#div_colindanciasDefaul").hide();
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
            // $('[id="puntoCardinal"]').val(data.puntoCardinal);
            $('[id="colindanciaHiden"]').val(data.puntoCardinal);
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
          /////Validaciones/////////////
        let  colindaCon  = $("#colindaCon").val();
        let  medidasMetros  = $("#medidasMetros").val();
        if(isNaN(medidasMetros)){
            $.notify({

                    message: 'Este campo solo debe contener números.'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

        }
        else if(colindaCon.length == 0|| medidasMetros == 0){
            $.notify({

                message: 'Por favor llene los campos'
            },
            {
                type: 'danger',
                z_index: 999999,
            });

        }else{

		let updateColindacia = {

            id:$('#idPredioColindancias').val(),
            puntoCardinal:$("#puntoCardinal").val(),
            colindaCon:$("#colindaCon").val(),
            medidasMetros: $("#medidasMetros").val(),
            observacionesColindacias:$("#observacionesColindacias").val(),

        };

		ActualizarColindancia(new Array(updateColindacia));
        $('#addColindancia').modal('hide');

        }

		});


///Como esta en Editar aportacion las colindacias
///no deben excistir porque ya son 4
$("#puntoCardinal").find("option[value='Norte']").remove();
$("#puntoCardinal").find("option[value='Sur']").remove();
$("#puntoCardinal").find("option[value='Este']").remove();
$("#puntoCardinal").find("option[value='Oeste']").remove();


});


/////////Editar Aportacion metodo post////////////
$(document).ready(function() {
    let actualizarAportacion  = function(){

       ////ID APORTACION PARA VALIDAR///
        this.Idaportacion = $("#id_aportacion").val();
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

    let guardarCambios = function(aportacion){

		$.post('/aportacion/actualizarAportacion', {a:aportacion}, function(data){

			if(data != null){

				if(data.resp == "ok"){


                    window.location = "/aportacion";
				}else{

					alert(data.msg);
				}
			}

		}, 'json');
	};


    $("#btn_guardarCambios").click(function(){
          //////Input///////////////////
    let parcela   = $("#parcela").val();
    let manzana   = $("#manzana").val();
    let lote      = $("#lote").val();
    let local     = $("#local").val();
    let categoria = $("#categoria").val();
    let condicion = $("#condicion").val();
    let titular   = $("#titular").val();
    let ubicacion = $("#ubicacion").val();
    let localidad = $("#localidad").val();
    let antecedentes         = $("#antecedentes").val();
    let claveCatastral       = $("#claveCatastral").val();
    let regimenPropiedad     = $("#regimenPropiedad").val();
    let titularAnterior      = $("#titularAnterior").val();
    let documentoPropiedad   = $("#documentoPropiedad").val();
    let folio                = $("#folio").val();
    let Contribuyente        = $("#Contribuyente").val();
    let factura              = $("#factura").val();
    let giroComercial        = $("#giroComercial").val();
    let nombreComercial      = $("#nombreComercial").val();
    let tenencia              = $("#tenencia").val();
    let rfContribuyente      = $("#rfContribuyente").val();
    let usoDestino           = $("#usoDestino").val();
    let terreno              = $("#terreno").val();
    let valor_zona           = $("#valor_zona").val();
    let sup_m                = $("#sup_m").val();
    let valor_c              = $("#valor_c").val();
    let tasa                 = $("#tasa_i").val();
    let ejercicio_fiscal           = $("#ejercicio_fiscal").val();
    let ejercicio_fiscal_final     = $("#ejercicio_fiscal_final").val();


    /////Para Validar filas de Colindacias/////////
    var table = $('#colindacias').DataTable();
    //Muestro la cantidad de filas
    console.log("Filas: " + table.rows().count());
    let filas = parseInt(table.rows().count());;
    //////////////Validaciones///////////////////

    if(parcela.length == 0)
    {
            $.notify({

                    message: 'Por favor, Ingrese una Parcela'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(categoria.length == 0)
    {
            $.notify({

                    message: 'Por favor, Seleccione una Categoria'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(condicion.length == 0)
    {
            $.notify({

                    message: 'Por favor, Seleccione una Condicion'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(titular.length == 0)
    {
            $.notify({

                    message: 'Por favor, Ingrese un Titular'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(ubicacion.length == 0)
    {
            $.notify({

                    message: 'Por favor, Ingrese una ubicacion'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(localidad.length == 0)
    {
            $.notify({

                    message: 'Por favor, Seleccione una Localidad'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(antecedentes.length == 0)
    {
            $.notify({

                    message: 'Por favor, Ingrese los Antecedentes'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(regimenPropiedad.length == 0)
    {
            $.notify({

                    message: 'Por favor, Seleccione un Regimen de Propiedad'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(titularAnterior.length == 0)
    {
            $.notify({

                    message: 'Por favor, Ingrese El Titular Anterior'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(documentoPropiedad.length == 0)
    {
            $.notify({

                    message: 'Por favor, Seleccione un Documento de Propiedad'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(folio.length == 0)
    {
            $.notify({

                    message: 'Por favor, Ingrese un Folio'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(Contribuyente.length == 0)
    {
            $.notify({

                    message: 'Por favor, Ingrese El Contribuyente'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(giroComercial.length == 0)
    {
            $.notify({

                    message: 'Por favor, Seleccione el Giro Comercial'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(nombreComercial.length == 0)
    {
            $.notify({

                    message: 'Por favor, Ingrese El Nombre Comercial'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(tenencia.length == 0)
    {
            $.notify({

                    message: 'Por favor, Ingrese Una Tenencia'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(usoDestino.length == 0)
    {
            $.notify({

                    message: 'Por favor, Seleccione El Uso Destino.'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

    }
    else if(terreno.length == 0)
    {
            $.notify({

                    message: 'Por favor, Ingrese los Metros Terreno.'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

                $("#terreno").focus();
                $('#terreno').addClass('is-invalid');
                return false;

    }
    else if(terreno.length > 0){
        $('#terreno').removeClass('is-invalid');
    }
    if(valor_zona.length == 0)
    {
            $.notify({

                    message: 'Por favor, El Valor de Metros Zona.'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

                $("#valor_zona").focus();
                $('#valor_zona').addClass('is-invalid');
                return false;

    }
    else if(valor_zona.length > 0){
        $('#valor_zona').removeClass('is-invalid');
    }

    if(sup_m.length == 0)
    {
            $.notify({

                    message: 'Por favor, Ingrese los Metros Construccion.'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

                $("#sup_m").focus();
                $('#sup_m').addClass('is-invalid');
                return false;

    }
    else if(sup_m.length > 0){
        $('#sup_m').removeClass('is-invalid');
    }

    if(valor_c.length == 0)
    {
            $.notify({

                    message: 'Por favor, Seleccione Valores de Construcción.'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

                $("#valor_c").focus();
                $('#valor_c').addClass('is-invalid');
                return false;

    }
    else if(valor_c.length > 0){
        $('#valor_c').removeClass('is-invalid');
    }
    if(tasa.length == 0)
    {
            $.notify({

                    message: 'Por favor, Seleccione la Tasa Impositiva.'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

                $("#tasa_i").focus();
                $('#tasa_i').addClass('is-invalid');
                return false;

    }
    else if(tasa.length > 0){
        $('#tasa_i').removeClass('is-invalid');
    }
    if(ejercicio_fiscal > ejercicio_fiscal_final){
            $.notify({

                    message: 'El Año de Ejercicio Fiscal no debe ser Mayor que Ejercicio Fiscal Final'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });
                $("#ejercicio_fiscal").focus();
                $('#ejercicio_fiscal').addClass('is-invalid');
                $("#ejercicio_fiscal_final").focus();
                $('#ejercicio_fiscal_final').addClass('is-invalid');
                return false;

    }

    else if(parcela.length > 0 && categoria.length > 0 && condicion.length > 0 && titular.length > 0 && ubicacion.length > 0 && localidad.length > 0 && antecedentes.length > 0 && regimenPropiedad.length > 0 && titularAnterior.length > 0 && documentoPropiedad.length > 0 && folio.length > 0 && Contribuyente.length > 0 && factura.length > 0 && giroComercial.length > 0 && nombreComercial.length > 0 && tenencia.length > 0 && usoDestino.length > 0 && terreno.length > 0 && valor_zona.length > 0 && sup_m.length > 0 && valor_c.length > 0 && tasa.length > 0 ){

        if(filas < 4){
            $.notify({

                    message: 'El minimo de colindancias agregados debe ser de 4'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

        }else{

            let updateAportacion = new actualizarAportacion();

			guardarCambios(new Array(updateAportacion));
        }
        }


		});


});
///////////////////////////
//formato moneda
var formatter = new Intl.NumberFormat('en-US', {
style: 'currency',
currency: 'USD',
});
//funcion Calular Aportacion-Inicio
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
    inputTooShort:function(e){var t=e.minimum-e.input.length,n="Por favor, introduzca "+t+" car";return t==1?n+="ácter":n+="acteres",n},
    noResults: function(){return "No se encontraron resultados"},
    errorLoading:function(){return"La carga falló"},
    searching: function(){return "Buscando..."}
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
        $("#formato").show();

    },
    error: function (jqXHR, textStatus, errorThrown)
    {
       $('#modal_alert').modal('show'); // show bootstrap modal
    }
    });
});

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
        this.correoElectronico   = $("#correoElectronico").val();
        this.telefono            = $("#telefono").val();
        this.genero              = $("#genero").val();
        }

    let guardarContribuyente = function(contribuyente){

		$.post('/aportacion/guardarContribuyente', {c:contribuyente}, function(data){

			if(data != null){

            if(data.resp =="okno"){

                    $.notify({

                message: 'No se puede guardar porque el RFC ya existe en la Base de datos'
                    },
                    {
                        type: 'danger',
                        z_index: 999999,
                    });

                }else if(data.resp == "ok"){

                    $("#id_aportacion").val(data.id_objeto);
                    $("#Contribuyente").val(data.nombre);
                    $("#rfContribuyente").val(data.rfc);
                    $('#addContribuyente').modal('hide');
				}else{

					alert(data.msg);
				}
			}

		}, 'json');
	};


    $("#btn_guardar").click(function(){
           ////////Funcion Validar Rfc///////////////

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
    ////////////Funcion Validar CURP///////////////
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

    //////////////////////////////////////////////

    let  nombreContribuyente  = $("#nombreContribuyente").val();
    let  apellidoPaterno = $("#apellidoPaterno").val();
    let  apellidoMaterno = $("#apellidoMaterno").val();
    let  rfc = $("#rfc").val();
    let  curp = $("#curp").val();
    let  dia = $("#dia").val();
    let  mes = $("#mes").val();
    let  año = $("#año").val();
    let  correoElectronico = $("#correoElectronico").val();
    let  telefono = $("#telefono").val();
    let  razonSocial = $("#razonSocial").val();


    if($("#tipoContribuyente").val()==="F"){

    if(nombreContribuyente == 0) {
        $.notify({

            message: 'Por favor, Ingrese El Nombre del Contribuyente'
        },
        {
            type: 'danger',
            z_index: 999999,
        });

        $('#nombreContribuyente').focus();
        $('#nombreContribuyente').addClass('is-invalid');

        return false;

    }
    else if(nombreContribuyente.length > 0){
        $('#nombreContribuyente').removeClass('is-invalid');
    }
    if(apellidoPaterno.length == 0) {
        $.notify({

            message: 'Por favor, Ingrese El Apellido Paterno'
        },
        {
            type: 'danger',
            z_index: 999999,
        });
        $('#apellidoPaterno').focus();
        $('#apellidoPaterno').addClass('is-invalid');

        return false;

    }
    else if(apellidoPaterno.length > 0){
        $('#apellidoPaterno').removeClass('is-invalid');
    }
    else if(apellidoMaterno.length == 0) {
            $.notify({

            message: 'Por favor, Ingrese El Apellido Materno'
        },
        {
            type: 'danger',
            z_index: 999999,
        });

    }
    else if(rfc.length == 0) {
        $.notify({

            message: 'Por favor, Ingrese el R.F.C.'
        },
        {
            type: 'danger',
            z_index: 999999,
        });
    }

    else if(curp.length == 0){
        $.notify({

            message: 'Por favor, Ingrese el C.U.R.P.'
        },
        {
            type: 'danger',
            z_index: 999999,
        });


    }
else if(dia.length == 0||mes.length == 0||año.length == 0){
    $.notify({

                message: 'Por favor, Ingrese Una Fecha de Nacimiento'
            },
            {
                type: 'danger',
                z_index: 999999,
            });

}
else if(mes == 2 && dia > 28|| mes == 4 && dia > 30 || mes == 6 && dia > 30 || mes == 9 && dia > 30 || mes == 11 && dia > 30 ){

        $.notify({

                message: 'Por favor, Ingrese una fecha valida.'
            },
            {
                type: 'danger',
                z_index: 999999,
            });


}else{


if(nombreContribuyente.length > 0 && apellidoPaterno.length > 0 && apellidoMaterno.length > 0 && rfc.length > 0 && curp.length > 0 && dia.length > 0 && mes.length > 0 && año.length > 0 && correoElectronico.length == 0 && telefono.length == 0 ){

if(curp.length > 0){
    let  curCorrecto = curpValida(curp)
    if (!curCorrecto) {
            $.notify({

                message: 'El C.U.R.P. Ingresado no es válido por favor inténtelo de Nuevo'
            },
            {
                type: 'danger',
                z_index: 999999,
            });

    }else if(rfc.length > 0){


    let rfcCorrecto = rfcValido(rfc);   // ⬅️ Acá se comprueba
    if (!rfcCorrecto) {

                $.notify({

                message: 'El R.F.C. Ingresado no es válido por favor inténtelo de Nuevo'
            },
            {
                type: 'danger',
                z_index: 999999,
            });

        }else{
            let addContribuyente = new Contribuyente();

            guardarContribuyente(new Array(addContribuyente));
        }
    }
}


}else if(nombreContribuyente.length > 0 && apellidoPaterno.length > 0 && apellidoMaterno.length > 0 && rfc.length > 0 && curp.length > 0 && dia.length > 0 && mes.length > 0 && año.length > 0 && correoElectronico.length > 0 && telefono.length < 1 ){

    if($("#correoElectronico").val().indexOf('@', 0) == -1 || $("#correoElectronico").val().indexOf('.', 0) == -1){
        $.notify({

                message: 'El correo electrónico introducido no es correcto.'
            },
            {
                type: 'danger',
                z_index: 999999,
            });
        }else if(curp.length > 0){
            let  curCorrecto = curpValida(curp)
            if (!curCorrecto) {
                    $.notify({

                        message: 'El C.U.R.P. Ingresado no es válido por favor inténtelo de Nuevo'
                    },
                    {
                        type: 'danger',
                        z_index: 999999,
                    });

            }else if(rfc.length > 0){


            let rfcCorrecto = rfcValido(rfc);   // ⬅️ Acá se comprueba
            if (!rfcCorrecto) {

                        $.notify({

                        message: 'El R.F.C. Ingresado no es válido por favor inténtelo de Nuevo'
                    },
                    {
                        type: 'danger',
                        z_index: 999999,
                    });

                }else{
                    let addContribuyente = new Contribuyente();

                    guardarContribuyente(new Array(addContribuyente));
                }
            }
        }


}else if(nombreContribuyente.length > 0 && apellidoPaterno.length > 0 && apellidoMaterno.length > 0 && rfc.length > 0 && curp.length > 0 && dia.length > 0 && mes.length > 0 && año.length > 0 && correoElectronico.length < 1 && telefono.length  > 0 ){

    if($("#telefono").val().length < 9){
            $.notify({

                message: 'El teléfono debe tener 9 caracteres.'
            },
            {
                type: 'danger',
                z_index: 999999,
            });

        }else if(curp.length > 0){
            let  curCorrecto = curpValida(curp)
            if (!curCorrecto) {
                    $.notify({

                        message: 'El C.U.R.P. Ingresado no es válido por favor inténtelo de Nuevo'
                    },
                    {
                        type: 'danger',
                        z_index: 999999,
                    });

            }else if(rfc.length > 0){


            let rfcCorrecto = rfcValido(rfc);   // ⬅️ Acá se comprueba
            if (!rfcCorrecto) {

                        $.notify({

                        message: 'El R.F.C. Ingresado no es válido por favor inténtelo de Nuevo'
                    },
                    {
                        type: 'danger',
                        z_index: 999999,
                    });

                }else{
                    let addContribuyente = new Contribuyente();

                    guardarContribuyente(new Array(addContribuyente));
                }
            }
        }


}else if(nombreContribuyente.length > 0 && apellidoPaterno.length > 0 && apellidoMaterno.length > 0 && rfc.length > 0 && curp.length > 0 && dia.length > 0 && mes.length > 0 && año.length > 0 && correoElectronico.length > 0 && telefono.length > 0 ){

    if($("#correoElectronico").val().indexOf('@', 0) == -1 || $("#correoElectronico").val().indexOf('.', 0) == -1){
        $.notify({

                message: 'El correo electrónico introducido no es correcto.'
            },
            {
                type: 'danger',
                z_index: 999999,
            });
        }else if($("#telefono").val().length < 9){
            $.notify({

                message: 'El teléfono debe tener 9 caracteres.'
            },
            {
                type: 'danger',
                z_index: 999999,
            });

        }else if(curp.length > 0){
            let  curCorrecto = curpValida(curp)
            if (!curCorrecto) {
                    $.notify({

                        message: 'El C.U.R.P. Ingresado no es válido por favor inténtelo de Nuevo'
                    },
                    {
                        type: 'danger',
                        z_index: 999999,
                    });

            }else if(rfc.length > 0){


            let rfcCorrecto = rfcValido(rfc);   // ⬅️ Acá se comprueba
            if (!rfcCorrecto) {

                        $.notify({

                        message: 'El R.F.C. Ingresado no es válido por favor inténtelo de Nuevo'
                    },
                    {
                        type: 'danger',
                        z_index: 999999,
                    });

                }else{
                    let addContribuyente = new Contribuyente();

                    guardarContribuyente(new Array(addContribuyente));
                }
            }
        }


}

}
///////Validacion Persona Moral////////////

}else if($("#tipoContribuyente").val()==="M"){
    if(nombreContribuyente == 0) {
        $.notify({

            message: 'Por favor, Ingrese el Nombre del Contribuyente'
        },
        {
            type: 'danger',
            z_index: 999999,
        });
        $('#nombreContribuyente').focus();
        $('#nombreContribuyente').addClass('is-invalid');

        return false;

    }else if(nombreContribuyente.length > 0){
        $('#nombreContribuyente').removeClass('is-invalid');
    }
    if(rfc == 0) {
        $.notify({

            message: 'Por favor, Ingrese el R.F.C'
        },
        {
            type: 'danger',
            z_index: 999999,
        });

        $('#rfc').focus();
        $('#rfc').addClass('is-invalid');

        return false;

    }
    else if(rfc.length > 0){
        $('#rfc').removeClass('is-invalid');
    }
    if(razonSocial == 0) {
        $.notify({

            message: 'Por favor, Ingrese una Razón Social'
        },
        {
            type: 'danger',
            z_index: 999999,
        });

        $('#razonSocial').focus();
        $('#razonSocial').addClass('is-invalid');

        return false;

    }

    else if(rfc.length > 0){
        $('#razonSocial').removeClass('is-invalid');
    }

if(nombreContribuyente.length > 0 && rfc.length > 0 && razonSocial.length > 0 && telefono.length == 0 && correoElectronico.length == 0){

if(rfc.length > 0){


    var rfcCorrecto = rfcValido(rfc);   // ⬅️ Acá se comprueba
    if (!rfcCorrecto) {

                $.notify({

                message: 'El R.F.C Ingresado no es valido Por favor Intente de Nuevo'
            },
            {
                type: 'danger',
                z_index: 999999,
            });

        }else{
            let addContribuyente = new Contribuyente();

            guardarContribuyente(new Array(addContribuyente));
        }
    }



}else if(nombreContribuyente.length > 0 && rfc.length > 0 && razonSocial.length > 0 && telefono.length < 1 & correoElectronico.length > 0 ){

    if($("#correoElectronico").val().indexOf('@', 0) == -1 || $("#correoElectronico").val().indexOf('.', 0) == -1){
        $.notify({

                message: 'El correo electrónico introducido no es correcto.'
            },
            {
                type: 'danger',
                z_index: 999999,
            });
        }else if(rfc.length > 0){
            var rfcCorrecto = rfcValido(rfc);   // ⬅️ Acá se comprueba
            if (!rfcCorrecto) {
                $.notify({

                    message: 'El R.F.C Ingresado no es valido Por favor Intente de Nuevo'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

            }else{
                let addContribuyente = new Contribuyente();

                guardarContribuyente(new Array(addContribuyente));
            }

        }


}else if(nombreContribuyente.length > 0 && rfc.length > 0 && razonSocial.length > 0 && telefono.length > 0 & correoElectronico.length < 1 ){

    if($("#telefono").val().length < 9){
            $.notify({

                message: 'El teléfono debe tener 9 caracteres.'
            },
            {
                type: 'danger',
                z_index: 999999,
            });

        }else if(rfc.length > 0){
            var rfcCorrecto = rfcValido(rfc);   // ⬅️ Acá se comprueba
            if (!rfcCorrecto) {
                $.notify({

                    message: 'El R.F.C Ingresado no es valido Por favor Intente de Nuevo'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

            }else{
                let addContribuyente = new Contribuyente();

                guardarContribuyente(new Array(addContribuyente));
            }

        }


}else if(nombreContribuyente.length > 0 && rfc.length > 0 && razonSocial.length > 0 && telefono.length > 0 & correoElectronico.length > 0 ){

    if($("#correoElectronico").val().indexOf('@', 0) == -1 || $("#correoElectronico").val().indexOf('.', 0) == -1){
        $.notify({

                message: 'El correo electrónico introducido no es correcto.'
            },
            {
                type: 'danger',
                z_index: 999999,
            });
        }else if($("#telefono").val().length < 9){
            $.notify({

                message: 'El teléfono debe tener 9 caracteres.'
            },
            {
                type: 'danger',
                z_index: 999999,
            });

        }else if(rfc.length > 0){
            var rfcCorrecto = rfcValido(rfc);   // ⬅️ Acá se comprueba
            if (!rfcCorrecto) {
                $.notify({

                    message: 'El R.F.C Ingresado no es valido Por favor Intente de Nuevo'
                },
                {
                    type: 'danger',
                    z_index: 999999,
                });

            }else{
                let addContribuyente = new Contribuyente();

                guardarContribuyente(new Array(addContribuyente));
            }

        }


}

}

		});

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
        $('#div_rfc').removeClass('col-sm-6');
        $('#div_rfc').addClass('col-sm-4');
        $('#div_apellidoPaterno').show();
        $('#div_apellidoMaterno').show();
        $('#div_fechaNacimeinto').show();
        $('#div_genero').show();
        $('#div_estadoCivil').show();
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
        $('#genero').val("M");

    });


});

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
        $('#div_rfc').removeClass('col-sm-4');
        $('#div_rfc').addClass('col-sm-6');
        $('#div_apellidoPaterno').hide();
        $('#div_apellidoMaterno').hide();
        $('#div_fechaNacimeinto').hide();
        $('#div_genero').hide();
        $('#div_estadoCivil').hide();
        $('#div_mes').hide();
        $('#div_año').hide();
        $('#div_curp').hide();
        $('#br_año').hide();
        $('#br_mes').hide();
        ////Para remover las clases////
        $('#nombreContribuyente').removeClass('is-invalid');
        $('#razonSocial').removeClass('is-invalid');
        $('#rfc').removeClass('is-invalid');
        $('#correoElectronico').removeClass('is-invalid');
        $('#telefono').removeClass('is-invalid');
        ////////////////
        $('#nombreContribuyente').val('');
        $('#razonSocial').val('');
        $('#rfc').val('');
        $('#correoElectronico').val('');
        $('#telefono').val('');
    }
    else if(tipo_Persona == "F"){
        $('#div_nombre').removeClass('col-sm-12');
        $('#div_nombre').addClass('col-sm-4');
        $('#div_correoElectronico').removeClass('col-sm-6');
        $('#div_correoElectronico').addClass('col-sm-4');
        $('#div_telefono').removeClass('col-sm-6');
        $('#div_telefono').addClass('col-sm-4');
        $('#div_razonSocial').hide();
        $('#div_rfc').removeClass('col-sm-6');
        $('#div_rfc').addClass('col-sm-4');
        $('#div_apellidoPaterno').show();
        $('#div_apellidoMaterno').show();
        $('#div_fechaNacimeinto').show();
        $('#div_genero').show();
        $('#div_estadoCivil').show();
        $('#div_mes').show();
        $('#div_año').show();
        $('#div_curp').show();
        $('#br_año').show();
        $('#br_mes').show();
          ////Para remover las clases////
        $('#nombreContribuyente').removeClass('is-invalid');
        $('#apellidoPaterno').removeClass('is-invalid');
        $('#apellidoMaterno').removeClass('is-invalid');
        $('#curp').removeClass('is-invalid');
        $('#rfc').removeClass('is-invalid');
        $('#dia').removeClass('is-invalid');
        $('#mes').removeClass('is-invalid');
        $('#año').removeClass('is-invalid');
        $('#correoElectronico').removeClass('is-invalid');
        $('#telefono').removeClass('is-invalid');
          //////////////////////////////
        $('#nombreContribuyente').val('');
        $('#apellidoPaterno').val('');
        $('#apellidoMaterno').val('');
        $('#curp').val('');
        $('#rfc').val('');
        $('#dia').val('');
        $('#mes').val('');
        $('#año').val('');
        $('#correoElectronico').val('');
        $('#telefono').val('');



    }

};


