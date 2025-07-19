<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    {{-- Définit l'encodage des caractères pour supporter les accents et caractères spéciaux --}}

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Permet un affichage responsive (adapte la taille du contenu à l’écran) --}}

    <title>Bubble</title>
    {{-- Titre de la page affiché dans l’onglet du navigateur --}}

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- Importe Alpine.js, une petite librairie JavaScript pour gérer l’interactivité (comme les menus) --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'], true)
    {{-- Charge les fichiers CSS et JS compilés par Vite (styles Tailwind, scripts) --}}
</head>

<body class="bg-pink-50 text-pink-900 font-sans min-h-screen flex flex-col">
    {{-- Corps de la page avec : fond rose clair, texte rose foncé, police sans serif,
         hauteur minimale = écran entier, et disposition verticale (colonne) --}}

    <!-- 🔺 HEADER -->
    <header class="bg-pink-200 p-4 shadow rounded-b-3xl flex items-center justify-between relative z-50">
        {{-- Barre en haut : fond rose, padding, ombre, arrondis bas, éléments espacés --}}

        <!-- 👤 Photo + nom -->
        <div class="flex items-center gap-3">
            {{-- Affiche l’avatar de l’utilisateur connecté ou un icône par défaut --}}
            @if(Auth::user()->photo)
                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profil"
                     class="w-10 h-10 rounded-full object-cover">
            @else
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-pink-400 font-bold">
                    👤
                </div>
            @endif
            <span class="font-semibold hidden sm:inline">Bonjour, {{ Auth::user()->name }} 🌸</span>
            {{-- Message de bienvenue visible seulement sur écran moyen et plus --}}
        </div>

        <!-- 🍔 BOUTON MENU MOBILE (ouvre la fenêtre pop-up) -->
        <div class="block sm:hidden" x-data="{ open: false }">
            {{-- Menu visible uniquement en mobile. Quand on clique : open devient true --}}
            <button @click="open = !open" class="text-xl" title="Menu">
                ☰
            </button>

            <!-- Fenêtre Pop-up (visible lorsque open est true) -->
            <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" @click.self="open = false">
                <div class="bg-white p-6 rounded-lg w-4/5 max-w-md shadow-md space-y-4">
                    <h2 class="text-xl font-semibold text-pink-600 mb-4">Sélectionne une section</h2>

                    <!-- Liens vers les sections avec une meilleure séparation -->
                    <a href="#" class="block hover:text-pink-500 border-b border-pink-200 pb-2" @click="alert('To-do section clicked!'); open = false">📝 To-do</a>
                    <a href="#" class="block hover:text-pink-500 border-b border-pink-200 pb-2" @click="alert('Journal section clicked!'); open = false">📔 Journal</a>
                    <a href="#" class="block hover:text-pink-500 border-b border-pink-200 pb-2" @click="alert('Budget section clicked!'); open = false">💰 Budget</a>
                    <a href="#" class="block hover:text-pink-500 border-b border-pink-200 pb-2" @click="alert('Calendrier section clicked!'); open = false">📆 Calendrier</a>
                    <a href="#" class="block hover:text-pink-500 border-b border-pink-200 pb-2" @click="alert('Recettes section clicked!'); open = false">🍰 Recettes</a>
                    <a href="#" class="block hover:text-pink-500 border-b border-pink-200 pb-2" @click="alert('Outils de calcul section clicked!'); open = false">🧮 Outils de calcul</a>

                    <!-- Fermer la fenêtre pop-up -->
                    <button @click="open = false" class="mt-4 text-pink-500 hover:underline">
                        ✖️ Fermer
                    </button>
                </div>
            </div>
        </div>

        <!-- ⚙️ RÉGLAGES + DÉCONNEXION ORDINATEUR -->
        <div class="hidden sm:flex gap-4 items-center">
            {{-- Affiche les boutons de profil + déconnexion sur écran moyen et plus --}}
            <a href="{{ route('profile.edit') }}" title="Réglages" class="hover:scale-110 transition">
                ⚙️
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Déconnexion" class="hover:scale-110 transition">
                    🚪
                </button>
            </form>
        </div>
    </header>

    <!-- 🔸 CONTENU -->
    <main class="flex-1 p-4">
        {{-- Section principale de la page : on injecte le contenu spécifique avec @yield --}}
        @yield('content')
    </main>

</body>
</html>
