<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\Filiere;
use App\Models\Module;
use App\Models\Role;
use App\Models\Log;
use App\Models\Etudiant;
use App\Models\User;
use App\Models\Element;
use App\Models\Professeur;
use App\Models\AgentScolarite;
use App\Models\AgentExamen;
use App\Helpers\AdminHelper;
use App\Helpers\AdminDashboardHelper;
use Illuminate\Support\Arr;
use Excel;
use App\Exports\EtudiantExport;
use App\Exports\EtudiantAllExport;
use App\Imports\EtudiantAllImport;
use App\Exports\Etudiantsample;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;

class AdminController extends Controller
{
    public function module(){
        return view('admin.pages.module')->with('filieres', Filiere::all());
    }
    public function dashboard(){
        return view('admin.pages.dashboard')->with([
            'countetudiant' => Etudiant::count(),
            'countprofesseur' => Professeur::count(),
            'countagentscolarite' => AgentScolarite::count(),
            'countagentexamen' => AgentExamen::count()
        ]);
    }

    public function etudiant(){
        return view('admin.pages.etudiant')->with('filieres', Filiere::all());
    }
    public function etudiantliste(){
        return view('admin.pages.etudiantliste')->with('filieres', Filiere::all());
    }
    public function professeur(){
        return view('admin.pages.professeur')->with([
            'professeurs' =>  AdminHelper::getAllProfesseur(),
            'elements' => json_decode(AdminHelper::displayAllElements(Element::all()))
        ]);
    }
    public function element(){
        return view('admin.pages.element', [
            'modules' => Module::all(),
            'professeurs' => AdminHelper::getAllProfesseur(),
            'filieres' => Filiere::all()
        ]);
    }

    public function log(){
        return view('admin.pages.logs')->with([
            'roles' => Role::all(),
            'filieres' => Filiere::all(),
            'professeurs' => AdminHelper::getAllProfesseur(),
            'agentscolarites' => AdminHelper::getAllAgentScolarite(),
            'agentexamens' => AdminHelper::getAllAgentExamen(),
        ]);
    }

    public function gestionfiliere(Request $request){
        
        if($request->ajax()){
            if($request->op == 'afficher'){
                return Filiere::all();
            }
            elseif($request->op == 'ajouter'){
                $messages = [
                    'code.required' => 'le code est requis',
                    'libelle.required' => 'la libelle est requise'
                ];
                $validator = Validator::make($request->all(), [
                    'code' => 'required',
                    'libelle' => 'required',
                ], $messages);

                

                if($validator->fails()){
                    return json_encode([
                        'error' => $validator->messages()->get('*')
                    ]);
                } else {
                    $newFiliere = Filiere::create($request->only('code', 'libelle'));
                    if($newFiliere){
                        return [
                            'message' => [
                                'title' => 'success',
                                'message' => 'La filière a était crée avec succès'
                            ],
                            'data' => Filiere::all()
                        ];
                    } else {
                        return [
                            'message' => [
                                'title' => 'fail',
                                'message' => 'Erreur lors de la connexion à la base de données'
                            ],
                            'data' => Filiere::all()
                        ];
                    }
                }
            } 
            elseif( $request->op == 'delete'){
                foreach($request->items as $item){
                    AdminHelper::deleteFiliere(intval($item));
                }
                return Filiere::all();
            } elseif( $request->op == 'update'){
                $messages = [
                    'code.required' => 'le code est requis',
                    'libelle.required' => 'la libelle est requise'
                ];
                $validator = Validator::make($request->all(), [
                    'code' => 'required',
                    'libelle' => 'required',
                ], $messages);

                if($validator->fails()){
                    return json_encode([
                        'error' => $validator->messages()->get('*')
                    ]);
                } else {
                    $filiere = Filiere::find($request->id);
                    $filiere->code = $request->code;
                    $filiere->libelle = $request->libelle;
                    $filiere->save();
                    if($filiere){
                        return Filiere::all();
                    } else {
                        return [
                            'message' => [
                                'title' => 'fail',
                                'message' => 'Erreur lors de la connexion à la base de données'
                            ]
                        ];
                    }
                }

            }
        }
    }

    public function gestionModule(Request $request){
        if($request->ajax()){
            if($request->op == 'afficher'){
                return json_encode(AdminHelper::moduleOutput(Module::all()));
            }
            elseif($request->op == 'ajouter'){

                    $messages = [
                        'nom.required' => 'le nom du module est requis',
                        'id_filiere.required' => 'la filière est requise',
                        'id_filiere.exists' => 'la filière doit être valide',

                    ];
                    $validator = Validator::make($request->all(), [
                        'nom' => 'required',
                        'id_filiere' => 'required|exists:filieres,id',
                    ], $messages);

                    if($validator->fails()){
                        return json_encode([
                            'error' => $validator->messages()->get('*')
                        ]);
                    } else {
                        $newModule = Module::create($request->only('nom', 'id_filiere'));
                        if($newModule){
                            return [
                                'message' => [
                                    'title' => 'success',
                                    'message' => 'Le module a était crée avec succès'
                                ],
                                'data' => AdminHelper::moduleOutput(Module::all())
                            ];
                        } 
                    }
            }
             elseif( $request->op == 'delete'){
                foreach($request->items as $item){
                    Module::find($item)->delete();
                }

                return AdminHelper::moduleOutput(Module::all());
            }
            elseif( $request->op == 'update'){
                $messages = [
                    'nom.required' => 'le nom du module est requis',
                    'id_filiere.required' => 'la filiere est requise',
                    'id_filiere.exists' => 'la filiere doit exister',

                ];
                $validator = Validator::make($request->all(), [
                    'nom' => 'required',
                    'id_filiere' => 'required|exists:filieres,id',
                ], $messages);

                if($validator->fails()){
                    return json_encode([
                        'error' => $validator->messages()->get('*')
                    ]);
                } else {
                

                    $module =  Module::find(intval($request->id))->update($request->only('nom', 'id_filiere'));
                    return AdminHelper::moduleOutput(Module::all());
                }
            }
            elseif( $request->op == "search"){
                $modules = Module::where('id_filiere', $request->id_filiere)->get();
                return AdminHelper::moduleOutput($modules);
            }
        } 

    }


    public function gestionElement(Request $request){
        if($request->ajax()){
            if($request->op == 'afficher'){
                return AdminHelper::displayAllElements(Element::all());
            }
            elseif($request->op == 'ajouter'){
                $messages = [
                    'nom.required' => 'le nom est requis',
                    'id_module.required' => 'le champ module  est requis',
                    'id_prof.required' => 'le champ module  est requis',
                    'id_prof.exists' => 'L\'identifiant sélectionné n\'est pas valide.',
                    'id_module.exists' => 'L\'identifiant sélectionné n\'est pas valide.',
                ];
                $validator = Validator::make($request->all(), [
                    'nom' => 'required',
                    'id_module' => 'required|exists:modules,id',
                    'id_prof' => 'required|exists:professeurs,id',
                ], $messages);

                if($validator->fails()){
                    return json_encode([
                        'error' => $validator->messages()->get('*')
                    ]);
                } else {
                    $newElement = Element::create($request->only('nom','id_module','id_prof'));
                    if($newElement){
                        return [
                            'success' => 'L\'élément est ajouté avec succès',
                            'data' => json_decode(AdminHelper::displayAllElements(Element::all()))
                        ];
                    }  else {
                        return [
                                    'message' => [
                                        'title' => 'fail',
                                        'message' => 'Erreur lors de la connexion à la base de données'
                                    ]
                                ];
                    }
                }
            }
            elseif($request->op == 'delete'){
                foreach($request->items as $item){
                    Element::find($item)->delete();
                }
                return AdminHelper::displayAllElements(Element::all());
            }
            elseif($request->op == 'update'){
                $messages = [
                    'nom.required' => 'le nom est requis',
                    'id_module.required' => 'le champ module  est requis',
                    'id_prof.required' => 'le champ professeur est requis',
                    'id_prof.exists' => 'L\'identifiant sélectionné n\'est pas valide.',
                    'id_module.exists' => 'L\'identifiant sélectionné n\'est pas valide.',
                ];
                $validator = Validator::make($request->all(), [
                    'nom' => 'required',
                    'id_module' => 'required|exists:modules,id',
                    'id_prof' => 'required|exists:professeurs,id',
                ], $messages);

                if($validator->fails()){
                    return json_encode([
                        'error' => $validator->messages()->get('*')
                    ]);
                } else {
                    $element = Element::find($request->id)
                    ->update($request->only('nom', 'id_module', 'id_prof'));
                    if($element){
                        return [
                            'success' => 'L\'element est modifié avec success',
                            'data' => json_decode(AdminHelper::displayAllElements(Element::all()))
                        ];
                    }  else {
                        return [
                                    'message' => [
                                        'title' => 'fail',
                                        'message' => 'Erreur lors de la connexion à la base de données'
                                    ]
                                ];
                    }
                }
                $element = Element::find($request->id)
                ->update($request->only('nom', 'id_module', 'id_prof'));

                return AdminHelper::displayAllElements(Element::all());
            }
            elseif($request->op == 'listemodule'){
                
                return Module::where('id_filiere', $request->id_filiere)->get();
            }
            elseif($request->op == 'filitrage'){
                
                return AdminHelper::searchElements($request->filtrageOp, $request);
            }
            elseif($request->op == 'filiere'){
                $filiere = Filiere::find(Module::find($request->id_module)->id_filiere);
                return json_encode([
                       'filiere' => $filiere,
                       'modules' => Module::where('id_filiere', $filiere->id)->get()
                    ]);
            }
        }
    }

    public function gestionProfesseur(Request $request){
        if($request->ajax()){
            if($request->op == 'afficher'){
                return json_encode(AdminHelper::getAllProfesseur());
            }
            elseif($request->op == 'ajouter'){

                

                return AdminHelper::addUsersByRole($request->all(), 2, [
                    'action' => 'add'
                ]);
            }
            elseif($request->op == 'delete'){
                foreach($request->items as $item){
                    $id = Professeur::find($item)->id_user;
                    User::find($id)->delete();
                }
                return json_encode(AdminHelper::getAllProfesseur());
            }
            elseif($request->op == 'update'){
                return AdminHelper::updateUserByRole($request->all(), 2, [
                    'action' => 'update',
                    'id' => User::find(Professeur::find($request->id)->id_user)->id
                ]);
            } elseif($request->op == 'getemail'){
                return json_encode([
                    'email' => User::find(Professeur::find($request->id)->id_user)->email,
                ]);
            } elseif($request->op == 'filitrage'){
                return json_decode(AdminHelper::displayAllElements(Element::where('id_prof', $request->id_prof)->get()));
            } else if ($request->op == "allelements"){
                return json_decode(AdminHelper::displayAllElements(Element::all()));
            }
            
            
        }
    }

    public function gestionAgentScolarite(Request $request){
        if($request->ajax()){
            if($request->op == 'afficher'){
                return json_encode(AdminHelper::getAllAgentScolarite());
            }
            elseif($request->op == 'ajouter'){
                return AdminHelper::addUsersByRole($request->all(), 3, [
                    'action' => 'add'
                ]);
            }
            elseif($request->op == 'delete'){
                foreach($request->items as $item){
                    $id = AgentScolarite::find($item)->id_user;
                    User::find($id)->delete();
                }
                return json_encode(AdminHelper::getAllAgentScolarite());
            }
            elseif($request->op == 'update'){
                return AdminHelper::updateUserByRole($request->all(), 3, [
                    'action' => 'update',
                    'id' => User::find(AgentScolarite::find($request->id)->id_user)->id
                ]);
            } elseif($request->op == 'getemail'){
                return json_encode([
                    'email' => User::find(AgentScolarite::find($request->id)->id_user)->email,
                ]);
            }
            
            
        }
    }

    public function gestionAgentExamen(Request $request){
        if($request->ajax()){
            if($request->op == 'afficher'){
                return json_encode(AdminHelper::getAllAgentExamen());
            }
            elseif($request->op == 'ajouter'){
                return AdminHelper::addUsersByRole($request->all(), 4, [
                    'action' => 'add'
                ]);
            }
            elseif($request->op == 'delete'){
                foreach($request->items as $item){
                    $id = AgentExamen::find($item)->id_user;
                    User::find($id)->delete();
                }
                return json_encode(AdminHelper::getAllAgentExamen());
            }
            elseif($request->op == 'update'){
                return AdminHelper::updateUserByRole($request->all(), 4, [
                    'action' => 'update',
                    'id' => User::find(AgentExamen::find($request->id)->id_user)->id
                ]);
            } elseif($request->op == 'getemail'){
                return json_encode([
                    'email' => User::find(AgentExamen::find($request->id)->id_user)->email,
                ]);
            }
            
            
        }
    }
    public function gestionEtudiant(Request $request){
        if($request->ajax()){
            if($request->op == 'afficher'){
                return json_encode(AdminHelper::getAllAgentExamen());
            }
            if($request->op == 'ajouter'){
                return AdminHelper::addUsersByRole($request->all(), 5, [
                    'action' => 'add'
                ]);
            }
          
            
        }
    }
    public function gestionetudiantliste(Request $request){
        if($request->ajax()){
            if($request->op == "afficher"){
                return json_encode(AdminHelper::getAllEtudiant(Etudiant::all()));
            } else if($request->op == "update"){
                $rules = [
                    'nom' => 'required',
                    'prenom' => 'required',
                    'email' => 'required|email|unique:users,email,'.User::find(Etudiant::find($request->id)->id_user)->id,
                    'cin' => 'required|unique:users,cin,'.User::find(Etudiant::find($request->id)->id_user)->id,
                    'id_filiere' => 'required|exists:filieres,id'
                ];
                $messages = [
                    'email.required' => 'le champ email est requis',
                    'email.unique' => 'il existe deja un compte associe à l\'email fourni',
                    'email.email' => 'Veuillez saisir un correcte email',
                    'cin.required' => 'le champ cin est requis',
                    'cin.unique' => 'il existe deja un compte associe au cin fourni',
                    'prenom.required' => 'le champ prenom est requis',
                    'nom.required' => 'le champ nom est requis',
                    'id_filiere.required' => 'le champ filiere est requis',
                    'id_filiere.exists' => 'la filiere doit etre valide',
                ];

                $validator = Validator($request->all(), $rules, $messages);
                if($validator->fails()){
                    return [
                        'error' => $validator->messages()->get('*')
                    ];
                } else {
                    User::find(Etudiant::find($request->id)->id_user)->update($request->only('nom', 'prenom', 'email', 'cin'));
                    Etudiant::find($request->id)->update($request->only('id_filiere'));
                    return json_encode(AdminHelper::getAllEtudiant(Etudiant::all()));
                }
            } else if($request->op == "filtragefiliere"){
                return json_encode(AdminHelper::getAllEtudiantByFiliere($request->id_filiere));
            } else if($request->op == "delete"){
                foreach($request->items as $item){
                    Etudiant::find($item)->delete();
                }
                return json_encode(AdminHelper::getAllEtudiant(Etudiant::all()));
            }
        }
    }

    public function export(Request $request){

        if($request->filiere == 0){
            return Excel::download(new EtudiantAllExport(), 'etudiant.xlsx');
        }
        
        return Excel::download(new EtudiantExport($request->filiere), Filiere::find($request->filiere)->code. '-etudiant.xlsx');
    }

    public function import(Request $request){

            $rules = [
                'filiere' => 'required',
                'file' => 'required|mimes:xlsx'
            ];
            $messages = [
                'filiere.required' => 'la filiere est requise',
                'file.required' => 'le champ de fichier est obligatoire.',
                'file.mimes' => 'l\'extension du fichier doit être xlsx'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            if($validator->fails()){
                
                return json_encode(array(
                    'error' => $validator->errors()->getMessages()));

            } else {
                $users = Excel::toCollection(new EtudiantAllImport(), $request->file('file'));
                foreach($users[0] as $user){
                    if($user[0] == 'nom'){
                        // dd(count($user));
                        return AdminHelper::importEtudiants($users, $request->filiere);
                    } else {
                        return json_encode(array(
                            'styleerror' => 'Veuillez respectez la forme du fichier exemplaire'
                        ));
                        // $filiere = Filiere::where('code', $user[1])->get('id');
                        // dd(AdminHelper::importEtudiants('one', $users, $filiere->toArray()[0]['id']));
                    }
                }

            }

        
            $users = Excel::toCollection(new EtudiantAllImport(), $request->file('file'));
            foreach($users[0] as $user){
                if($user[0] == '#'){
                    dd(AdminHelper::importEtudiants('all', $users));
                } else if($user[0] == 'Filiere:'){
                    $filiere = Filiere::where('code', $user[1])->get('id');
                    dd(AdminHelper::importEtudiants('one', $users, $filiere->toArray()[0]['id']));
                }
            }
            return redirect()->back();
        // } catch(\Error $error){
        //     return back()->withError('test error');
        // }
        //  catch(NoTypeDetectedException $e){
        //     return back()->withError('test error');
        // }
    }

    public function exportsample(Request $request){
        return Excel::download(new Etudiantsample(), 'exemple.xlsx');
    }
    public function gestionlogs(Request $request){
        if($request->ajax()){
            if($request->op == 'afficher'){
                return AdminHelper::getLogs(Log::select('logs.*')->join('users','users.id', '=', 'logs.id_user')->where('role_id', '!=', 1)->orderBy('updated_at', 'desc')->get());
                
            } else if($request->op == 'filtre'){
                return AdminHelper::filtrelogs($request->filtreOp , $request->except('_token', 'op','filtreOp'));
            } else if ($request->op == "etudiant"){
                return AdminHelper::getAllEtudiantByFiliere($request->id_filiere);
            }
        }
    }
    public function gestionDashboard(Request $request){
        if($request->ajax()){
            if($request->op == "afficher"){
                return [
                    'etudiant' => AdminDashboardHelper::getEtudiantStats(),
                    'module' => AdminDashboardHelper::getModuleStats()
                ];
            }
        }
    }
    


}




