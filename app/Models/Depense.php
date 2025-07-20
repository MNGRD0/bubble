<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'nom',
        'montant',
        'type', // 🟢 AJOUTE CE CHAMP !
        'date',
        'user_id', // aussi important si tu veux filtrer par utilisateur
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
