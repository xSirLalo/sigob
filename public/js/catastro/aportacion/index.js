    // $('#buscar').on( 'click', function () {
    //     // var id =  $('#buscar').val();
    //     //var from = $("#query").val();
    //     var like = $("#query").val();
    //     var from = $("#buscarAportacion").val();

////Inicio DataTable/////

$(document).ready(function() {
    setTimeout(function() {
        // [ Configuration Option ]

            var table = $('#aportaciones').DataTable({
            responsive: true,
            searching: true,
            autoWidth: false,
            scrollX: true,
            scroller: {
                loadingIndicator: true
            },
            processing: true,
            serverSide: true,
            //deferRender: true,
            paging: true,
            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            //pageLength: 10,
            order: [[ 0, "desc" ]],
            ajax: {
                url: "/aportacion/datatable",
                type: "POST",
                dataSrc:"data",
                data: function(d){
                    return $.extend({},d,{
                        //"filter_options":$("#query2").val(),
                        "filter_options":$("#buscarAportacion").val(),
                    });

                },
                error: function(){
                    $(".aportaciones-error").html("");
                    $("#aportaciones").append('<tbody class="aportaciones-error"><tr class="text-center"><th colspan="6">No se encontraron datos en el servidor. </th></tr></tbody>');
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
                {data: 'idAportacion',},
                {data: 'Parcela'},
                {data: 'Contribuyente'},
                {data: 'Propietario'},
                {data: 'Lote', searchable: false},
                {data: 'UltimoPago', searchable: false},
                {data: 'Estatus', orderable: false, searchable: false},
                {data: 'Opciones', orderable: false, searchable: false },
                ],
            columnDefs: [
                {
                    targets: 6,
                    orderable: false,
                    render: function(data, type, row, meta){
                        if( row['Estatus'] == 1 ){
                            $actionBtn = `<span class="badge badge-light-success">Verificado</span>`;
                        }else if(row['Estatus'] == 2){
                            $actionBtn = `<span class="badge badge-light-danger">Cancelado</span>`;
                        }
                        else {
                            $actionBtn = `<span class="badge badge-light-warning">En Proceso</span>`;
                        }
                        return $actionBtn;
                    },
                },
                {
                    targets: 7,
                    orderable: false,
                    render: function(data, type, row, meta){
                        if(row['Estatus'] == 3 ){
                        $actionBtn = `<a href="aportacion/ver-aportacion/` + row['idAportacion'] + `"> <button  type="button"class="btn btn-warning">Editar</button></a>
                        <a href="aportacion/pdfdirrector/` + row['idAportacion'] + `"> <button type="button="class="btn btn btn-primary" >Imprimir</button></a>
                        <a href="#"> <button type="button="class="btn btn btn-success" disabled >Pase Caja</button></a> `;

                        // $actionBtn = `<button value="` + row['idAportacion'] + `" id="btnEditar" type="button="class="btn btn-warning" onclick="edit_aportacion(` + row['idAportacion'] + `)">Editar</button>
                        // <a href="aportacion/pdfdirrector/` + row['idAportacion'] + `"> <button type="button="class="btn btn btn-primary" >Imprimir</button></a>
                        // <a href="#"> <button type="button="class="btn btn btn-success" disabled >Pase Caja</button></a> `;
                        }else if(row['Estatus'] == 2){
                        $actionBtn = `<a href="#"> <button type="button="class="btn btn-warning" disabled>Editar</button></a>
                        <a href="#"><button type="button="class="btn btn btn-primary" disabled>Imprimir</button></a>
                        <a href="#"> <button type="button="class="btn btn-success" disabled>Pase Caja</button></a>`;

                        }else {

                        $actionBtn = `<a href="aportacion/editar-aportacion"> <button type="button="class="btn btn-warning" disabled>Editar</button></a>
                        <a href="aportacion/pdfdirrector/` + row['idAportacion'] + `"><button type="button="class="btn btn btn-primary" >Imprimir</button></a>
                        <a href="http://sistematulum.net:9000/TLANIA/oestadocuentapredialpase.aspx?MTULUM,2021,3,4,` + row['idSolicitud'] + `" target="_blank"> <button type="button="class="btn btn-success" >Pase Caja</button></a>`;


                        }
                        return $actionBtn;
                    },
                },
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


//////Inicio Buscar por Contribuyente, ID, Propietario, Parcela/////
        $(document).on('change', '#buscarAportacion', function () {
            let select = $('#buscarAportacion').val();
            $('#query2').val(select);
            console.log(select);
            //return select;
        });

        $('#query').on( 'keyup', function () {

            //console.log(parametro());
            let colum = $('#query2').val();
            table
            //.columns(colum)
            .search( this.value )
            .draw();
            } );


    }, 350);
});
////Fin DataTable/////




$(document).ready(function() {
function formatRepo(repo) {
    if (repo.loading) return repo.text;

    var markup = "";
    if (repo.titular) {
        markup += "<div class='select2-result-repository__description'>" + repo.titular + "</div>";
    }

    return markup;
}
///select///

function formatRepoSelection(repo) {
    return repo.titular || repo.text;
}

$(".js-data-example-ajax2").select2({
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
    dropdownParent: $("#MyModal"),
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

$('.js-data-example-ajax2').change(function(){
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
        $('[name ="parcela"]').val(data.parcela);
        $('[name ="manzana"]').val(data.manzana);
        $('[name ="lote"]').val(data.lote);
        $('[name ="local"]').val(data.local);
        $('[name ="categoria"]').val(data.categoria);
        $('[name ="condicion"]').val(data.condicion);
        $('[name ="titular"]').val(data.titular);
        $('[name ="ubicacion"]').val(data.ubicacion);
        $('[name ="antecedentes"]').val(data.antecedentes);
        $('[name ="regimen_propiedad"]').val(data.regimenPropiedad);
        $('[name ="contribuyente"]').val(data.contribuyente);
        $('[name ="giro_comercial"]').val(data.giroComercial);
        $('[name ="nombre_comercial"]').val(data.nombreComercial);
        $('[name ="tenencia"]').val(data.tenencia);
        $('[name ="rfc"]').val(data.rfc);
        $('[name ="uso_destino"]').val(data.usoDestino);
        $('[name ="n_region"]').val(data.n_region);
        $('[name ="lote"]').val(data.lote);
        $('[name ="localidad"]').val(data.localidad);
        $('[name ="d_propiedad"]').val(data.d_propiedad);
        $('[name ="d_arrendamiento"]').val(data.d_arrendamiento);
        $('[name ="g_comercial"]').val(data.g_comercial);
        $('[name ="n_comercial"]').val(data.n_comercial);
        $('[name ="s_ocupada"]').val(data.s_ocupada);
        $('[name ="u_destino"]').val(data.u_destino);
        $('[name ="titular_anterior"]').val(data.titular_anterior);
        $('[name ="arrendador"]').val(data.arrendador);
        $('[name ="con_norte"]').val(data.con_norte);
        $('[name ="con_sur"]').val(data.con_sur);
        $('[name ="con_este"]').val(data.con_este);
        $('[name ="con_oeste"]').val(data.con_oeste);
        $('[name ="norte"]').val(data.norte);
        $('[name ="sur"]').val(data.sur);
        $('[name ="este"]').val(data.este);
        $('[name ="oeste"]').val(data.oeste);
        $('[name ="id_predio"]').val(data.id_predio);
        $('[name ="idcontribuyente"]').val(data.idcontribuyente);
        $('[name ="cvlCatastral"]').val(data.cvlCatastral);
        $("#formato").show();

    },
    error: function (jqXHR, textStatus, errorThrown)
    {
       $('#modal_alert').modal('show'); // show bootstrap modal
    }
    });
});
//enviar id por referencia en Javascript
$("#agregar_requerimiento_modal").click(function(e){
    e.preventDefault();
    var combo = document.getElementById("contribuyente_id");
    var selected = combo.options[combo.selectedIndex].value;
    window.location.href ="aportacion/nueva-aportacion/" + selected;
})

$("#formato").hide();

//Funcion Ocultar modal
$('#MyModal').on('hide.bs.modal', function(event) {
//limpiar los input del Modal
//$(this).find('form')[0].reset();
$('#aportacion_form_modal')[0].reset();
//Limpiar el selec del modal
$('.js-data-example-ajax2').empty();
$('.js-data-example-ajax2').select2("val", "");
//Oculatar la parte del calculo
$("#formato").hide();
//$(this).find('form')[0].reset();

})
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
        document.getElementById("pago_a").value = formatter.format(0);
    }else{
    let pago_aportacion = valor_tasa * avaluo_total;
    document.getElementById("pago_a").value = formatter.format(pago_aportacion);
    document.getElementById("p_hide").value = formatter.format(pago_aportacion);
    }

}
//funcion Calular-Fin

function add_contribuyente()
{
    $('#btnGuardar').show();
    $('#btnGuardar').removeClass('invisible');
    $('#aportacion_form_modal')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // clear error class
    $('.text-danger').empty(); // clear error string
    $("#aportacion_form_modal :input").prop("disabled", false);
    $('#MyModal').modal('show'); // show bootstrap modal
   // $('.modal-title').text('Agregar Contribuyente'); // Set Title to Bootstrap modal title
}
$("#aportacion_form_modal").submit(function(event){
    event.preventDefault();
    var URL = '/aportacion/guardarModal';
    //Ajax Load data from ajax
    $.ajax({
        url: URL,
        type: 'POST',
        dataType: 'JSON',
        async: true,
        data: $("#aportacion_form_modal").serialize(),
        success: function (data) {
            if(data.status) //if success close modal and reload ajax table
            {
                location.reload();
                $('#MyModal').modal('hide'); // show bootstrap modal when complete loaded
            } else {
                $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // clear error class
                $('.text-danger').empty(); // clear error string
                $.each(data.errors, function(key, value) {
                    $('[name="'+ key +'"]').addClass('is-invalid');
                    for(var i in value) {
                        $('[name="'+ key +'"]').parents('.form-group').find('.text-danger').append('<li>' + value[i] + '</li>');
                    }
                });
            }
            console.log(data);
            $('#btnGuardar').val('Guardar'); //change button text
            $('#btnGuardar').attr('disabled',false); //set button enable
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            console.log(data);
        }
    });
});

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

//Inicio Funcion validacion button buscar aportacion////
// $(document).ready(function() {
//     $('#query').attr("disabled", true);
// });
// function validacioninput(){
//     let buscar_aportacion =  $("#buscarAportacion").val();

//     if(buscar_aportacion == ""){
//         $('#query').attr("disabled", true);
//     }
//     else{
//         $('#query').attr("disabled", false);
//     }

// };
///Fin Funcion validacion button buscar aportacion////


///Funcion buscador Id-Contribuyente-Propietario-Parcela///

//     $('#buscar').on( 'click', function () {

//         var id = 1;
//         $.ajax({
//             url: "/aportacion/datatable",
//             id:id,
//             method: 'POST',
//             data:{id:id},

//             // dataType: 'JSON',
//             // async: true,
//             // success: function(data)
//             // {
//             //     console.log("variable enviada con excito");
//             // },
//             // error: function (jqXHR, textStatus, errorThrown)
//             // {
//             //     alert("error");
//             // }
//         });
//     // });


// });
///Fin Funcion buscador Id-Contribuyente-Propietario-Parcela///

///////////devolver datos con metodo pos////
$('#xd').click(function(){
    var id = $(this).val();
    var url = '/aportacion/editar-aportacion/' + id;
    //console.log(id);
    //alert("hola");

    //AJAX request
    $.ajax({
    url: url,
    method: 'POST',
    dataType: 'JSON',
    async: true,
    success: function(data)
    {
    console.log(data);
        $('[name="id_aportacion"]').val(data.id_aportacion);


    },
    error: function (jqXHR, textStatus, errorThrown)
    {
    //    $('#modal_alert').modal('show'); // show bootstrap modal
    console.log("error");
    }
    });
});
// $("#xd").click(function(e){
//     e.preventDefault();


//     //var combo = document.getElementById("contribuyente_id");
//     //var selected = combo.options[combo.selectedIndex].value;
//     window.location.href ="aportacion";
//     $.ajax({
//     url: url,
//     method: 'POST',
//     dataType: 'JSON',
//     async: true,
//     success: function(data)
//     {
//     console.log(data);
//         $('[name ="parcela"]').val(data.parcela);


//     },
//     error: function (jqXHR, textStatus, errorThrown)
//     {
//        $('#modal_alert').modal('show'); // show bootstrap modal
//     }
//     });
// });


// function edit_aportacion(id)
// {

//     $.ajax({
//     url : "/aportacion/editar-aportacion/" + id,
//     type: "POST",
//     dataType: "JSON",
//     contentType: "application/json; charset=utf-8",
//     success: function(data)
//         {
//             console.log(data);
//             $('[name="id_aportacion"]').val(data.id_aportacion);

//         },
//         error: function (jqXHR, textStatus, errorThrown)
//         {
//             alert('Error get data from ajax');
//         }
//     });
// }

// edit_aportacion($().val());

