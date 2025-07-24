<?php

namespace App\Http\Controllers;

use App\Models\Fichier;
use App\Models\Dossier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class FichierController extends Controller
{
    use AuthorizesRequests;

    public function create()
    {
        $dossiers = Dossier::where('user_id', Auth::id())->get();
        return view('fichiers.create', compact('dossiers'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'fichier' => 'required|file',
        'dossier_id' => 'required|exists:dossiers,id',
    ]);

    $chemin = $request->file('fichier')->store('fichiers', 'public');

    \App\Models\Fichier::create([
        'nom' => $request->nom,
        'chemin' => $chemin,
        'dossier_id' => $request->dossier_id,
        'user_id' => auth()->id(),
    ]);

    return redirect()->route('dossiers.show', $request->dossier_id)
                     ->with('success', 'Fichier ajouté.');
}


    public function destroy(Fichier $fichier)
    {
        $this->authorize('delete', $fichier);

        Storage::disk('public')->delete($fichier->chemin);
        $fichier->delete();

        return back()->with('success', 'Fichier supprimé.');
    }
}
