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

class Etudiantsample implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        return collect(array([
            'nom' => '',
            'prenom' => '',
            'cin' => '',
            'email' => ''
        ]));
    }
    public function headings(): array
    {
        return [
        
            'nom',
            'prenom',
            'cin',
            'email'
            
        ];
    }
}
