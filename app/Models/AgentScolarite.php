<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentScolarite extends Model
{
    use HasFactory;

    protected $table = "agent_scolarites";

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
