/////////Ver Aportacion//////////
$(document).ready(function() {

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
            $('[id="contribuyente"]').val(data.contribuyente);
            $('[id="factura"]').val(data.factura);
            $('[id="giroComercial"]').val(data.giroComercial);
            $('[id="nombreComercial"]').val(data.nombreComercial);
            $('[id="tenencia"]').val(data.tenencia);
            $('[id="rfc"]').val(data.rfc);
            $('[id="usoDestino"]').val(data.usoDestino);

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

}

edit_aportacion($('#hdn_id_cont').val());


});

/////////Editar Aportacion metodo post////////////
$(document).ready(function() {
    let actualizarAportacion  = function(){

        this.Idaportacion       = $("#hdn_id_cont").val();
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


