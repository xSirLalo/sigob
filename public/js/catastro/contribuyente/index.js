$(document).ready(function() {
    setTimeout(function() {
        // [ Configuration Option ]
        $('#contribuyentes').DataTable({
            "order": [[ 0, "desc" ]],
            responsive: true,
            // scrollX: true,
            // autoWidth: false,
            // processing: true,
            // serverSide: true,
            // ajax: '/contribuyente',
            lengthMenu: [
                [5, 10, 25],
                [5, 10, 25]
            ],
            columns: [
                {data: 'id_contribuyente', orderable: true, searchable: false,},
                {data: 'nombre'},
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
});
