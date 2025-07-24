@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8 p-6 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold text-pink-600 mb-4">➕ Ajouter un fichier</h2>

    <form method="POST" action="{{ route('fichiers.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Nom du fichier --}}
        <div class="mb-4">
            <label class="block text-pink-700 font-semibold">Nom</label>
            <input type="text" name="nom" required class="w-full rounded p-2 border border-pink-300">
        </div>

        {{-- Fichier à uploader --}}
        <div class="mb-4">
            <label class="block text-pink-700 font-semibold">Fichier</label>
            <input type="file" name="fichier" required class="w-full border border-pink-300 rounded p-2">
        </div>

        {{-- Dossier associé --}}
        <input type="hidden" name="dossier_id" value="{{ request('dossier_id') }}">

        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
            Enregistrer
        </button>
    </form>
</div>
@endsection
