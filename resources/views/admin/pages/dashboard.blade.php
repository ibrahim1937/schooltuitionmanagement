@extends('admin.master')


@section('title')

<title>Dashboard</title>

@endsection


@section('content')

    <div class="container-fluid">
        <div class="row">

            <!-- Nombre des Etudiants Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Etudiants</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 etudiantstats">{{ $countetudiant }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nombre des Professeurs Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Professeurs</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 professeurstats">{{ $countprofesseur }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Nombre des Agents de scolarité Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Agents de scolarité</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 agentexamenstats">{{ $countagentscolarite }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Nombre des Agents d'examen Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Agents d'examen</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 agentexamenstats">{{ $countagentexamen }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Etudiants par filieres :</h6>
                        
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="etudiantstats"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Modules par filieres :</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="modulestats"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>



@endsection



@section('scripts')
<script> 
   let gestionurl = "{{ route('admin.gestiondashboard') }}";
</script>
<script src="{{ asset('js/admin/dashboard.js') }}"></script>
@endsection