@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">
    <h1 class="text-2xl font-bold text-center text-pink-600">➕ Nouvelle Enveloppe</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('budget.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Nom -->
        <div>
            <label for="nom" class="block text-sm font-medium text-gray-700">Nom de l’enveloppe</label>
            <input type="text" name="nom" id="nom"
                   value="{{ old('nom') }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500">
        </div>

        <!-- Montant -->
        <div>
            <label for="montant" class="block text-sm font-medium text-gray-700">Montant (€)</label>
            <input type="number" name="montant" id="montant"
                   step="0.01" min="0"
                   value="{{ old('montant') }}"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500">
        </div>

        <!-- Couleur -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Choisir une couleur</label>

            <input type="hidden" name="couleur" id="selectedColor" value="{{ old('couleur', '#F87171') }}">

            <div id="colorSelector" class="flex flex-wrap gap-3 justify-center">
                @foreach([
                    '#F87171' => 'Rouge',
                    '#FB923C' => 'Orange',
                    '#FBBF24' => 'Jaune',
                    '#34D399' => 'Vert',
                    '#60A5FA' => 'Bleu clair',
                    '#A78BFA' => 'Violet',
                    '#F472B6' => 'Rose',
                    '#FACC15' => 'Jaune clair',
                    '#4ADE80' => 'Vert clair',
                    '#38BDF8' => 'Bleu vif',
                    '#818CF8' => 'Indigo',
                    '#D946EF' => 'Fuchsia'
                ] as $code => $nom)
                    <div class="color-circle w-8 h-8 rounded-full cursor-pointer border-2 transition-transform duration-150 hover:scale-110"
                         data-color="{{ $code }}"
                         title="{{ $nom }}"
                         style="background-color: {{ $code }};">
                    </div>
                @endforeach
            </div>

            @error('couleur')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Aperçu style fleur -->
<div class="flex items-center gap-2 mt-2">
    <span class="text-sm text-gray-600">Couleur choisie :</span>
    <div id="previewBox"
         class="w-8 h-8 rounded-full border border-gray-300 shadow-sm"
         style="background-color: {{ old('couleur', '#F87171') }};">
    </div>
</div>




        <!-- Bouton valider -->
        <div class="text-center">
            <button type="submit"
                    class="bg-pink-500 text-white px-6 py-2 rounded-full hover:bg-pink-600 transition">
                ✅ Créer
            </button>
        </div>
    </form>
</div>

<!-- Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selector = document.getElementById('colorSelector');
        const hiddenInput = document.getElementById('selectedColor');
        const preview = document.getElementById('previewBox');
        const currentValue = hiddenInput.value;

        function selectColor(element) {
            selector.querySelectorAll('.color-circle').forEach(div => {
                div.classList.remove('ring-2', 'ring-black');
            });

            element.classList.add('ring-2', 'ring-black');
            hiddenInput.value = element.dataset.color;
            preview.style.backgroundColor = element.dataset.color;
        }

        const initial = selector.querySelector(`.color-circle[data-color="${currentValue}"]`);
        if (initial) selectColor(initial);

        selector.querySelectorAll('.color-circle').forEach(div => {
            div.addEventListener('click', () => selectColor(div));
        });
    });
</script>
@endsection
