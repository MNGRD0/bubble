@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Mes Événements</h2>

    <a href="{{ route('evenements.create') }}" class="bg-pink-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Ajouter un événement</a>

    <div class="space-y-4">
        @forelse ($evenements as $event)
            <div class="p-4 rounded shadow border">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold">{{ $event->titre }}</h3>
                    <span class="px-2 py-1 text-sm rounded" style="background-color: {{ $event->sticker->couleur ?? '#ccc' }}">
                        {{ $event->sticker->nom ?? 'Sans sticker' }}
                    </span>
                </div>
                <p class="text-sm text-gray-600">📅 {{ $event->date->format('d/m/Y H:i') }}</p>
                @if ($event->description)
                    <p class="mt-2">{{ $event->description }}</p>
                @endif

                <div class="flex justify-end gap-4 mt-3">
                    <a href="{{ route('evenements.edit', $event) }}" class="text-blue-500 underline">Modifier</a>

                    <form action="{{ route('evenements.destroy', $event) }}" method="POST" onsubmit="return confirm('Supprimer cet événement ?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 underline">Supprimer</button>
                    </form>
                </div>
            </div>
        @empty
            <p>Tu n’as encore aucun événement 📭</p>
        @endforelse
    </div>
</div>
@endsection
