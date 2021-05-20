<?php

namespace App\Exports;

use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EtudiantExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $id_filiere;
    public function __construct($id_filiere){
        $this->id_filiere = $id_filiere;
    }
    public function collection()
    {
        $count = 0;
        $result = array();
        // array_push($result , [
        //     'number' => 'id',
        //     'nom' => 'nom',
        //     'prenom' => 'prenom',
        //     'cin' => 'cin',
        //     'email' => 'email'
        // ]);
        // if(!($this->id_filiere == 0)){
            foreach(Etudiant::where('id_filiere', $this->id_filiere)->get() as $etudiant){
                $count += 1;
                $user = User::find($etudiant->id_user);
                $temp = [
                    'number' => $count,
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'cin' => $user->cin,
                    'email' => $user->email
                ];
                array_push($result, $temp);
    
        //     }

        // } else {

        //     foreach(Etudiant::where('id_filiere', $this->id_filiere)->get() as $etudiant){
        //         $user = User::find($etudiant->id_user);
        //         $temp = [
        //             'id' => $etudiant->id,
        //             'nom' => $user->nom,
        //             'prenom' => $user->prenom,
        //             'cin' => $user->cin,
        //             'email' => $user->email
        //         ];
        //         array_push($result, $temp);
    
        //     }
        }
        

        return collect($result);
    }

    public function headings(): array
    {
        return [
            [
                'Filiere:',
                ''.Filiere::find($this->id_filiere)->code,
                '',
                '',
                ''
            ],
            [
            '#',
            'nom',
            'prenom',
            'cin',
            'email'
            ]
        ];
    }

    // public function registerEvents(): array
    // {
    // return [

    //     AfterSheet::class    => function(AfterSheet $event) {

    //         $event->sheet->setColumnFormat([
    //             'id' => 'teet'
    //         ]);
    //     }
    // ];
    // }
}
