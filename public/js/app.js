$(document).ready(function () {
    var minimumFields = 1,
        maximumFields = 5;
    $(document).on('click', '#add_more', function () {
        var original = document.getElementsByClassName('file-input file-input-new');
        console.log(original);
        $('#select').clone()
            .removeAttr("id")

            .appendTo('#additionalselects');

            minimumFields++;

        if (minimumFields >= maximumFields) {
            $("#add_more").prop("disabled", true);
        }
    });

    $(document).on('click', '.delete', function () {
        if (minimumFields != 1) {
            $(this).parent().parent().remove();
            minimumFields--;
                if (minimumFields < maximumFields) {
                    $("#add_more").prop("disabled", false);
            }
        }
    });
});
