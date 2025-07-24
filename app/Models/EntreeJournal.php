<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntreeJournal extends Model
{
    use HasFactory;

    protected $table = 'entree_journals';

    protected $fillable = ['journal_id', 'titre', 'contenu'];

    // Relation vers le journal parent
    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
}
