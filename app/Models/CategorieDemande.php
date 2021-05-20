<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieDemande extends Model
{
    use HasFactory;


    protected $table = 'categorie_demandes';

    public function role(){
        return $this->belongsTo(Role::class);
    }
}
