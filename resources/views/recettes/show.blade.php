@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-2xl shadow-md mt-6">

    {{-- Bouton retour --}}
    <a href="{{ route('recettes.categorie.show', $recette->categorie_recette_id) }}" class="text-pink-500 hover:underline mb-4 inline-block">
        ← Retour à la catégorie
    </a>

    {{-- Image si présente --}}
    @if($recette->image)
        <div class="w-60 mx-auto mb-4">
            <img src="{{ asset('storage/' . $recette->image) }}" alt="Image de la recette"
                 class="rounded-xl shadow object-cover w-full h-40">
        </div>
    @endif

    {{-- Titre --}}
    <h1 class="text-3xl font-bold text-pink-600 mb-6 text-center">{{ $recette->titre }}</h1>

    {{-- Ingrédients --}}
    @if($recette->ingredients)
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">📝 Ingrédients</h2>
            <div class="bg-pink-50 p-4 rounded-lg whitespace-pre-line text-gray-700 pt-0">
                {{ $recette->ingredients }}
            </div>
        </div>
    @endif

    {{-- Étapes --}}
    @if($recette->etapes)
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">👩‍🍳 Étapes</h2>
            <div class="bg-pink-50 p-4 rounded-lg whitespace-pre-line text-gray-700 pt-0">
                {{ $recette->etapes }}
            </div>
        </div>
    @endif

    {{-- Infos supplémentaires --}}
    <div class="text-sm text-gray-500">
        <p>Catégorie : <span class="font-semibold text-pink-500">{{ $recette->categorie->nom ?? 'Non catégorisée' }}</span></p>
        <p>Ajoutée le : {{ $recette->created_at->format('d/m/Y') }}</p>
    </div>

    {{-- Boutons --}}
    <div class="mt-6 flex justify-between">
        <a href="{{ route('recettes.edit', $recette->id) }}"
           class="px-4 py-2 bg-pink-500 text-white rounded-lg shadow hover:bg-pink-600">
            ✏️ Modifier
        </a>

        <form action="{{ route('recettes.destroy', $recette->id) }}" method="POST"
      onsubmit="return confirm('Supprimer cette recette ?')">
    @csrf
    @method('DELETE')
    <button type="submit"
        class="w-10 h-10 flex items-center justify-center rounded-full bg-pink-500 text-white font-bold hover:bg-pink-600 transition"
        title="Supprimer cette recette" aria-label="Supprimer cette recette">
        −
    </button>
</form>


    </div>
</div>
@endsection
