$(document).ready(function(){
    setTimeout(function() {
        // [ Configuration Option ]
        $('#aportaciones').DataTable({
            responsive: true,
            autoWidth: false,
            scrollX: true,
            scroller: {
                loadingIndicator: true
            },
            processing: true,
            // serverSide: true,
            deferRender: true,
            paging: true,
            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            pageLength: 10,
            order: [],
            ajax: {
                url: "/aportacion/datatable",
                type: "POST",
                error: function(){
                    $(".aportaciones-error").html("");
                    $("#aportaciones").append('<tbody class="aportaciones-error"><tr class="text-center"><th colspan="6">No data found in the server</th></tr></tbody>');
                    $(".dataTables_empty").css("display","none");
                    $("#aportaciones_processing").css("display","none");
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
                {data: 'idAportacion', orderable: true, searchable: false,},
                {data: 'Contribuyente'},
                {data: 'Titular'},
                {data: 'Vigencia'},
                {data: 'Pago'},
                {data: 'Estatus', orderable: false, searchable: false,},
                {data: 'Opciones', orderable: false, searchable: false },
            ],
            columnDefs: [
                {
                    targets: 6,
                    orderable: false,
                    render: function(data, type, row, meta){
                    $actionBtn = `
                        <div class="btn-group">
                            <a href="/aportacion/pdf/` + row['idAportacion'] + `"> <button class="btn btn-primary"> Imprimir</button> </a>
                        </div>
                        `;
                        return $actionBtn;
                    }
                }
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.6/i18n/Spanish.json"
            },
        });

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

    }, 350);
});
//Modal-Funcion Modificar
function edit_validation(id)
{
    save_method = 'update';
    $('#btnGuardar').show();
    $('#btnGuardar').removeClass('invisible');
    $('#validacion_form_modal')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // clear error class
    $('.text-danger').empty(); // clear error string
    $("#validacion_form_modal :input").prop("disabled", false);
    //Ajax Load data from ajax
    $.ajax({
    url : "ver/" + id,
    type: "POST",
    dataType: "JSON",
    contentType: "application/json; charset=utf-8",
    success: function(data)
        {
            //console.log(data);
            $('[name="id_aportacion"]').val(data.id_aportacion);
            $('[name="vig"]').val(data.vig);
            $('[name="terreno"]').val(data.terreno);
            $('[name="valor_m2_zona"]').val(data.valor_m2_zona);
            $('[name="v_terreno"]').val(formatter.format(data.v_terreno));
            $('[name="sup_m"]').val(data.sup_m);
            $('[name="select_valor_construccion"]').val(data.valorConstruccion);
            $('[name="valor"]').val(data.valor);
            $('[name="v_in"]').val(data.valor);
            $('[name="v_c"]').val(formatter.format(data.v_c));
            $('[name="a_total"]').val(formatter.format(data.a_total));
            $('[name="avaluo_hidden"]').val(data.avaluo_hidden);
            $('[name="select_tasa"]').val(data.select_tasa);
            $('[name="tasa_hidden"]').val(data.tasa_hidden);
            $('[name="ejercicio_f"]').val(data.ejercicio_f);
            $('[name="pago_a"]').val(formatter.format(data.pago_a));
            //$('[name="pago_a"]').val(formatter.format(data.pago_a));
            $('#myModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('DIRECCION DE CATASTRO'); // Set Title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

    if(save_method == 'update') {
        $("#validacion_form_modal").submit(function(event){
            event.preventDefault();
            var id = $("#id_aportacion").val();
            var url = 'editar/' + id;
            //console.log(id);
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                async: true,
                data: $("#validacion_form_modal").serialize(),
                success: function (data) {

                console.log(data);
                if(data.proceso) //if success close modal and reload ajax table
                {
                    //console.log(data);
                    //console.log(data.proceso);
                    location.reload();
                    $('#myModal').modal('hide'); // show bootstrap modal when complete loaded
                } else {
                    console.log(data);
                        $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // clear error class
                        $('.text-danger').empty(); // clear error string
                        $.each(data.errors, function(key, value) {
                            $('[name="'+ key +'"]').addClass('is-invalid');
                            for(var i in value) {
                                $('[name="'+ key +'"]').parents('.form-group').find('.text-danger').append('<li>' + value[i] + '</li>');
                            }
                        });
                    }
                    $('#btnGuardar').val('Guardar'); //change button text
                    $('#btnGuardar').attr('disabled',false); //set button enable
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    //console.log(data);
                    alert('Error get data from ajax');
                }
            });
        });
    }
}
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
    let pago_aportacion = valor_tasa * a_total;
    document.getElementById("pago_a").value = formatter.format(pago_aportacion);

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
    let pago_aportacion = valor_tasa * a_total;
    document.getElementById("pago_a").value = formatter.format(pago_aportacion);
}

//select Tasa impositiva
function timpositiva() {
    let select_tasa = document.getElementById("tasa_i");
    let valor_tasa = select_tasa.options[select_tasa.selectedIndex].value;
    document.getElementById("tasa_hidden").value = valor_tasa;
    let avaluo_total = parseFloat(document.getElementById("avaluo_hidden").value);
    let valor_avaluo = document.getElementById("a_total").value;
    if(valor_avaluo.length == 0){
        document.getElementById("pago_a").value = 0;
    }else{
    let pago_aportacion = valor_tasa * avaluo_total;
    document.getElementById("pago_a").value = formatter.format(pago_aportacion);
    document.getElementById("p_hide").value = formatter.format(pago_aportacion);
    }

}
//funcion Calular-Fin

//Modal-Funcion Solo numeros con 1 punto y maximo dos decimales
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
//Modal-validar solo numero
function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
    return true;
    }
    return false;
}




