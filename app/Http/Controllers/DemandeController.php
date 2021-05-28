<?php

namespace App\Http\Controllers;

use App\Models\CategorieDemande;
use Illuminate\Support\Facades\Validator;
use App\Models\Demande;
use App\Models\Element;
use App\Models\Etat;
use App\Models\Etudiant;
use App\Models\Module;
use App\Models\Activities;
use App\Models\Log;
use App\Models\Professeur;
use App\Models\Rectifier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class DemandeController extends Controller
{

    public function scolarite()
    {
        $categories=CategorieDemande::all();
        //dd($categories);
        return view('etudiant.pages.scolarite', [
            'categories'=>$categories
        ]);
    }
    public function afficherDemandes(){
        $result = array();
                $user=Auth::user()->id;
                $etudiant = Etudiant::where('id_user', $user)->get();
                $demandes =Demande::orderBy('id', 'asc')->where('id_etudiant', $etudiant[0]->id)->get();
                foreach ($demandes as $d) {
                    $etat = Etat::find($d->id_etat);
                    $categorie = CategorieDemande::find($d->id_categorie);
                    $temp = [
                        'id'=>$d->id,
                        'demande'=> $categorie->nom_categorie,
                        'message' => $etat->etat,
                        'Date_livraison'=>$d->Date_livraison,
                        'dateDemande'=>$d->created_at
                    ];

                    array_push($result, $temp);
                }
            return $result;
    }
    public function afficherDemandeslivree(){
        $result = array();
                $user=Auth::user()->id;
                $etudiant = Etudiant::where('id_user', $user)->get();
                $demandes =Demande::all()->where('id_etudiant', $etudiant[0]->id)->where('id_etat',3);
                foreach ($demandes as $d) {
                    $etat = Etat::find($d->id_etat);
                    $categorie = CategorieDemande::find($d->id_categorie);
                    $temp = [
                        'id'=>$d->id,
                        'demande'=> $categorie->nom_categorie,
                        'message' => $etat->etat,
                        'Date_livraison'=>$d->Date_livraison,
                        'dateDemande'=>$d->created_at->format('Y-m-d')
                    ];

                    array_push($result, $temp);
                }
            return $result;
    }
    public function afficherDemandesrefuser(){
        $result = array();
                $user=Auth::user()->id;
                $etudiant = Etudiant::where('id_user', $user)->get();
                $demandes =Demande::all()->where('id_etudiant', $etudiant[0]->id)->where('id_etat',4);
                foreach ($demandes as $d) {
                    $etat = Etat::find($d->id_etat);
                    $categorie = CategorieDemande::find($d->id_categorie);
                    $temp = [
                        'id'=>$d->id,
                        'demande'=> $categorie->nom_categorie,
                        'message' => $etat->etat,
                        'Date_livraison'=>$d->Date_livraison,
                        'dateDemande'=>$d->created_at->format('Y-m-d')
                    ];

                    array_push($result, $temp);
                }
            return $result;
    }
    public function afficheLivreDemadeEtudian(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                return json_encode(['livree'=>$this->afficherDemandeslivree(),'refuser'=>$this->afficherDemandesrefuser()]);
            }

        }
    }
    public function gestionscolarite(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                return json_encode($this->afficherDemandes());

            } elseif ($request->op == 'ajouter') {
                $messages = [
                    'id_categorie.required' => 'la demande est requis',
                ];
                $validator = Validator::make($request->all(), [
                    'id_categorie' => 'required',
                ], $messages);

                if($validator->fails()){
                    return json_encode([
                        'error' => $validator->errors()->getMessages()
                    ]);
                }else {
                    $user=Auth::user()->id;
                    $etudiant = Etudiant::where('id_user', $user)->get();
                    $demande = Demande::create([
                        'id_etudiant' => $etudiant[0]->id,
                        'id_categorie' => $request->input('id_categorie'),
                        'id_etat' => 1,
                    ]);

                    if($demande){

                        $log = Log::where('id_user' , $user )->latest('last_seen_at')->first();
                        Activities::create([
                            'id_log' => $log->id,
                            'activity' => 'Ajouter une demande'
                        ]);

                        return json_encode([
                            'message' => [
                                'title' => 'success',
                                'message' => 'La demande a était envoyer avec succès'
                            ],
                            'data' => $this->afficherDemandes()
                        ]);
                    } else {
                        return json_encode([
                            'message' => [
                                'title' => 'fail',
                                'message' => 'Erreur lors de la connexion à la base de données'
                            ],
                            'data' =>$this->afficherDemandes()
                        ]);
                    }
                }


                // return json_encode($result);
            }
        }
    }
    public function accepterDemande(){
        $result = array();
        $categorie=CategorieDemande::where('role_id', 3)
                                    ->get();
        for ($i=0; $i < count($categorie); $i++) {
            $demandes = Demande::all()->where('id_categorie', $categorie[$i]->id)->where('id_etat', 1);
            foreach ($demandes as $d) {
                $etudiant = Etudiant::find($d->id_etudiant);
                $categorie1 = CategorieDemande::find($d->id_categorie);
                $user = User::find($etudiant->id_user);
                $temp=[
                    'id'=>$d->id,
                    'demande'=> $categorie1->nom_categorie,
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'Date_livraison'=>$d->Date_livraison
                ];
                array_push($result, $temp);
            }
        }
        return $result;
    }
    public function gestiondemande(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                return json_encode($this->accepterDemande());
            } elseif ($request->op == 'accepter') {
                $demande=Demande::find($request->id)->update([
                    'id_etat'=>2,
                    'Date_livraison'=>$request->date
                    ]);
                if($demande){

                    $log = Log::where('id_user' , Auth::user()->id )->latest('last_seen_at')->first();
                        Activities::create([
                            'id_log' => $log->id,
                            'activity' => 'Accepter une demande'
                        ]);

                    return json_encode([
                        'message' => [
                            'title' => 'success',
                            'message' => 'La reponse a était envoyer avec succès'
                        ],
                        'data' => $this->accepterDemande()
                    ]);
                } else {
                    return json_encode([
                        'message' => [
                            'title' => 'fail',
                            'message' => 'Erreur lors de la connexion à la base de données'
                        ],
                        'data' =>$this->accepterDemande()
                    ]);
                }

            } elseif ($request->op == 'refuser') {
                $demande=Demande::find($request->id)->update([
                    'id_etat'=>4
                    ]);
                if($demande){

                    $log = Log::where('id_user' , Auth::user()->id )->latest('last_seen_at')->first();
                        Activities::create([
                            'id_log' => $log->id,
                            'activity' => 'Refuser une demande'
                        ]);

                    return json_encode([
                        'message' => [
                            'title' => 'success',
                            'message' => 'La reponse a était refuser avec succès'
                        ],
                        'data' => $this->accepterDemande()
                    ]);
                } else {
                    return json_encode([
                        'message' => [
                            'title' => 'fail',
                            'message' => 'Erreur lors de la connexion à la base de données'
                        ],
                        'data' =>$this->accepterDemande()
                    ]);
                }

            }
        }
    }
    public function refuser(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                $result = array();
                $categorie=CategorieDemande::where('role_id', 3)
                                            ->get();

                // return json_encode($etat);
                for ($i=0; $i < count($categorie); $i++) {
                    $demandes = Demande::all()->where('id_categorie', $categorie[$i]->id)->where('id_etat', 4);
                    foreach ($demandes as $d) {
                        $etat = Etat::find($d->id_etat);
                        // $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $etat)->format('d.m.Y');

                        $etudiant = Etudiant::find($d->id_etudiant);
                        $categorie1 = CategorieDemande::find($d->id_categorie);
                        $user = User::find($etudiant->id_user);
                        $temp=[
                            'id'=>$d->id,
                            'demande'=> $categorie1->nom_categorie,
                            'nom' => $user->nom,
                            'etat' => $etat->etat,
                            'prenom' => $user->prenom,
                            'updated_at' =>$d->updated_at->format('d-m-Y')
                        ];
                        array_push($result, $temp);
                    }
                }
                return json_encode($result);
            }

        }
    }
    public function eserefuser(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                $result = array();
                $categorie=CategorieDemande::where('role_id', 4)
                                            ->get();
                for ($i=0; $i < count($categorie); $i++) {
                    $demandes = Demande::all()->where('id_categorie', $categorie[$i]->id)->where('id_etat', 4);
                    foreach ($demandes as $d) {
                        $etat = Etat::find($d->id_etat);
                        // $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $etat)->format('d.m.Y');

                        $etudiant = Etudiant::find($d->id_etudiant);
                        $categorie1 = CategorieDemande::find($d->id_categorie);
                        $user = User::find($etudiant->id_user);
                        $temp=[
                            'id'=>$d->id,
                            'demande'=> $categorie1->nom_categorie,
                            'nom' => $user->nom,
                            'etat' => $etat->etat,
                            'prenom' => $user->prenom,
                            'updated_at' =>$d->updated_at->format('d-m-Y')
                        ];
                        array_push($result, $temp);
                    }
                }
                return json_encode($result);
            }

        }
    }
    public function livree(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                $result = array();
                $categorie=CategorieDemande::all();
                for ($i=0; $i < count($categorie); $i++) {
                    $demandes = Demande::all()->where('id_categorie', $categorie[$i]->id)->where('id_etat', 3);
                    foreach ($demandes as $d) {
                        $etat = Etat::find($d->id_etat);
                        $etudiant = Etudiant::find($d->id_etudiant);
                        $categorie1 = CategorieDemande::find($d->id_categorie);
                        $user = User::find($etudiant->id_user);
                        $temp=[
                            'id'=>$d->id,
                            'demande'=> $categorie1->nom_categorie,
                            'nom' => $user->nom,
                            'etat' => $etat->etat,
                            'prenom' => $user->prenom,
                            'Date_livraison'=>$d->Date_livraison,
                            'updated_at' =>$d->updated_at->format('Y-m-d')
                        ];
                        array_push($result, $temp);
                    }
                }
                return json_encode($result);
            }

        }
    }
    public function eselivree(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                $result = array();
                $categorie=CategorieDemande::where('role_id', 4)
                                            ->get();
                for ($i=0; $i < count($categorie); $i++) {
                    $demandes = Demande::all()->where('id_categorie', $categorie[$i]->id)->where('id_etat', 3);
                    foreach ($demandes as $d) {
                        $etat = Etat::find($d->id_etat);
                        $etudiant = Etudiant::find($d->id_etudiant);
                        $categorie1 = CategorieDemande::find($d->id_categorie);
                        $user = User::find($etudiant->id_user);
                        $temp=[
                            'id'=>$d->id,
                            'demande'=> $categorie1->nom_categorie,
                            'nom' => $user->nom,
                            'etat' => $etat->etat,
                            'prenom' => $user->prenom,
                            'Date_livraison'=>$d->Date_livraison,
                            'updated_at' =>$d->updated_at->format('Y-m-d')
                        ];
                        array_push($result, $temp);
                    }
                }
                return json_encode($result);
            }

        }
    }
    public function historique(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                $result = array();
                $categorie=CategorieDemande::all();

                // return json_encode($categorie);
                for ($i=0; $i < count($categorie); $i++) {
                    $demandes = Demande::all()->where('id_categorie', $categorie[$i]->id);
                    foreach ($demandes as $d) {
                        $etat = Etat::find($d->id_etat);
                        $etudiant = Etudiant::find($d->id_etudiant);
                        $categorie1 = CategorieDemande::find($d->id_categorie);
                        $user = User::find($etudiant->id_user);
                        $temp=[
                            'id'=>$d->id,
                            'demande'=> $categorie1->nom_categorie,
                            'nom' => $user->nom,
                            'etat' => $etat->etat,
                            'prenom' => $user->prenom,
                            'updated_at' =>$d->updated_at->format('Y-m-d')
                        ];
                        array_push($result, $temp);
                    }
                }
                return json_encode($result);
            }

        }
    }
    public function esehistorique(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                $result = array();
                $categorie=CategorieDemande::where('role_id', 4)
                                            ->get();
                // return json_encode($categorie);
                for ($i=0; $i < count($categorie); $i++) {
                    $demandes = Demande::all()->where('id_categorie', $categorie[$i]->id);
                    foreach ($demandes as $d) {
                        $etat = Etat::find($d->id_etat);
                        $etudiant = Etudiant::find($d->id_etudiant);
                        $categorie1 = CategorieDemande::find($d->id_categorie);
                        $user = User::find($etudiant->id_user);
                        $temp=[
                            'id'=>$d->id,
                            'demande'=> $categorie1->nom_categorie,
                            'nom' => $user->nom,
                            'etat' => $etat->etat,
                            'prenom' => $user->prenom,
                            'updated_at' =>$d->updated_at->format('Y-m-d')
                        ];
                        array_push($result, $temp);
                    }
                }
                return json_encode($result);
            }

        }
    }
    public function livreeacceptée(){
        $result = array();
                $categorie=CategorieDemande::all();
                for ($i=0; $i < count($categorie); $i++) {
                    $demandes = Demande::all()->where('id_categorie', $categorie[$i]->id)->where('id_etat', 2);
                    foreach ($demandes as $d) {
                        $etudiant = Etudiant::find($d->id_etudiant);
                        $categorie1 = CategorieDemande::find($d->id_categorie);
                        $user = User::find($etudiant->id_user);
                        $etat = Etat::find($d->id_etat);
                        $temp=[
                            'id'=>$d->id,
                            'demande'=> $categorie1->nom_categorie,
                            'etat' => $etat->etat,
                            'nom' => $user->nom,
                            'prenom' => $user->prenom,
                            'Date_livraison'=>$d->Date_livraison,
                            'updated_at' =>$d->updated_at->format('Y-m-d')

                        ];
                        array_push($result, $temp);
                    }
                }
            return $result;

    }
    public function accepter(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                return json_encode($this->livreeacceptée());
            } elseif ($request->op == 'livree') {
                $m = Demande::find($request->id);
                $m->id_etat = 3;
                $m->save();
                // return json_encode();
                if($m){

                    $log = Log::where('id_user' , Auth::user()->id )->latest('last_seen_at')->first();
                        Activities::create([
                            'id_log' => $log->id,
                            'activity' => 'Livrer une demande'
                        ]);

                    return json_encode([
                        'message' => [
                            'title' => 'success',
                            'message' => 'La reponse a était livrée avec succès'
                        ],
                        'data' => $this->livreeacceptée()
                    ]);
                } else {
                    return json_encode([
                        'message' => [
                            'title' => 'fail',
                            'message' => 'Erreur lors de la connexion à la base de données'
                        ],
                        'data' =>$this->livreeacceptée()
                    ]);
                }
            }
        }
    }
    public function eseaccepter(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                $result = array();
                $categorie=CategorieDemande::where('role_id', 4)
                                            ->get();
                for ($i=0; $i < count($categorie); $i++) {
                    $demandes = Demande::all()->where('id_categorie', $categorie[$i]->id)->where('id_etat', 2);
                    foreach ($demandes as $d) {
                        $etudiant = Etudiant::find($d->id_etudiant);
                        $categorie1 = CategorieDemande::find($d->id_categorie);
                        $user = User::find($etudiant->id_user);
                        $etat = Etat::find($d->id_etat);
                        $temp=[
                            'id'=>$d->id,
                            'demande'=> $categorie1->nom_categorie,
                            'etat' => $etat->etat,
                            'nom' => $user->nom,
                            'prenom' => $user->prenom,
                            'Date_livraison'=>$d->Date_livraison,
                            'updated_at' =>$d->updated_at->format('Y-m-d')

                        ];
                        array_push($result, $temp);
                    }
                }
                return json_encode($result);
            }
        }
    }
    public function accepterParEseshow(){
        $result = array();
        $categorie=CategorieDemande::where('role_id', 4)
                                    ->get();
        for ($i=0; $i < count($categorie); $i++) {
            $demandes = Demande::all()->where('id_categorie', $categorie[$i]->id)->where('id_etat', 2)->whereNull('Date_livraison');
            foreach ($demandes as $d) {
                $etudiant = Etudiant::find($d->id_etudiant);
                $categorie1 = CategorieDemande::find($d->id_categorie);
                $user = User::find($etudiant->id_user);
                $etat = Etat::find($d->id_etat);
                $temp=[
                    'id'=>$d->id,
                    'demande'=> $categorie1->nom_categorie,
                    'etat' => $etat->etat,
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'Date_livraison'=>$d->Date_livraison,
                    'updated_at' =>$d->updated_at->format('Y-m-d')

                ];
                array_push($result, $temp);
            }
        }
        return $result;

    }

    public function accepterparese(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                return json_encode($this->accepterParEseshow());
            } elseif ($request->op == 'livree') {
                $m = Demande::find($request->id);
                $m->Date_livraison = $request->date;
                $m->save();
                // return json_encode($this->accepterParEseshow());
                if($m){
                    $log = Log::where('id_user' , Auth::user()->id )->latest('last_seen_at')->first();
                        Activities::create([
                            'id_log' => $log->id,
                            'activity' => 'Livrer une demande'
                        ]);
                    return json_encode([
                        'message' => [
                            'title' => 'success',
                            'message' => 'La reponse a était acceptée avec succès'
                        ],
                        'data' => $this->accepterParEseshow()
                    ]);
                } else {
                    return json_encode([
                        'message' => [
                            'title' => 'fail',
                            'message' => 'Erreur lors de la connexion à la base de données'
                        ],
                        'data' =>$this->accepterParEseshow()
                    ]);
                }
            }
        }
    }
    public function demandeaffichiw(){
        $result = array();
                $categorie=CategorieDemande::where('role_id', 4)
                                            ->get();
                for ($i=0; $i < count($categorie); $i++) {
                    $demandes = Demande::all()->where('id_categorie', $categorie[$i]->id)->where('id_etat', 1);
                    foreach ($demandes as $d) {
                        $etudiant = Etudiant::find($d->id_etudiant);
                        $categorie1 = CategorieDemande::find($d->id_categorie);
                        $user = User::find($etudiant->id_user);
                        $temp=[
                            'id'=>$d->id,
                            'demande'=> $categorie1->nom_categorie,
                            'nom' => $user->nom,
                            'prenom' => $user->prenom,
                            'created_at'=>$d->created_at->format('Y-m-d'),
                            'Date_livraison'=>$d->Date_livraison
                        ];
                        array_push($result, $temp);
                    }
                }
            return $result;
    }
    public function demande(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                return json_encode($this->demandeaffichiw());
            } elseif ($request->op == 'accepter') {
                $m = Demande::find($request->id);
                $m->id_etat = 2;
                $m->save();
                if($m){

                    $log = Log::where('id_user' , Auth::user()->id  )->latest('last_seen_at')->first();
                        Activities::create([
                            'id_log' => $log->id,
                            'activity' => 'Accepter une demande'
                        ]);

                    return json_encode([
                        'message' => [
                            'title' => 'success',
                            'message' => 'La reponse a était acceptée avec succès'
                        ],
                        'data' => $this->demandeaffichiw()
                    ]);
                } else {
                    return json_encode([
                        'message' => [
                            'title' => 'fail',
                            'message' => 'Erreur lors de la connexion à la base de données'
                        ],
                        'data' =>$this->demandeaffichiw()
                    ]);
                }

            } elseif ($request->op == 'refuser') {
                $m = Demande::find($request->id);
                $m->id_etat = 4;
                $m->save();
                if($m){



                    $log = Log::where('id_user' , Auth::user()->id )->latest('last_seen_at')->first();
                        Activities::create([
                            'id_log' => $log->id,
                            'activity' => 'Refuser une demande'
                        ]);

                    return json_encode([
                        'message' => [
                            'title' => 'success',
                            'message' => 'La reponse a était refusée avec succès'
                        ],
                        'data' => $this->demandeaffichiw()
                    ]);
                } else {
                    return json_encode([
                        'message' => [
                            'title' => 'fail',
                            'message' => 'Erreur lors de la connexion à la base de données'
                        ],
                        'data' =>$this->demandeaffichiw()
                    ]);
                }
            }
        }


    }
    public function rectfier()
    {
        $user=Auth::user()->id;
        $etudiant = Etudiant::where('id_user', $user)->get();
        $modules=Module::all()->where('id_filiere' ,$etudiant[0]->id_filiere);
        // dd($modules);
        return view('etudiant.pages.rectfier', [
            'modules'=>$modules
        ]);
    }
    public function afficherRectification(){
        $result = array();
        $user=Auth::user()->id;
        $etudiant = Etudiant::where('id_user', $user)->get();
        // $demandes =Demande::all()->where('id_etudiant', $etudiant[0]->id);
        // $demandes = Demande::all();
        $rectifier = Rectifier::all()->where('id_etudiant', $etudiant[0]->id);
        foreach ($rectifier as $r) {
            $etat = Etat::find($r->id_etat);
            $module = Module::find($r->id_module);
            $element = Element::find($r->id_element);
            $temp = [
                'id'=>$r->id,
                'module'=> $module->nom,
                'element'=>$element->nom,
                'message' => $etat->etat,
                'commentaire'=> $r->commentaire
            ];

            array_push($result, $temp);
        }
        return $result;
    }
    public function afficherRectificationRefuser(){
        $result = array();
        $user=Auth::user()->id;
        $etudiant = Etudiant::where('id_user', $user)->get();
        $rectifier = Rectifier::all()->where('id_etudiant', $etudiant[0]->id)->where('id_etat',4);
        foreach ($rectifier as $r) {
            $etat = Etat::find($r->id_etat);
            $module = Module::find($r->id_module);
            $element = Element::find($r->id_element);
            $temp = [
                'id'=>$r->id,
                'module'=> $module->nom,
                'element'=>$element->nom,
                'message' => $etat->etat,
                'commentaire'=> $r->commentaire
            ];

            array_push($result, $temp);
        }
        return $result;
    }
    public function afficherRectificationAcepter(){
        $result = array();
        $user=Auth::user()->id;
        $etudiant = Etudiant::where('id_user', $user)->get();
        $rectifier = Rectifier::all()->where('id_etudiant', $etudiant[0]->id)->where('id_etat',2);
        foreach ($rectifier as $r) {
            $etat = Etat::find($r->id_etat);
            $module = Module::find($r->id_module);
            $element = Element::find($r->id_element);
            $temp = [
                'id'=>$r->id,
                'module'=> $module->nom,
                'element'=>$element->nom,
                'message' => $etat->etat,
                'commentaire'=> $r->commentaire
            ];

            array_push($result, $temp);
        }
        return $result;
    }
    public function afficherAccepteretRefuserEtudian(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                return json_encode(['accepter'=>$this->afficherRectificationAcepter(),'refuser'=>$this->afficherRectificationRefuser()]);
            }

        }
    }
    public function gestionrectfier(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'element') {
                return Element::where('id_module',$request->id_module)->get();
            }elseif ($request->op == 'afficher') {
                return json_encode($this->afficherRectification());
            } elseif ($request->op == 'ajouter') {
                $messages = [
                    'id_module.required' => 'le module est requis',
                    'id_element.required' => 'element est requis',
                ];
                $validator = Validator::make($request->all(), [
                    'id_module' => 'required',
                    'id_element' => 'required',
                ], $messages);
                if($validator->fails()){
                    return json_encode([
                        //  'error' => $validator->messages()->get('*')
                    ]);
                }else {
                    $user=Auth::user()->id;
                    $etudiant = Etudiant::where('id_user', $user)->get();
                    // $demande = new Rectifier();
                    // $demande->id_etudiant=$etudiant[0]->id;
                    // $demande->id_module =$request->input('id_module');
                    // $demande->id_element = $request->input('id_element');
                    // $demande->commentaire  =$request->input('commentaire');
                    // $demande->id_etat=1;
                    // $demande->save();
                    $rectifier = Rectifier::create([
                        'id_etudiant' => $etudiant[0]->id,
                        'id_module' => $request->input('id_module'),
                        'id_element' => $request->input('id_element'),
                        'commentaire' => $request->input('commentaire'),
                        'id_etat' => 1
                    ]);

                    if($rectifier){

                        $log = Log::where('id_user' , Auth::user()->id )->latest('last_seen_at')->first();
                        Activities::create([
                            'id_log' => $log->id,
                            'activity' => 'Ajouter une demande'
                        ]);

                        return json_encode([
                            'message' => [
                                'title' => 'success',
                                'message' => 'La demande de rectification a était envoyer avec succès'
                            ],
                            'data' => $this->afficherRectification()
                        ]);
                    } else {
                        return json_encode([
                            'message' => [
                                'title' => 'fail',
                                'message' => 'Erreur lors de la connexion à la base de données'
                            ],
                            'data' => $this->afficherRectification()
                        ]);
                    }
                }
            }


        }


    }
    public function getAllRectifier()
    {
        $result = array();
        $user=Auth::user()->id;
        $prof=Professeur::where('id_user', $user)->get();
        $element=Element::where('id_prof',$prof[0]->id)->get();
        // $rectifier = Rectifier::all()->where('id_element',$element[0]->id)->where('id_etat', 1);
            for ($i=0; $i < count($element); $i++) {
                $rectifier = Rectifier::all()->where('id_element',$element[$i]->id)->where('id_etat', 1);
                foreach ($rectifier as $r) {

                        $etudiant = Etudiant::find($r->id_etudiant);
                        $module = Module::find($r->id_module);
                        $element1 = Element::find($r->id_element);
                        $user = User::find($etudiant->id_user);
                        $etat = Etat::find($r->id_etat);
                        $temp=[
                            'id'=>$r->id,
                            'module'=> $module->nom,
                            'element'=>$element1->nom,
                            'nom' => $user->nom,
                            'prenom' => $user->prenom,
                            'created_at'=>$r->created_at->format('d-m-Y'),
                            'updated_at'=>$r->updated_at->format('d-m-Y'),
                            'etat' => $etat->etat,
                            'commentaire'=>$r->commentaire
                        ];
                        array_push($result, $temp);
                }

            }
        return $result;
    }
    public function demanderectifier(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                return json_encode($this->getAllRectifier());
            } elseif ($request->op == 'accepter') {
                $r=Rectifier::find($request->id)->update(['id_etat'=>2]);
                if($r){
                    // return json_encode($this->getAllRectifier());
                    $log = Log::where('id_user' , Auth::user()->id )->latest('last_seen_at')->first();
                        Activities::create([
                            'id_log' => $log->id,
                            'activity' => ' Accepter une demande'
                        ]);
                    return [
                        'message' => [
                            'title' => 'success',
                            'message' => 'La demande de rectification a était accepter avec succès'
                        ],
                        'data' => $this->getAllRectifier()
                    ];
                }else{
                    return json_encode([
                        'message' => [
                            'title' => 'fail',
                            'message' => 'Erreur lors de la connexion à la base de données'
                        ],
                        'data' => $this->getAllRectifier()
                    ]);
                }

            }elseif ($request->op == 'refuser') {
                $r=Rectifier::find($request->id)->update(['id_etat'=>4]);
                if($r){
                    // return json_encode($this->getAllRectifier());
                    $log = Log::where('id_user' , Auth::user()->id )->latest('last_seen_at')->first();
                        Activities::create([
                            'id_log' => $log->id,
                            'activity' => 'Refuser une demande'
                        ]);
                    return [
                        'message' => [
                            'title' => 'success',
                            'message' => 'La demande de rectification a était refuser avec succès'
                        ],
                        'data' => $this->getAllRectifier()
                    ];
                }else{
                    return json_encode([
                        'message' => [
                            'title' => 'fail',
                            'message' => 'Erreur lors de la connexion à la base de données'
                        ],
                        'data' => $this->getAllRectifier()
                    ]);
                }
                    }
        }
    }
    public function profAccepter()
    {
        $result = array();
        $user=Auth::user()->id;
        $prof=Professeur::where('id_user', $user)->get();
        $element=Element::where('id_prof',$prof[0]->id)->get();
        // $rectifier = Rectifier::all()->where('id_element',$element[0]->id)->where('id_etat', 2);
            for ($i=0; $i < count($element); $i++) {
                $rectifier = Rectifier::all()->where('id_element',$element[$i]->id)->where('id_etat', 2);
                foreach ($rectifier as $r) {

                        $etudiant = Etudiant::find($r->id_etudiant);
                        $module = Module::find($r->id_module);
                        $element1 = Element::find($r->id_element);
                        $user = User::find($etudiant->id_user);
                        $etat = Etat::find($r->id_etat);
                        $temp=[
                            'id'=>$r->id,
                            'module'=> $module->nom,
                            'element'=>$element1->nom,
                            'nom' => $user->nom,
                            'prenom' => $user->prenom,
                            'updated_at'=>$r->updated_at->format('d-m-Y'),
                            'etat' => $etat->etat,
                            'commentaire'=>$r->commentaire
                        ];
                        array_push($result, $temp);
                }

            }
        return $result;
    }
    public function profrefuser()
    {
        $result = array();
        $user=Auth::user()->id;
        $prof=Professeur::where('id_user', $user)->get();
        $element=Element::where('id_prof',$prof[0]->id)->get();
            for ($i=0; $i < count($element); $i++) {
                $rectifier = Rectifier::all()->where('id_element',$element[$i]->id)->where('id_etat', 4);
                foreach ($rectifier as $r) {

                        $etudiant = Etudiant::find($r->id_etudiant);
                        $module = Module::find($r->id_module);
                        $element1 = Element::find($r->id_element);
                        $user = User::find($etudiant->id_user);
                        $etat = Etat::find($r->id_etat);
                        $temp=[
                            'id'=>$r->id,
                            'module'=> $module->nom,
                            'element'=>$element1->nom,
                            'nom' => $user->nom,
                            'prenom' => $user->prenom,
                            'updated_at'=>$r->updated_at->format('d-m-Y'),
                            'etat' => $etat->etat,
                            'commentaire'=>$r->commentaire
                        ];
                        array_push($result, $temp);
                }

            }
        return $result;
    }
    public function profhistorique()
    {
        $result = array();
        $user=Auth::user()->id;
        $prof=Professeur::where('id_user', $user)->get();
        $element=Element::where('id_prof',$prof[0]->id)->get();
            for ($i=0; $i < count($element); $i++) {
                $rectifier = Rectifier::all()->where('id_element',$element[$i]->id);
                foreach ($rectifier as $r) {

                        $etudiant = Etudiant::find($r->id_etudiant);
                        $module = Module::find($r->id_module);
                        $element1 = Element::find($r->id_element);
                        $user = User::find($etudiant->id_user);
                        $etat = Etat::find($r->id_etat);
                        $temp=[
                            'id'=>$r->id,
                            'module'=> $module->nom,
                            'element'=>$element1->nom,
                            'nom' => $user->nom,
                            'prenom' => $user->prenom,
                            'updated_at'=>$r->updated_at->format('d-m-Y'),
                            'etat' => $etat->etat,
                            'commentaire'=>$r->commentaire
                        ];
                        array_push($result, $temp);
                }

            }
        return $result;
    }
    public function accepterrectifier(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                return json_encode($this->profAccepter());

            }
        }
    }
    public function refuserrectifier(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                return json_encode($this->profrefuser());

            }
        }
    }
    public function getAllElementshistoriquerectifier(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                return json_encode($this->profhistorique());

            }
        }
    }
    public function getAlletats(){
        $etat_array =array();
        $etats = Etat::all();

        foreach ($etats as $etat) {
            $id_etat = $etat->id;
            $nom_etat =$etat->etat;
            $etat_array[ $id_etat ] = $nom_etat;
        }
        return $etat_array;

    }
    public function getAlletats2(){
        $etat_array =array();
        $etats = Etat::where('id', '!=' , 3)->orWhereNull('id')->get();

        foreach ($etats as $etat) {
            $id_etat = $etat->id;
            $nom_etat =$etat->etat;
            $etat_array[ $id_etat ] = $nom_etat;
        }
        return $etat_array;

    }
    public function countdemandeEtudiant($etat){
        $user=Auth::user()->id;
        $etudiant = Etudiant::where('id_user', $user)->get();
        // $demandes =Demande::all()->where('id_etudiant', $etudiant[0]->id);
        $count = Demande::where('id_etat',$etat)->where('id_etudiant', $etudiant[0]->id)->count();
        return $count;
    }
    public function countrectifeireEtudiant($etat){
        $user=Auth::user()->id;
        $etudiant = Etudiant::where('id_user', $user)->get();
        // $demandes =Demande::all()->where('id_etudiant', $etudiant[0]->id);
        $count = Rectifier::where('id_etat',$etat)->where('id_etudiant', $etudiant[0]->id)->count();
        return $count;
    }
    public function getchart1demandes()
    {
        $demandes_count_array = array();
		$etat_array = $this->getAlletats();
		$etat_name_array = array();
		if ( ! empty( $etat_array ) ) {
			foreach ( $etat_array as $id_etat => $nom_etat ){
				$demandes_count = $this->countdemandeEtudiant( $id_etat );
				array_push( $demandes_count_array, $demandes_count );
				array_push( $etat_name_array, $nom_etat );
			}
		}
		$allcountandetat = array(
			'etat' => $etat_name_array,
			'count' => $demandes_count_array,
		);

		return $allcountandetat;

    }
    public function getchart1rectifier()
    {
        $demandes_count_array = array();
		$etat_array = $this->getAlletats2();
		$etat_name_array = array();
		if ( ! empty( $etat_array ) ) {
			foreach ( $etat_array as $id_etat => $nom_etat ){
				$demandes_count = $this->countrectifeireEtudiant( $id_etat );
				array_push( $demandes_count_array, $demandes_count );
				array_push( $etat_name_array, $nom_etat );
			}
		}
		$allcountandetat = array(
			'etat' => $etat_name_array,
			'count' => $demandes_count_array,
		);

		return $allcountandetat;

    }
    public function countdemandeess($categorie){
        $count = Demande::where('id_categorie',$categorie)->count();
        return $count;
    }
    public function getAllCategorieEss(){
        $categorie_array =array();
        $categories = CategorieDemande::where('role_id', 3)->get();;

        foreach ($categories as $categorie) {
            $id_cat = $categorie->id;
            $nom_cat =$categorie->nom_categorie;
            $etat_array[ $id_cat ] = $nom_cat;
        }
        return $etat_array;

    }
    public function getchart2()
    {
        $demandes_count_array = array();
		$cat_array = $this->getAllCategorieEss();
		$cat_name_array = array();
		if ( ! empty( $cat_array ) ) {
			foreach ( $cat_array as $id_cat => $nom_cat ){
				$demandes_count = $this->countdemandeess( $id_cat );
				array_push( $demandes_count_array, $demandes_count );
				array_push( $cat_name_array, $nom_cat);
			}
		}
		$allcountandcat = array(
			'categorie' => $cat_name_array,
			'count' => $demandes_count_array,
		);

		return $allcountandcat;

    }
    public function getAllCategorieEse(){
        $categorie_array =array();
        $categories = CategorieDemande::where('role_id', 4)->get();;

        foreach ($categories as $categorie) {
            $id_cat = $categorie->id;
            $nom_cat =$categorie->nom_categorie;
            $etat_array[ $id_cat ] = $nom_cat;
        }
        return $etat_array;

    }
    public function getchart3()
    {
        $demandes_count_array = array();
		$cat_array = $this->getAllCategorieEse();
		$cat_name_array = array();
		if ( ! empty( $cat_array ) ) {
			foreach ( $cat_array as $id_cat => $nom_cat ){
				$demandes_count = $this->countdemandeess( $id_cat );
				array_push( $demandes_count_array, $demandes_count );
				array_push( $cat_name_array, $nom_cat);
			}
		}
		$allcountandcat = array(
			'categorie' => $cat_name_array,
			'count' => $demandes_count_array,
		);

		return $allcountandcat;

    }

    public function getAllElements(){
        $elements_array =array();
        $user=Auth::user()->id;
        $prof = Professeur::where('id_user', $user)->get();
        $elements = Element::where('id_prof', $prof[0]->id)->get();

        foreach ($elements as $element) {
            $id_ele = $element->id;
            $nom_ele =$element->nom;
            $elements_array[ $id_ele ] = $nom_ele;
        }
        return $elements_array;

    }
    public function countdemandeprof($element){
        $count = Rectifier::where('id_element',$element)->count();
        return $count;
    }
    public function getchart4()
    {
        $rectifier_count_array = array();
		$element_array = $this->getAllElements();
		$element_name_array = array();
		if ( ! empty( $element_array ) ) {
			foreach ( $element_array as $id_ele => $nom_ele ){
				$demandes_count = $this->countdemandeprof( $id_ele );
				array_push( $rectifier_count_array, $demandes_count );
				array_push( $element_name_array, $nom_ele );
			}
		}
		$allcountandelement = array(
			'element' => $element_name_array,
			'count' => $rectifier_count_array,
		);

		return $allcountandelement;

    }
    public function dashboard(){
        $result = array();
        $result2 = array();
        $user=Auth::user()->id;
        $etudiant = Etudiant::where('id_user', $user)->get();
        $demandes =Demande::all()->where('id_etudiant', $etudiant[0]->id)->count();
        $dlivrees =Demande::all()->where('id_etudiant', $etudiant[0]->id)->where('id_etat',3)->count();
        $rectifiers =Rectifier::all()->where('id_etudiant', $etudiant[0]->id)->count();
        $demandeslistes = Demande::where('id_etudiant', $etudiant[0]->id)->orderBy('created_at', 'asc')->take(5)->get();
        foreach ($demandeslistes as $d) {
            $categorie1 = CategorieDemande::find($d->id_categorie)->nom_categorie;
            $etat = Etat::find($d->id_etat)->etat;
            // $temp = [
            //     'cat'=>$categorie1,
            //     'etat'=>$etat

            // ]
            array_push($result, $categorie1);
            array_push($result2, $etat);
        }


        $rlivrees =Rectifier::all()->where('id_etudiant', $etudiant[0]->id)->where('id_etat',2)->count();
        return view('etudiant.pages.dashboard', [
            'demandes'=>$demandes,
            'dlivree'=>$dlivrees,
            'rectifiers'=>$rectifiers,
            'rlivree'=>$rlivrees,
        ]);
    }
    function getAllMonths(){
		$month_array = array();

        $user=Auth::user()->id;
        $etudiant = Etudiant::where('id_user', $user)->get();
        $posts_dates =Demande::where('id_etudiant', $etudiant[0]->id)->orderBy( 'created_at', 'ASC' )->pluck( 'created_at' );

		// $posts_dates = $demande->orderBy( 'created_at', 'ASC' )->pluck( 'created_at' );
		$posts_dates = json_decode( $posts_dates );

		if ( ! empty( $posts_dates ) ) {
			foreach ( $posts_dates as $unformatted_date ) {
				$date = new \DateTime( $unformatted_date );
				$month_no = $date->format( 'm' );
				$month_name = $date->format( 'M' );
				$month_array[ $month_no ] = $month_name;
			}
		}
		return $month_array;
	}
    function getAllMonths2(){

		$month_array = array();
		$posts_dates = Rectifier::orderBy( 'created_at', 'ASC' )->pluck( 'created_at' );
		$posts_dates = json_decode( $posts_dates );

		if ( ! empty( $posts_dates ) ) {
			foreach ( $posts_dates as $unformatted_date ) {
				$date = new \DateTime( $unformatted_date );
				$month_no = $date->format( 'm' );
				$month_name = $date->format( 'M' );
				$month_array[ $month_no ] = $month_name;
			}
		}
		return $month_array;
	}

	function getMonthlydemandeCount( $month ) {
        $user=Auth::user()->id;
        $etudiant = Etudiant::where('id_user', $user)->get();
		$monthly_post_count = Demande::where('id_etudiant', $etudiant[0]->id)->whereMonth( 'created_at', $month )->get()->count();
		return $monthly_post_count;
	}
    function getMonthlyRectifierCount( $month ) {
        $user=Auth::user()->id;
        $etudiant = Etudiant::where('id_user', $user)->get();
		$monthly_retifier_count = Rectifier::where('id_etudiant', $etudiant[0]->id)->whereMonth( 'created_at', $month )->get()->count();
		return $monthly_retifier_count;
	}

	function getMonthlydemandeData() {

		$monthly_post_count_array = array();
		$month_array = $this->getAllMonths();
		$month_name_array = array();
		if ( ! empty( $month_array ) ) {
			foreach ( $month_array as $month_no => $month_name ){
				$monthly_post_count = $this->getMonthlydemandeCount( $month_no );
				array_push( $monthly_post_count_array, $monthly_post_count );
				array_push( $month_name_array, $month_name );
			}
		}
        $monthly_post_data_array = array(
			'months' => $month_name_array,
			'demande_count_data' => $monthly_post_count_array,

		);

		return $monthly_post_data_array ;

    }
    function getMonthlyrectifierData() {

		$monthly_post_count_array = array();
		$month_array = $this->getAllMonths2();
		$month_name_array = array();
		if ( ! empty( $month_array ) ) {
			foreach ( $month_array as $month_no => $month_name ){
				$monthly_post_count = $this->getMonthlyRectifierCount( $month_no );
				array_push( $monthly_post_count_array, $monthly_post_count );
				array_push( $month_name_array, $month_name );
			}
		}
        $monthly_post_data_array = array(
			'months' => $month_name_array,
			'demande_count_data' => $monthly_post_count_array,

		);

		return $monthly_post_data_array;

    }
    public function etudiantdashboardsuives(){
        $result = array();
        $user=Auth::user()->id;
        $etudiant = Etudiant::where('id_user', $user)->get();
        $demandeslistes = Demande::where('id_etudiant', $etudiant[0]->id)->orderBy('created_at', 'DESC')->take(5)->get();
        foreach ($demandeslistes as $d) {
            $categorie1 = CategorieDemande::find($d->id_categorie)->nom_categorie;
            $etat = Etat::find($d->id_etat)->etat;
            $temp = [
                'cat'=>$categorie1,
                'etat'=>$etat

            ];
            array_push($result, $temp);
        }
        return($result);
    }
    public function etudiantdashboardsuiverectification(){
        $result = array();
        $user=Auth::user()->id;
        $etudiant = Etudiant::where('id_user', $user)->get();
        $rectiflistes = Rectifier::where('id_etudiant', $etudiant[0]->id)->orderBy('created_at', 'DESC')->take(5)->get();
        foreach ($rectiflistes as $d) {
            $element = Element::find($d->id_element)->nom;
            $etat = Etat::find($d->id_etat)->etat;
            $temp = [
                'cat'=>$element,
                'etat'=>$etat

            ];
            array_push($result, $temp);
        }
        return($result);
    }
    public function chart1(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                return json_encode([
                    'demande'=>$this->getchart1demandes(),
                    'rectifier'=>$this->getchart1rectifier(),
                    'date1'=>$this->getMonthlydemandeData(),
                    'date2'=>$this->getMonthlyrectifierData(),
                    'statutdemandes'=>$this->etudiantdashboardsuives(),
                    'statutrectife'=>$this->etudiantdashboardsuiverectification()
                    ]

                );

            }
        }
    }
    public function dashboardess(){
        $demande1=Demande::all()->count();
        $demande2=Demande::where('id_etat',2)->count();
        $demande3=Demande::where('id_etat',3)->count();
        $demande4=Demande::where('id_etat',4)->count();
        return view('ess.pages.dashboard', ['demande1'=>$demande1,'demande2'=>$demande2,'demande3'=>$demande3,'demande4'=>$demande4]);
    }
    public function essdashboardsuive(){
        $result = array();
        $demandeslistes = Demande::orderBy('created_at', 'DESC')->where('id_etat',1)->get();
        foreach ($demandeslistes as $d) {
                $etudiant = Etudiant::find($d->id_etudiant);
                $categorie1 = CategorieDemande::find($d->id_categorie);
                $user = User::find($etudiant->id_user);
                $etat = Etat::find($d->id_etat)->etat;
                $temp=[
                    'demande'=> $categorie1->nom_categorie,
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'created_at'=>$d->created_at->format('Y-m-d'),
                    'etat'=>$etat
                ];
            array_push($result, $temp);
        }
        return($result);
    }
    public function chart2(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                return json_encode([
                    'chart1'=>$this->getchart2(),
                    'table'=>$this->essdashboardsuive()
                    ]);

            }
        }
    }
    public function esedashboardsuive(){
        $result = array();
        $categorie=CategorieDemande::where('role_id', 4)
                                    ->get();
        for ($i=0; $i < count($categorie); $i++) {
            $demandes = Demande::where('id_categorie', $categorie[$i]->id)->orderBy('created_at', 'DESC')->take(5)->get();
            foreach ($demandes as $d) {
                $etudiant = Etudiant::find($d->id_etudiant);
                $categorie1 = CategorieDemande::find($d->id_categorie);
                $user = User::find($etudiant->id_user);
                $etat = Etat::find($d->id_etat)->etat;
                $temp=[
                    'demande'=> $categorie1->nom_categorie,
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'created_at'=>$d->created_at->format('Y-m-d'),
                    'etat'=>$etat
                ];
                array_push($result, $temp);
            }
        }
        return $result;


    }

    public function chart3(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                return json_encode([
                    'chart1'=>$this->getchart3(),
                    'table'=>$this->demandeaffichiw()
                    ]);

            }
        }
    }
    public function dashboardese(){
        $result = array();
        $categorie=CategorieDemande::where('role_id', 4)
                                    ->get();
        $demande11=0;
        $demande22=0;
        $demande33=0;
        $demande44=0;
        for ($i=0; $i < count($categorie); $i++) {

            $demande1 = Demande::where('id_categorie', $categorie[$i]->id)->count();
            $demande2 = Demande::where('id_categorie', $categorie[$i]->id)->where('id_etat',2)->count();
            $demande3 = Demande::where('id_categorie', $categorie[$i]->id)->where('id_etat',3)->count();
            $demande4 = Demande::where('id_categorie', $categorie[$i]->id)->where('id_etat',4)->count();
            $demande11 = ($demande11 +$demande1);
            $demande22 = ($demande22 +$demande2);
            $demande33 = ($demande33 +$demande3);
            $demande44 = ($demande44 +$demande4);
        }
        // return $demande11;
        return view('ese.pages.dashboard', ['demande1'=>$demande11,
        'demande2'=>$demande22,
        'demande3'=>$demande33,
        'demande4'=>$demande44
        ]);
    }
    public function dashboardprof(){
        $result = array();
        $a=0;
        $b=0;
        $c=0;
        $d=0;
        $user=Auth::user()->id;
        $prof=Professeur::where('id_user', $user)->get();
        $element=Element::where('id_prof',$prof[0]->id)->get();
            for ($i=0; $i < count($element); $i++) {
                $rectifier = Rectifier::all()->where('id_element',$element[$i]->id)->count();
                $a=$rectifier+$a;

            }
            for ($i=0; $i < count($element); $i++) {
                $rectifier = Rectifier::all()->where('id_element',$element[$i]->id)->where('id_etat',1)->count();
                $b=$rectifier+$b;

            }
            for ($i=0; $i < count($element); $i++) {
                $rectifier = Rectifier::all()->where('id_element',$element[$i]->id)->where('id_etat',2)->count();
                $c=$rectifier+$c;

            }
            for ($i=0; $i < count($element); $i++) {
                $rectifier = Rectifier::all()->where('id_element',$element[$i]->id)->where('id_etat',4)->count();
                $d=$rectifier+$d;

            }
        $demande1=$a;
        $demande2=$b;
        $demande3=$c;
        $demande4=$d;
        return view('prof.pages.dashboard', ['demande1'=>$demande1,'demande2'=>$demande2,'demande3'=>$demande3,'demande4'=>$demande4]);
    }
    public function profdashboardsuive(){

        // $result = array();
        // $rectiflistesarrat = array();
        // $user=Auth::user()->id;
        // $prof = Professeur::where('id_user', $user)->get();
        // // $rectiflistes = Rectifier::where('id_element', $prof[0]->id)->orderBy('created_at', 'DESC')->take(5)->get();
        // foreach(Element::all() as $element){
        //     if($element->id_prof != $prof[0]->id){
        //         continue;
        //     }
        //     array_push($rectiflistesarrat, Rectifier::where('id_element', $element->id)->orderBy('created_at', 'DESC')->take(5)->get());
        // }

        // foreach ( collect($rectiflistesarrat) as $d) {
        //     $element = Element::find($d[0]->id_element)->nom;
        //     $etat = Etat::find($d[0]->id_etat)->etat;
        //     $etudiant = Etudiant::find($d[0]->id_etudiant);
        //     $categorie1 = CategorieDemande::find($d[0]->id_categorie);
        //     $user = User::find($etudiant->id_user);
        //     $temp = [
        //         'elem'=>$element,
        //         'nom' => $user->nom,
        //         'prenom' => $user->prenom,
        //         'created_at'=>$d[0]->created_at->format('Y-m-d'),
        //         'etat'=>$etat

        //     ];
        //     array_push($result, $temp);
        // }
        // return $result;
        // $result = array();
        // $array_rectifier = array();
        // $array_last = array();
        // $user=Auth::user()->id;
        // $prof=Professeur::where('id_user', $user)->get();
        // $element=Element::where('id_prof',$prof[0]->id)->get();
        // // $rectifier = Rectifier::all()->where('id_element',$element[0]->id)->where('id_etat', 1);
        //     for ($i=0; $i < count($element); $i++) {
        //         $rectifier = Rectifier::where('id_element', $element[$i]->id)->where('id_etat', 1)->get();
        //         array_push($result, $rectifier);
        //     }
        //     $array_rectifier = collect($result)->sortBy('created_at')->take(5);
        //     for ($i=0; $i < 5; $i++) {
        //         $test = $array_rectifier[$i];

        //     }
        //     foreach ( collect($test) as $d) {
        //         $element = Element::find($d->id_element)->nom;
        //         $etat = Etat::find($d->id_etat)->etat;
        //         $etudiant = Etudiant::find($d->id_etudiant);
        //         $categorie1 = CategorieDemande::find($d->id_categorie);
        //         $user = User::find($etudiant->id_user);
        //         $temp = [
        //             'elem'=>$element,
        //             'nom' => $user->nom,
        //             'prenom' => $user->prenom,
        //             'created_at'=>$d->created_at->format('Y-m-d'),
        //             'etat'=>$etat

        //         ];
        //         array_push($array_last, $temp);
        // }
        // return $result;



    }

    public function chart4(Request $request)
    {
        if ($request->ajax()) {
            if ($request->op == 'afficher') {
                return json_encode([
                    'chart1'=>$this->getchart4(),
                    'table'=>$this->getAllRectifier()
                    ]);

            }
        }
    }


}