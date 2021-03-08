$(document).ready(function() {
    // var info = (myTable == null) ? { "start": 0, "length": 10 } : myTable.page.info();
    setTimeout(function() {
        // [ Configuration Option ]
        $('#contribuyentes').DataTable({
            // responsive: true,
            // autoWidth: false,
            // scrollX: true,
            processing: true,
            serverSide: true,
            deferRender: true,
            paging: true,
            // ajax: "/contribuyente",
            // ajax: {
            //     "type": "GET",
            //     "url": "/contribuyente",
            //     "dataType": "JSON",
            //     // "contentType": 'application/json; charset=utf-8',
            //     "data": function (data) {
            //         // Grab form values containing user options
            //         // var form = {};
            //         // $.each($("form").serializeArray(), function (i, field) {
            //         //     form[field.name] = field.value || "";
            //         // });
            //         // Add options used by Datatables
            //         var info = { "start": 0, "length": 10, "draw": 1 };
            //         // $.extend(form, info);
            //         // return JSON.stringify(form);
            //     },
            //     "complete": function(response) {
            //         console.log(response);
            //     }
            // },
            sAjaxSource:"/contribuyente/datatable",
            // ajax:{
            //     url :"/contribuyente",
            //     type: "post",
            //     error: function(){
            //         $(".contribuyentes-error").html("");
            //         $("#contribuyentes").append('<tbody class="contribuyentes-error"><tr class="text-center"><th colspan="6">No data found in the server</th></tr></tbody>');
            //         $(".dataTables_empty").css("display","none");
            //         $("#contribuyentes_processing").css("display","none");
            //     }
            // },
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
            // columnDefs: [
            //     {
            //         "targets": 5,
            //         orderable: false,
            //         "render": function(data, type, row, meta){
            //         $actionBtn = `
            //             <div class="btn-group">
            //                 <a href="/contribuyente/ver/` + row['idContribuyente'] + `"  class="btn btn-info" data-toggle="modal" onclick="view_contribuyente(` + row['idContribuyente'] + `)">Ver</a>
            //                 <a href="/contribuyente/editar/` + row['idContribuyente'] + `" class="btn btn-warning" data-toggle="modal" onclick="edit_contribuyente(` + row['idContribuyente'] + `)">Editar</a>
            //                 <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="` + row['idContribuyente'] + `">Eliminar</button>
            //             </div>
            //         `;
            //             return $actionBtn;
            //         }
            //     }
            // ],
            // language: {
            //     url: "//cdn.datatables.net/plug-ins/1.10.6/i18n/Spanish.json"
            // },
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
