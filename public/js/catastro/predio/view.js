$(document).ready(function () {
    $("#archivo").fileinput({
        browseClass: 'btn btn-xs btn-secondary',
        language: "es",
        showCaption: true,
        showRemove: false,
        showUpload: false,
        showPreview: false,
        maxFileCount: 1,
        browseLabel: '',
        browseIcon: '<i class="fa fa-folder"></i>',
        allowedFileExtensions: ["png", "jpeg", "jpg", "bmp", "pdf"],
        uploadUrl: '/biblioteca/guardar-archivo',
        uploadAsync: true,
        uploadExtraData: function (previewId, index) {
            var info = {
                'id_archivo_categoria':$("#id_archivo_categoria").val(),
                'input1':$('[name="input1"]').val(),
                'relacion': "ArchivoPredio"
            };
            return info;
        }
    }).on("filebatchselected", function (event, files) {
        $("#archivo").fileinput("upload");
    });

    $("#archivo").on('fileuploaded', function(event, data, previewId, index) {
        var data = data.response;
        // console.log(data);
        if(data.response == "ok"){
            $('#subirArchivoForm')[0].reset();
            $("#archivosList").load(" #archivosList");
            $('#subirArchivoModal').modal('hide');
        }else{
            alert("Error: " + data.error);
        }
    });    
});
