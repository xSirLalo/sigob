$(document).ready(function() {
    // setTimeout(function() {
        // [ Configuration Option ]
        $('#bibliotecas').DataTable({
            // order: [[ 0, "desc" ]],
            // responsive: true,
            // autoWidth: false,
            // scrollX: true,
            lengthMenu: [
                [25, 50, 100],
                [25, 50, 100]
            ],
            // pageLength: 25,
            initComplete: function () {
                $('#lv-links').hide();
                if ($(this).find('tbody tr').length<=1) {
                    $(this).parent().show();
                }
            },
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.6/i18n/Spanish.json"
            },
        });

        // [ New Constructor ]
        // var newcs = $('#new-cons').DataTable();

        // new $.fn.dataTable.Responsive(newcs);

        // [ Immediately Show Hidden Details ]
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
