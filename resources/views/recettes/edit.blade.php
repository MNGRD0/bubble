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

    <!-- ✏️ Titre -->
    <h1 class="text-2xl font-semibold text-pink-600 text-center">✏️ Modifier la recette</h1>

    <!-- 🔴 Affichage des erreurs -->
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-lg space-y-1">
        @foreach ($errors->all() as $error)
            <div>❗ {{ $error }}</div>
        @endforeach
    </div>
@endif

    <!-- 📄 Formulaire -->
    <form method="POST" action="{{ route('recettes.update', $recette->id) }}" enctype="multipart/form-data" class="space-y-4 mt-4">
        @csrf
        @method('PUT')

        <!-- 🔘 Choisir la catégorie -->
        <div>
            <label for="categorie_recette_id" class="text-sm text-pink-600">Catégorie :</label>
            <select name="categorie_recette_id" id="categorie_recette_id" required
                class="w-full p-3 border border-pink-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-400">
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ $recette->categorie_recette_id == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- 📝 Titre -->
        <div>
            <label for="titre" class="text-sm text-pink-600">Titre :</label>
            <input type="text" name="titre" id="titre" value="{{ $recette->titre }}" required
                class="w-full p-3 border border-pink-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-400">
        </div>

        <!-- 🧂 Ingrédients -->
        <div>
            <label for="ingredients" class="text-sm text-pink-600">Ingrédients :</label>
            <textarea name="ingredients" id="ingredients" rows="4"
                class="w-full p-3 border border-pink-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-400">{{ $recette->ingredients }}</textarea>
        </div>

        <!-- 🔪 Étapes -->
        <div>
            <label for="etapes" class="text-sm text-pink-600">Étapes :</label>
            <textarea name="etapes" id="etapes" rows="6"
                class="w-full p-3 border border-pink-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-400">{{ $recette->etapes }}</textarea>
        </div>

        <!-- 📸 Image actuelle -->
        @if ($recette->image)
            <div class="text-sm text-gray-600">
                <p class="mb-2">Image actuelle :</p>
                <img src="{{ asset('storage/' . $recette->image) }}" alt="Image de la recette" class="w-full max-w-xs rounded-lg shadow">
            </div>
        @endif

        <!-- 📷 Nouvelle image -->
        <div>
            <label for="image" class="text-sm text-pink-600">Changer l’image (facultatif) :</label>
            <input type="file" name="image" id="image"
                class="w-full p-2 border border-pink-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-pink-400">
        </div>

        <!-- ✅ Bouton modifier -->
        <div class="text-center">
            <button type="submit"
                class="bg-pink-500 text-white py-2 px-6 rounded-lg hover:bg-pink-600 text-lg">
                💾 Sauvegarder les modifications
            </button>
        </div>
    </form>
</div>
@endsection
