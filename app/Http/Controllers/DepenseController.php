<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Budget;
use Illuminate\Http\Request;

class DepenseController extends Controller
{
    public function create($budgetId)
    {
        $budget = Budget::where('user_id', auth()->id())->findOrFail($budgetId);
        return view('depenses.create', compact('budget'));
    }

 public function store(Request $request, $budgetId)
{
    $request->validate([
        'libelle' => 'required|string|max:255',
        'montant' => 'required|numeric|min:0.01',
        'type'    => 'required|in:depense,entree',
    ]);

    $budget = Budget::where('user_id', auth()->id())->findOrFail($budgetId);

    // Force proprement les données
    $type = strtolower(trim($request->type));
    $montant = abs($request->montant); // on stocke TOUJOURS des positifs

    $budget->depenses()->create([
        'nom'     => $request->libelle,
        'montant' => $montant,
        'type'    => $type,
        'user_id' => auth()->id(),
    ]);

    return redirect()->route('budgets.show', $budget->id)->with('success', 'Ajout effectué avec succès !');
}





    public function destroy($id)
    {
        $depense = Depense::findOrFail($id);

        if ($depense->user_id !== auth()->id()) {
            abort(403);
        }

        $depense->delete();

        return redirect()->back()->with('success', 'Dépense supprimée.');
    }
}
