<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Recette;
use App\Models\CategorieRecette;

class RecetteController extends Controller
{
    use AuthorizesRequests;

    // 🧁 Affiche toutes les recettes de l’utilisateur
    public function index()
    {
        $recettes = Recette::where('user_id', Auth::id())->with('categorie')->latest()->get();
        $categories = CategorieRecette::where('user_id', Auth::id())->get();

        return view('recettes.index', compact('recettes', 'categories'));
    }

    // ➕ Affiche le formulaire d’ajout d’une recette
    public function create($categorieId = null)
{
    $categories = CategorieRecette::where('user_id', Auth::id())->get();
    return view('recettes.create', compact('categories', 'categorieId'));
}

    // 💾 Enregistre une nouvelle recette
    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'ingredients' => 'nullable|string',
            'etapes' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'categorie_recette_id' => 'nullable|exists:categories_recettes,id',
        ]);

        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('recettes', 'public');
        }

        Recette::create($data);

        return redirect()->route('recettes.index')->with('success', 'Recette ajoutée !');
    }

    // 👁️ Affiche une recette individuellement
    public function show($id)
    {
        $recette = Recette::where('user_id', Auth::id())
                          ->where('id', $id)
                          ->with('categorie')
                          ->firstOrFail();

        return view('recettes.show', compact('recette'));
    }

    // 🖊️ Formulaire de modification
   

public function edit($id)
{
    $recette = Recette::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

    $categories = CategorieRecette::where('user_id', Auth::id())->get();

    return view('recettes.edit', compact('recette', 'categories'));
}


    // 🔄 Mise à jour d’une recette
    public function update(Request $request, Recette $recette)
    {
        $this->authorize('update', $recette);

        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'ingredients' => 'nullable|string',
            'etapes' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'categorie_recette_id' => 'nullable|exists:categories_recettes,id',
        ]);

        if ($request->hasFile('image')) {
            if ($recette->image) {
                Storage::disk('public')->delete($recette->image);
            }
            $data['image'] = $request->file('image')->store('recettes', 'public');
        }

        $recette->update($data);

        return redirect()->route('recettes.index')->with('success', 'Recette mise à jour !');
    }

    // ❌ Supprime une recette
    public function destroy(Recette $recette)
    {
        

        if ($recette->image) {
            Storage::disk('public')->delete($recette->image);
        }

        $recette->delete();

        return redirect()->route('recettes.index')->with('success', 'Recette supprimée.');
    }

    // ➕ Crée une catégorie
    public function storeCategorie(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
        ]);

        CategorieRecette::create([
            'nom' => $request->nom,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Catégorie ajoutée !');
    }

    // ❌ Supprime une catégorie
    public function destroyCategorie($id)
    {
        $categorie = CategorieRecette::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $this->authorize('delete', $categorie);

        $categorie->delete();

        return back()->with('success', 'Catégorie supprimée.');
    }

    // 📂 Affiche les recettes d'une catégorie
    public function showCategorie($id)
    {
        $categorie = CategorieRecette::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $recettes = Recette::where('categorie_recette_id', $categorie->id)
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('recettes.categorie', compact('categorie', 'recettes'));
    }
}
