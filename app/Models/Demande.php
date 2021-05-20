<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;
    protected $table = "demandes";

    protected $fillable = [
        'id_etudiant',
        'id_etat',
        'id_categorie' ,
        'Date_livraison'
    ];
}