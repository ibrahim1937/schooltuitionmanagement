<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
    <!--Section: Block Content-->
<section class="text-center">

    

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
  
    
  
  </section>
  <!--Section: Block Content-->

  <style>
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
}
  </style>
  <script src="{{ asset('js/jquery-3.6.0.js') }}"></script>
  <script>
      var resetpassword = "{{ route('resetpassword') }}";
  </script>
  <script src="{{ asset('js/resetpassword.js') }}"></script>
</body>
</html>