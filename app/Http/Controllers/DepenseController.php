<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Depense;
use App\Models\Budget;

class DepenseController extends Controller
{
    // ➕ Formulaire d'ajout de dépense
    public function create($budgetId)
    {
        $budget = Budget::where('id', $budgetId)->where('user_id', Auth::id())->firstOrFail();
        return view('depenses.create', compact('budget'));
    }

    // 💾 Enregistrement d'une dépense
    public function store(Request $request, $budgetId)
    {
        $budget = Budget::where('id', $budgetId)->where('user_id', Auth::id())->firstOrFail();

        $data = $request->validate([
            'description' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
        ]);

        $data['budget_id'] = $budget->id;

        Depense::create($data);

        return redirect()->route('budget.index')->with('success', 'Dépense ajoutée avec succès.');
    }

    // 🗑️ Suppression d’une dépense
    public function destroy($id)
    {
        $depense = Depense::findOrFail($id);

        $budget = Budget::where('id', $depense->budget_id)->where('user_id', Auth::id())->firstOrFail();

        $depense->delete();

        return redirect()->route('budget.index')->with('success', 'Dépense supprimée.');
    }
}
