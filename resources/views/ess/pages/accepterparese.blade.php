@extends('ess.master')

@section('title')
    <title>Demande</title>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row shadow" style="overflow: hidden;">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-dark text-center">Demandes  acceptée par agent examans : </h5>
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
                            <th scope="col">Date d'acceptation</th>
                            <th scope="col">Etat</th>
                            <th scope="col">Date de livraison</th>
                          </tr>
                        </thead>
                        <tbody id="content-demande" style="overflow: auto;">

                        </tbody>
                      </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Date de livraison</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="form-modifier">
                <div class="modal-body errorparent">
                    <div class="form-row">
                            <label for="example-date-input" class="col-2 col-form-label">Date :</label>
                            <div class="col-10">
                              <input class="form-control" type="date" id="date">
                            </div>

                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="valider" class="btn btn-success">Valider</button>
                </div>
            </form>
          </div>
        </div>
      </div>


@endsection
@section('scripts')
    <script>
        let accepterparese1 = "{{ route('ess.accepterparese') }}";

    </script>
    <script src="{{ asset('js/ess/accepterparese.js') }}"></script>
@endsection

