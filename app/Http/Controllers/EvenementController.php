<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Models\Sticker;
use App\Models\Calendrier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EvenementController extends Controller
{
    public function index()
    {
        $evenements = Evenement::where('user_id', Auth::id())
            ->with(['sticker', 'calendrier'])
            ->orderBy('date', 'asc')
            ->get();

        return view('evenements.index', compact('evenements'));
    }

    public function create()
    {
        $stickers = Sticker::where('user_id', Auth::id())->get();
        $calendriers = Calendrier::where('user_id', Auth::id())->get();

        return view('evenements.create', compact('stickers', 'calendriers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'date' => 'required|date',
            'sticker_id' => 'required|exists:stickers,id',
            'calendrier_id' => 'required|exists:calendriers,id',
            'description' => 'nullable|string',
        ]);

        Evenement::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'date' => $request->date,
            'sticker_id' => $request->sticker_id,
            'calendrier_id' => $request->calendrier_id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('evenements.index')->with('success', 'Événement ajouté avec succès.');
    }

    public function edit(Evenement $evenement)
    {
        $this->authorize('update', $evenement);

        $stickers = Sticker::where('user_id', Auth::id())->get();
        $calendriers = Calendrier::where('user_id', Auth::id())->get();

        return view('evenements.edit', compact('evenement', 'stickers', 'calendriers'));
    }

    public function update(Request $request, Evenement $evenement)
    {
        $this->authorize('update', $evenement);

        $request->validate([
            'titre' => 'required|string|max:255',
            'date' => 'required|date',
            'sticker_id' => 'required|exists:stickers,id',
            'calendrier_id' => 'required|exists:calendriers,id',
            'description' => 'nullable|string',
        ]);

        $evenement->update($request->only(['titre', 'description', 'date', 'sticker_id', 'calendrier_id']));

        return redirect()->route('evenements.index')->with('success', 'Événement modifié.');
    }

    public function destroy(Evenement $evenement)
    {
        $this->authorize('delete', $evenement);
        $evenement->delete();

        return redirect()->route('evenements.index')->with('success', 'Événement supprimé.');
    }

    /**
     * Affiche le calendrier mensuel avec les événements groupés par jour.
     */
    public function vueMois($year = null, $month = null)
    {
        // Si aucune année/mois n'est fourni → date actuelle
        $date = Carbon::createFromDate($year ?? now()->year, $month ?? now()->month, 1)->startOfMonth();

        $evenements = Evenement::whereMonth('date', $date->month)
            ->whereYear('date', $date->year)
            ->where('user_id', Auth::id())
            ->with('sticker')
            ->get()
            ->groupBy(function ($event) {
                return $event->date->format('Y-m-d');
            });

        return view('evenements.mois', [
            'date' => $date,
            'evenements' => $evenements,
        ]);
    }
}
