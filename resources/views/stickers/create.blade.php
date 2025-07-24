@extends('layouts.app')

@section('content')
<div class="container max-w-md">
    <h2 class="text-xl font-bold mb-4">Créer un nouveau sticker</h2>

    <form action="{{ route('stickers.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Nom</label>
            <input type="text" name="nom" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Couleur (code HEX)</label>
            <input type="color" name="couleur" class="w-full p-2" required>
        </div>

        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded">Créer</button>
    </form>
</div>
@endsection
