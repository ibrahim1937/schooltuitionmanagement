<?php

namespace App\Imports;

use App\User;
use App\Etudiant;
use App\Filiere;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use collect;

class EtudiantAllImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            Employee::create([
                'id_filiere' => Filiere::where('code',$row[5])->get()->id,
            ]);

            User::create([
                'nom' => $row[1],
                'prenom' => $row[2],
                'cin' => $row[3],
                'email' => $row[4],
            ]);
        }
    }
}
