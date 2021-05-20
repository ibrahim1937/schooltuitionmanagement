@extends('admin.master')

@section('title')
    <title>Registres</title>
@endsection

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class=" mb-2 text-gray-800 text-center">Registre d'activités</h1>

    <div class="row shadow formcontainer">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtrer les registres :
            </h6>
        </div>

        <div class="form-row">
            <div class="col col-sm-11 m-3 rolecontainer">
                <label for="roleselect">Role</label>
                    <select name="role" id="roleselect" class="form-select">
                        <option value="">Choisissez un role</option>
                        @foreach ($roles as $r)
                            @php
                                if($r->id == 1){
                                    continue;
                                }
                            @endphp
                            <option value="{{ $r->id }}">{{ $r->nom }}</option>
                        @endforeach

                    </select>
                
            </div>
        </div>
        
        <!-- option for etudiant -->
        <div class="row etudiantoption" style="display: none;">
            <div class="col-sm-11 col-lg-5">
                <div class="m-3 filierecontainer">
                    <label for="filiereselect">Filière</label>
                    <select name="filiere" id="filiereselect" class="form-select">
                        <option value="">Choisissez une filière</option>
                        @foreach ($filieres as $f)
                            <option value="{{ $f->id }}">{{ $f->code }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="col-sm-11 col-lg-6">
                <div class="custom-file m-3">
                    <div class="prenomcontainer">
                        <label for="etudiantselect">Étudiant</label>
                        <select name="etudiant" id="etudiantselect" class="form-select">
                            <option value="">Choisissez un étudiant</option>
    
                        </select>
                    </div>
                </div>           
            </div>
        </div>
        <!-- option for professeur -->
        <div class="form-row professeuroption" style="display: none;">
            <div class="col-sm-11">
                <div class=" m-3 professeurcontainer">
                    <label for="professeurselect">Professeur</label>
                    <select name="professeur" id="professeurselect" class="form-select">
                        <option value="">Choisissez un Professeur</option>
                        @foreach ($professeurs as $p)
                            <option value="{{ $p->id }}">{{ $p->nom }} {{ $p->prenom }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
        </div>
        <!-- option for agent de scolarite -->
        <div class="form-row agentscolariteoption" style="display: none;">
            <div class="col-sm-11">
                <div class=" m-3 agentscolaritecontainer">
                    <label for="agentscolariteselect">Agent de scolarité</label>
                    <select name="agentscolarite" id="agentscolariteselect" class="form-select">
                        <option value="">Choisissez un Agent de scolarité</option>
                        @foreach ($agentscolarites as $as)
                            <option value="{{ $as->id }}">{{ $as->nom }} {{ $as->prenom }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
        </div>
        <!-- option for agent d'examen -->
        <div class="form-row agentexamenoption" style="display: none;">
            <div class="col-sm-11">
                <div class=" m-3 agentexamencontainer">
                    <label for="agentexamenselect">Agent d'examen</label>
                    <select name="agentexamen" id="agentexamenselect" class="form-select">
                        <option value="">Choisissez un Agent d'examen</option>
                        @foreach ($agentexamens as $ae)
                            <option value="{{ $ae->id }}">{{ $ae->nom }} {{ $ae->prenom }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
        </div>
       <!-- date manipulation -->
       <div class="row">
            <div class="col-sm-11 m-3">
                <h6 class="text-primary">Option de filtrage :</h6>
                <label for="datedepart">Un jour</label> &nbsp;
                <input type="radio" id="datedepart" name="dateoption" value="datedepart"><br>
                <label for="datedepartarrivee">Entre deux Dates</label> &nbsp;
                <input type="radio" id="datedepartarrivee" name="dateoption" value="datedepartarrivee"><br>
            </div>
       </div>
       <!-- date option un jour  -->
        <div class="row dateunjour" style="display: none;">
            <div class="col-sm-11">
                <div class="custom-file m-3 datecontainer">
                    <label for="date-only">Date</label>
                    <input type="date" class="form-control" id="date-only">
                </div>
                            
            </div> 
        </div>
        <div class="row betweendates" style="display: none;">
            <div class="col-sm-11 col-lg-6">
                <div class="custom-file m-3 startdatecontainer">
                    <label for="start-date">Date Debut</label>
                    <input type="datetime-local" class="form-control" id="start-date">
                </div>
                            
            </div> 
            <div class="col-sm-11 col-lg-5">
                <div class="custom-file m-3 enddatecontainer">
                    <label for="end-date">Date Fin</label>
                    <input type="datetime-local" class="form-control" id="end-date">
                </div>
                            
            </div> 
        </div>
        <div class="form-row m-3">
            <button type="button" id="searchlogs" class="btn btn-success m-1">Chercher</button>
            <button type="reset" id="reset" class="btn btn-info m-1">Reset</button>
        </div>

    </div>
    <br><br>
    <div class="row shadow" style="overflow: hidden">
        <div class="card-header py-3">
            <h6 class="m-2 font-weight-bold text-primary">Liste Des Registres: </h6>           
        </div>
        <div class="row table-responsive">
        
                <table class="table table-stripped table-hover table-bordered display w-auto mw-100" style="overflow: auto;">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Debut Session</th>
                        <th scope="col">Fin Session</th>
                        <th scope="col">Activité</th>
                      </tr>
                    </thead>
                    <tbody id="content-logs" style="overflow: auto;">
                     
                    </tbody>
                </table>
            </div>
    </div>




</div>



@endsection




@section('scripts')
<script>
    let logsurl =  "{{ route('admin.logs') }}";
</script>

<script src="{{ asset('js/admin/logs.js') }}"></script>

@endsection