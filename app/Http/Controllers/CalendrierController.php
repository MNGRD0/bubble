<?php

namespace App\Http\Controllers;

use App\Models\Calendrier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendrierController extends Controller
{
    public function index()
    {
        $calendriers = Calendrier::where('user_id', Auth::id())->get();

        return view('calendriers.index', compact('calendriers'));
    }

    public function create()
    {
        return view('calendriers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        Calendrier::create([
            'nom' => $request->nom,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('calendriers.index')->with('success', 'Calendrier créé avec succès.');
    }

    public function edit(Calendrier $calendrier)
    {
        $this->authorize('update', $calendrier);

        return view('calendriers.edit', compact('calendrier'));
    }

    public function update(Request $request, Calendrier $calendrier)
    {
        $this->authorize('update', $calendrier);

        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $calendrier->update([
            'nom' => $request->nom,
        ]);

        return redirect()->route('calendriers.index')->with('success', 'Calendrier mis à jour.');
    }

    public function destroy(Calendrier $calendrier)
    {
        $this->authorize('delete', $calendrier);

        $calendrier->delete();

        return redirect()->route('calendriers.index')->with('success', 'Calendrier supprimé.');
    }
}
