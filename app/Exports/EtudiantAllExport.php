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

class EtudiantAllExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $result = array();
        $count = 0;
        foreach(Etudiant::all() as $etudiant){
            $user = User::find($etudiant->id_user);
            $filiere = Filiere::find($etudiant->id_filiere);
            $count += 1;
            $temp = [
                'id' => $count,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'cin' => $user->cin,
                'email' => $user->email,
                'filiere' => $filiere->code
            ];
            array_push($result, $temp);
        }

        return collect($result);
    }



    public function headings(): array
    {
        return [
                '#',
                'nom',
                'prenom',
                'cin',
                'email',
                'filiere'
        ];
    }
}
