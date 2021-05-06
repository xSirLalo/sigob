$(document).ready(function() {
   setTimeout(function() {
        // [ Configuration Option ]
    var myTable =  $('#contribuyentes').DataTable({
            // responsive: true,
            // searching: true,
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
            order: [[ 0, "desc" ]],
            ajax: {
                url :"/contribuyente/datatable",
                type: "POST",
                dataSrc:"data",
                error: function(){
                    $(".contribuyentes-error").html("");
                    $("#contribuyentes").append('<tbody class="contribuyentes-error"><tr class="text-center"><th colspan="6">No data found in the server</th></tr></tbody>');
                    $(".dataTables_empty").css("display","none");
                    $("#contribuyentes_processing").css("display","none");
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
                            <a href="/contribuyente/ver/` + row['idContribuyente'] + `"  class="btn btn-info btn-sm">Detalle</a>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-id="` + row['idContribuyente'] + `">Eliminar</button>
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

        // [ Immediately Show Hidden Details ]
        // $('#show-hide-res').DataTable({
        //     responsive: {
        //         details: {
        //             display: $.fn.dataTable.Responsive.display.childRowImmediate,
        //             type: ''
        //         }
        //     }
        // });

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
