$(document).ready(function() {
    setTimeout(function() {
        // [ Configuration Option ]
        $('#res-config').DataTable({
            "order": [[ 0, "desc" ]],
            responsive: true,
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
