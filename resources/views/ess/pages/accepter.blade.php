@extends('ess.master')

@section('title')
    <title>Demande</title>
@endsection

@section('content')


<div class="container-fluid">
    <div class="row shadow" style="overflow: hidden;">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-dark text-center">Demandes  acceptée par agent scolarite : </h5>
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
                            <th scope="col">Date de livraison</th>
                            <th scope="col">Date de accepter</th>
                            <th scope="col">Etat</th>
                            <th scope="col">Livree</th>
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
        let accepter1 = "{{ route('ess.accepter') }}";

    </script>
    <script src="{{ asset('js/ess/accepter.js') }}"></script>
@endsection

