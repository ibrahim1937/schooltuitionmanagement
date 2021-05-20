<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);
        
        $user = User::where('email','=',$request->email)->first();

        
        if($user){
            /* there is a user found in the database*/
            $credentials = $request->only('email', 'password');
            if(Auth::attempt($credentials)){
                Auth::login(User::find($user->id), true);
                $now = Carbon::now();
                Log::create([
                    'id_user' => $user->id,
                    'last_seen_at' => $now
                ]);
                if($user->role_id == 1){
                    return redirect()->route('admin.dashboard');
                } elseif($user->role_id == 5){
                    return redirect()->route('etudiant.dashboard');
                }
                elseif($user->role_id == 2){
                    return redirect()->route("prof.dashboard");
                }
                elseif($user->role_id == 3){
                    return redirect()->route('ess.dashboard');
                }
                elseif($user->role_id == 4){
                    return redirect()->route('ese.dashboard');
                }
            } else {
                return back()->with('fail',"Votre mot de passe n'est pas correcte");
            }
            
        } else {
            return back()->with('fail','On a pas trouver le compte');
        }



    }
}
