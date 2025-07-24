<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class JournalController extends Controller
{
    use AuthorizesRequests;
    public function index()
{
    $journaux = Journal::where('user_id', Auth::id())
                      ->orderBy('updated_at', 'desc')
                      ->get();

    return view('journal.index', compact('journaux'));
}


    public function create()
    {
        return view('journal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'couleur' => 'nullable|string|max:7',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('journaux', 'public');
        }

        Journal::create([
            'user_id' => Auth::id(),
            'nom' => $request->nom,
            'couleur' => $request->couleur,
            'image' => $imagePath,
        ]);

        return redirect()->route('journaux.index')->with('success', 'Journal créé avec succès !');
    }

    public function show(Journal $journal)
{
    if ($journal->user_id !== auth()->id()) {
        abort(403, 'Accès interdit');
    }

    return view('journal.show', compact('journal'));
}

public function update(Request $request, Journal $journal)
{
    $this->authorize('update', $journal);

    $request->validate([
        'nom' => 'required|string|max:255',
        'couleur' => 'nullable|string|max:7',
        'image' => 'nullable|image|max:2048',
        'contenu' => 'nullable|string',
    ]);

    $journal->update([
        'nom' => $request->nom,
        'couleur' => $request->couleur,
        'contenu' => $request->contenu,
        'image' => $request->hasFile('image')
            ? $request->file('image')->store('journaux', 'public')
            : $journal->image,
    ]);

    return redirect()->route('journaux.show', $journal)->with('success', 'Journal mis à jour !');
}

public function destroy(Journal $journal)
{
    $this->authorize('delete', $journal); // vérifie si l'utilisateur a le droit de supprimer

    // Supprime l’image associée si elle existe
    if ($journal->image) {
        \Storage::disk('public')->delete($journal->image);
    }

    $journal->delete();

    return redirect()->route('journaux.index')->with('success', 'Journal supprimé avec succès !');
}




}

