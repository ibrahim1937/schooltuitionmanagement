<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Hash;

class ResetPasswordController extends Controller
{
    public $rules = [
      'password' => 'required|string|min:6|confirmed',
      'password_confirmation' => 'required',
    ];

    public $messages =  [
        'password.required' => 'le champ mot de passe est requis',
        'password.min' => 'Le mot de passe doit comporter au moins 6 caractères.',
        'password_confirmation.required' => 'le champ mot de passe est requis',
        'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.'
    ];
    public function getPassword($token){
        return view('password-reset')->with('token', $token);
    }

    public function updatePassword(Request $request){

        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if($validator->fails()){
            
            return [
                'error' => $validator->messages()->get('*')
            ];
            
        } else {
            // validator passes

            // check if the token exists in the password_resets table

            $preset = PasswordReset::where('token', $request->token)->latest()->first();

            if($preset){

                // token exists
                $user = User::where('email', $preset->email)->first();
                if($user){
                    $user->update([
                        'password' => Hash::make($request->password)
                    ]);

                    $presetdelete = PasswordReset::find($preset->id)->delete();
                    
                    return [
                        'success' => 'Le mot de passe a était change avec succes'
                    ];
                } else {
                    return [
                        'fail' => 'L\'utilisateur introuvable'
                    ];
                }

            } else {
                return [
                    'tokenerror' => 'le lien fourni est invalide ou a expiré'
                ];
            }


        }
        
        
    }
}
