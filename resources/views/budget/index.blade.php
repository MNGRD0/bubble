@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4 text-center">
            ✅ <strong>{{ session('success') }}</strong>
        </div>
    @endif

    <h1 class="text-2xl font-bold mb-6 text-pink-600 text-center">💰 Mes Budgets</h1>

    <div class="flex justify-end mb-6">
        <a href="{{ route('budgets.create') }}"
           class="w-8 h-8 rounded-full bg-pink-500 text-white flex items-center justify-center text-xl hover:bg-pink-600 transition"
           title="Ajouter une enveloppe">+</a>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 transition duration-200 ease-in-out">
        @forelse($budgets as $budget)
            @php
                $totalDepenses = $budget->depenses->where('type', 'depense')->sum('montant');
                $totalEntrees = $budget->depenses->where('type', 'entree')->sum('montant');
                $reste = $budget->montant + $totalEntrees - $totalDepenses;
                $couleur = $budget->couleur ?? '#F472B6';
            @endphp

           <div onclick="window.location='{{ route('budgets.show', $budget->id) }}'"
     class="bg-white rounded-xl shadow p-4 relative space-y-2 border border-gray-200 
            transition duration-200 ease-in-out cursor-pointer hover:bg-pink-100 hover:shadow-lg">



                <!-- ✅ Nom + bouton modifier -->
                <div class="flex items-center gap-2">
                    <div class="inline-block px-3 py-1 rounded-md text-white font-semibold text-sm" style="background-color: {{ $couleur }}">
                        {{ $budget->nom }}
                    </div>
                    <a href="{{ route('budgets.edit', $budget->id) }}"
                       onclick="event.stopPropagation()"
                       class="w-6 h-6 bg-pink-200 text-pink-700 rounded-full flex items-center justify-center text-xs hover:bg-pink-300"
                       title="Modifier">✏️</a>
                </div>

                <p class="text-sm text-gray-700">Budget total :
                    <strong>{{ number_format($budget->montant, 2) }} €</strong>
                </p>
                <p class="text-sm text-gray-700">Restant :
                    <strong class="{{ $reste < 0 ? 'text-red-500' : 'text-green-600' }}">
                        {{ number_format($reste, 2) }} €
                    </strong>
                </p>

                <!-- ➕ Ajouter dépense ou entrée -->
                <a href="{{ route('depenses.create', $budget->id) }}"
                   onclick="event.stopPropagation()"
                   class="absolute bottom-3 left-3 w-6 h-6 bg-pink-200 hover:bg-pink-300 text-pink-700 text-base rounded-full flex items-center justify-center"
                   title="Ajouter une dépense ou une entrée">+</a>

                <!-- ❌ Supprimer -->
                <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST"
                      onsubmit="event.stopPropagation(); return confirm('❗ Supprimer cette enveloppe ? Toutes ses dépenses seront supprimées.')"
                      class="absolute top-2 right-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-6 h-6 bg-pink-200 hover:bg-pink-300 text-pink-700 rounded-full flex items-center justify-center font-bold"
                            title="Supprimer">−</button>
                </form>
            </div>
        @empty
            <p class="text-gray-500 text-center col-span-3">Aucune enveloppe créée pour l’instant.</p>
        @endforelse
    </div>
</div>
@endsection
