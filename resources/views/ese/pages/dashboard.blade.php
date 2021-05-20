@extends('ese.master')

@section('title')
    <title>Demande</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class=" mb-2 text-gray-800">Bienvenue dans l'espace service d'examen</h1>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                   Demandes</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $demande1 }}</div>
                            </div>
                            <div class="col-auto">
                                {{-- <i class="fas fa-list fa-2x text-gray-300"></i> --}}
                                <i class="fas fa-copy fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Demandes acceptée</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $demande2 }}</div>
                            </div>
                            <div class="col-auto">
                                {{-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> --}}
                                <i class="far fa-check-circle fa-2x text-gray-300"></i>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Demandes livrée</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $demande3 }}</div>
                            </div>
                            <div class="col-auto">
                                {{-- <i class="fas fa-list fa-2x text-gray-300"></i> --}}
                                <i class="fas fa-truck fa-2x text-gray-300"></i>

                                {{-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Demandes Refusée</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $demande4 }}</div>
                            </div>
                            <div class="col-auto">
                                {{-- <i class="fas fa-comments fa-2x text-gray-300"></i> --}}
                                <i class="fas fa-book-dead fa-2x text-gray-300"></i>
                                {{-- <i class="far fa-check-circle fa-2x text-gray-300"></i> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-xl-4 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Aperçu sur Demandes</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-5" >
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Les dernieres demandes scolaires en cours</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-stripped table-hover" style="position: relative; width:100%;">
                                <thead>
                                </thead>
                                <tbody id="content-table">

                                </tbody>
                              </table>
                        </div>
                        <div class="mt-4 text-center small">
                            <a target="_blank" rel="nofollow" href="{{ route('ese.demandes') }}">Voir plus →
                               </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>


@endsection
@section('scripts')
<script>
    let chart3 = "{{ route('ese.chart3') }}";

</script>
    <script src="{{ asset('js/charts/chart3.js') }}"></script>
@endsection

