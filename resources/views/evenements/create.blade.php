@extends('layouts.app')

@section('content')
<div class="container max-w-lg">
    <h2 class="text-xl font-bold mb-4">Ajouter un événement</h2>

    <form action="{{ route('evenements.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Titre</label>
            <input type="text" name="titre" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Date et heure</label>
            <input type="datetime-local" name="date" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Sticker</label>
            <select name="sticker_id" class="w-full p-2 border rounded" required>
                @foreach ($stickers as $sticker)
                    <option value="{{ $sticker->id }}">{{ $sticker->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Calendrier</label>
            <select name="calendrier_id" class="w-full p-2 border rounded" required>
                @foreach ($calendriers as $calendrier)
                    <option value="{{ $calendrier->id }}">{{ $calendrier->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Description (facultatif)</label>
            <textarea name="description" class="w-full p-2 border rounded"></textarea>
        </div>

        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded">Enregistrer</button>
    </form>
</div>
@endsection
