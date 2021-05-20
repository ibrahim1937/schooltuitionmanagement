<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $table = 'modules';

    protected $fillable = [
        'nom',
        'id_filiere',
    ];

    public function filiere(){
        return $this->belongsTo(Filiere::class);
    }
}
