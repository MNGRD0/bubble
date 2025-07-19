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
        'date',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
