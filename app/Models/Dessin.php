<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dessin extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'chemin',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
