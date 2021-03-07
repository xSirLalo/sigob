$(document).ready(function() {
    // setTimeout(function() {
        // [ Configuration Option ]
        $('#contribuyentes').DataTable({
            "order": [[ 0, "desc" ]],
            // responsive: true,
            // autoWidth: false,
            scrollX: true,
            lengthMenu: [
                [5, 10, 25],
                [5, 10, 25]
            ],
            pageLength: 5,
            processing: true,
            serverSide: true,
            ajax: {
            url:'contribuyente',
            type: "post",
            dataSrc: function ( json ) {
                //Make your callback here.
                // alert("Done!");
                console.log(json);
                return json.data;
            }
                // error: function (jqXHR, textStatus, errorThrown)
                // {
                //     console.log();
                //     alert('Error get data from ajax');
                // }
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
                {data: 'genero', orderable: true, searchable: false,},
                {data: 'opciones', orderable: false, searchable: false },
            ],
            columnDefs: [
                {
                    "targets": 5,
                    orderable: false,
                    "render": function(data, type, row, meta){
                    $actionBtn = `
                        <div class="btn-group">
                            <a href="/contribuyente/ver/` + row['idContribuyente'] + `"  class="btn btn-info" data-toggle="modal" onclick="view_contribuyente(` + row['idContribuyente'] + `)">Ver</a>
                            <a href="/contribuyente/editar/` + row['idContribuyente'] + `" class="btn btn-warning" data-toggle="modal" onclick="edit_contribuyente(` + row['idContribuyente'] + `)">Editar</a>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="` + row['idContribuyente'] + `">Eliminar</button>
                        </div>
                    `;
                        return $actionBtn;
                    }
                }
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.6/i18n/Spanish.json"
                // "lengthMenu": "Mostrar _MENU_ registros por página",
                // "zeroRecords": "Nada encontrado - disculpa.",
                // "info": "Mostrando la página _PAGE_ de _PAGES_",
                // "infoEmpty": "No hay datos...",
                // "infoFiltered": "(filtrado de _MAX_ registros totales)",
                // "search": "Buscar:",
                // "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                // "paginate":{
                //     'next': 'Siguiente',
                //     'previous': 'Anterior',
                // },
            },
        });

    //     // [ New Constructor ]
    //     var newcs = $('#new-cons').DataTable();

    //     new $.fn.dataTable.Responsive(newcs);

    //     // [ Immediately Show Hidden Details ]
    //     $('#show-hide-res').DataTable({
    //         responsive: {
    //             details: {
    //                 display: $.fn.dataTable.Responsive.display.childRowImmediate,
    //                 type: ''
    //             }
    //         }
    //     });

    // }, 350);
});
