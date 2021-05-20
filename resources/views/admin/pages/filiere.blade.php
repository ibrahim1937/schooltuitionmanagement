@extends('admin.master')

@section('title')
    <title>Gestion des filieres</title>
@endsection

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class=" mb-2 text-gray-800 text-center">Gestion Filieres</h1>

    <div class="row shadow">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Ajouter une Filiere :
            </h6>
        </div>
        
        <div class="row">
                
                <form id="add">
                    @if(Session::get('fail'))
                        <div class="alert alert-danger m-3 fail">{{ Session::get('fail') }}</div>
                    @elseif(Session::get('success'))
                        <div class="alert alert-success m-3 success">{{ Session::get('success') }}</div>
                    @endif
                    @csrf
                    <div class="form-row">
                        <div class="col-sm-11 col-lg-5 codecontainer">
                            <input type="text" class="form-control m-3" placeholder="Code" id="code" name="code">
                        </div>
                        <div class="col-sm-11 col-lg-6 libellecontainer">
                            <input type="text" class="form-control m-3" placeholder="Libelle" id="libelle" name="libelle">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <button type="submit" class="btn btn-success m-3">Ajouter</button>
                    </div>
                </form>
        </div>
        
    </div>
    <br><br>
    <div class="row shadow" style="overflow: hidden">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste Des Filieres: </h6>
            <button disabled="disabled" class="btn btn-danger menu-buttons " id="delete" data-bs-toggle="modal" data-bs-target="#deletefiliere">Supprimer</button>
            <button class="btn btn-light menu-buttons " id="selectall">Selectionner Tout</button>
        </div>
        <div class="row table-responsive">
                <table class="table table-stripped table-hover table-bordered display w-auto mw-100" style="overflow: auto;">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Code</th>
                        <th scope="col">Libelle</th>
                        <th scope="col">Modifier</th>
                      </tr>
                    </thead>
                    <tbody id="content-filiere" style="overflow: auto">
                     
                    </tbody>
                  </table>
        </div>
    </div>
  
  <!-- Modal de modifiaction-->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modifier Filiere</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" id="form-modifier">
            @csrf
            <div class="modal-body errorparent">
                <div class="form-row">
                    <div class="col-sm-11 codemcontainer">
                        <label for="codem">Code</label>
                        <input type="text" class="form-control m-3" placeholder="Code" id="codem" name="code">
                    </div>
                    <div class="col-sm-11 libellemcontainer">
                        <label for="libellem">Libelle</label>
                        <input type="text" class="form-control m-3" placeholder="Libelle" id="libellem" name="libelle">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" id="modifier" class="btn btn-success">Modifier</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Modal delete-->
  <div class="modal fade" id="deletefiliere" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background: red; color:white;">
          <h5 class="modal-title" id="exampleModalLabel">Supprimer une filiere</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body confirmtext">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="button" id="deletebutton" class="btn btn-danger">Supprimer</button>
        </div>
      </div>
    </div>
  </div>


</div>



@endsection



@section('scripts')
    <script>
        let gestionfiliereurl = "{{ route('admin.gestionfiliere') }}";

    </script>
    <script src="{{ asset('js/admin/filiere.js') }}"></script>
@endsection