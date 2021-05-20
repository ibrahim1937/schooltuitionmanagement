@extends('etudiant.master')

@section('title')
    <title>Profile</title>
@endsection

@section('content')

<div class="container">
    <div class="main-body">


          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <div class="content_img">
                        <img src="{{ file_exists(public_path().'/storage/images/'.Auth::user()->photo) ? asset('storage/images/'. Auth::user()->photo) : asset('storage/images/user.png') }}" alt="Admin" class="rounded-circle profile-photo" width="100%" height="100%">
                        <div><a data-bs-toggle="modal" data-bs-target="#imagemodal" style="text-decoration: none;"><i class="fas fa-camera"></i> Changer Photo</a></div>
                    </div>
                    <div class="mt-3">
                      <h4>{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</h4>
                      <p class="text-secondary mb-1">{{ $role->nom }}</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mt-3">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                      @foreach ($filiere as $f)
                        <h6 class="mb-0">Filiere</h6>
                        <span class="text-secondary">{{ $f->libelle }}</span>
                      @endforeach

                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    @foreach ($filiere as $f)
                    <h6 class="mb-0">Code</h6>
                    <span class="text-secondary">{{ $f->code }}</span>
                    @endforeach
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body formcontainer">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Nom</h6>
                    </div>
                    <div class="col-sm-9 text-secondary nomcontainer success-container">
                        <input type="text" name="nom" id="" class="inputprofile text-secondary" value="{{ Auth::user()->nom }}" disabled>
                        <div class="editcontainer">
                          <i class="fas fa-edit optionicons" ></i>
                        </div>
                        <div class="validatecontainer">
                          <i class="fas fa-check optionicons" style="display: none;"></i>
                        </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Prenom</h6>
                    </div>
                    <div class="col-sm-9 text-secondary prenomcontainer success-container">
                        <input type="text" name="prenom" id="" class="inputprofile text-secondary" value="{{ Auth::user()->prenom }}" disabled>
                      <div class="editcontainer">
                        <i class="fas fa-edit optionicons" ></i>
                      </div>
                      <div class="validatecontainer">
                        <i class="fas fa-check optionicons" style="display: none;"></i>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary emailcontainer success-container">
                      <input type="email" name="email" id="email" class="inputprofile text-secondary" value="{{ Auth::user()->email }}" disabled>
                      <div class="editcontainer">
                        <i class="fas fa-edit optionicons" ></i>
                      </div>
                      <div class="validatecontainer">
                        <i class="fas fa-check optionicons" style="display: none;"></i>
                      </div>

                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">CIN</h6>
                    </div>
                    <div class="col-sm-9 text-secondary cincontainer success-container">
                      <input type="text" name="cin" id="" class="inputprofile text-secondary" value="{{ Auth::user()->cin }}" disabled>
                      <div class="editcontainer">
                        <i class="fas fa-edit optionicons" ></i>
                      </div>
                      <div class="validatecontainer">
                        <i class="fas fa-check optionicons" style="display: none;"></i>
                      </div>

                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Role</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{ $role->nom }}
                    </div>
                  </div>
                  <hr>

                </div>
              </div>
              <div class="row gutters-sm">
                <div class="col-sm-12 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="d-flex align-items-center text-info mb-3">Changer Mot de passe</h6>

                      <form id="passwordform">
                          @csrf
                          <input type="hidden" name="op" value="password">
                          <div class="form-group oldpasswordcontainer">
                              <label for="oldpassword">Ancien mot de passe</label>
                              <input type="password" name="oldpassword" id="oldpassword" class="form-control">
                          </div>
                          <div class="form-group newpasswordcontainer">
                              <label for="newpassword">Nouveau mot de passe</label>
                              <input type="password" name="newpassword" id="newpassword" class="form-control">
                          </div>
                          <div class="form-group newpassword_confirmationcontainer">
                              <label for="newpassword_confirmation">Confirmer le nouveau mot de passe</label>
                              <input type="password" name="newpassword_confirmation" id="newpassword_confirmation" class="form-control">
                          </div>
                          <div class="form-group">
                              <button type="submit" class="btn btn-success" id="submitpassword">Changer</button>
                              <button type="reset" class="btn btn-success">Réinitialiser</button>
                          </div>
                      </form>
                      {{-- <small>Web Design</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Website Markup</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>One Page</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Mobile Template</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Backend API</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                      </div> --}}
                    </div>
                  </div>
                </div>
                {{-- <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">assignment</i>Project Status</h6>
                      <small>Web Design</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Website Markup</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>One Page</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Mobile Template</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Backend API</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
    </div>


  <!-- Modal -->
  <div class="modal fade" id="imagemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="op" value="image" hidden>
        <div class="modal-content">
            <div class="modal-header bg-info" style="color: white;">
            <h5 class="modal-title" id="exampleModalLabel">Uploader image</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-sm-11 m-2">
                        <input type="file" class="custom-file-input py-2" name="file" id="customFile">
                        <label class="custom-file-label" for="customFile">Choisissez une image</label>
                    </div>
                    <div class="col-sm-11 m-2">
                        <button type="submit" class="btn btn-primary m-1" style="float: right">Enregistrer</button>
                        <button type="reset" class="btn btn-info m-1" style="float: right">Réinitialiser</button>
                        <button type="button" class="btn btn-secondary m-1" data-bs-dismiss="modal" style="float: right">Close</button>

                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
  </div>


    <style>

.content_img{
 position: relative;
 width: 200px;
 height: 200px;
 float: left;
 margin-right: 10px;
 border-radius: 50%;
 overflow: hidden;
}

/* Child Text Container */
.content_img div{
 position: absolute;
 bottom: 0;
 right: 0;
 left: 0;
 align-items: center;
 justify-content: center;
 background: black;
 color: white;
 margin-bottom: 5px;
 font-family: sans-serif;
 opacity: 0;
 visibility: hidden;
 -webkit-transition: visibility 0s, opacity 0.5s linear;
 transition: visibility 0s, opacity 0.5s linear;
}

.content_img div a {
    font-size: 14px;
}

.optionicons {
    float: right;
    cursor: pointer;
}
.editcontainer .optionicons:hover {
    color: blue;
}
.validatecontainer .optionicons:hover {
    color: green;
}
.editcontainer, .validatecontainer {
    margin: 4px;
    padding: 4px;
    display: inline;
}

/* Hover on Parent Container */
.content_img:hover{
 cursor: pointer;
}

.content_img:hover div{
 width: 200px;
 padding: 10px 15px;
 visibility: visible;
text-align: center;
overflow: hidden;
 opacity: 0.7;
}
.inputprofile {
    width: 85%!important;
    position: relative;
}
    </style>


@endsection




@section('scripts')
<script>
    let profileurl =  "{{ route('etudiant.profile') }}";
</script>

<script src="{{ asset('js/etudiant/profile.js') }}"></script>

@endsection
