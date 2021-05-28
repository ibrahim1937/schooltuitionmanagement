<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style3.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link href="{{ asset('fontawesome-free/css/all.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    {{-- <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/boostrap.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="img">
			<img src="{{ asset('loginfiles/img/aa.jpg')}}">
		</div>
		<div class="login-content">
			<form action="{{ route('resetpassword') }}" method="post" id="resetform">
                @csrf
				<h2 class="title">Réinitialiser Votre mot de passe</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Nouveau mot de passe</h5>
           		   		<input type="password" id="newPass" name="password" class="input" name="email">

           		   </div>
                </div>


           		<div class="input-div pass">
           		   <div class="i">
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Confirmez le mot de passe</h5>
           		    	<input type="password" id="newPassConfirm" name="password_confirmation" class="input" name="password">

            	   </div>

            	</div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    changer le mot de passe
                </button>
                <div class="d-flex justify-content-between align-items-center m-3">

                    <u><a href="{{ route('loginpage') }}">S'identifier</a></u>

                </div>
            </form>
        </div>
    </div>



    <!--Section: Block Content-->
{{-- <section class="text-center">



    <div class="container">

        <div class="center-screen">
            <form action="{{ route('resetpassword') }}" class="shadow" method="post" id="resetform">
                @csrf

                <div class="form-group m-3">
                    <h4 class="text text-center text-primary">Réinitialiser Votre mot de passe</h4>
                </div>
                <div class="form-group m-3">
                    <input type="hidden" name="token" value="{{ $token }}">
                </div>
                <div class="form-group m-3 passwordcontainer">

                  <label data-error="wrong" data-success="right" for="newPass">Nouveau mot de passe</label>
                  <input type="password" id="newPass" class="form-control" name="password">

                </div>

                <div class="form-group m-3 passwordcontainerc">
                    <label data-error="wrong" data-success="right" for="newPassConfirm">Confirmez le mot de passe</label>
                  <input type="password" id="newPassConfirm" class="form-control" name="password_confirmation">

                </div>

                <button type="submit" class="btn btn-primary m-3">changer le mot de passe</button>

                <div class="d-flex justify-content-between align-items-center m-3">

                    <u><a href="{{ route('loginpage') }}">S'identifier</a></u>

                </div>
              </form>

        </div>


    </div>



  </section> --}}
  <!--Section: Block Content-->

  {{-- <style>
      .center-screen {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  min-height: 100vh;
}
.center-screen > form {
    width: 80%;
} --}}

  </style>
  <script src="{{ asset('js/jquery-3.6.0.js') }}"></script>
  <script>
      var resetpassword = "{{ route('resetpassword') }}";
  </script>
  <script src="{{ asset('js/resetpassword.js') }}"></script>
  <script src="{{ asset('js/jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('js/jquery.easing.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('loginfiles/js/main.js') }}"></script>
</body>
</html>
