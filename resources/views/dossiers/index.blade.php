@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl text-pink-600 font-bold mb-6">📁 Mes Dossiers</h1>

    <a href="{{ route('dossiers.create') }}" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
        ➕ Nouveau dossier
    </a>

    <div class="flex flex-wrap gap-4 mt-6">
        @forelse ($dossiers as $dossier)
            <div class="relative flex flex-col items-center px-2 py-3 bg-pink-100 rounded-lg shadow-sm text-center w-[90px]">
                {{-- Icône dossier avec coins arrondis --}}
                <a href="{{ route('dossiers.show', $dossier) }}">
                    <div class="w-12 h-10 rounded-md shadow-inner relative"
                         style="background-color: {{ $dossier->couleur ?? '#facc15' }}; border: 2px solid {{ $dossier->couleur ?? '#fbbf24' }}">
                        <div class="absolute -top-1 left-1 w-6 h-2 rounded-md"
                             style="background-color: {{ $dossier->couleur ?? '#fde68a' }}; border: 1px solid {{ $dossier->couleur ?? '#fbbf24' }}">
                        </div>
                    </div>
                </a>

                {{-- Nom --}}
                <div class="mt-2 text-[13px] font-semibold text-pink-900 truncate w-full">
                    {{ $dossier->nom }}
                </div>

                {{-- Actions --}}
                <div class="absolute top-1 right-1 flex space-x-1 text-sm">
                    <a href="{{ route('dossiers.edit', $dossier) }}" title="Modifier">✏️</a>
                    <form action="{{ route('dossiers.destroy', $dossier) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                        @csrf @method('DELETE')
                        <button type="submit" title="Supprimer">➖</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Aucun dossier trouvé.</p>
        @endforelse
    </div>
</div>
@endsection
