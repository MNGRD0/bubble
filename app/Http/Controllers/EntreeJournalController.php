<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\EntreeJournal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EntreeJournalController extends Controller
{
    use AuthorizesRequests; // ✅ C'est ça qui manquait

    public function store(Request $request, Journal $journal)
    {
        $this->authorize('update', $journal); // Vérifie que l'utilisateur peut écrire dans ce journal

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);

        $journal->entrees()->create([
            'titre' => $validated['titre'],
            'contenu' => $validated['contenu'],
        ]);

        return redirect()->route('journaux.show', $journal)
            ->with('success', '✍️ Entrée enregistrée avec succès !');
    }
}
