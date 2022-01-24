@extends('layouts.app')
@section('content')


@include('layouts.headers.cards', ['data_count' => $data_count])

<!-- Page content -->
<div class="container-fluid mt--7">
    <!-- Dark table -->
    <div class="row">
        <div class="col">
            <div class="card shadow" style="padding: 10px;">
                <div class="card-header bg-transparent border-0">
                    <h3 class="text-black mb-0">Todos los Registros: </h3>
                </div>
                <div>


                    <table
                        class="table align-items-center table-hover table-flush display cell-border responsive nowrap"
                        style="width:100%;" id="list-registro">
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
                                {{-- <th scope="col" style="color: aliceblue;">Categoria</th>
                        <th scope="col" style="color: aliceblue;">Tipo</th>
                        <th scope="col" style="color: aliceblue;">Producto</th>
                        <th scope="col" style="color: aliceblue;">Observacion</th> --}}
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



<!-- Modal -->
<div class="modal fade" id="modal-entrega" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="title-modal"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" class="form-control" id="name" disabled>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Carnet Identidad Nº</label>
                            <input type="text" class="form-control" id="ci" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label>Expedido</label>
                            <input type="text" class="form-control" id="expedido" disabled>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4">
                            <label>Nº Celular</label>
                            <input type="text" class="form-control" id="celular" disabled>
                        </div>
                        <div class="col-sm-4">
                            <label>Distrito</label>
                            <input type="text" class="form-control" id="distrito" disabled>
                        </div>
                        <div class="col-sm-4">
                            <label>Sub Central</label>
                            <input type="text" class="form-control" id="central" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Rubro</label>
                            <input type="text" class="form-control" id="rubro" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label>Tipo</label>
                            <input type="text" class="form-control" id="tipo" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="s-observacion">
                    <label>Productos</label>
                    <select class="form-control" multiple="multiple" id="productos-select">

                    </select>
                </div>

                <div class="form-group" id="txt_obs">
                    <label>Observación</label>
                    <textarea class="form-control" id="observacion"
                        placeholder="LLenar este campo solo si es necesario" rows="5"></textarea>
                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn-entregar-producto">Entregar</button>
            </div>
        </div>
    </div>
</div>


@include('layouts.footers.auth')
</div>
@endsection
<script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
<script src="{{ asset('assets') }}/vendor/select2/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="{{ asset('assets') }}/vendor/select2/dist/css/select2.min.css">


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

<style>

</style>

<script>
$(document).ready(function() {

    $('#productos-select').select2({
        placeholder: 'Seleccione las opciones',
        allowClear: true,
        // multiple: true,
        width: '100%',
        tags: true
    });




    $(document).on('click', '#btn-entrega-producto', function() {

        var btn_id = $(this).val();

        $.ajax({
            type: "POST",
            url: "{{ route('personas.detalle') }}",
            data: {
                _token: "{{ csrf_token() }}",
                id: $(this).val(),
            },
            success: function(data) {
                $('#observacion').val('');
                if (data.status == true) {
                    $('#title-modal').text(
                        'ENTREGA DE PRODUCTO AGROPECUARIO FORMULARIO N.º ' + data
                        .response.nro_formulario);
                    $('#name').val($.trim(data.response.nombre + ' ' + data.response
                        .primer_ap + ' ' + data.response.segundo_ap));
                    $('#ci').val(data.response.ci);
                    $('#expedido').val(data.response.expedido);
                    $('#celular').val(data.response.nro_cel);
                    $('#distrito').val(data.response.distrito);
                    $('#central').val(data.response.sub_central);
                    $('#rubro').val(data.response.nombre_rubro);
                    $('#tipo').val(data.response.tipo);
                    $('#btn-entregar-producto').val(btn_id);
                    $("#productos-select").empty();
                    var productos_data = '';
                    $.each(data.productos, function(index, value){
                        productos_data = productos_data + '<option value="'+ value.id +'">'+value.nombre_producto+'</option>';
                    });
                    $("#productos-select").append(productos_data);
                    $('#modal-entrega').modal('show');
                }
            }
        });

    });




    $(document).on('click', '#btn-entregar-producto', function() {
        $.ajax({
            type: "PUT",
            url: "{{ route('personas.update') }}",
            data: {
                _token: "{{ csrf_token() }}",
                id_persona: $(this).val(),
                productos: $('#productos-select').val(),
                observacion: $('#observacion').val()
            },
            success: function(data) {
                if (data.status == true) {
                    console.log(data);
                    $('#modal-entrega').modal('hide');
                    $('#list-registro').DataTable().ajax.reload();
                    $('#num-entregados').text(data.entregados);
                    $('#num-pendientes').text(data.pendientes);
                    $('#num-producto-pending').text(data.pendientes_producto);
                    swal("OK!", data.response, "success")
                }else if(data.status == true){
                    swal({
                    title: "Ups!",
                    text: data.message,
                    type: "warning",
                    timer: 3000
                    }),
                    function () {
                        location.reload(true);
                    };
                }
            },
            error: function(xhr, textStatus, errorThrown){
                swal({
                    title: "Ups!",
                    text: 'Procto es requerido!',
                    type: "warning",
                    timer: 2000
                    });
                
            } 
        });
    });
    //


    $(document).on('click', '#btn-ver-detalle', function() {
        alert('El modulo se encuentra en desarrollo');
    });

    $(document).on('click', '#btn-observado', function() {
        alert('El modulo se encuentra en desarrollo');
    });


    var table = $('#list-registro').DataTable({
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
            "sSearch": 'Buscar Datos:',
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
            "url": "{{ route('personas.get-data-all') }}",
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

                    if (row.status == null) {
                        return '<h5 style="color: #700101;">PENDIENTE</h5>';
                    }
                    if (row.status == 'PENDIENTE-PRODUCTO') {
                        return '<h5 style="color: #700101;">PENDIENTE DE PRODUCTO</h5>';
                    } else if (row.status == 'ENTREGADO') {
                        return '<h5 style="color: #035e1b;">ENTREGADO</h5>';
                    } else if (row.status == 'OBSERVADO') {
                        return '<h5 style="color: #e77500;">OBSERVADO</h5>';
                    }

                }
            },
            // { "data": "actividad" },
            //{'defaultContent': '<button value="'+"ci"+'">Click!</button>'} //contenido default
            {
                sortable: false,
                "render": function(data, type, row, meta) {

                    if (row.status == null) {
                        return '<button value="' + row.id +
                            '" type="button" title="Entregar Producto Agropecuario" id="btn-entrega-producto" class="btn btn-danger"><i class="fab fa-product-hunt"></i></button>';
                    }
                    if (row.status == 'PENDIENTE-PRODUCTO') {
                        return '<button value="' + row.id +
                            '" type="button" title="Entregar Producto Agropecuario Faltante" id="btn-pendiente-producto" class="btn btn-danger"><i class="fas fa-project-diagram"></i></button>';
                    } else if (row.status == 'ENTREGADO') {
                        return '<button value="' + row.id +
                            '" type="button" title="Ver detalle" id="btn-ver-detalle" class="btn btn-success"><i class="fas fa-eye"></i></button>';
                    } else if (row.status == 'OBSERVADO') {
                        return '<button value="' + row.id +
                            '" type="button" title="Ver Observación" id="btn-observado" class="btn btn-dark"><i class="fas fa-asterisk"></i></button>';
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

    $(document).on('click', '#btn-pendiente-producto', function() {
alert('pendiente en desarrollo');
    });
});
</script>