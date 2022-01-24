@extends('layouts.app')

@section('content')
@include('layouts.headers.cards', ['data_count' => $data_count])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
            <div class="card bg-gradient-default shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            {{-- <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6> --}}
                            <h2 class="text-white mb-0">Sindicatos</h2>
                        </div>
                        <div class="col">
                            <ul class="nav nav-pills justify-content-end">
                                {{-- <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales" data-update='{"data":{"datasets":[{"data":[0, 20, 10, 30, 15, 40, 20, 60, 60]}]}}'
                                data-prefix="$" data-suffix="en">
                                <a href="#" class="nav-link py-2 px-3 active" data-toggle="tab">
                                    <span class="d-none d-md-block">Month</span>
                                    <span class="d-md-none">M</span>
                                </a>
                                </li> --}}
                                {{-- <li class="nav-item" data-toggle="chart" data-target="#chart-sales" data-update='{"data":{"datasets":[{"data":[0, 20, 5, 25, 10, 30, 15, 40, 40]}]}}'
                                data-prefix="$" data-suffix="k">
                                <a href="#" class="nav-link py-2 px-3" data-toggle="tab">
                                    <span class="d-none d-md-block">Week</span>
                                    <span class="d-md-none">W</span>
                                </a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <!-- Chart wrapper -->
                        <canvas id="chart-show" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="form-row">
        <div class="form-group col-md-12" style="text-align: center;">
            <h3 for="ausenciap1">PUNTOS Y COORDENADAS</h3>
            <select class="form-control col-sm-12" id="filter-count" style="text-align: center;">
                <option value="total">TOTAL {{ $data_count->total ?? '' }}</option>
                <option value="entregados">ENTREGADOS {{ $data_count->total_entregados ?? ''}}</option>
                <option value="pendientes">PENDIENTES {{ $data_count->total_pendientes ?? ''}}</option>
                <option value="pendientes_productos">PENDIENTES DE PRODUCTOS {{ $data_count->total_pendientes_producto ?? ''}}</option>
            </select>
            <div id="map-eventos-sociales" class="col-sm-12" style="height: 402px; margin-top: 20px;"></div>
        </div>
    </div>






    @include('layouts.footers.auth')
</div>
@endsection

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

<script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>

<script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
<script src="{{ asset('libreries') }}/leaflet-map/js/leaflet.js"></script>
<script src="{{ asset('libreries') }}/leaflet-map/js/leaflet.wms.js"></script>
<script src="{{ asset('libreries') }}/leaflet-map/js/proj4.js"></script>
<script src="{{ asset('libreries') }}/leaflet-map/js/proj4leaflet.js"></script>

<link rel="stylesheet" href="{{ asset('libreries') }}/leaflet-map/css/leaflet.css" />



<script>
//   maps code


var crs = new L.Proj.CRS(
    "EPSG:32719", "+proj=utm +zone=19 +south +datum=WGS84 +units=m +no_defs", {
        resolutions: [1600, 800, 400, 200, 100, 50, 25, 10, 5, 2.5, 1, 0.5, 0.25, 0.125, 0.0625]
    }
);



function getFeatureInfoUrl(map, layer, latlng, params) {
    var point = map.latLngToContainerPoint(latlng, map.getZoom()),
        size = map.getSize(),
        bounds = map.getBounds(),
        sw = bounds.getSouthWest(),
        ne = bounds.getNorthEast(),
        sw = crs.projection._proj.forward([sw.lng, sw.lat]),
        ne = crs.projection._proj.forward([ne.lng, ne.lat]);
    var defaultParams = {
        TRANSPARENT: true,
        request: 'GetFeatureInfo',
        service: 'WMS',
        srs: 'EPSG:32719',
        styles: '',
        version: '1.1.1',
        format: 'image/png',
        bbox: [sw.join(','), ne.join(',')].join(','),
        height: size.y,
        width: size.x,
        layers: 0,
        query_layers: 0
    };
    params = L.Util.extend(defaultParams, params || {});
    params[params.version === '1.3.0' ? 'i' : 'x'] = point.x;
    params[params.version === '1.3.0' ? 'j' : 'y'] = point.y;
    return layer + L.Util.getParamString(params, layer, true);
}



$(document).ready(function() {
    setTimeout(
        function() {
            $('.leaflet-control-attribution').text('innova.cochabamba.bo');
        }, 200);

    let mymap = new L.Map('map-eventos-sociales', {
        //crs: crs,
        minZoom: 13,
        maxZoom: 19,
        layers: [
            // L.tileLayer.wms('https://busquedasgamc.cochabamba.bo/web/index.php?r=services/get-imagenes', {
            // layers: '0',
            // format: 'image/png',
            // opacity: 0.9,
            // version: '1.1.1'
            // })

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                layers: '0',
                format: 'image/png',
                opacity: 0.9,
                version: '1.1.1',
                maxZoom: 25,
                crs: crs
            })
        ]
    });



    var districtLayer = L.tileLayer.wms(
        'https://busquedasgamc.cochabamba.bo/web/index.php?r=services/get-info-catastro', {
            layers: '0',
            format: 'image/png',
            version: '1.1.1',
            opacity: 1,
            maxZoom: 22,
            transparent: true,
            continuousWorld: true
        }).addTo(mymap);

    //marga el inicio del mapa 
    //mymap.setView([-17.39382474713952, -66.15696143763128], 18);
    mymap.setView([-17.425460491975,-66.201554314586], 13);

    setTimeout(function() {
        mymap.invalidateSize();
    }, 1000);

    let marker;
    '@foreach($data_persons as $value)'
    ubications = '{{ $value->ubicacion }}'.split(',');
    if ('{{$value->status}}' == 'ENTREGADO') {
        var valueIcon = new L.Icon({
            iconUrl: '{{ asset("libreries") }}/img/marker-icon-2x-green.png',
            shadowUrl: '{{ asset("libreries") }}/img/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });
    } else if ('{{$value->status}}' == null || '{{$value->status}}' == '') {
        
        var valueIcon = new L.Icon({
            iconUrl: '{{ asset("libreries") }}/img/marker-icon-2x-red.png',
            shadowUrl: '{{ asset("libreries") }}/img/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });
    } else if ('{{$value->status}}' == 'PENDIENTE-PRODUCTO') {
        var valueIcon = new L.Icon({
            iconUrl: '{{ asset("libreries") }}/img/marker-icon-2x-orange.png',
            shadowUrl: '{{ asset("libreries") }}/img/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });
    }

    marker = new L.Marker(ubications, {
        draggable: false,
        icon: valueIcon
    });

    mymap.addLayer(marker);
    nombre = '{{ $value->nombre." ".$value->primer_ap. " ".$value->segundo_ap }}';

    if('{{$value->status}}' == null || '{{$value->status}}' == ''){
        marker.bindPopup('<div style="text-align: center;"><i class="fas fa-home fa-6x"></i></div>' +
        '<span class="my-div-span"><b>Nombre: </b>' + nombre + '<br>' +
        '<b>CI: </b>{{ $value->ci }}<br>' +
        '<b>Sindicato: </b>{{ $value->sindicato }}<br>' +
        '<b>Rubro: </b>{{ $value->nombre_rubro }}<br>' +
        '<b>Tipo: </b>{{ $value->tipo }}<br>' +
        '<b>Estado:  PENDIENTE</b><br>' +
        '</span>');
    }else{
        marker.bindPopup('<div style="text-align: center;"><i class="fas fa-home fa-6x"></i></div>' +
        '<span class="my-div-span"><b>Nombre: </b>' + nombre + '<br>' +
        '<b>CI: </b>{{ $value->ci }}<br>' +
        '<b>Sindicato: </b>{{ $value->sindicato }}<br>' +
        '<b>Rubro: </b>{{ $value->nombre_rubro }}<br>' +
        '<b>Tipo: </b>{{ $value->tipo }}<br>' +
        '<b>Fecha: </b>{{ $value->fecha_entrega }}<br>' +
        '<b>Estado:  {{ $value->status }}</b><br>' +
        '</span>');
    }


    '@endforeach'



    //counter filter select

    $('#filter-count').on('change', function() {

        $.ajax({
            type: "POST",
            url: "{{ route('personas.filter') }}",
            data: {
                _token: "{{ csrf_token() }}",
                criterio: $(this).val(),
            },
            success: function(data) {
                if (data.status == true) {

                    $(".leaflet-marker-icon").remove();
                    $(".leaflet-marker-shadow").remove();
                    $(".leaflet-popup").remove();
                    mymap.setView([-17.425460491975,-66.201554314586], 
                    13,{
                  'animate': true,
                  'duration': 3});
                    $.each(data.response, function(index, value) {
                        ubications = value.ubicacion.split(',');
                        console.log(value.status);
                        if (value.status == 'ENTREGADO') {
                            var valueIcon = new L.Icon({
                                iconUrl: '{{ asset("libreries") }}/img/marker-icon-2x-green.png',
                                shadowUrl: '{{ asset("libreries") }}/img/marker-shadow.png',
                                iconSize: [25, 41],
                                iconAnchor: [12, 41],
                                popupAnchor: [1, -34],
                                shadowSize: [41, 41]
                            });
                        } else if (value.status == '' || value.status == null) {
                            var valueIcon = new L.Icon({
                                iconUrl: '{{ asset("libreries") }}/img/marker-icon-2x-red.png',
                                shadowUrl: '{{ asset("libreries") }}/img/marker-shadow.png',
                                iconSize: [25, 41],
                                iconAnchor: [12, 41],
                                popupAnchor: [1, -34],
                                shadowSize: [41, 41]
                            });
                        } else if (value.status == 'PENDIENTE-PRODUCTO') {
                            var valueIcon = new L.Icon({
                                iconUrl: '{{ asset("libreries") }}/img/marker-icon-2x-orange.png',
                                shadowUrl: '{{ asset("libreries") }}/img/marker-shadow.png',
                                iconSize: [25, 41],
                                iconAnchor: [12, 41],
                                popupAnchor: [1, -34],
                                shadowSize: [41, 41]
                            });
                        }

                        marker = new L.Marker(ubications, {
                            draggable: false,
                            icon: valueIcon
                        });

                        mymap.addLayer(marker);
                        nombre = value.nombre+" "+ value.primer_ap +" "+ value.segundo_ap;

                        if(value.status == '' || value.status == null ){
                            marker.bindPopup(
                            '<div style="text-align: center;"><i class="fas fa-home fa-6x"></i></div>' +
                            '<span class="my-div-span"><b>Nombre: </b>' +
                            nombre + '<br>' +
                            '<b>CI: </b>'+ value.ci +'<br>' +
                            '<b>Sindicato: </b>'+ value.sindicato + '<br>' +
                            '<b>Rubro: </b>'+value.nombre_rubro + '<br>' +
                            '<b>Tipo: </b>'+ value.tipo +'<br>' +
                            '<b>Estado:  PENDIENTE</b><br>' +
                            '</span>');
                        }else{
                            marker.bindPopup(
                            '<div style="text-align: center;"><i class="fas fa-home fa-6x"></i></div>' +
                            '<span class="my-div-span"><b>Nombre: </b>' +
                            nombre + '<br>' +
                            '<b>CI: </b>'+ value.ci +'<br>' +
                            '<b>Sindicato: </b>'+ value.sindicato + '<br>' +
                            '<b>Rubro: </b>'+value.nombre_rubro + '<br>' +
                            '<b>Tipo: </b>'+ value.tipo +'<br>' +
                            '<b>Fecha: </b>'+ value.fecha_entrega + '<br>' +
                            '<b>Estado:  '+value.status +'</b><br>' +
                            '</span>');
                        }
                       
                    });
                }
            }
        });


    });

    //end counter filter




});
//end map code




const config = {
    type: 'bar',
    data: {
        labels: [
            'Maica Sud',
            'Maica Chica',
            'Maica Arriba',
            'Maica central',
            'Maica Norte',
            'Maica Milenario',
            'Maica Kaspichaca',
            'Maica San Isidro',
            'Maica Quenamari',
            'Maica Bolivia'
        ],
        datasets: [{
            label: '# Entregas',
            data: [
                '{{ $data_count->maica_sud }}',
                '{{ $data_count->maica_chica }}',
                '{{ $data_count->maica_arriba }}',
                '{{ $data_count->maica_central }}',
                '{{ $data_count->maica_norte }}',
                '{{ $data_count->maica_milenario }}',
                '{{ $data_count->maica_kaspichaca }}',
                '{{ $data_count->maica_san_isidro }}',
                '{{ $data_count->maica_quenamari }}',
                '{{ $data_count->maica_bolivia }}',
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(171, 235, 198, 0.2)',
                'rgba(234, 237, 237, 0.2)',
                'rgba(212, 172, 13, 0.2)',
                'rgba(135, 54, 0, 0.2)',
                'rgba(255, 159, 64, 0.2)'

            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(171, 235, 198, 1)',
                'rgba(234, 237, 237, 1)',
                'rgba(212, 172, 13, 1)',
                'rgba(135, 54, 0, 1)',
                'rgba(255, 159, 64, 1)'

            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
}


setTimeout(
    function() {
        const reporte = new Chart($('#chart-show'), config);
    }, 1000);
</script>