<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'montant',
         'couleur',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }

    public function totalDepenses()
    {
        return $this->depenses()->sum('montant');
    }

    public function reste()
    {
        return $this->montant - $this->totalDepenses();
    }
}
