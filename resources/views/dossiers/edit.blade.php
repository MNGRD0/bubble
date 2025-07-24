@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold text-pink-600 mb-4">✏️ Modifier le dossier</h2>

    <form method="POST" action="{{ route('dossiers.update', $dossier) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="block text-sm font-semibold text-pink-700">Nom du dossier</label>
            <input type="text" name="nom" value="{{ old('nom', $dossier->nom) }}" required
                   class="w-full rounded border border-pink-300 p-2">
        </div>

        <div class="mb-3">
            <label class="block text-sm font-semibold text-pink-700">Couleur du dossier</label>
            <input type="color" name="couleur" value="{{ old('couleur', $dossier->couleur ?? '#ffc0cb') }}"
                   class="w-16 h-10 border border-pink-300 rounded">
        </div>

        {{-- Si c'est un sous-dossier, on conserve le parent_id en caché --}}
        @if ($dossier->parent_id)
            <input type="hidden" name="parent_id" value="{{ $dossier->parent_id }}">
        @endif

        <div class="flex justify-between mt-4">
            <a href="{{ url()->previous() }}" class="text-sm text-gray-600 hover:underline">← Retour</a>
            <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
