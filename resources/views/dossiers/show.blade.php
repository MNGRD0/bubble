@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    {{-- 📁 Fil d’Ariane --}}
    <div class="text-sm text-pink-600 mb-2">
        <a href="{{ route('dossiers.index') }}" class="hover:underline">📁 Mes dossiers</a>

        @php
            $chemin = [];
            $parent = $dossier->parent;
            while ($parent) {
                $chemin[] = $parent;
                $parent = $parent->parent;
            }
            $chemin = array_reverse($chemin);
        @endphp

        @foreach ($chemin as $parent)
            / <a href="{{ route('dossiers.show', $parent) }}" class="hover:underline">{{ $parent->nom }}</a>
        @endforeach

        / <span class="font-semibold">{{ $dossier->nom }}</span>
    </div>

    {{-- Titre + Crayon --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold text-pink-600">📁 {{ $dossier->nom }}</h2>
        <button onclick="document.getElementById('modal-edit').classList.remove('hidden')" title="Modifier">✏️</button>
    </div>

    {{-- 🪄 Modal Édition --}}
    <div id="modal-edit" class="fixed inset-0 bg-black bg-opacity-30 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-sm relative shadow-lg">
            <button class="absolute top-2 right-2 text-gray-500 hover:text-black" onclick="document.getElementById('modal-edit').classList.add('hidden')">✖</button>
            <h3 class="text-lg font-bold text-pink-600 mb-4">Modifier le dossier</h3>

            <form method="POST" action="{{ route('dossiers.update', $dossier) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="block text-sm font-semibold text-pink-700">Nom</label>
                    <input type="text" name="nom" value="{{ $dossier->nom }}" required class="w-full rounded border border-pink-300 p-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-pink-700">Couleur</label>
                    <input type="color" name="couleur" value="{{ $dossier->couleur ?? '#ffc0cb' }}" class="w-16 h-10 p-0 border border-pink-300 rounded">
                </div>

                <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600 w-full">
                    Enregistrer
                </button>
            </form>
        </div>
    </div>

    {{-- Ajouter un fichier --}}
    <a href="{{ route('fichiers.create') }}?dossier_id={{ $dossier->id }}"
       class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600 mb-4 inline-block">
        ➕ Ajouter un fichier
    </a>

    {{-- Ajouter un sous-dossier --}}
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-pink-600 mb-2">➕ Ajouter un sous-dossier</h3>
        <form action="{{ route('dossiers.store') }}" method="POST">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $dossier->id }}">
            <div class="flex items-center gap-2">
                <input type="text" name="nom" required placeholder="Nom du sous-dossier"
                       class="rounded border border-pink-300 p-2 w-60 text-sm">
                <input type="color" name="couleur" class="h-10 w-10 p-0 border rounded" value="#ffc0cb">
                <button type="submit" class="bg-pink-500 text-white px-3 py-2 rounded hover:bg-pink-600">
                    Créer
                </button>
            </div>
        </form>
    </div>

    {{-- Sous-dossiers --}}
    @if ($dossier->enfants->count() > 0)
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-pink-600 mb-2">📂 Sous-dossiers</h3>
            <div class="flex flex-wrap gap-4">
                @foreach ($dossier->enfants as $enfant)
                    <div class="relative flex flex-col items-center px-2 py-3 bg-pink-100 rounded-lg shadow-sm text-center w-[90px]">
                        <a href="{{ route('dossiers.show', $enfant) }}">
                            <div class="w-12 h-10 rounded-md shadow-inner relative"
                                 style="background-color: {{ $enfant->couleur ?? '#facc15' }}; border: 2px solid {{ $enfant->couleur ?? '#fbbf24' }}">
                                <div class="absolute -top-1 left-1 w-6 h-2 rounded-sm"
                                     style="background-color: {{ $enfant->couleur ?? '#fde68a' }}; border: 1px solid {{ $enfant->couleur ?? '#fbbf24' }}"></div>
                            </div>
                        </a>

                        <div class="mt-2 text-[13px] font-semibold text-pink-900 truncate w-full">
                            {{ $enfant->nom }}
                        </div>

                        <div class="absolute top-1 right-1 flex space-x-1 text-sm">
                            <a href="{{ route('dossiers.edit', $enfant) }}" title="Modifier">✏️</a>
                            <form action="{{ route('dossiers.destroy', $enfant) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Supprimer">➖</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Fichiers --}}
    <div class="flex flex-wrap gap-3 mt-4">
        @forelse ($dossier->fichiers as $fichier)
            @php
                $ext = pathinfo($fichier->chemin, PATHINFO_EXTENSION);
                $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                $isVideo = in_array(strtolower($ext), ['mp4', 'webm', 'mov']);
                $isPdf = strtolower($ext) === 'pdf';
            @endphp

            <div class="w-16 text-center text-[11px] relative group transition-all duration-200 transform hover:scale-105">
                {{-- Supprimer --}}
                <form action="{{ route('fichiers.destroy', $fichier) }}" method="POST"
                      onsubmit="return confirm('Supprimer ce fichier ?')"
                      class="absolute -top-2 -right-2 z-10">
                    @csrf @method('DELETE')
                    <button class="bg-white text-red-500 border border-red-300 rounded-full w-5 h-5 flex items-center justify-center shadow-sm text-[12px]
                                   transition hover:bg-red-100 hover:text-red-700">
                        ✖
                    </button>
                </form>

                {{-- Aperçu --}}
                <a href="{{ Storage::url($fichier->chemin) }}" target="_blank" title="{{ $fichier->nom }}">
                    @if ($isImage)
                        <img src="{{ Storage::url($fichier->chemin) }}" class="w-14 h-14 object-cover rounded border shadow-sm" />
                    @elseif ($isVideo)
                        <div class="w-14 h-14 flex items-center justify-center bg-gray-200 rounded border text-xl shadow-sm">🎥</div>
                    @elseif ($isPdf)
                        <div class="w-14 h-14 flex items-center justify-center bg-red-100 text-red-600 rounded border text-xl shadow-sm">📄</div>
                    @else
                        <div class="w-14 h-14 flex items-center justify-center bg-gray-100 rounded border text-xl shadow-sm">📎</div>
                    @endif
                </a>

                {{-- Nom --}}
                <div class="truncate mt-1 font-medium text-[11px]" title="{{ $fichier->nom }}">
                    {{ Str::limit($fichier->nom, 16) }}
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500">Aucun fichier</p>
        @endforelse
    </div>
</div>
@endsection
