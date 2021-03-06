window.onload = function() {
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var url = 'contribuyente/eliminar/' + id;
        $('.modal-title').text('Eliminar')
        $(this).find( ".btn-ok" ).click(function() {
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                async: true,
                success: function () {
                    location.reload();
                    $('#deleteModal').modal('hide'); // show bootstrap modal when complete loaded
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log();
                    alert('Error get data from ajax');
                }
            });
        });
    })
}
