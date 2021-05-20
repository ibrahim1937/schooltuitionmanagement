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
                            <th scope="col">Accepter</th>
                            <th scope="col">Refuser</th>

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
            <h5 class="m-0 font-weight-bold text-dark text-center">Demandes  envoyées par les étudiant : </h5>
            <form id="add">

                <div class="row">

                   @if(Session::get('fail'))
                            <div class="alert alert-danger m-3 fail">{{ Session::get('fail') }}</div>
                        @elseif(Session::get('success'))
                            <div class="alert alert-success m-3 success">{{ Session::get('success') }}</div>
                        @endif
                        @csrf
                </div>

            </form>

        </div>
        <div class="row table-responsive" >
                <table class="table table-stripped table-hover w-auto table-bordered display" style=" min-width:100%;overflow: auto;">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Demandes</th>
                            <th scope="col">Nom d'etdiant</th>
                            <th scope="col">Prenom d'etdiant</th>
                            <th scope="col">Accepter</th>
                            <th scope="col">Refuser</th>

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
        let demande1 = "{{ route('ese.demandes') }}";

    </script>
    <script src="{{ asset('js/ese/demande.js') }}"></script>
@endsection

