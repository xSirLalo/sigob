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
            $('[name="terreno"]').val(data.terreno);
            $('[name="v_terreno"]').val(data.v_terreno);
            $('[name="sup_m"]').val(data.sup_m);
            $('[name="v_c"]').val(data.v_c);
            $('[name="a_total"]').val(data.a_total);
            $('[name="vig"]').val(data.vig);
            $('[name="pago_a"]').val(data.pago_a);
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
                    //console.log(data);
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

// Modal-Funcion Calcular Aportacion
function Calcular()
{
    let metros_terreno = parseFloat(document.getElementById("terreno").value);
    let valor_terreno = metros_terreno *100;
    document.getElementById("v_terreno").value = valor_terreno;
    //  Calculo valor Construccion
    let inv = parseFloat(document.getElementById("v_in").value);
    let metros_construccion = parseFloat(document.getElementById("sup_m").value);
    let valor_construnccion = metros_construccion * inv;
    document.getElementById("v_c").value = valor_construnccion;
    //Avaluo Total
    let avaluo_total = valor_terreno + valor_construnccion;
    document.getElementById("a_total").value = avaluo_total;
    //validaciones
    let m_terreno = document.getElementById("terreno").value;
    let m_construnccion = document.getElementById("sup_m").value;
    let valor_oculto = document.getElementById("v_in").value;
    //valida si el campo metros Terreno esta vacio
    if (m_terreno.length == 0) {
        document.getElementById("v_terreno").value = 0;
        document.getElementById("a_total").value = 0;
    }
    //valida si el campo metros Construccion esta vacio
    if (m_construnccion.length == 0) {
        document.getElementById("v_c").value = 0;
        document.getElementById("a_total").value = 0;
    }
   //valida si el campo oculto no tiene valor
    if (valor_oculto.length == 0) {
        document.getElementById("v_c").value = 0;
        document.getElementById("v_in").value = 0;
        document.getElementById("a_total").value = 0;
    }
     //Tasa_impositiva
    let select_tasa = document.getElementById("tasa_i");
    let valor_tasa = select_tasa.options[select_tasa.selectedIndex].value;
    let a_total = parseFloat(document.getElementById("a_total").value);
    let pago_aportacion = valor_tasa * a_total;
    document.getElementById("pago_a").value = pago_aportacion;

}

function valorC() {
    let  select_valores_construccion = document.getElementById("valor_c");
    let valores_construccion = select_valores_construccion.options[select_valores_construccion.selectedIndex].value;
    document.getElementById("v_in").value = valores_construccion;
    let metros_construccion = parseFloat(document.getElementById("sup_m").value);
    let valor_construnccion = valores_construccion * metros_construccion;
    let valor_c = document.getElementById("sup_m").value;
    if(valor_c.length == 0){
        metros_construccion = 0;
        document.getElementById("v_c").value = 0;
    }else{
        document.getElementById("v_c").value = valor_construnccion;
    }
    //Calculo Valor Terreno
    let metros_terreno = parseFloat(document.getElementById("terreno").value);
    let valor_terreno = metros_terreno *100;
    document.getElementById("v_terreno").value = valor_terreno;
    //Calculo valor Construccion
    let inv = parseFloat(document.getElementById("v_in").value);
    let mts_construccion = parseFloat(document.getElementById("sup_m").value);
    let val_construnccion = mts_construccion * inv;
    document.getElementById("v_c").value = val_construnccion;
    //Avaluo Total
    let avaluo_total = valor_terreno + valor_construnccion;
    document.getElementById("a_total").value = avaluo_total;
    //validaciones
    let m_terreno = document.getElementById("terreno").value;
    let m_construnccion = document.getElementById("sup_m").value;
    let valor_oculto = document.getElementById("v_in").value;
    //valida si el campo metros Terreno esta vacio
    if (m_terreno.length == 0) {
        document.getElementById("v_terreno").value = 0;
        document.getElementById("a_total").value = 0;
    }
    //valida si el campo metros Construccion esta vacio
    if (m_construnccion.length == 0) {
        document.getElementById("v_c").value = 0;
        document.getElementById("a_total").value = 0;
    }
   //valida si el campo oculto no tiene valor
    if (valor_oculto.length == 0) {
        document.getElementById("v_c").value = 0;
        document.getElementById("v_in").value = 0;
        document.getElementById("a_total").value = 0;
    }
    //Tasa_impositiva
    let select_tasa = document.getElementById("tasa_i");
    let valor_tasa = select_tasa.options[select_tasa.selectedIndex].value;
    let a_total = parseFloat(document.getElementById("a_total").value);
    let pago_aportacion = valor_tasa * a_total;
    document.getElementById("pago_a").value = pago_aportacion;
}

//select Tasa impositiva
function timpositiva() {
    let select_tasa = document.getElementById("tasa_i");
    let valor_tasa = select_tasa.options[select_tasa.selectedIndex].value;
    let avaluo_total = parseFloat(document.getElementById("a_total").value);
    let pago_aportacion = valor_tasa * avaluo_total;
    document.getElementById("pago_a").value = pago_aportacion;
}

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
    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
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




