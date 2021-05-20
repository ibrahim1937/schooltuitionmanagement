@extends('admin.master')

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
              {{-- <div class="card mt-3">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Website</h6>
                    <span class="text-secondary">https://bootdey.com</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>Github</h6>
                    <span class="text-secondary">bootdey</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>Twitter</h6>
                    <span class="text-secondary">@bootdey</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram mr-2 icon-inline text-danger"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>Instagram</h6>
                    <span class="text-secondary">bootdey</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>Facebook</h6>
                    <span class="text-secondary">bootdey</span>
                  </li>
                </ul>
              </div> --}}
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
    let profileurl =  "{{ route('admin.profile') }}";
</script>

<script src="{{ asset('js/admin/profile.js') }}"></script>

@endsection