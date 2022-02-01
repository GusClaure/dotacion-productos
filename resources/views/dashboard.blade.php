@extends('layouts.app', ['sitio' => 'das'])

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
        <div class="form-group col-md-12">
            <div class="row" style="margin-top: 10px;">
                <div class="col-sm-6">
                <h3 for="ausenciap1">SINDICATOS</h3>
            <select class="form-control col-sm-12" id="filter-sindicato" >
            <option selected disabled>Elija un Sindicato</option>
            @foreach ($sindicatos as $value)
            <option value="{{ $value->sindicato }}">{{ $value->sindicato }}</option>
            @endforeach
            </select>
                </div>
                <div class="col-sm-6">
                <h3 for="ausenciap1">TOTAL</h3>
            <select class="form-control col-sm-12" id="filter-count" disabled>
                <option selected disabled>Elija una opción</option>
                <option value="total">TOTAL</option>
                <option value="entregados">ENTREGADOS </option>
                <option value="pendientes">PENDIENTES</option>
            </select>
                </div>
            </div>
            
            <div id="map-productos-agropecuarios" class="col-sm-12" style="height: 402px; margin-top: 20px;"></div>
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

    let mymap = new L.Map('map-productos-agropecuarios', {
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
    mymap.setView([-17.39382474713952, -66.15696143763128], 18);
    //mymap.setView([-17.425460491975,-66.201554314586], 13);

    setTimeout(function() {
        mymap.invalidateSize();
    }, 1000);



    //counter filter select

    $('#filter-count').on('change', function() {

        $.ajax({
            type: "POST",
            url: "{{ route('personas.filter') }}",
            data: {
                _token: "{{ csrf_token() }}",
                criterio: $(this).val(),
                sindicato: $('#filter-sindicato').val()
            },
            success: function(data) {
                if (data.status == true) {

                    $(".leaflet-marker-icon").remove();
                    $(".leaflet-marker-shadow").remove();
                    $(".leaflet-popup").remove();
                    ubication = '';
                    $.each(data.response, function(index, value) {
                        if(value.ubicacion != 0){
                        ubication = value.ubicacion.split(',');
                        ubications = value.ubicacion.split(',');
                        
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
                            '<b>Estado:  SIN ENTREGAR</b><br>' +
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
                            '<b>Estado:  '+value.status +'</b><br>' +
                            '</span>');
                        }
                        }
                      
                    });
                    mymap.flyTo(ubication, 13, {
                                animate: true,
                                duration: 3
                            });
                }
            }
        });


    });

    //end counter filter

$('#filter-sindicato').on('change', function() {
    $('#filter-count').prop( "disabled", false );
    $.ajax({
            type: "POST",
            url: "{{ route('personas.filter') }}",
            data: {
                _token: "{{ csrf_token() }}",
                criterio: $('#filter-count').val(),
                sindicato: $(this).val()
            },
            success: function(data) {
                if (data.status == true) {

                    $(".leaflet-marker-icon").remove();
                    $(".leaflet-marker-shadow").remove();
                    $(".leaflet-popup").remove();
                    ubication = '';
                    $.each(data.response, function(index, value) {
                        if(value.ubicacion != 0){
                        ubication = value.ubicacion.split(',');
                        ubications = value.ubicacion.split(',');
                        
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
                            '<b>Estado:  SIN ENTREGAR</b><br>' +
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
                            '<b>Estado:  '+value.status +'</b><br>' +
                            '</span>');
                        }
                        }
                      
                    });
                    mymap.flyTo(ubication, 13, {
                                animate: true,
                                duration: 3
                            });
                }
            }
        });

});


});
//end map code




const config = {
    type: 'horizontalBar',
    data: {
        labels: [
            'Azirumarca',
            'Campesino Norte',
            'Maica',
            'Pucara Grande',
            'Valle Hermoso'
        ],
        datasets: [{
            label: '# Entregados',
            data: [
                '{{ $data_count->azirumarca }}',
                '{{ $data_count->campesino_norte }}',
                '{{ $data_count->maica }}',
                '{{ $data_count->pucara_grande }}',
                '{{ $data_count->valle_hermoso }}',
            ],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(75, 192, 192)',
                'rgb(255, 205, 86)',
                'rgb(201, 203, 207)',
                'rgb(54, 162, 235)'
            ]
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