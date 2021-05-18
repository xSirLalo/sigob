$(document).ready(function(){
    setTimeout(function() {
        // [ Configuration Option ]
        $('#predios').DataTable({
            responsive: true,
            // searching: true,
            autoWidth: true,
            // scrollX: true,
            // scroller: {
            //     loadingIndicator: true
            // },
            processing: true,
            serverSide: true,
            deferRender: true,
            paging: true,
            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            pageLength: 10,
            order: [[ 0, "desc" ]],
            ajax: {
                url: "/predio/datatable",
                type: "POST",
                dataSrc:"data",
                error: function(){
                    $(".predios-error").html("");
                    $("#predios").append('<tbody class="predios-error"><tr class="text-center"><th colspan="6">No data found in the server</th></tr></tbody>');
                    $(".dataTables_empty").css("display","none");
                    $("#predios_processing").css("display","none");
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
                {data: 'idPredio', orderable: true, searchable: false,},
                {data: 'claveCatastral'},
                {data: 'contribuyente'},
                {data: 'ubicacion'},
                {data: 'tipo', orderable: false, searchable: false,},
                {data: 'opciones', orderable: false, searchable: false },
            ],
            columnDefs: [
                {
                    targets: 5,
                    orderable: false,
                    render: function(data, type, row, meta){
                    $actionBtn = `
                        <div class="btn-group">
                            <a href="/predio/ver/` + row['idPredio'] + `"> <button class="btn btn-info btn-sm" title="Detalle"><i class="fas fa-folder-open fa-fw"></i></button> </a>
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
