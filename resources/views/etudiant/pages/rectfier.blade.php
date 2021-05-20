@extends('etudiant.master')

@section('title')
    <title>rectifier</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row shadow" style="overflow: hidden;">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-dark text-center">Vos demandes des rectifications: </h5>

        </div>
        <div class="row table-responsive" >
                <table class="table table-stripped table-hover w-auto table-bordered display" style=" min-width:100%;overflow: auto;">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Module</th>
                            <th scope="col">Element</th>
                            <th scope="col">Commentaire</th>
                            <th scope="col">Reponse</th>
                          </tr>
                    </thead>
                    <tbody id="content-rectifier" style="overflow: auto;">

                    </tbody>
                  </table>
        </div>

    </div>
    <div class=" m-5 card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-dark text-center">Poser des rectifications : </h5>
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
                            <div class="row">
                                <div class="col-sm-11 col-lg-5">
                                    <div class="custom-file m-3">
                                        <label for="module">Module</label>
                                        <select class="form-select" id="module">
                                            <option>Choisissez un module</option>
                                            @foreach ($modules as $module)
                                                <option value="{{ $module->id }}">{{ $module->nom}}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                </div>
                                <div class="col-sm-11 col-lg-6">
                                    <div class="custom-file m-3">
                                        <label for="profselect">Element de module</label>
                                        <select class="form-select" id="element" name="element" disabled>
                                            <option>Choisissez Element</option>

                                            </select>
                                    </div>

                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Comentaire</label>
                                    <textarea class="form-control" id="commentaire" rows="3"></textarea>
                                  </div>
                            </div>

                            <div class="form-row">
                                <button type="submit" id="btn" class="btn btn-success m-3">Ajouter</button>
                            </div>
                </div>


                </form>
            </div>
        </div>
    </div>
</div>












@endsection
@section('scripts')
    <script>
        let rectifier1 = "{{ route('etudiant.gestionrectfier') }}";

    </script>

    <script src="{{ asset('js/etudiant/rectifier.js') }}"></script>

@endsection
