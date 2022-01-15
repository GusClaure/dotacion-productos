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
                                    {{-- <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales" data-update='{"data":{"datasets":[{"data":[0, 20, 10, 30, 15, 40, 20, 60, 60]}]}}' data-prefix="$" data-suffix="en">
                                        <a href="#" class="nav-link py-2 px-3 active" data-toggle="tab">
                                            <span class="d-none d-md-block">Month</span>
                                            <span class="d-md-none">M</span>
                                        </a>
                                    </li> --}}
                                    {{-- <li class="nav-item" data-toggle="chart" data-target="#chart-sales" data-update='{"data":{"datasets":[{"data":[0, 20, 5, 25, 10, 30, 15, 40, 40]}]}}' data-prefix="$" data-suffix="k">
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





        
      
       

    
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush

<script>
  

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
            label: '# of Votes',
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
  function() 
  {
    const reporte = new Chart(document.getElementById('chart-show'), config);
  }, 1000);

 
  
   
</script>




