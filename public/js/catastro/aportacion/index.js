$(document).ready(function() {
    setTimeout(function() {
        // [ Configuration Option ]
        $('#aportacionesf').DataTable({
            responsive: true,
            autoWidth: false,
            scrollX: true,
            scroller: {
                loadingIndicator: true
            },
            processing: true,
            serverSide: true,
            deferRender: true,
            paging: true,
            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            pageLength: 10,
            order: [],
            ajax: {
                type: "POST",
                url: "/aportacion/datatable",
                dataType: "JSON",
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
                {data: 'Fecha'},
                {data: 'Estatus', orderable: false, searchable: false,},
                {data: 'opciones', orderable: false, searchable: false },
            ],
            columnDefs: [
                {
                    targets: 5,
                    orderable: false,
                    render: function(data, type, row, meta){
                    $actionBtn = `
                        <div class="btn-group">
                            <a href="/aportacion/pdf/` + row['idAportacion'] + `"> <button type="button="class="btn btn-primary"` + (row['Estatus'] == 2 || row['Estatus'] == 3 ) ? ' disable' : ''  + `">Imprimir</button> </a>
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
        var newcs = $('#new-cons').DataTable();

        new $.fn.dataTable.Responsive(newcs);

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

$(".js-data-example-ajax2").select2({
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
        $('[name ="titular"]').val(data.titular);
        $('[name ="n_region"]').val(data.n_region);
        $('[name ="lote"]').val(data.lote);
        $('[name ="ubicacion"]').val(data.ubicacion);
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

function Calcular() {
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
    //document.getElementById("pago_as").value = w;
}

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
