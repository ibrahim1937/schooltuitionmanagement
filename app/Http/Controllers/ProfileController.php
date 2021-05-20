<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\Role;
use Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $imagerules = [
        'file' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
    ];
    private $imagemessages = [
        'file.required' => 'L\'image est requise',
        'file.max' => 'L\'image a dépasser la taille maximal',
        'file.mimes' => 'L\'image doit avoir comme extension : jpeg,jpg,png,gif'
    ];

    private $passwordrules = [
        'oldpassword' => 'required',
        'newpassword' => 'required|min:6',
        'newpassword_confirmation' => 'required|min:6|same:newpassword'
    ];
    private $passwordmessages = [
        'oldpassword.required' => 'l\ancien mot de passe est requis',
        'newpassword.required' => 'le champ de mot de passe est requis',
        'newpassword.min' => 'le mot de passe doit contenir au moins 6 caractères',
        'newpassword_confirmation.min' => 'le mot de passe doit contenir au moins 6 caractères',
        'newpassword_confirmation.same' => 'le mot de passe fourni n\'est pas identique au mot de passe entrée',
        'newpassword_confirmation.required' => 'le champ de mot de passe est requis',
    ];
    private $nomrule = [
        'nom' => 'required'
    ];
    private $prenomrule = [
        'prenom' => 'required'
    ];
    // private $emailrule = [
    //     'email' => 'required|email|unique:users,email,'.Auth::user()->id
    // ];
    // private $cinrule = [
    //     'cin' => 'required|unique:users,cin,'.Auth::user()->id
    // ];

    private $nommessages = [
        'nom.required' => 'le champ nom est requis'
    ];
    private $prenomessages = [
        'prenom.required' => 'le champ prenom est requis'
    ];
    private $emailmessages = [
        'email.required' => 'le champ email est requis',
        'email.unique' => 'il existe deja un compte associe à l\'email fourni',
        'email.email' => 'Veuillez saisir un correcte email'
    ];
    private $cinmessages = [
        'cin.required' => 'le champ cin est requis',
        'cin.unique' => 'il existe deja un compte associe au cin fourni'
    ];

    public function adminProfile(){
        return view('admin.pages.profile')->with([
            'role' => Role::find(Auth::user()->role_id)
        ]);
    }



    public function etudiantProfile(){
        return view('etudiant.pages.profile')->with([
            'role' => Role::find(Auth::user()->role_id),
            'filiere' => $this->filiereprofile()
        ]);
    }
    public function profProfile(){
        return view('prof.pages.profile')->with([
            'role' => Role::find(Auth::user()->role_id)
        ]);
    }
    public function essProfile(){
        return view('ess.pages.profile')->with([
            'role' => Role::find(Auth::user()->role_id)
        ]);
    }
    public function eseProfile(){
        return view('ese.pages.profile')->with([
            'role' => Role::find(Auth::user()->role_id)
        ]);
    }



    public function gestionAdminProfile(Request $request){
        if($request->ajax()){
            if($request->op == "password"){
                $validator = Validator::make($request->all() , $this->passwordrules, $this->passwordmessages);
                if($validator->fails()){
                    return [
                        'error' => $validator->messages()->get('*')
                    ];
                }else {
                    $user = User::find(Auth::user()->id);
                    if(Hash::check($request->oldpassword, $user->password)){
                        $user->update([
                            'password' => Hash::make($request->newpassword)
                        ]);
                        return [
                            'success' => 'votre mot de passe à été changé avec succès'
                        ];
                    } else {
                        return [
                            'error' => [
                                'oldpassword' => 'le mot de passe est incorrecte'
                            ]
                        ];
                    }
                }
            } else if ($request->op == "modifier"){

                if($request->nom){
                    $validator = Validator::make($request->all(), $this->nomrule, $this->nommessages);
                    $champ = "nom";
                }
                else if($request->prenom){
                    $validator = Validator::make($request->all(), $this->prenomrule, $this->prenomessages);
                    $champ = "prenom";
                }
                else if(property_exists((object) $request->all(), 'nom')){
                    $validator = Validator::make($request->all(), $this->nomrule, $this->nommessages);
                    $champ = "nom";
                }
                else if(property_exists((object) $request->all(), 'prenom')){
                    $validator = Validator::make($request->all(), $this->prenomrule, $this->prenomessages);
                    $champ = "prenom";
                }
                else if($request->email){
                    $validator = Validator::make($request->all(), [
                            'email' => 'required|email|unique:users,email,'.Auth::user()->id
                    ], $this->emailmessages);
                    $champ = "email";
                }
                else if($request->cin){
                    $validator = Validator::make($request->all(), [
                        'cin' => 'required|unique:users,cin,'.Auth::user()->id
                    ], $this->cinmessages);
                    $champ = "cin";
                }

                // checking the validator

                if($validator->fails()){
                    return [
                        'error' => $validator->messages()->get('*')
                    ];
                } else {
                    $user = User::find(Auth::user()->id)->update($request->except('op','_token'));
                    return [
                        'success' => 'le champ '.$champ.' est mis à jour'
                    ];
                }
            }

        } elseif($request->op == "image"){
                // image request
                $validator = Validator::make($request->all(), $this->imagerules, $this->imagemessages);
                if($validator->fails()){
                    dd($validator->messages()->get('*'));
                } else {
                    $imageName = time().'.'.$request->file->extension();
                    $request->file->move(public_path('storage/images'), $imageName);
                    User::find(Auth::user()->id)->update([
                        'photo' => $imageName
                    ]);
                    return back()
                            ->with('imagesuccess','You have successfully upload image.');
                }
        }

    }
    public function gestionEtudiantProfile(Request $request){
        if($request->ajax()){
            if($request->op == "password"){
                $validator = Validator::make($request->all() , $this->passwordrules, $this->passwordmessages);
                if($validator->fails()){
                    return [
                        'error' => $validator->messages()->get('*')
                    ];
                }else {
                    $user = User::find(Auth::user()->id);
                    if(Hash::check($request->oldpassword, $user->password)){
                        $user->update([
                            'password' => Hash::make($request->newpassword)
                        ]);
                        return [
                            'success' => 'votre mot de passe à été changé avec succès'
                        ];
                    } else {
                        return [
                            'error' => [
                                'oldpassword' => 'le mot de passe est incorrecte'
                            ]
                        ];
                    }
                }
            } else if ($request->op == "modifier"){

                if($request->nom){
                    $validator = Validator::make($request->all(), $this->nomrule, $this->nommessages);
                    $champ = "nom";
                }
                else if($request->prenom){
                    $validator = Validator::make($request->all(), $this->prenomrule, $this->prenomessages);
                    $champ = "prenom";
                }
                else if(property_exists((object) $request->all(), 'nom')){
                    $validator = Validator::make($request->all(), $this->nomrule, $this->nommessages);
                    $champ = "nom";
                }
                else if(property_exists((object) $request->all(), 'prenom')){
                    $validator = Validator::make($request->all(), $this->prenomrule, $this->prenomessages);
                    $champ = "prenom";
                }
                else if($request->email){
                    $validator = Validator::make($request->all(), [
                            'email' => 'required|email|unique:users,email,'.Auth::user()->id
                    ], $this->emailmessages);
                    $champ = "email";
                }
                else if($request->cin){
                    $validator = Validator::make($request->all(), [
                        'cin' => 'required|unique:users,cin,'.Auth::user()->id
                    ], $this->cinmessages);
                    $champ = "cin";
                }

                // checking the validator

                if($validator->fails()){
                    return [
                        'error' => $validator->messages()->get('*')
                    ];
                } else {
                    $user = User::find(Auth::user()->id)->update($request->except('op','_token'));
                    return [
                        'success' => 'le champ '.$champ.' est mis à jour'
                    ];
                }
            }

        } elseif($request->op == "image"){
                // image request
                $validator = Validator::make($request->all(), $this->imagerules, $this->imagemessages);
                if($validator->fails()){
                    dd($validator->messages()->get('*'));
                } else {
                    $imageName = time().'.'.$request->file->extension();
                    $request->file->move(public_path('storage/images'), $imageName);
                    User::find(Auth::user()->id)->update([
                        'photo' => $imageName
                    ]);
                    return back()
                            ->with('imagesuccess','You have successfully upload image.');
                }
        }

    }
    public function gestionprofProfile(Request $request){
        if($request->ajax()){
            if($request->op == "password"){
                $validator = Validator::make($request->all() , $this->passwordrules, $this->passwordmessages);
                if($validator->fails()){
                    return [
                        'error' => $validator->messages()->get('*')
                    ];
                }else {
                    $user = User::find(Auth::user()->id);
                    if(Hash::check($request->oldpassword, $user->password)){
                        $user->update([
                            'password' => Hash::make($request->newpassword)
                        ]);
                        return [
                            'success' => 'votre mot de passe à été changé avec succès'
                        ];
                    } else {
                        return [
                            'error' => [
                                'oldpassword' => 'le mot de passe est incorrecte'
                            ]
                        ];
                    }
                }
            } else if ($request->op == "modifier"){

                if($request->nom){
                    $validator = Validator::make($request->all(), $this->nomrule, $this->nommessages);
                    $champ = "nom";
                }
                else if($request->prenom){
                    $validator = Validator::make($request->all(), $this->prenomrule, $this->prenomessages);
                    $champ = "prenom";
                }
                else if(property_exists((object) $request->all(), 'nom')){
                    $validator = Validator::make($request->all(), $this->nomrule, $this->nommessages);
                    $champ = "nom";
                }
                else if(property_exists((object) $request->all(), 'prenom')){
                    $validator = Validator::make($request->all(), $this->prenomrule, $this->prenomessages);
                    $champ = "prenom";
                }
                else if($request->email){
                    $validator = Validator::make($request->all(), [
                            'email' => 'required|email|unique:users,email,'.Auth::user()->id
                    ], $this->emailmessages);
                    $champ = "email";
                }
                else if($request->cin){
                    $validator = Validator::make($request->all(), [
                        'cin' => 'required|unique:users,cin,'.Auth::user()->id
                    ], $this->cinmessages);
                    $champ = "cin";
                }

                // checking the validator

                if($validator->fails()){
                    return [
                        'error' => $validator->messages()->get('*')
                    ];
                } else {
                    $user = User::find(Auth::user()->id)->update($request->except('op','_token'));
                    return [
                        'success' => 'le champ '.$champ.' est mis à jour'
                    ];
                }
            }

        } elseif($request->op == "image"){
                // image request
                $validator = Validator::make($request->all(), $this->imagerules, $this->imagemessages);
                if($validator->fails()){
                    dd($validator->messages()->get('*'));
                } else {
                    $imageName = time().'.'.$request->file->extension();
                    $request->file->move(public_path('storage/images'), $imageName);
                    User::find(Auth::user()->id)->update([
                        'photo' => $imageName
                    ]);
                    return back()
                            ->with('imagesuccess','You have successfully upload image.');
                }
        }

    }
    public function gestionessProfile(Request $request){
        if($request->ajax()){
            if($request->op == "password"){
                $validator = Validator::make($request->all() , $this->passwordrules, $this->passwordmessages);
                if($validator->fails()){
                    return [
                        'error' => $validator->messages()->get('*')
                    ];
                }else {
                    $user = User::find(Auth::user()->id);
                    if(Hash::check($request->oldpassword, $user->password)){
                        $user->update([
                            'password' => Hash::make($request->newpassword)
                        ]);
                        return [
                            'success' => 'votre mot de passe à été changé avec succès'
                        ];
                    } else {
                        return [
                            'error' => [
                                'oldpassword' => 'le mot de passe est incorrecte'
                            ]
                        ];
                    }
                }
            } else if ($request->op == "modifier"){

                if($request->nom){
                    $validator = Validator::make($request->all(), $this->nomrule, $this->nommessages);
                    $champ = "nom";
                }
                else if($request->prenom){
                    $validator = Validator::make($request->all(), $this->prenomrule, $this->prenomessages);
                    $champ = "prenom";
                }
                else if(property_exists((object) $request->all(), 'nom')){
                    $validator = Validator::make($request->all(), $this->nomrule, $this->nommessages);
                    $champ = "nom";
                }
                else if(property_exists((object) $request->all(), 'prenom')){
                    $validator = Validator::make($request->all(), $this->prenomrule, $this->prenomessages);
                    $champ = "prenom";
                }
                else if($request->email){
                    $validator = Validator::make($request->all(), [
                            'email' => 'required|email|unique:users,email,'.Auth::user()->id
                    ], $this->emailmessages);
                    $champ = "email";
                }
                else if($request->cin){
                    $validator = Validator::make($request->all(), [
                        'cin' => 'required|unique:users,cin,'.Auth::user()->id
                    ], $this->cinmessages);
                    $champ = "cin";
                }

                // checking the validator

                if($validator->fails()){
                    return [
                        'error' => $validator->messages()->get('*')
                    ];
                } else {
                    $user = User::find(Auth::user()->id)->update($request->except('op','_token'));
                    return [
                        'success' => 'le champ '.$champ.' est mis à jour'
                    ];
                }
            }

        } elseif($request->op == "image"){
                // image request
                $validator = Validator::make($request->all(), $this->imagerules, $this->imagemessages);
                if($validator->fails()){
                    dd($validator->messages()->get('*'));
                } else {
                    $imageName = time().'.'.$request->file->extension();
                    $request->file->move(public_path('storage/images'), $imageName);
                    User::find(Auth::user()->id)->update([
                        'photo' => $imageName
                    ]);
                    return back()
                            ->with('imagesuccess','You have successfully upload image.');
                }
        }

    }
    public function gestioneseProfile(Request $request){
        if($request->ajax()){
            if($request->op == "password"){
                $validator = Validator::make($request->all() , $this->passwordrules, $this->passwordmessages);
                if($validator->fails()){
                    return [
                        'error' => $validator->messages()->get('*')
                    ];
                }else {
                    $user = User::find(Auth::user()->id);
                    if(Hash::check($request->oldpassword, $user->password)){
                        $user->update([
                            'password' => Hash::make($request->newpassword)
                        ]);
                        return [
                            'success' => 'votre mot de passe à été changé avec succès'
                        ];
                    } else {
                        return [
                            'error' => [
                                'oldpassword' => 'le mot de passe est incorrecte'
                            ]
                        ];
                    }
                }
            } else if ($request->op == "modifier"){

                if($request->nom){
                    $validator = Validator::make($request->all(), $this->nomrule, $this->nommessages);
                    $champ = "nom";
                }
                else if($request->prenom){
                    $validator = Validator::make($request->all(), $this->prenomrule, $this->prenomessages);
                    $champ = "prenom";
                }
                else if(property_exists((object) $request->all(), 'nom')){
                    $validator = Validator::make($request->all(), $this->nomrule, $this->nommessages);
                    $champ = "nom";
                }
                else if(property_exists((object) $request->all(), 'prenom')){
                    $validator = Validator::make($request->all(), $this->prenomrule, $this->prenomessages);
                    $champ = "prenom";
                }
                else if($request->email){
                    $validator = Validator::make($request->all(), [
                            'email' => 'required|email|unique:users,email,'.Auth::user()->id
                    ], $this->emailmessages);
                    $champ = "email";
                }
                else if($request->cin){
                    $validator = Validator::make($request->all(), [
                        'cin' => 'required|unique:users,cin,'.Auth::user()->id
                    ], $this->cinmessages);
                    $champ = "cin";
                }

                // checking the validator

                if($validator->fails()){
                    return [
                        'error' => $validator->messages()->get('*')
                    ];
                } else {
                    $user = User::find(Auth::user()->id)->update($request->except('op','_token'));
                    return [
                        'success' => 'le champ '.$champ.' est mis à jour'
                    ];
                }
            }

        } elseif($request->op == "image"){
                // image request
                $validator = Validator::make($request->all(), $this->imagerules, $this->imagemessages);
                if($validator->fails()){
                    dd($validator->messages()->get('*'));
                } else {
                    $imageName = time().'.'.$request->file->extension();
                    $request->file->move(public_path('storage/images'), $imageName);
                    User::find(Auth::user()->id)->update([
                        'photo' => $imageName
                    ]);
                    return back()
                            ->with('imagesuccess','You have successfully upload image.');
                }
        }

    }
    public function filiereprofile(){
        $user=Auth::user()->id;
        $etudiant = Etudiant::where('id_user', $user)->get();
        $filiere =Filiere::where('id', $etudiant[0]->id_filiere)->get();
        return $filiere;

    }

}