@extends('etudiant.master')

@section('title')
    <title>rectifier</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row shadow" style="overflow: hidden;">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-dark text-center">Vos demandes rectifications refusée : </h5>

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
</div>





@endsection
@section('scripts')
    <script>
        let refuserRectifier1 = "{{ route('etudiant.refuserRectifier1') }}";

    </script>

    <script src="{{ asset('js/etudiant/refuserRectifier.js') }}"></script>

@endsection
