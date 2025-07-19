@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    <!-- ✅ Message de succès -->
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded shadow text-sm">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-2xl font-semibold text-pink-600 text-center">Modifier la catégorie</h1>

    <form action="{{ route('recettes.categories_recettes.update', $categorie->id) }}" method="POST">


        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nom" class="block text-sm font-medium text-gray-700">Nom de la catégorie</label>
            <input type="text" name="nom" id="nom"
                   value="{{ old('nom', $categorie->nom) }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500">
            @error('nom')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('recettes.index') }}" class="text-sm text-gray-500 hover:underline">
                ← Retour
            </a>

            <button type="submit"
                    class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
                💾 Enregistrer
            </button>
        </div>
    </form>

</div>
@endsection
