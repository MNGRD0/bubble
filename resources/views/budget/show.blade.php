@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 space-y-6">

    <!-- 🔙 Bouton retour -->
    <a href="{{ route('budgets.index') }}"
       class="inline-block mb-4 text-pink-600 hover:underline">
       ← Retour aux budgets
    </a>

    <!-- 💰 Détails -->
    <h1 class="text-2xl font-bold text-center text-pink-600 mb-4">
        💼 {{ $budget->nom }}
    </h1>

    @php
        $depenses = request('all') ? $budget->depenses->sortByDesc('created_at') : $budget->depenses->sortByDesc('created_at')->take(5);
        $totalEntrees = $budget->depenses->filter(fn($d) => strtolower(trim($d->type)) === 'entree')->sum('montant');
        $totalDepenses = $budget->depenses->filter(fn($d) => strtolower(trim($d->type)) === 'depense')->sum('montant');
        $total = $budget->montant + $totalEntrees;
        $reste = $total - $totalDepenses;
    @endphp

    <div class="bg-white shadow rounded-xl p-4 space-y-2">
        <p>Total initial : <strong>{{ number_format($budget->montant, 2) }} €</strong></p>
        <p>Entrées : <strong class="text-green-600">+{{ number_format($totalEntrees, 2) }} €</strong></p>
        <p>Dépenses : <strong class="text-red-500">-{{ number_format($totalDepenses, 2) }} €</strong></p>
        <p>Restant :
            <strong class="{{ $reste < 0 ? 'text-red-500' : 'text-green-600' }}">
                {{ number_format($reste, 2) }} €
            </strong>
        </p>
    </div>

    <!-- 📋 Mouvements -->
    <h2 class="text-lg font-semibold mt-6 text-pink-600">📄 Mouvements</h2>

    <ul class="space-y-2">
        @forelse ($depenses as $depense)
            @php
                $isEntree = strtolower(trim($depense->type)) === 'entree';
            @endphp
            <li class="flex justify-between px-4 py-2 bg-white shadow rounded-lg text-sm">
                <span>{{ $depense->nom }}</span>
                <span class="{{ $isEntree ? 'text-green-600' : 'text-red-500' }}">
                    {{ $isEntree ? '+' : '-' }}{{ number_format($depense->montant, 2) }} €
                </span>
            </li>
        @empty
            <li class="text-center text-gray-400">Aucune dépense ou entrée enregistrée.</li>
        @endforelse
    </ul>

   <!-- Bouton afficher plus -->
@if (!request('all') && $budget->depenses->count() > 5)
    <div class="text-center mt-4">
        <a href="{{ route('budgets.show', $budget->id) }}?all=1"
           class="inline-block px-4 py-2 text-sm text-pink-600 bg-pink-100 bg-opacity-50 rounded-full hover:bg-pink-200 transition">
            Afficher plus
        </a>
    </div>
@elseif (request('all'))
    <div class="text-center mt-4">
        <a href="{{ route('budgets.show', $budget->id) }}"
           class="inline-block px-4 py-2 text-sm text-pink-600 bg-pink-100 bg-opacity-50 rounded-full hover:bg-pink-200 transition">
            Réduire
        </a>
    </div>
@endif


</div>
@endsection
