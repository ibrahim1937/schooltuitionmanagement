@extends('admin.master')

@section('title')
    <title>Gestion des agent de scolarités</title>
@endsection

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class=" mb-2 text-gray-800 text-center">Gestion Agent de Scolarité</h1>

    <div class="row shadow formcontainer">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ajouter un Agent de Scolarité :
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
            <button type="button" id="submitagent" class="btn btn-success">Ajouter</button>
        </div>

    </div>
    <br><br>
    <div class="row shadow" style="overflow: hidden;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste Des Agents de scolarité: </h6>
            <div class="row">
                <div class="col col-sm-11 col-lg-3">
                    <button class="btn btn-light menu-buttons " style="width:100%;" id="selectall">Selectionner Tout</button>
                </div>
                <div class="col col-sm-11 col-lg-2">
                    <button disabled="disabled" class="btn btn-danger menu-buttons " style="width:100%;" id="delete" data-bs-toggle="modal" data-bs-target="#deleteagents">Supprimer</button>
                </div> 
            </div>             
        </div>
        <div class="row table-responsive">
        
                <table class="table table-stripped table-hover table-bordered display" style="overflow: auto;">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">cin</th>
                        <th scope="col">Modifier</th>
                      </tr>
                    </thead>
                    <tbody id="content-agents" style="overflow: auto;">
                     
                    </tbody>
                </table>
            </div>
    </div>

      <!-- Modal de modifiaction-->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modifier Agent de scolarité</h5>
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
  <div class="modal fade" id="deleteagents" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    let gestionurl =  "{{ route('admin.gestionagentscolarite') }}";
</script>

<script src="{{ asset('js/admin/agentscolarite.js') }}"></script>

@endsection