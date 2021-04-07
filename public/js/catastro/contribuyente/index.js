$(document).ready(function() {
    // var info = (myTable == null) ? { "start": 0, "length": 10 } : myTable.page.info();
    setTimeout(function() {
        // [ Configuration Option ]
        $('#contribuyentes').DataTable({
            responsive: true,
            autoWidth: false,
            scrollX: true,
            // scrollY: 200,
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
            // ajax: {
            //     type: "POST",
            //     url: "/contribuyente",
            //     dataType: "JSON",
            //     // "contentType": 'application/json; charset=utf-8',
            //     data: function (data) {
            //         // Grab form values containing user options
            //         // var form = {};
            //         // $.each($("form").serializeArray(), function (i, field) {
            //         //     form[field.name] = field.value || "";
            //         // });
            //         // Add options used by Datatables
            //         var out = [];

            //         for ( var i=data.start, ien=data.start+data.length ; i<ien ; i++ ) {
            //             out.push( [ i+'-1', i+'-2', i+'-3', i+'-4', i+'-5' ] );
            //         }
            //         var info = { "start": 0, "length": 10, "draw": 1 };
            //         // $.extend(form, info);
            //         // return JSON.stringify(form);
            //     },
            //     error: function(){
            //         $(".contribuyentes-error").html("");
            //         $("#contribuyentes").append('<tbody class="contribuyentes-error"><tr class="text-center"><th colspan="6">No data found in the server</th></tr></tbody>');
            //         $(".dataTables_empty").css("display","none");
            //         $("#contribuyentes_processing").css("display","none");
            //     },
            //     "complete": function(response) {
            //         console.log(response);
            //     }
            // },
            // sAjaxSource:"/contribuyente/datatable",
            ajax:{
                url :"/contribuyente/datatable",
                type: "post",
                error: function(){
                    $(".contribuyentes-error").html("");
                    $("#contribuyentes").append('<tbody class="contribuyentes-error"><tr class="text-center"><th colspan="6">No data found in the server</th></tr></tbody>');
                    $(".dataTables_empty").css("display","none");
                    $("#contribuyentes_processing").css("display","none");
                }
            },
            initComplete: function () {
                $('#lv-links').hide();
                if ($(this).find('tbody tr').length<=1) {
                    $(this).parent().show();
                }
            },
            columns: [
                {data: 'idContribuyente', orderable: true, searchable: false,},
                {data: 'nombre'},
                {data: 'apellidoPaterno'},
                {data: 'apellidoMaterno'},
                {data: 'genero', orderable: false, searchable: false,},
                {data: 'opciones', orderable: false, searchable: false },
            ],
            columnDefs: [
                {
                    targets: 5,
                    orderable: false,
                    render: function(data, type, row, meta){
                    $actionBtn = `
                        <div class="btn-group">
                            <a href="/contribuyente/ver/` + row['idContribuyente'] + `"  class="btn btn-info">Detalle</a>
                            <a href="/contribuyente/editar/` + row['idContribuyente'] + `" class="btn btn-warning">Editar</a>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="` + row['idContribuyente'] + `">Eliminar</button>
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

function add_contribuyente()
{
    save_method = 'add';
    $('#btnGuardar').show();
    $('#btnGuardar').removeClass('invisible');
    $('#contribuyente_form')[0].reset(); // reset form on modals
    $('.form-control').removeClass('is-invalid').removeClass('is-valid'); // clear error class
    $('.text-danger').empty(); // clear error string
    $("#contribuyente_form :input").prop("disabled", false);
    $('#myModal').modal('show'); // show bootstrap modal
    $('.modal-title').text('Agregar'); // Set Title to Bootstrap modal title
    $('#form_update').attr('id','contribuyente_form');

    if(save_method == 'add') {
    $("#contribuyente_form").submit(function(event){
        event.preventDefault();
        var URL = 'contribuyente/agregar';
        //Ajax Load data from ajax
        $.ajax({
            url: URL,
            type: 'POST',
            dataType: 'JSON',
            async: true,
            data: $("#contribuyente_form").serialize(),
            success: function (data) {
                if(data.status) //if success close modal and reload ajax table
                {
                    location.reload();
                    $('#myModal').modal('hide'); // show bootstrap modal when complete loaded
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
                $('#btnGuardar').val('Guardar'); //change button text
                $('#btnGuardar').attr('disabled',false); //set button enable
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(data);
                alert('Error get data from ajax');
            }
        });
    });
    }
}
