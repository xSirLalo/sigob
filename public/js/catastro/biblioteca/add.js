'use strict';
$(document).ready(function () {
    // [ loading data ]
    function formatRepo(repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.full_name || repo.text;
    }

    $(".js-data-example-ajax2").select2({
        ajax: {
            url: "/contribuyente/buscar",
            dataType: 'JSON',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatRepo, // omitted for brevity, see the source of this page
        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
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

    // $("#archivo").fileinput({
    //     browseClass: 'btn btn-xs btn-secondary',
    //     language: "es",
    //     showCaption: true,
    //     showRemove: false,
    //     showUpload: false,
    //     showPreview: false,
    //     maxFileCount: 1,
    //     browseLabel: '',
    //     browseIcon: '<i class="fa fa-folder"></i>',
    //     allowedFileExtensions: ["png", "jpeg", "jpg", "bmp", "pdf"],
    //     uploadUrl: '/biblioteca/guardar-archivo',
    //     uploadAsync: true,
    //     uploadExtraData: function (previewId, index) {
    //         var info = 0;//{'tk':$("#token").val()};
    //         return info;
    //     }
    // }).on("filebatchselected", function (event, files) {
    //     // $("#archivo").fileinput("upload");
    // });
});
