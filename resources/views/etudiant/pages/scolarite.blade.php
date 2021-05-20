@extends('etudiant.master')

@section('title')
    <title>Scolarite</title>
@endsection

@section('content')

    <!-- Page Heading -->
<div class="container-fluid">
        <div class="row shadow" style="overflow: hidden;">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-dark text-center">Vos demandes scolaire : </h5>

            </div>
            <div class="row table-responsive" >
                    <table class="table table-stripped table-hover w-auto table-bordered display" style=" min-width:100%;overflow: auto;">
                        <thead>
                          <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Demandes</th>
                            <th scope="col">Message</th>
                            <th scope="col">Livree on</th>
                          </tr>
                        </thead>
                        <tbody id="content-demande" style="overflow: auto;">

                        </tbody>
                      </table>
            </div>
        </div>
        <div class=" m-5 card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-dark text-center">Poser des demandes scolaires : </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form id="add">

                        <div class="row">

                           @if(Session::get('fail'))
                                    <div class="alert alert-danger m-3 fail">{{ Session::get('fail') }}</div>
                                @elseif(Session::get('success'))
                                    <div class="alert alert-success m-3 success">{{ Session::get('success') }}</div>
                                @endif
                                @csrf
                                <div class="form-row">
                                    <div class="custom-file m-3">
                                        <select class="form-control" id="demande" name="demande">
                                            <option>Choisissez Demande</option>
                                            @foreach ($categories as $categorie)
                                                <option value="{{ $categorie->id }}">{{ $categorie->nom_categorie }}</option>
                                            @endforeach
                                          </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <button type="submit" id="btn" class="btn btn-primary m-3">Ajouter</button>
                                </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>


@endsection

@section('scripts')
    <script>
        let gestionscolaritel = "{{ route('etudiant.gestionscolarite') }}";

    </script>
    <script src="{{ asset('js/etudiant/scolarite.js') }}"></script>
@endsection
