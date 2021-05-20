@extends('admin.master')

@section('title')
    <title>Gestion des modules</title>
@endsection

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class=" mb-2 text-gray-800 text-center">Gestion Modules</h1>

    <div class="row shadow">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Ajouter un Module :
            </h6>
        </div>
        
        <div class="row error-ajout moduleajoutcontainer">
                    <div class="form-row">
                        <div class="col-sm-11 col-lg-5 codemodulecontainer m-3">
                            <input type="text" class="form-control" placeholder="Code" id="nom">
                        </div>
                        <div class="col-sm-11 col-lg-6">
                            <div class="custom-file m-3 filierecontainer">
                                <select class="form-control" id="filiere">
                                    <option>Choisissez Filière</option>
                                    @foreach ($filieres as $filiere)
                                        <option value="{{ $filiere->id }}">{{ $filiere->code }}</option>
                                    @endforeach
                                  </select>
                            </div>
                            
                        </div>
                        <button type="button" id="modulesubmit" class="btn btn-success m-3">Ajouter</button>
                    </div>
        </div>
        
    </div>
    <br><br>
    <div class="row shadow" style="overflow : hidden;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste Des Modules: </h6>
            <div class="row">
              <div class="col col-sm-11 col-lg-3">
                  <select class="form-select menu-buttons" id="filieresearch">
                      <option value="">Choisissez une filière</option>
                      @foreach ($filieres as $filiere)
                          <option value="{{ $filiere->id }}">{{ $filiere->code }}</option>
                      @endforeach
                  </select> 
              </div>
              <div class="col col-sm-11 col-lg-3">
                  <button class="btn btn-light menu-buttons " style="width:100%;" id="selectall">Selectionner Tout</button>
              </div>
              <div class="col col-sm-11 col-lg-3">
                  <button disabled="disabled" class="btn btn-danger menu-buttons " style="width:100%;" id="delete" data-bs-toggle="modal" data-bs-target="#deletemodule">Supprimer</button>
              </div> 
          </div>  
        </div>
        <div class="row table-responsive">
            <table class="table table-stripped table-hover table-bordered display w-auto mw-100" style="overflow: auto;">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Code Filiere</th>
                        <th scope="col">Modifier</th>
                      </tr>
                    </thead>
                    <tbody id="content-module" style="overflow: auto;">
                     
                    </tbody>
              </table>
            </div>
    </div>
  
  <!-- Modal de modifiaction-->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modifier Module</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" id="form-modifier">
            <div class="modal-body errorparent">
                <div class="form-row">
                    <div class="col-sm-11 nommcontainer">
                        <label for="nomm">Code Module</label>
                        <input type="text" class="form-control m-3" placeholder="Code" id="nomm">
                    </div>
                    <div class="col-sm-11 filieremcontainer">
                        <label for="filierem">Filière</label>
                        <select class="form-control form-select m-3" id="filierem">
                            <option>Choisissez Filière</option>
                            @foreach ($filieres as $filiere)
                                <option value="{{ $filiere->id }}">{{ $filiere->code }}</option>
                            @endforeach
                        </select>
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
  <div class="modal fade" id="deletemodule" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background: red; color:white;">
          <h5 class="modal-title" id="exampleModalLabel">Supprimer un module</h5>
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
        let gestionmoduleurl = "{{ route('admin.gestionmodule') }}";

    </script>
    <script src="{{ asset('js/admin/module.js') }}"></script>
@endsection