<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_filiere',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function demande(){
        return $this->hasMany(Demande::class);
    }
}
