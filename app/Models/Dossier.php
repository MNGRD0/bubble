<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'couleur',
        'user_id',
        'parent_id',
    ];

    // Le propriétaire du dossier
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Sous-dossiers
    public function enfants()
    {
        return $this->hasMany(Dossier::class, 'parent_id');
    }

    // Dossier parent
    public function parent()
    {
        return $this->belongsTo(Dossier::class, 'parent_id');
    }

    // Fichiers dans ce dossier
    public function fichiers()
    {
        return $this->hasMany(Fichier::class);
    }
}
