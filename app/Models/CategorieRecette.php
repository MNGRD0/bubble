<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieRecette extends Model
{
    use HasFactory;

    protected $table = 'categories_recettes';

    protected $fillable = [
        'nom',
        'user_id',
    ];

    public function recettes()
    {
        return $this->hasMany(Recette::class, 'categorie_recette_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
