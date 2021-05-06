$(document).ready(function () {

    $('body').on("change", ".custom-select", function (evt) {
      var fieldValue  = $(this).val();
      $(this).siblings('.custom-select').children('option').each(function() {
        if ( $(this).val() === fieldValue ) {
          $(this).attr('disabled', true);   
        }
      });
    });

    var minimumFields = 1,
        maximumFields = 5;

    $(document).on('click', '#add_more', function () {
        var original = document.getElementsByClassName('file-input file-input-new');
        console.log(original);
        $('#select').clone()
            .removeAttr("id")
            .appendTo('#additionalselects');
            minimumFields++;

            const $selects = $(".custom-select");
            $selects.on('change', function(evt) {
                // create empty array to store the selected values
                const selectedValue = [];
                // get all selected options and filter them to get only options with value attr (to skip the default options). After that push the values to the array.
                $selects.find(':selected').filter(function(idx, el) {
                    return $(el).attr('value');
                }).each(function(idx, el) {
                    selectedValue.push($(el).attr('value'));
                });
                // loop all the options
                $selects.find('option').each(function(idx, option) { 
                    // if the array contains the current option value otherwise we re-enable it.
                    if (selectedValue.indexOf($(option).attr('value')) > -1) {
                        // if the current option is the selected option, we skip it otherwise we disable it.
                        if ($(option).is(':checked')) {
                            return;
                        } else {
                            $(this).attr('disabled', true);
                        }
                    } else {
                        $(this).attr('disabled', false);
                    }
                });
            });

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
