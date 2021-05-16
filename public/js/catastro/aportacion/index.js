$(document).ready(function() {

        // [ Configuration Option ]
            var table = $('#aportaciones').DataTable({
            responsive: true,
            searching: true,
            autoWidth: true,
            processing: true,
            serverSide: true,
            //deferRender: true,
            paging: true,
            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            //pageLength: 10,
            order: [[ 0, "desc" ]],
            ajax: {
                url: "/aportacion/datatable",
                type: "POST",
                dataSrc:"data",
                data: function(d){
                    return $.extend({},d,{
                        "filter_options":$("#buscarAportacion").val(),
                    });

                },
                error: function(){
                    $(".aportaciones-error").html("");
                    $("#aportaciones").append('<tbody class="aportaciones-error"><tr class="text-center"><th colspan="6">No se encontraron datos en el servidor. </th></tr></tbody>');
                    $(".dataTables_empty").css("display","none");
                    $("#aportaciones_processing").css("display","none");
                },
                "complete": function(response) {
                    console.log(response);
                }
            },
            initComplete: function () {
                $('#lv-links').hide();
                if ($(this).find('tbody tr').length<=1) {
                    $(this).parent().show();
                }
            },
            columns: [
                {data: 'idAportacion',},
                {data: 'Parcela'},
                {data: 'Contribuyente'},
                {data: 'Propietario'},
                {data: 'Lote', searchable: false},
                {data: 'UltimoPago', searchable: false},
                {data: 'Estatus', orderable: false, searchable: false},
                {data: 'Opciones', orderable: false, searchable: false },
                ],
            columnDefs: [
                {
                    targets: 6,
                    orderable: false,
                    render: function(data, type, row, meta){
                        if( row['Estatus'] == 1 ){
                            $actionBtn = `<span class="badge badge-light-success">Aprobado</span>`;
                        }else if(row['Estatus'] == 2){
                            $actionBtn = `<span class="badge badge-light-danger">Cancelado</span>`;
                        }
                        else {
                            $actionBtn = `<span class="badge badge-light-warning">En Proceso</span>`;
                        }
                        return $actionBtn;
                    },
                },
                {
                    targets: 7,
                    orderable: false,
                    render: function(data, type, row, meta){
                        if(row['Estatus'] == 3 ){
                        $actionBtn = `<a href="aportacion/ver-aportacion/` + row['idAportacion'] + `"> <button  data-toggle="tooltip" title="Editar" type="button"class="btn btn-warning"><i class="fa fa-edit"></i></button></a>
                        <a href="aportacion/pdfdirrector/` + row['idAportacion'] + `"> <button data-toggle="tooltip" title="Imprimir" type="button="class="btn btn btn-primary"><i class="fas fa-print"></i></button></a>
                        <a href="#"> <button data-toggle="tooltip" title="Pase de Caja" type="button="class="btn btn btn-success" disabled ><i class="fas fa-file-invoice-dollar"></i></button></a> `;

                        }else if(row['Estatus'] == 2){
                        $actionBtn = `<a href="#"> <button type="button="class="btn btn-warning" disabled><i class="fa fa-edit"></i></button></a>
                        <a href="#"><button type="button="class="btn btn btn-primary" disabled><i class="fas fa-print"></i></button></a>
                        <a href="#"> <button type="button="class="btn btn-success" disabled><i class="fas fa-file-invoice-dollar"></i></button></a>`;

                        }else {
                        $actionBtn = `<a href="aportacion/editar-aportacion"> <button type="button="class="btn btn-warning" disabled><i class="fa fa-edit"></i></button></a>
                        <a href="aportacion/pdfdirrector/` + row['idAportacion'] + `"><button type="button="class="btn btn btn-primary" ><i class="fas fa-print"></i></button></a>
                        <a href="http://sistematulum.net:9070/TLANIA/oestadocuentapredialpase.aspx?MTULUM,2021,3,4,` + row['idSolicitud'] + `" target="_blank"> <button type="button="class="btn btn-success" ><i class="fas fa-file-invoice-dollar"></i></button></a>`;

                        }
                        return $actionBtn;
                    },
                },
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.6/i18n/Spanish.json"
            },




        });

        $('#show-hide-res').DataTable({
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate,
                    type: ''
                }
            }
        });


//////Inicio Buscar por Contribuyente, ID, Propietario, Parcela/////
        $(document).on('change', '#buscarAportacion', function () {
            let select = $('#buscarAportacion').val();
            $('#query2').val(select);
            console.log(select);
            //return select;
        });

        $('#query').on( 'keyup', function () {

            //console.log(parametro());
            let colum = $('#query2').val();
            table
            //.columns(colum)
            .search( this.value )
            .draw();
            } );
});
////Fin DataTable/////
