@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-md space-y-6">

    <!-- 🔙 Retour -->
    <div class="flex justify-start mb-4">
        <a href="{{ route('recettes.index') }}" class="text-pink-500 text-lg hover:text-pink-600 flex items-center space-x-2">
            <span class="text-pink-500 text-xl">←</span>
            <span>Retour aux catégories</span>
        </a>
    </div>

    <!-- 🏷️ Nom de la catégorie -->
    <h1 class="text-2xl font-semibold text-pink-600 text-center">{{ $categorie->nom }}</h1>

    <!-- 🍰 Bouton Ajouter une recette -->
    <div class="text-center">
        <a href="{{ route('recettes.create', $categorie->id) }}"
           class="inline-block bg-pink-500 text-white py-2 px-4 rounded-lg hover:bg-pink-600 mt-4">
            ➕ Ajouter une recette
        </a>
    </div>

    <!-- 📋 Liste des recettes -->
    <div class="mt-8 space-y-4">
        @forelse($recettes as $recette)
            <a href="{{ route('recettes.show', $recette->id) }}"
   class="flex bg-pink-100 hover:bg-pink-200 rounded-lg p-4 shadow transition items-center gap-4">
    
    {{-- Image à gauche --}}
    @if($recette->image)
        <img src="{{ asset('storage/' . $recette->image) }}" alt="Image"
             class="w-16 h-16 rounded object-cover flex-shrink-0">
    @endif

    {{-- Texte à droite --}}
    <div class="flex flex-col justify-center">
        <h2 class="text-lg font-semibold text-pink-700 mb-1">{{ $recette->titre }}</h2>
        <p class="text-sm text-gray-600 line-clamp-2">
            {{ Str::limit(strip_tags($recette->etapes), 80) }}
        </p>
    </div>
</a>

        @empty
            <p class="text-gray-600 text-sm">Aucune recette dans cette catégorie pour le moment.</p>
        @endforelse
    </div>

</div>
@endsection
