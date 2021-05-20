<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = "logs";

    protected $fillable = [
        'id_user',
        'last_seen_at',
        'end_session_at',
    ];
}
