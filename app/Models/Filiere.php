<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    protected $table="filieres";

    protected $fillable = [
        'code',
        'libelle',
    ];

    public function module(){
        return $this->hasMany(Module::class);
    }
}
