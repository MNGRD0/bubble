<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Recette;
use App\Models\CategorieRecette;


class CategorieRecetteController extends Controller
{
    use AuthorizesRequests;


public function edit($id)
{
    $categorie = CategorieRecette::where('user_id', auth()->id())->findOrFail($id);
    return view('categories_recettes.edit', compact('categorie'));
}

public function update(Request $request, $id)
{
    $categorie = CategorieRecette::where('user_id', auth()->id())->findOrFail($id);

    $request->validate([
        'nom' => 'required|string|max:255',
    ]);

    $categorie->nom = $request->nom;
    $categorie->save();

    return redirect()->route('recettes.categorie.show', $categorie->id)
                     ->with('success', 'Catégorie mise à jour avec succès.');
}

}