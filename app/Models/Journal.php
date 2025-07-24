<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    // Pas besoin de préciser $table si ta table s'appelle 'journals'
    // protected $table = 'journaux'; // à utiliser seulement si tu utilises ce nom

    protected $fillable = ['user_id', 'nom', 'image', 'couleur', 'contenu'];

    // Relation vers User (propriétaire du journal)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation vers les entrées (si tu gardes les entrées multiples)
    public function entrees()
    {
        return $this->hasMany(EntreeJournal::class);
    }
}
