@extends('admin.master')

@section('title')
    <title>Gestion des Etudiants</title>
@endsection

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class=" mb-2 text-gray-800 text-center">Liste des  Étudiants</h1>

    

    <div class="row shadow" style="overflow: hidden">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des filières: </h6>
            <div class="row">
                <div class="col col-sm-11 col-lg-3">
                    <select name="filiere" id="filiereselect" class="form-select m-1">
                        <option value="">Choisissez une filière</option>
                        @foreach ($filieres as $f)
                            <option value="{{ $f->id }}">{{ $f->code }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col col-sm-11 col-lg-3">
                    <button class="btn btn-light menu-buttons " style="width:100%;" id="selectall">Selectionner Tout</button>
                </div>
                <div class="col col-sm-11 col-lg-2">
                    <button disabled="disabled" class="btn btn-danger menu-buttons " style="width:100%;" id="delete" data-bs-toggle="modal" data-bs-target="#deleteetudiant">Supprimer</button>
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
                        <th scope="col">Cin</th>
                        <th scope="col">Email</th>
                        <th scope="col">Filiere</th>
                        <th scope="col">Modifier</th>
                      </tr>
                    </thead>
                    <tbody id="content-etudiant" style="overflow: auto;">
                     
                    </tbody>
                </table>
            </div>
    </div>
    <br><br>
    <div class="row" style="padding:0px;">

            <div class="card shadow">
                <div class="py-3 card-header">
                    <h3 class="m-0 font-weight-bold text-primary">Exporter les etudiants</h3>
                </div>
                
                    <form action="{{ route('admin.export') }}" method="get">
                        <div class="form-row">
                            <div class="col col-sm-11 m-3 filierecontainerexport">
                                <label for="filiere">Filiere</label>
                                    <select name="filiere" id="filiereselectexport" class="form-select">
                                        <option value="0">Tous les filieres</option>
                                        @foreach ($filieres as $f)
                                            <option value="{{ $f->id }}">{{ $f->code }}</option>
                                        @endforeach
                
                                    </select>
                                
                            </div>
                    </div>
                    
                        <div class="col col-sm-11 m-3">
                            <button type="submit" id="export" class="btn btn-primary">Exporter</a>
                        </div>
                    </form>
                

            </div>
            
            

        {{-- <div class="col col-sm-12">
            <div class="card shadow">
                <div class="py-3 card-header">
                    <h3 class="m-0 font-weight-bold text-primary">Ajouter des etudiants par filiere</h3>
                </div>
                    
                    <form id="importform">
                        @csrf
                        <div class="form-row">
                            <div class="col col-sm-11 m-3 mw-90 filierecontainerimport">
                                <label for="filiere">Filiere</label>
                                <select name="filiere" id="filiereselectimport" class="form-select">
                                    <option value="">Tous les filieres</option>
                                    @foreach ($filieres as $f)
                                        <option value="{{ $f->id }}">{{ $f->code }}</option>
                                    @endforeach
            
                                </select>
                                @if(session('errorimport'))
                                    <p>{{ session('errorimport')['filiere'][0]}}</p>
                                @endif

                            </div>
                            <div class="col col-sm-11 m-3 filecontainer">
                                <input type="file" @if(session('error'))class="custom-file-input is-invalid py-2"@else class="custom-file-input py-2"@endif  name="file" id="customFile">
                                <label class="custom-file-label" for="customFile">Choisissez un fichier excel</label>
                            </div>
                        </div>
                    
                    
                        <div class="col col-sm-11">
                            <button type="submit" id="import" class="btn btn-primary m-1">Importer</button>
                            <a href="{{ route('admin.exportsample') }}" class="btn btn-primary m-1">Exemplaire Excel</a>
                        </div>
                    </form>

            </div>
            
            
        </div> --}}
        
        <br>
    </div>


      <!-- Modal de modifiaction-->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modifier Etudiant</h5>
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
                    <div class="col-sm-11 filierecontainerm m-3">
                        
                    <label for="filierem">Filiere</label>
                    <select name="filiere" id="filierem" class="form-select">
                        <option value="">Choisissez une filiere</option>
                        @foreach ($filieres as $f)
                            <option value="{{ $f->id }}">{{ $f->code }}</option>
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
  <div class="modal fade" id="deleteetudiant" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    let gestionurl =  "{{ route('admin.gestionetudiantliste') }}";
    let exporturl = "{{ route('admin.export') }}";
    let importurl = "{{ route('admin.import') }}";
</script>

<script src="{{ asset('js/admin/etudiantlist.js') }}"></script>

@endsection