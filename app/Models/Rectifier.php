<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rectifier extends Model
{
    use HasFactory;
    protected $table = "rectifiers";

    protected $fillable = [
        'id_etudiant',
        'id_etat',
        'id_module' ,
        'id_element' ,
        'commentaire'
    ];
}
