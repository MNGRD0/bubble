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



    </div>
<!-- Espace vide entre les deux blocs -->
<div class="h-10"></div>

    <!-- 🌸 Partie 2 : Mini Calculatrice Casio -->
<!-- 🌸 Partie 2 : Mini Calculatrice Casio -->
<!-- 🌸 Partie 2 : Mini Calculatrice Casio -->
<div class="bg-pink-100 rounded-2xl shadow-lg p-4 w-full max-w-xs mx-auto mt-12">
    <div class="bg-white text-right text-xl font-mono rounded-xl p-3 mb-4 shadow-inner h-14 flex items-center justify-end overflow-auto" id="calcDisplay">0</div>

    <div class="flex flex-col gap-2">
        @php
            $rows = [
                ['AC','C','%','/'],
                ['7','8','9','*'],
                ['4','5','6','-'],
                ['1','2','3','+'],
                ['0','00','.','='],
            ];
        @endphp

        @foreach ($rows as $row)
            <div class="flex gap-2">
                @foreach ($row as $btn)
                    <button onclick="calculatrice('{{ $btn }}')"
                        class="flex-1 p-4 text-base font-semibold rounded-xl text-center shadow
                            {{ $btn === 'AC' ? 'bg-pink-500 text-white' : '' }}
                            {{ $btn === 'C' ? 'bg-pink-400 text-white' : '' }}
                            {{ $btn === '=' ? 'bg-pink-600 text-white' : '' }}
                            {{ !in_array($btn, ['AC','C','=']) ? 'bg-white text-pink-800' : '' }}
                            hover:scale-105 transition-all">
                        {{ $btn }}
                    </button>
                @endforeach
            </div>
        @endforeach
    </div>
</div>




<script>
    function calculerReduction(pourcentage) {
        const prix = parseFloat(document.getElementById('prixInitial').value);
        if (isNaN(prix) || prix <= 0) return;

        const reduction = (prix * pourcentage) / 100;
        const final = prix - reduction;

        document.getElementById('prixFinalAffiche').innerText = final.toFixed(2) + ' €';
    }

    function resetReduction() {
        document.getElementById('prixInitial').value = '';
        document.getElementById('prixFinalAffiche').innerText = '0.00 €';
    }

    let calcBuffer = '';
    function calculatrice(input) {
        const display = document.getElementById('calcDisplay');

        if (input === 'AC') {
            calcBuffer = '';
        } else if (input === 'C') {
            calcBuffer = calcBuffer.slice(0, -1);
        } else if (input === '=') {
            try {
                calcBuffer = eval(calcBuffer.replace(/[^-()\d/*+.]/g, '')).toString();
            } catch {
                calcBuffer = 'Erreur';
            }
        } else {
            calcBuffer += input;
        }

        display.innerText = calcBuffer || '0';
    }
</script>
@endsection
