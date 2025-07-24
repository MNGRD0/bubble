@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8 p-6 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold text-pink-600 mb-4">Créer un nouveau dossier</h2>

    <form method="POST" action="{{ route('dossiers.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-pink-700 font-semibold">Nom</label>
            <input type="text" name="nom" required class="w-full rounded p-2 border border-pink-300">
        </div>

        <div class="mb-4">
            <label class="block text-pink-700 font-semibold">Couleur (ex. #ffc0cb)</label>
            <input type="color" name="couleur" class="w-16 h-10 p-0 border border-pink-300 rounded">
        </div>

        <div class="mb-4">
            <label class="block text-pink-700 font-semibold">Dossier parent (optionnel)</label>
            <select name="parent_id" class="w-full rounded border border-pink-300">
                <option value="">Aucun</option>
                @foreach ($dossiers as $d)
                    <option value="{{ $d->id }}">{{ $d->nom }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
            Créer
        </button>
    </form>
</div>
@endsection
