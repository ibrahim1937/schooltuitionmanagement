@extends('admin.master')

@section('title')
    <title>Gestion des professeurs</title>
@endsection

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class=" mb-2 text-gray-800 text-center">Gestion Professeurs</h1>

    <div class="row shadow formcontainer">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ajouter un Professeur :
            </h6>
        </div>
        
        <div class="row error-ajout">
            <div class="col col-sm-11 m-3 errorcontainer" style="position: relative;">

            </div>
            <div class="col-sm-11 col-lg-5">
                <div class="m-3 nomcontainer">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" placeholder="Nom..." id="nom">
                </div>
            </div>
            <div class="col-sm-11 col-lg-6">
                <div class="custom-file m-3">
                    <div class="prenomcontainer">
                        <label for="prenom">Prenom</label>
                        <input type="text" class="form-control" placeholder="Prenom..." id="prenom">
                    </div>
                </div>           
            </div>
        </div>
       
        <div class="row">
            <div class="col-sm-11 col-lg-5">
                <div class="custom-file m-3 emailcontainer">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" placeholder="Email" id="email">
                </div>
                            
            </div> 
            <div class="col-sm-11 col-lg-6">
                <div class="custom-file m-3 cincontainer">
                    <label for="cin">CIN</label>
                    <input type="text" class="form-control" placeholder="CIN" id="cin">
                </div>
                            
            </div> 
        </div>
        <div class="form-row m-3">
            <button type="button" id="submitprof" class="btn btn-success">Ajouter</button>
        </div>

    </div>
    <br><br>
    <div class="row shadow" style="overflow: hidden">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste Des Professeurs: </h6>
            <div class="row">
                <div class="col col-sm-11 col-lg-3">
                    <button class="btn btn-light menu-buttons " style="width:100%;" id="selectall">Selectionner Tout</button>
                </div>
                <div class="col col-sm-11 col-lg-2">
                    <button disabled="disabled" class="btn btn-danger menu-buttons " style="width:100%;" id="delete" data-bs-toggle="modal" data-bs-target="#deleteprof">Supprimer</button>
                </div> 
            </div>             
        </div>
        <div class="row table-responsive">
        
                <table class="table table-stripped table-hover table-bordered display w-auto mw-100" style="overflow: auto;">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">cin</th>
                        <th scope="col">Modifier</th>
                      </tr>
                    </thead>
                    <tbody id="content-prof" style="overflow: auto;">
                     
                    </tbody>
                </table>
            </div>
    </div>
    <br><br>
    <div class="row shadow" style="overflow: hidden;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste Des Éléments par professeur: </h6>
            <div class="row">
                <div class="col col-sm-11 col-lg-4">
                    <label for="profsearch">Chercher par professeur</label>
                    <select class="form-select menu-buttons" id="profsearch">
                        <option value="">Choisissez un Professeur</option>
                        @foreach ($professeurs as $professeur)
                        
                            <option value="{{ $professeur->id }}">{{ $professeur->nom  . ' ' . $professeur->prenom}}</option>
                        @endforeach
                    </select> 
                </div>
            </div>             
        </div>
        <div class="row table-responsive">
        
                <table class="table table-stripped table-hover table-bordered display w-auto mw-100" style="overflow: hidden;">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Code</th>
                        <th scope="col">Module</th>
                        <th scope="col">Professeur</th>
                      </tr>
                    </thead>
                    <tbody id="content-prof-search" style="overflow: hidden;">
                     
                    </tbody>
                </table>
            </div>
    </div>

      <!-- Modal de modifiaction-->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modifier Professeur</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" id="form-modifier">
            @csrf
            <div class="modal-body errorparent">
                <div class="form-row">
                    <div class="col-sm-11 nomcontainerm m-3">
                        <label for="nomm">Nom</label>
                        <input type="text" class="form-control" placeholder="Code" id="nomm">
                    </div>
                    <div class="col-sm-11 prenomcontainerm m-3">
                        <label for="prenomm">Prenom</label>
                        <input type="text" class="form-control " placeholder="Libelle" id="prenomm">
                    </div>
                    <div class="col-sm-11 cincontainerm m-3">
                        <label for="cinm">CIN</label>
                        <input type="text" class="form-control " placeholder="Libelle" id="cinm">
                    </div>
                    <div class="col-sm-11 emailcontainerm m-3">
                        <label for="emailm">Email</label>
                        <input type="email" class="form-control " placeholder="Libelle" id="emailm">
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
  <div class="modal fade" id="deleteprof" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background: red; color:white;">
          <h5 class="modal-title" id="exampleModalLabel">Supprimer un Agent</h5>
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
    let gestionprofurl =  "{{ route('admin.gestionprofesseur') }}";
</script>

<script src="{{ asset('js/admin/professeur.js') }}"></script>

@endsection