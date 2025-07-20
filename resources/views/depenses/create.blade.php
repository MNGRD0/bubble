@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">
    <h1 class="text-2xl font-bold text-center text-pink-600">➕ Ajouter une Dépense ou une Entrée</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('depenses.store', $budget->id) }}" method="POST" class="space-y-4">
        @csrf

        <!-- Libellé -->
        <div>
            <label for="libelle" class="block text-sm font-medium text-gray-700">Libellé</label>
            <input type="text" name="libelle" id="libelle"
                   value="{{ old('libelle') }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500"
                   placeholder="Ex : courses, salaire, remboursement...">
        </div>

        <!-- Montant -->
        <div>
            <label for="montant" class="block text-sm font-medium text-gray-700">Montant (€)</label>
            <input type="number" name="montant" id="montant"
                   step="0.01" min="0"
                   value="{{ old('montant') }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500">
        </div>

        <!-- Type -->
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
            <select name="type" id="type"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500">
                <option value="depense" {{ old('type') === 'depense' ? 'selected' : '' }}>Dépense</option>
                <option value="entree" {{ old('type') === 'entree' ? 'selected' : '' }}>Entrée d'argent</option>
            </select>
        </div>

        <!-- Bouton -->
        <div class="text-center">
            <button type="submit"
                    class="bg-pink-500 text-white px-6 py-2 rounded-full hover:bg-pink-600 transition">
                💾 Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
