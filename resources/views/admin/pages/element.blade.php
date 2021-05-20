@extends('admin.master')

@section('title')
    <title>Gestion Eléments</title>
@endsection

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class=" mb-2 text-gray-800 text-center">Gestion Eléments de module</h1>

    <div class="row shadow ajoutcontainer">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Ajouter un element de module :
            </h6>
        </div>
        
        <div class="row error-ajout">
            <div class="col-sm-11 col-lg-5">
                <div class="m-3 nomcontainer">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" placeholder="Code" id="nom">
                </div>
            </div>
            <div class="col-sm-11 col-lg-6">
                <div class="custom-file m-3">
                    <label for="filiere">Filiere</label>  
                    <select class="form-select" id="filiere">
                        <option value="">Choisissez une filière</option>
                        @foreach ($filieres as $filiere)
                            <option value="{{ $filiere->id }}">{{ $filiere->code }}</option>
                        @endforeach
                    </select>
                </div>           
            </div>
        </div>
       
        <div class="row">
            <div class="col-sm-11 col-lg-5">
                <div class="custom-file m-3 modulecontainer">
                    <label for="module">Module</label>    
                    <select class="form-select" id="module" disabled>
                        <option value="">Choisissez un module</option>
                        @foreach ($modules as $module)
                            <option value="{{ $module->id }}">{{ $module->nom }}</option>
                        @endforeach
                    </select>
                </div>
                            
            </div>
            <div class="col-sm-11 col-lg-6">
                <div class="custom-file m-3  professeurcontainer">
                    <label for="profselect">Professeur</label>  
                    <select class="form-select" id="profselect">
                        <option>Choisissez un professeur</option>
                        @foreach ($professeurs as $professeur)
                            <option value="{{ $professeur->id }}">{{ $professeur->nom }} {{ $professeur->prenom }}</option>
                        @endforeach
                        </select>
                </div>
                            
            </div>  
        </div>
        <div class="form-row">
            <button type="button" id="submitelement" class="btn btn-success m-3">Ajouter</button>
        </div>
        
        
        
    </div>
    <br><br>
    <div class="row shadow" style="overflow: hidden;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste Des Elements: </h6>
            <div class="row">
                <div class="col col-sm-11 col-lg-3">
                    <label for="filieresearch">Chercher Par Filiere</label>
                </div>
                <div class="col col-sm-11 col-lg-3">
                    <label for="modulesearch">Chercher Par Module</label>
                </div>
            </div>
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
                    <select class="form-select menu-buttons" id="modulesearch" style="width: 100%;" disabled>
                        <option>Choisissez un module</option>
                    </select>
                </div>
                <div class="col col-sm-11 col-lg-3">
                    <button class="btn btn-light menu-buttons " style="width:100%;" id="selectall">Selectionner Tout</button>
                </div>
                <div class="col col-sm-11 col-lg-3">
                    <button disabled="disabled" class="btn btn-danger menu-buttons " style="width:100%;" id="delete" data-bs-toggle="modal" data-bs-target="#deleteelement">Supprimer</button>
                </div> 
            </div>             

        </div>
        <div class="row table-responsive">
                <table class="table table-stripped table-hover table-bordered display w-auto mw-100" style="overflow: auto;">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Element</th>
                        <th scope="col">Module</th>
                        <th scope="col">Filiere</th>
                        <th scope="col">Professeur</th>
                        <th scope="col">Modifier</th>
                      </tr>
                    </thead>
                    <tbody id="content-element" style="overflow: auto;">
                     
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
                <div class="form-row errormodifier">
                    <div class="col-sm-11 m-3 nommcontainer">
                        <label for="nomm">Element</label>
                        <input type="text" class="form-control" placeholder="Code d'element..." id="nomm">
                    </div>
                    <div class="col-sm-11 m-3">
                        <label for="libellem">Filiere</label>
                        <select class="form-control form-select" id="filierem">
                            <option value="">Choisissez une filiere</option>
                            @foreach ($filieres as $filiere)
                                <option value="{{ $filiere->id }}">{{ $filiere->code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-11 m-3 modulemcontainer">
                        <label for="libellem">Module</label>
                        <select class="form-control form-select" id="modulem">
                            <option value="">Choisissez un module</option>
                        </select>
                    </div>
                    <div class="col-sm-11 m-3 professeurmcontainer">
                        <label for="libellem">Professeur</label>
                        <select class="form-control form-select" id="professeurm">
                            <option value="">Choisissez un professeur</option>
                            @foreach ($professeurs as $professeur)
                                <option value="{{ $professeur->id }}">{{ $professeur->nom }} {{ $professeur->prenom }}</option>
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
  <div class="modal fade" id="deleteelement" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        let gestionelementurl = "{{ route('admin.gestionelement') }}";

    </script>

    <script src="{{ asset('js/admin/element.js') }}"></script>
    
@endsection