<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DossierController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $dossiers = Dossier::where('user_id', Auth::id())
            ->whereNull('parent_id')
            ->with('enfants')
            ->get();

        return view('dossiers.index', compact('dossiers'));
    }

    public function create()
    {
        $dossiers = Dossier::where('user_id', Auth::id())->get();
        return view('dossiers.create', compact('dossiers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'couleur' => 'nullable|string',
            'parent_id' => 'nullable|exists:dossiers,id',
        ]);

        $validated['user_id'] = Auth::id();

        $dossierCree = Dossier::create($validated);

        // Si c’est un sous-dossier, on reste sur la page du dossier parent
        if ($request->filled('parent_id')) {
            return redirect()
                ->route('dossiers.show', $request->parent_id)
                ->with('success', 'Sous-dossier créé.');
        }

        // Sinon, redirection vers index
        return redirect()->route('dossiers.index')->with('success', 'Dossier créé.');
    }

    public function edit(Dossier $dossier)
    {
        $this->authorize('update', $dossier);

        $dossiers = Dossier::where('user_id', Auth::id())->get();

        return view('dossiers.edit', compact('dossier', 'dossiers'));
    }

    public function update(Request $request, Dossier $dossier)
    {
        $this->authorize('update', $dossier);

        $request->validate([
            'nom' => 'required|string|max:255',
            'couleur' => 'nullable|string',
            'parent_id' => 'nullable|exists:dossiers,id',
        ]);

        $dossier->update($request->only(['nom', 'couleur', 'parent_id']));

        return redirect()->route('dossiers.index')->with('success', 'Dossier mis à jour.');
    }

    public function destroy(Dossier $dossier)
    {
        $this->authorize('delete', $dossier);
        $dossier->delete();

        return redirect()->route('dossiers.index')->with('success', 'Dossier supprimé.');
    }

    public function show(Dossier $dossier)
    {
        $this->authorize('view', $dossier);

        $dossier->load(['fichiers', 'enfants']); // Charger les sous-dossiers aussi

        return view('dossiers.show', compact('dossier'));
    }
}
