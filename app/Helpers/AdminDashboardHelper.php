<?php



namespace App\Helpers;

use App\Models\User;
use App\Models\Log;
use App\Models\Professeur;
use App\Models\AgentScolarite;
use App\Models\AgentExamen;
use App\Models\Filiere;
use App\Models\Module;
use App\Models\Element;
use App\Models\Etudiant;
use Carbon\Carbon;
use DB;


class AdminDashboardHelper {



    public function getAllDashboardDetails(){

    }


    public static function getEtudiantStats(){

        $labels = array();
        $dataset = array();
        foreach(Filiere::all() as $filiere){
            $count = Etudiant::where('id_filiere', $filiere->id)->count();
            array_push($labels, $filiere->code);
            array_push($dataset, $count);
        }

        return [
            'labels' => $labels,
            'dataset' => $dataset,
            'title' => 'Etudiants par filiere',
            'xtitle' => 'Filiere',
            'ytitle' => 'Nombre'
        ];
    }

    public static function getModuleStats(){

        $labels = array();
        $dataset = array();
        foreach(Filiere::all() as $filiere){
            $count = Module::where('id_filiere', $filiere->id)->count();
            array_push($labels, $filiere->code);
            array_push($dataset, $count);
        }

        return [
            'labels' => $labels,
            'dataset' => $dataset,
            'title' => 'Modules par filiere',
            'xtitle' => 'Filiere',
            'ytitle' => 'Nombre'
        ];
    }

}
