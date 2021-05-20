<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Carbon\Carbon;
use Mail;

class ForgetPasswordController extends Controller
{

  public $rules = [
    'email' => 'required|email|exists:users',
  ];
  public $messages = [
    'email.required' => 'le champ email est requis',
    'email.email' => 'le champ doit contenir un valide e-mail adress',
    'email.exists' => 'Aucun compte trouvé avec l\'e-mail fourni'
  ];

  public $title = 'Réinitialiser votre mot de passe';
  public $body = 'nous vous envoyons cet e-mail car vous avez demandé une réinitialisation du mot de passe. cliquez sur le lien pour créer un nouveau mot de passe';


 public function postEmail(Request $request)
  {

    $validator = Validator::make($request->all(),$this->rules, $this->messages);
    if($validator->fails()){
        return [
          'error' => $validator->messages()->get('*')
        ];
    }

    $token = str_random(64);
    
     $preset = PasswordReset::create([
         'email' => $request->email,
         'token' => $token,
         'created_at' => Carbon::now()
     ]);

     // custume url to the reset password page
     $url = env('APP_URL').'reset-password/'.$token;

    $mailing = MailController::sendmail($this->title, $this->body, $url, $request->email);
    if($mailing){
      return [
        'success' => 'Nous vous avons envoyé un email pour réinitialiser votre mot de passe'
      ];
    } else {
      return [
        'failemail' => 'une erreur s\'est produite lors de l\'envoi de l\'e-mail'
      ];
    }
    
  }

}
