<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fichier extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'chemin',
        'user_id',
        'dossier_id',
    ];

    // Propriétaire
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Dossier dans lequel le fichier est
    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }
}
