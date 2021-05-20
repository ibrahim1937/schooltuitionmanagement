@extends('ese.master')

@section('title')
    <title>Demande</title>
@endsection

@section('content')

{{-- <div class="container-fluid">

    <!-- Page Heading -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class=" mb-2 text-gray-800">Bienvenue dans l'espace Agent</h1>
        <!-- DataTales Example -->
        <div class="row shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">les les nouveaux demandes: </h6>
            </div>
            <div class="row">
                    <table class="table table-stripped table-hover table-bordered display" style="position: relative; width:100%;">
                        <thead>
                          <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Demandes</th>
                            <th scope="col">Nom d'etdiant</th>
                            <th scope="col">Prenom d'etdiant</th>
                            <th scope="col">livreé on </th>
                            <th scope="col">Etats</th>
                          </tr>
                        </thead>
                        <tbody id="content-demande">

                        </tbody>
                      </table>
            </div>

        </div>

    </div>

</div> --}}
<div class="container-fluid">
    <div class="row shadow" style="overflow: hidden;">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-dark text-center">Demandes  livrées par agent scolarite : </h5>

        </div>
        <div class="row table-responsive" >
                <table class="table table-stripped table-hover w-auto table-bordered display" style=" min-width:100%;overflow: auto;">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Demandes</th>
                            <th scope="col">Nom d'etdiant</th>
                            <th scope="col">Prenom d'etdiant</th>
                            <th scope="col">livreé on </th>
                            <th scope="col">Etats</th>
                          </tr>
                    </thead>
                    <tbody id="content-demande" style="overflow: auto;">

                    </tbody>
                  </table>
        </div>
    </div>
</div>


@endsection
@section('scripts')
    <script>
        let livree2 = "{{ route('ese.eselivree') }}";

    </script>
    <script src="{{ asset('js/ese/livrer.js') }}"></script>
@endsection

