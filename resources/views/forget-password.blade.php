<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Forgot Password</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('fontawesome-free/css/all.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style3.css') }}">
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/boostrap.min.css') }}" rel="stylesheet">

</head>

<body>

        <div class="container">
            <div class="img">
                <img src="{{ asset('loginfiles/img/aa.jpg')}}">
            </div>
            <div class="login-content">
                <form class="user" action="{{ route('forgetpassword') }}" method="post" id="forgetform">
                    @csrf
                    {{-- <img src="{{ asset('loginfiles/img/avatar.svg')}}"> --}}
                    <h2 class="title">vous pouvez récupérer votre compte</h2>
                       <div class="input-div one">
                          <div class="i">
                                  <i class="fas fa-user"></i>
                          </div>
                          <div class="div">
                                  <h5>Email</h5>
                                  <input type="email" class="input" id="email" name="email">

                          </div>
                    </div>

                          @error('email')

                                <span class="text text-danger-center" style="display: inline;color:red;">
                                    {{ $message }}</span>

                         @enderror



                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Chercher
                    </button>
                    <a class="small" href="{{ route('loginpage') }}">Vous avez déjà un compte? s'identifier!</a>
                </form>
            </div>
        </div>

        <!-- Outer Row -->
        {{-- <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">
                                            Mot de passe oublié?</h1>
                                        <p class="mb-4">Entrez simplement votre adresse e-mail ci-dessous et nous vous enverrons un lien pour réinitialiser votre mot de passe!</p>
                                    </div>
                                    <form class="user" action="{{ route('forgetpassword') }}" method="post" id="forgetform">
                                        @csrf
                                        <div class="form-group emailcontainer">
                                            <input type="email" class="form-control form-control-user"
                                                id="email" aria-describedby="emailHelp"
                                                placeholder="Entrer votre E-mail address..." name="email">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Chercher
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('loginpage') }}">Vous avez déjà un compte? s'identifier!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div> --}}


    <script src="{{ asset('js/jquery-3.6.0.js') }}"></script>
  <script>
      var forgetpassword = "{{ route('forgetpassword') }}";
  </script>
  <script src="{{ asset('js/forgetpassword.js') }}"></script>
  <script type="text/javascript" src="{{ asset('loginfiles/js/main.js') }}"></script>

</body>

</html>
