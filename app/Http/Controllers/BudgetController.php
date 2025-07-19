<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Depense;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::where('user_id', auth()->id())->with('depenses')->get();

        return view('budget.index', compact('budgets'));
    }

   public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'montant' => 'required|numeric|min:0',
        'couleur' => 'nullable|string',
    ]);

    $budget = Budget::create([
        'user_id' => auth()->id(),
        'nom' => $request->nom,
        'montant' => $request->montant,
    ]);

    // On stocke la couleur en session (liée à l'ID de l'enveloppe)
    $couleurs = session('budget_couleurs', []);
    $couleurs[$budget->id] = $request->couleur;
    session(['budget_couleurs' => $couleurs]);

    return redirect()->route('budgets.index')->with('success', 'Enveloppe créée avec succès.');
}


    public function show($id)
    {
        $budget = Budget::where('user_id', auth()->id())->with('depenses')->findOrFail($id);
        return view('budget.show', compact('budget'));
    }

    public function addDepense(Request $request, $budgetId)
    {
        $budget = Budget::where('user_id', auth()->id())->findOrFail($budgetId);

        $request->validate([
            'nom' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'date' => 'nullable|date',
        ]);

        $budget->depenses()->create($request->only('nom', 'montant', 'date'));

        return redirect()->back()->with('success', 'Dépense ajoutée avec succès.');
    }

    public function destroyDepense($id)
    {
        $depense = Depense::findOrFail($id);

        // sécurité : vérifie que la dépense appartient bien à l'utilisateur
        if ($depense->budget->user_id !== auth()->id()) {
            abort(403);
        }

        $depense->delete();

        return redirect()->back()->with('success', 'Dépense supprimée.');
    }

    public function destroyBudget($id)
    {
        $budget = Budget::where('user_id', auth()->id())->findOrFail($id);
        $budget->delete();

        return redirect()->back()->with('success', 'Enveloppe supprimée.');
    }

    public function create()
{
    return view('budget.create');
}

public function edit($id)
{
    $budget = Budget::where('user_id', auth()->id())->findOrFail($id);
    return view('budget.edit', compact('budget'));
}

public function update(Request $request, $id)
{
    $budget = Budget::where('user_id', auth()->id())->findOrFail($id);

    $request->validate([
        'nom' => 'required|string|max:255',
        'montant' => 'required|numeric|min:0',
    ]);

    $budget->update([
        'nom' => $request->nom,
        'montant' => $request->montant,
    ]);

    return redirect()->route('budget.index')->with('success', 'Enveloppe mise à jour avec succès.');
}


}
