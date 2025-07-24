@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8 space-y-10">

    <!-- 🌸 Partie 1 : Réduction -->
    <div class="bg-white rounded-2xl shadow-md p-6">
        <h2 class="text-xl font-bold text-center text-pink-600 mb-6">🛍️ Calculateur de soldes</h2>
        
        <div class="flex justify-between items-center mb-4">
            <div class="w-1/2">
                <label class="block text-sm mb-1">Prix initial</label>
                <input id="prixInitial" type="number" placeholder="€" class="w-full p-2 rounded-xl border border-pink-300 focus:ring focus:ring-pink-200 text-lg">
            </div>
            <div class="text-right w-1/2">
                <label class="block text-sm mb-1">Prix final</label>
                <div id="prixFinalAffiche" class="text-xl font-bold text-pink-600">0.00 €</div>
            </div>
        </div>

        <h3 class="text-sm font-semibold mb-2">Remise</h3>

{{-- Mobile : flex wrap centré / Desktop : vraie grille alignée à gauche --}}
<div class="w-full md:w-auto md:max-w-none md:mx-0 md:px-0 md:grid md:grid-cols-5 md:gap-3 flex flex-wrap justify-center gap-3">
    @php
        $percentages = [5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95];
        $colors = [
            '#9CA3AF', '#A3E635', '#A3E635', '#A3E635', '#FACC15',
            '#FACC15', '#22D3EE', '#22D3EE', '#22D3EE', '#22D3EE',
            '#EC4899', '#EC4899', '#EC4899', '#EC4899', '#A78BFA',
            '#A78BFA', '#A78BFA', '#F87171', '#F87171'
        ];
    @endphp

    {{-- Bouton reset à gauche --}}
    <button onclick="resetReduction()" 
        class="w-12 h-12 rounded-full bg-gray-600 text-white font-bold text-lg flex items-center justify-center">
        ×
    </button>

    @foreach ($percentages as $index => $percent)
        <button onclick="calculerReduction({{ $percent }})"
            class="w-12 h-12 rounded-full text-white font-bold text-sm shadow-md flex items-center justify-center"
            style="background-color: {{ $colors[$index % count($colors)] }}"
        >
            {{ $percent }}%
        </button>
    @endforeach
</div>

@endsection
