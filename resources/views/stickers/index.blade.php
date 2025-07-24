@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Mes Stickers</h2>

    <a href="{{ route('stickers.create') }}" class="bg-pink-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Ajouter un sticker</a>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse ($stickers as $sticker)
            <div class="p-4 rounded shadow" style="background-color: {{ $sticker->couleur }}">
                <h3 class="text-lg font-semibold text-white">{{ $sticker->nom }}</h3>

                <div class="flex justify-between mt-2">
                    <a href="{{ route('stickers.edit', $sticker) }}" class="text-white underline">Modifier</a>

                    <form action="{{ route('stickers.destroy', $sticker) }}" method="POST" onsubmit="return confirm('Supprimer ce sticker ?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-white underline">Supprimer</button>
                    </form>
                </div>
            </div>
        @empty
            <p>Tu n'as pas encore de sticker 🎨</p>
        @endforelse
    </div>
</div>
@endsection
