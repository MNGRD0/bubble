@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md space-y-6">

    <!-- 🔙 Bouton retour -->
    <div class="flex justify-start">
        <a href="{{ route('recettes.index') }}" class="text-pink-500 hover:text-pink-600 text-lg flex items-center space-x-1">
            <span>←</span>
            <span>Retour aux catégories</span>
        </a>
    </div>

    <!-- 📋 Titre -->
    <h1 class="text-2xl font-semibold text-pink-600 text-center">🍰 Ajouter une recette</h1>

    <!-- 🔴 Affichage des erreurs -->
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-lg space-y-1">
        @foreach ($errors->all() as $error)
            <div>❗ {{ $error }}</div>
        @endforeach
    </div>
@endif

    <!-- 📄 Formulaire -->
    <form method="POST" action="{{ route('recettes.store') }}" enctype="multipart/form-data" class="space-y-4 mt-4">
        @csrf

        <!-- 🔘 Choisir une catégorie -->
        <div>
            <label for="categorie_recette_id" class="text-sm text-pink-600">Catégorie :</label>
            <select name="categorie_recette_id" id="categorie_recette_id" required
                class="w-full p-3 border border-pink-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-400">
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}"
                        {{ old('categorie_recette_id', $categorieId ?? '') == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- 📝 Titre -->
        <div>
            <label for="titre" class="text-sm text-pink-600">Titre de la recette :</label>
            <input type="text" name="titre" id="titre" value="{{ old('titre') }}" required
                class="w-full p-3 border border-pink-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-400"
                placeholder="Ex : Crêpes moelleuses">
        </div>

        <!-- 🧂 Ingrédients -->
        <div>
            <label for="ingredients" class="text-sm text-pink-600">Ingrédients :</label>
            <textarea name="ingredients" id="ingredients" rows="4"
                class="w-full p-3 border border-pink-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-400"
                placeholder="Liste des ingrédients, séparés par des virgules...">{{ old('ingredients') }}</textarea>
        </div>

        <!-- 🔪 Étapes -->
        <div>
            <label for="etapes" class="text-sm text-pink-600">Étapes :</label>
            <textarea name="etapes" id="etapes" rows="6"
                class="w-full p-3 border border-pink-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-400"
                placeholder="Décris les étapes de préparation...">{{ old('etapes') }}</textarea>
        </div>

        <!-- 📸 Image -->
        <div>
            <label for="image" class="text-sm text-pink-600">Image (facultatif) :</label>
            <input type="file" name="image" id="image"
                class="w-full p-2 border border-pink-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-pink-400">
        </div>

        <!-- ✅ Bouton ajouter -->
        <div class="text-center">
            <button type="submit"
                class="bg-pink-500 text-white py-2 px-6 rounded-lg hover:bg-pink-600 text-lg">
                ➕ Ajouter la recette
            </button>
        </div>
    </form>
</div>
@endsection
