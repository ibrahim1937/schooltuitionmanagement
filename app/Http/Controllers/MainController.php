<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Log;
use App\Models\Role;
use App\Models\Admin;
use App\Models\Professeur;
use App\Models\AgentExamen;
use App\Models\AgentScolarite;
use Carbon\Carbon;

class MainController extends Controller
{
    public function loginindex(){
        return view('login');
    }
    public function registerindex(){
        return view('register')->with('roles', Role::all());
    }
    public function register(Request $request){


        $request->validate([
            'prenom' => 'required',
            'nom' => 'required',
            'email' => 'required|email|unique:users',
            'roles' => 'required',
            'password' => 'required|min:5',
            'password2' => 'required|min:5', 
        ]);

        

        if($request->password == $request->password2){

            $newUser = new User;
            $newUser->nom = $request->nom;
            $newUser->prenom = $request->prenom;
            $newUser->email = $request->email;
            $newUser->role_id = $request->roles;
            $newUser->password = Hash::make($request->password);

            $newUser->save();

            

            

            if($newUser){
                $role_id = $request->roles;
                if($role_id == 1){
                    $e = new Admin;
                    $e->id_user = $newUser->id;
                    $e->save();
                }
                elseif($role_id == 2){
                    $e = new Professeur;
                    $e->id_user = $newUser->id;
                    $e->save();
                }
                elseif($role_id == 3){
                    $e = new AgentScolarite;
                    $e->id_user = $newUser->id;
                    $e->save();
                }
                elseif($role_id == 4){
                    $e = new AgentExamen;
                    $e->id_user = $newUser->id;
                    $e->save();
                }
                return back()->with('success', 'The  user is registered successfully');
            } else {
                return back()->with('fail', 'Error occured');
            }

        }
        
        
    }
    public function logout(Request $request){
        if(Auth::check()){


            $now = Carbon::now();
            $log = Log::where('id_user' , Auth::user()->id )->latest('last_seen_at')->first();
            $log->update([
                'end_session_at' => $now->format('Y-m-d H:i:s')
            ]);

            Auth::logout();

            return redirect('/');
        }
    }
    public function routing()
    {
        if(Auth::user()->role_id == 1){
            return redirect()->route('admin.dashboard');
        }
        elseif(Auth::user()->role_id == 2){
            return redirect()->route('prof.dashboard');
        }
        elseif(Auth::user()->role_id == 3){
            return redirect()->route('ess.dashboard');
        }
        elseif(Auth::user()->role_id == 4){
            return redirect()->route('ese.dashboard');
        }
        elseif(Auth::user()->role_id == 5){
            return redirect()->route('etudiant.dashboard');
        }
    }
}
