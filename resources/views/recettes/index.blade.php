@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <!-- ✅ Message de succès -->
@if(session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">
        ✅ <strong>{{ session('success') }}</strong>
    </div>
@endif

    <h1 class="text-2xl font-bold mb-6">🍽️ Mes Recettes</h1>

    {{-- Formulaire d’ajout de catégorie --}}
    <form action="{{ route('recettes.categories.store') }}" method="POST" class="mb-6 flex gap-2">
        @csrf
        <input type="text" name="nom" placeholder="Nouvelle catégorie"
               class="border rounded px-4 py-2 w-full" required>
        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded">Ajouter</button>
    </form>

    {{-- 🔽 Filtre des recettes --}}
    <form method="GET" action="{{ route('recettes.index') }}" class="flex space-x-4 mb-6">
        <select name="sort_by"
                class="p-2 border border-pink-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-400 text-sm">
            <option value="titre_asc" {{ request('sort_by') == 'titre_asc' ? 'selected' : '' }}>A à Z</option>
            <option value="titre_desc" {{ request('sort_by') == 'titre_desc' ? 'selected' : '' }}>Z à A</option>
            <option value="created_desc" {{ request('sort_by') == 'created_desc' ? 'selected' : '' }}>Ajout récent</option>
            <option value="created_asc" {{ request('sort_by') == 'created_asc' ? 'selected' : '' }}>Ajout ancien</option>
        </select>
        <button type="submit"
                class="bg-pink-500 text-white py-2 px-3 rounded-lg hover:bg-pink-600 text-sm">
            Filtrer
        </button>
    </form>

    {{-- Liste des catégories --}}
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
        @forelse ($categories as $categorie)
            <div class="bg-white rounded shadow p-4 relative">
                <a href="{{ route('recettes.categorie.show', $categorie->id) }}" class="block text-lg font-semibold hover:underline">
                    {{ $categorie->nom }}
                </a>
                <form action="{{ route('recettes.categorie.destroy', $categorie->id) }}" method="POST" class="absolute top-2 right-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            title="Supprimer la catégorie"
                            class="w-6 h-6 rounded-full bg-pink-200 text-pink-700 font-bold leading-none flex items-center justify-center hover:bg-pink-300">
                        −
                    </button>
                </form>
            </div>
        @empty
            <p class="col-span-3 text-gray-500">Aucune catégorie pour le moment.</p>
        @endforelse
    </div>

    {{-- Liste des recettes --}}
    @if($recettes->count())
        <div class="grid gap-6" id="recette-list">
            @foreach($recettes->take(5) as $recette)
    <div class="bg-white rounded shadow p-4 flex items-center gap-4">

        {{-- Image cliquable --}}
        <div class="w-16 h-16 bg-pink-100 rounded-xl flex items-center justify-center overflow-hidden">
            @if($recette->image)
                <a href="{{ route('recettes.show', $recette->id) }}">
                    <img src="{{ asset('storage/' . $recette->image) }}" alt="Image"
                         class="object-cover w-16 h-16 rounded">
                </a>
            @else
                <span class="text-gray-400 text-xs text-center">Aucune image</span>
            @endif
        </div>

        {{-- Infos recette --}}
        <div class="flex-1">
            <h2 class="text-lg font-bold mb-1">{{ $recette->titre }}</h2>
            <p class="text-sm text-gray-500 mb-1">Catégorie : {{ $recette->categorie->nom ?? 'Non catégorisée' }}</p>
            <p class="text-gray-700 text-sm">{{ Str::limit($recette->ingredients, 100) }}</p>

            <div class="mt-2 flex gap-3 flex-wrap text-sm items-center">
                <a href="{{ route('recettes.show', $recette->id) }}" class="text-pink-600 hover:underline">👁️ Voir</a>
                <a href="{{ route('recettes.edit', $recette->id) }}" class="text-blue-500 hover:underline">✏️ Modifier</a>

                {{-- ✅ Supprimer avec confirmation --}}
                <form id="delete-recette-{{ $recette->id }}" action="{{ route('recettes.destroy', $recette->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            onclick="if(confirm('Voulez-vous vraiment supprimer cette recette ?')) document.getElementById('delete-recette-{{ $recette->id }}').submit();"
                            title="Supprimer la recette"
                            class="w-6 h-6 rounded-full bg-pink-200 text-pink-700 font-bold leading-none flex items-center justify-center hover:bg-pink-300">
                        −
                    </button>
                </form>
            </div>
        </div>

    </div>
@endforeach

        </div>

        {{-- Boutons pagination dynamiques --}}
        @if($recettes->count() > 5)
            <div class="text-center mt-4 flex justify-center gap-4">
    <button id="loadMore"
            class="px-3 py-1 rounded-full text-pink-600 bg-pink-100 hover:bg-pink-200 transition text-sm">
        Afficher plus
    </button>

    <button id="showAll"
            class="px-3 py-1 rounded-full text-pink-600 bg-pink-100 hover:bg-pink-200 transition text-sm">
        Tout voir
    </button>

    <button id="reduceList"
            class="px-3 py-1 rounded-full text-pink-400 bg-pink-100 hover:bg-pink-200 transition text-sm hidden">
        Réduire
    </button>
</div>


            <script>
                const allRecettes = @json($recettes);
                const listEl = document.getElementById('recette-list');
                let displayed = 5;

                document.getElementById('loadMore').addEventListener('click', () => {
                    const next = allRecettes.slice(displayed, displayed + 5);
                    next.forEach(r => {
                        const div = document.createElement('div');
                        div.className = "bg-white rounded shadow p-4 flex items-center gap-4 mt-4";
                        div.innerHTML = `
                            <div class="w-16 h-16 bg-pink-100 rounded-xl flex items-center justify-center overflow-hidden">
                                ${r.image ? `<a href='/recettes/${r.id}'><img src='/storage/${r.image}' class='object-cover w-16 h-16 rounded'></a>` : `<span class='text-gray-400 text-xs text-center'>Aucune image</span>`}
                            </div>
                            <div class="flex-1">
                                <h2 class="text-lg font-bold mb-1">${r.titre}</h2>
                                <p class="text-sm text-gray-500 mb-1">Catégorie : ${r.categorie?.nom ?? 'Non catégorisée'}</p>
                                <p class="text-gray-700 text-sm">${r.ingredients?.slice(0, 100) ?? ''}</p>
                            </div>
                        `;
                        listEl.appendChild(div);
                    });
                    displayed += 5;
                    if (displayed >= allRecettes.length) {
                        document.getElementById('loadMore').classList.add('hidden');
                        document.getElementById('reduceList').classList.remove('hidden');
                    }
                });

                document.getElementById('showAll').addEventListener('click', () => {
                    while (displayed < allRecettes.length) {
                        document.getElementById('loadMore').click();
                    }
                });

                document.getElementById('reduceList').addEventListener('click', () => {
                    listEl.innerHTML = '';
                    allRecettes.slice(0, 5).forEach((r, i) => {
                        const div = document.createElement('div');
                        div.className = "bg-white rounded shadow p-4 flex items-center gap-4 mt-4";
                        div.innerHTML = `
                            <div class="w-16 h-16 bg-pink-100 rounded-xl flex items-center justify-center overflow-hidden">
                                ${r.image ? `<a href='/recettes/${r.id}'><img src='/storage/${r.image}' class='object-cover w-16 h-16 rounded'></a>` : `<span class='text-gray-400 text-xs text-center'>Aucune image</span>`}
                            </div>
                            <div class="flex-1">
                                <h2 class="text-lg font-bold mb-1">${r.titre}</h2>
                                <p class="text-sm text-gray-500 mb-1">Catégorie : ${r.categorie?.nom ?? 'Non catégorisée'}</p>
                                <p class="text-gray-700 text-sm">${r.ingredients?.slice(0, 100) ?? ''}</p>
                            </div>
                        `;
                        listEl.appendChild(div);
                    });
                    displayed = 5;
                    document.getElementById('loadMore').classList.remove('hidden');
                    document.getElementById('reduceList').classList.add('hidden');
                });
            </script>
        @endif

    @else
        <p class="text-gray-500">Aucune recette enregistrée.</p>
    @endif
</div>
@endsection
