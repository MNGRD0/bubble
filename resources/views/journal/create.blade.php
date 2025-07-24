@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-2xl shadow-xl">
    <h1 class="text-2xl font-bold text-center text-pink-600 mb-6">🎀 Créer un nouveau journal</h1>

    <form action="{{ route('journaux.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Nom -->
        <div class="mb-4">
            <label for="nom" class="block text-sm font-semibold text-gray-700 mb-1">Nom du journal</label>
            <input type="text" name="nom" id="nom" class="w-full p-2 rounded-xl border border-pink-300 focus:ring focus:ring-pink-200" required>
        </div>

        <!-- Couleur -->
        <div class="mb-4">
            <label for="couleur" class="block text-sm font-semibold text-gray-700 mb-1">Couleur du journal</label>
            <input type="color" name="couleur" id="couleur" value="#F9A8D4" class="w-16 h-10 rounded-lg border-2 border-pink-200">
        </div>

        <!-- Image -->
        <div class="mb-6">
            <label for="image" class="block text-sm font-semibold text-gray-700 mb-1">Image de couverture (facultative)</label>
            <input type="file" name="image" id="image" accept="image/*" class="block w-full text-sm text-gray-600 file:bg-pink-100 file:border-0 file:rounded-xl file:text-pink-700 file:px-4 file:py-2 hover:file:bg-pink-200">
        </div>

        <!-- Bouton -->
        <div class="text-center">
            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-6 rounded-xl shadow">
                💾 Créer le journal
            </button>
        </div>
    </form>
</div>
@endsection
