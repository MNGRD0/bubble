<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    use HasFactory;

    protected $fillable = [
    'titre',
    'ingredients',
    'etapes',
    'image',
    'categorie_recette_id',
    'user_id', // ← nécessaire pour le save
];


    // 🔗 Chaque recette appartient à une catégorie personnalisée
    public function categorie()
    {
        return $this->belongsTo(CategorieRecette::class, 'categorie_recette_id');
    }

    // 🔗 Chaque recette appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
