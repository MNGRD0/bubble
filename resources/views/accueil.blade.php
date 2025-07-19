@extends('layouts.app')
{{-- Utilise le layout principal qui contient le header, le HTML de base, etc. --}}

@section('content')
{{-- Début de la section "content", qui sera injectée dans le layout à l’endroit de @yield('content') --}}

<div class="max-w-screen-xl mx-auto w-full grid grid-cols-1 md:grid-cols-[220px_1fr] gap-8">
    {{-- Conteneur global du dashboard
         - max-w-screen-xl : limite la largeur totale
         - mx-auto : centre horizontalement
         - grid-cols-1 : une colonne sur mobile
         - md:grid-cols-[220px_1fr] : deux colonnes sur écran moyen ou plus (sidebar 220px + contenu)
         - gap-8 : espace entre les colonnes --}}

    <!-- 📌 Colonne gauche : modules verticaux bien collés (masqué sur mobile) -->
    <div class="space-y-3 md:block hidden" id="sidebar">
        {{-- Sidebar uniquement visible sur desktop (hidden sur mobile) avec espacement vertical entre les liens --}}

        @php
            $modules = [
                ['icon' => '📝', 'label' => 'To-do'],
                ['icon' => '🍰', 'label' => 'Recettes'],
                ['icon' => '📆', 'label' => 'Calendrier'],
                ['icon' => '📔', 'label' => 'Journal'],
                ['icon' => '💰', 'label' => 'Budget'],
                ['icon' => '📁', 'label' => 'Fichiers'],
                ['icon' => '🖊️', 'label' => 'Histoires'],
                ['icon' => '🧮', 'label' => 'Outils de calcul'],
                ['icon' => '🕌', 'label' => 'Islam'],
            ];
            // Liste des modules à afficher dans la barre latérale (chaque module a une icône et un label)
        @endphp

        @foreach ($modules as $module)
            {{-- Boucle sur chaque module pour créer un lien personnalisé --}}
            <a href="#"
               class="bg-pink-100 flex items-center gap-3 p-3 rounded-xl shadow hover:bg-pink-200 transition text-sm w-full">
               {{-- Style doux en rose, hover, ombre, coins arrondis --}}
                <span class="text-xl">{{ $module['icon'] }}</span>
                <span>{{ $module['label'] }}</span>
            </a>
        @endforeach
    </div>

    <!-- 📊 Colonne droite : dashboard plus large -->
    <div class="bg-white rounded-2xl p-6 shadow space-y-6 w-full max-w-none">
        {{-- Bloc principal avec contenu dynamique
             - Fond blanc, coins arrondis, ombre
             - padding intérieur, espacement entre blocs enfants --}}

        <!-- 🌤 Météo -->
        <div>
            <h3 class="text-md font-semibold text-pink-700 mb-1">Météo du jour</h3>
            <p class="text-sm text-gray-700">🌤 26°C à Paris — Ensoleillé</p>
            {{-- Titre et contenu météo fictif pour l’instant --}}
        </div>

        <!-- 🕌 Horaires de prière -->
        <div>
            <h3 class="text-md font-semibold text-pink-700 mb-1">Horaires de prière</h3>
            <ul class="text-sm text-gray-700 space-y-1">
                {{-- Liste simple des horaires de prière avec emojis --}}
                <li>🕛 Fajr : 04:18</li>
                <li>🌅 Dhuhr : 13:45</li>
                <li>☀️ Asr : 17:23</li>
                <li>🌇 Maghrib : 21:09</li>
                <li>🌙 Isha : 22:42</li>
            </ul>
        </div>

        <!-- ✅ Résumé des actions -->
        <div>
            <h3 class="text-md font-semibold text-pink-700 mb-1">Résumé rapide</h3>
            <ul class="text-sm text-gray-700 space-y-1">
                {{-- Petits résumés de l’activité personnelle --}}
                <li>✅ 3 tâches faites aujourd’hui</li>
                <li>📔 Journal : dernière entrée le 15 juillet</li>
                <li>💳 Budget : 42€ dépensés (loisirs)</li>
            </ul>
        </div>

        <!-- 🌟 Motivation -->
        <div class="text-sm text-pink-600 italic">
            “Chaque petit pas compte. Tu avances à ton rythme 💖”
            {{-- Citation positive affichée en bas du dashboard --}}
        </div>
    </div>
</div>
@endsection
