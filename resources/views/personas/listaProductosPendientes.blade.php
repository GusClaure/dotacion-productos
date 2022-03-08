@extends('layouts.app', ['sitio' => 'pendientes'])
@section('content')


@include('layouts.headers.cards', ['data_count' => $data_count])

<!-- Page content -->
<div class="container-fluid mt--7">
    <!-- Dark table -->
    <div class="row">
        <div class="col">
            <div class="card shadow" style="padding: 10px;">
                <div class="card-header bg-transparent border-0">
                    <h3 class="text-black mb-0">Productos Pendientes por Entregar: </h3>
                </div>
                <div>

                    <table
                        class="table align-items-center table-hover table-flush display cell-border responsive nowrap"
                        style="width:100%;" id="list-registro-entregados">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="color: aliceblue;">#</th>
                                <th scope="col" style="color: aliceblue;">Nº Formulario</th>
                                <th scope="col" style="color: aliceblue;">Nombre</th>
                                <th scope="col" style="color: aliceblue;">Apellidos</th>
                                <th scope="col" style="color: aliceblue;">CI</th>
                                <th scope="col" style="color: aliceblue;">Expedido</th>
                                <th scope="col" style="color: aliceblue;">Nº Celular</th>
                                <th scope="col" style="color: aliceblue;">Distrito</th>
                                <th scope="col" style="color: aliceblue;">Sud Central</th>
                                <th scope="col" style="color: aliceblue;">Estado</th>
                                <th scope="col" style="color: aliceblue;">Acciones</th>

                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- modal -->

<!-- Modal complementacion de entrega de producto -->
<div class="modal fade" id="modal-complementacion-producto" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="title-modal_con"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" class="form-control" id="name_con" disabled>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Carnet Identidad Nº</label>
                            <input type="text" class="form-control" id="ci_con" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label>Expedido</label>
                            <input type="text" class="form-control" id="expedido_con" disabled>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4">
                            <label>Nº Celular</label>
                            <input type="text" class="form-control" id="celular_con" disabled>
                        </div>
                        <div class="col-sm-4">
                            <label>Distrito</label>
                            <input type="text" class="form-control" id="distrito_con" disabled>
                        </div>
                        <div class="col-sm-4">
                            <label>Sub Central</label>
                            <input type="text" class="form-control" id="central_con" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Rubro</label>
                            <input type="text" class="form-control" id="rubro_con" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label>Tipo</label>
                            <input type="text" class="form-control" id="tipo_con" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="div-entregados">
                    <div style="text-align: center; color: #00912c;">
                        <label>Productos ya Entregados</label>
                    </div>
                    <div id="productos-entregados_con">
                    </div>
                </div>


                <div class="form-group" id="txt_obs">
                    
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>




<!-- Modal complementacion de entrega de producto -->
<div class="modal fade" id="modal-show-pdf" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
            <embed id="frame" width="100%" height="450">
            <!-- <iframe id="frame" frameborder="0" height="100%" width="100%"></iframe> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@include('personas.modalEntregaProducto')

@include('personas.modalComplementacionProducto')

@include('layouts.footers.auth')

@endsection

<script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>

<script src="../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('libreries') }}/datatable-boostrap/js/bootstrap-paginator.min.js"></script>
<script src="{{ asset('libreries') }}/datatable-boostrap/js/bootstrap-paginator.min.js"></script>
<script src="{{ asset('libreries') }}/datatable-boostrap/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('libreries') }}/datatable-boostrap/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('libreries') }}/datatable-boostrap/js/jszip.min.js"></script>
<script src="{{ asset('libreries') }}/datatable-boostrap/js/buttons.html5.min.js"></script>
<script src="{{ asset('libreries') }}/datatable-boostrap/js/pdfmake.min.js"></script>
<script src="{{ asset('libreries') }}/datatable-boostrap/js/vfs_fonts.js"></script>
<script src="{{ asset('libreries') }}/datatable-boostrap/js/dataTables.responsive.min.js"></script>

<link rel="stylesheet" href="{{ asset('libreries') }}/sweetalert.min.css">
<script src="{{ asset('libreries') }}/sweetalert.min.js"></script>
<link rel="stylesheet" href="/libreries/datatable-boostrap/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/libreries/datatable-boostrap/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="/libreries/datatable-boostrap/css/buttons.dataTables.min.css">

<script>
    $(document).ready(function() {

        
        $(document).on('click', '#btn-ver-detalle', function() {
        $('#modal-show-pdf').modal('show');
        var id_persona = $(this).val();
        $("#frame").attr("src", '/entregas/detalle-pdf/'+id_persona);
        // $('#show-pdf')
    });

        $(document).on('click', '#btn-detalle', function(){
            $('#div-entregados').show();
            btn_id = $(this).val();
            $.ajax({
            type: "POST",
            url: "{{ route('detalle.entrega') }}",
            data: {
                _token: "{{ csrf_token() }}",
                id_persona: $(this).val(),
            },
            success: function(data) {
                console.log(data);
                if (data.status == true) {
                    one_data = data.response[0];
                    $('#title-modal_con').text(
                        'COMPLEMENTACION DE ENTREGA DE PRODUCTO AGROPECUARIO FORMULARIO N.º ' +
                        one_data.nro_formulario);
                    $('#name_con').val($.trim(one_data.nombre + ' ' + one_data.primer_ap +
                        ' ' + one_data.segundo_ap));
                    $('#ci_con').val(one_data.ci);
                    $('#expedido_con').val(one_data.expedido);
                    $('#celular_con').val(one_data.nro_cel);
                    $('#distrito_con').val(one_data.distrito);
                    $('#central_con').val(one_data.sub_central);
                    $('#rubro_con').val(one_data.nombre_rubro);
                    $('#tipo_con').val(one_data.tipo);
                    $('#btn-complementacion-producto').val(btn_id);
                    $("#productos-select_con").empty();
                    $("#productos-entregados_con").empty();
                    var productos_entregados = '';
                    $.each(data.response, function(index, value) {
                        productos_entregados = productos_entregados +
                            '<label class="form-control">' + (index + 1) + '.- ' +
                            value.nombre_producto + '</label>';
                    });
                    
                    $("#productos-entregados_con").append(productos_entregados);
                    if(one_data.observacion != ''){
                        $('#txt_obs').append('<label>Observación</label><p>'+ one_data.observacion +'</p>')
                    }
                    
                    $('#modal-complementacion-producto').modal('show');
                }

            }
        });
        });

        var table = $('#list-registro-entregados').DataTable({
        lengthMenu: [
            [10, 20, 50, 100, 1000, 10000],
            ['10', '20', '50', '100', '1000', '10000']
        ],
        "lengthChange": false,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "paging": true,
        //colReorder: true,
        "searching": true,
        "language": {

            "sProcessing": '<p style="color: #012d02;">Cargando. Por favor espere...</p>',
            //"sProcessing": '<img src="https://media.giphy.com/media/3o7bu3XilJ5BOiSGic/giphy.gif" alt="Funny image">',
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": 'Buscar Datos Por CI:',
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": 'Primero',
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        },
        "bDestroy": true,
        "bJQueryUI": true,
        //datos
        "ajax": {
            "url": "{{ route('personas.get-data-all-pendientes') }}",
            "data": {
                "_token": "{{ csrf_token() }}",
            },
            "dataType": "json",
            "type": "POST",
        },
        // "rowCallback": function( row, data ) { //para diferenciar las columnas
        //     //console.log(data);
        //     // if ( true ) {
        //     //     $(row).addClass('selected');
        //     // }
        // },
        "columns": [{
                sortable: false,
                "render": function(data, type, row, meta) {
                    var value = meta.row + meta.settings._iDisplayStart +
                        1; //contador de numeros.
                    return value.toString();
                }
            },
            {
                "data": "nro_formulario.toString()"
            },
            {
                "data": "nombre"
            },
            {
                sortable: false,
                "render": function(data, type, row, meta) {
                    return $.trim(row.primer_ap + ' ' + row.segundo_ap);
                }
            },
            {
                "data": "ci.toString()"
            },
            {
                "data": "expedido"
            },
            {
                "data": "nro_cel..toString()"
            },
            {
                "data": "distrito"
            },
            {
                "data": "sub_central"
            },
            {
                sortable: false,
                "render": function(data, type, row, meta) {

                    if (row.status == 'PENDIENTE-PRODUCTO') {
                        return '<h5 style="color: #700101;">PENDIENTE DE PRODUCTO</h5>';
                    } else if (row.status == 'ENTREGADO') {
                        return '<h5 style="color: #035e1b;">ENTREGADO</h5>';
                    }

                }
            },
            // { "data": "actividad" },
            //{'defaultContent': '<button value="'+"ci"+'">Click!</button>'} //contenido default
            {
                sortable: false,
                "render": function(data, type, row, meta) {

                    if (row.status == 'PENDIENTE-PRODUCTO') {
                        return '<button value="' + row.id +
                            '" type="button" title="Ver detalle de la entrega" id="btn-detalle" class="btn btn-warning"><i class="fas fa-american-sign-language-interpreting"></i></button>' +
                            '<button value="' + row.id +'" type="button" title="Detalle de la entrega" id="btn-ver-detalle" class="btn btn-info"><i class="fas fa-eye"></i></button>';
                    } 

                }
            }
        ],
        dom: 'Bfrtip',
        buttons: ['pageLength', {
                extend: 'excelHtml5',
                titleAttr: 'Se exportará el reporte según a la cantidad de filas.',
                autoFilter: true,
                title: 'REGISTRO DE PRODUCTORES AGROPECUARIOS',
                text: 'EXPORTAR EXEL',
                //message: "Any message for header inside the file. I am not able to put message in next row in excel file but you can use \n",
                customize: function(xlsx) {},

            },

            // export funtion pdf
            // {
            //     extend: 'pdfHtml5',
            //     titleAttr: 'Exportar el resporte a PDF',
            //     text: 'EXPORTAR PDF',
            //     title: 'REPORTE DE FUNCIONARIOS',
            //     alignment: 'center',
            //     orientation: 'landscape',
            //     customize: function (doc) {

            //         doc.content.splice(0, 0, {
            //             margin: [0, 0, 0, -25],
            //             alignment: 'left',
            //             image: '',
            //             width: 260,
            //         });
            //         doc.styles.tableHeader.fillColor = '#CEF6F5';
            //         doc.styles.tableHeader.color = '#0B4C5F';
            //         doc.defaultStyle.fillColor = '#EFF5FB';
            //         doc.defaultStyle.fontSize = 8;
            //         doc.defaultStyle.alignment = 'center';
            //         doc.styles.tableHeader.fontSize = 8;
            //         //doc.content.splice(0,1);
            //         var now = new Date();
            //         var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear();

            //         doc['footer'] = (function (page, pages) {
            //             return {
            //                 columns: [
            //                     {
            //                         alignment: 'left',
            //                         text: ['Generado el: ', {text: jsDate.toString()}]
            //                     },
            //                     {
            //                         alignment: 'right',
            //                         text: ['Pagina ', {text: page.toString()}, ' de ', {text: pages.toString()}]
            //                     }
            //                 ],
            //                 margin: 20
            //             }
            //         });

            //     }
            // },
            {
                extend: 'csvHtml5',
                titleAttr: 'Exportar el resporte a CSV',
                text: 'EXPORTAR CSV',
                title: 'Any title for the file',
                customize: function(csv) {

                    return "Any heading for the csv file can be separated with , and for new line use \n" +
                        csv;
                }
            },
            {
                extend: 'copyHtml5',
                text: 'COPIAR',
                titleAttr: 'Copiar en el portapapeles'
            },
        ]
    });
    });
</script>