@extends('layouts.app')

@section('content')

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
