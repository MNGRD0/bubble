<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Bubble</title>

    <!-- Polices kawaii -->
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue&family=Indie+Flower&display=swap" rel="stylesheet">

    <!-- CSS + JS compilés par Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'], true)

    @yield('head') <!-- Pour ajouter des styles CSS spécifiques à chaque vue -->
</head>

<body class="bg-pink-50 text-pink-900 font-sans min-h-screen flex flex-col">

    <!-- 🔺 HEADER -->
    <header class="bg-pink-200 p-4 shadow rounded-b-3xl flex items-center justify-between relative z-50">
        <!-- 👤 Utilisateur -->
        <div class="flex items-center gap-3">
            @if(Auth::user()->photo)
                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profil" class="w-10 h-10 rounded-full object-cover">
            @else
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-pink-400 font-bold">👤</div>
            @endif
            <span class="font-semibold hidden sm:inline">Bonjour, {{ Auth::user()->name }} 🌸</span>
        </div>

        <!-- 🍔 MENU MOBILE -->
        <div class="block sm:hidden" x-data="{ open: false }">
            <button @click="open = !open" class="text-xl" title="Menu">☰</button>

            <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" @click.self="open = false">
                <div class="bg-white p-6 rounded-lg w-4/5 max-w-md shadow-md space-y-4">
                    <h2 class="text-xl font-semibold text-pink-600 mb-4">Sélectionne une section</h2>
                    <a href="#" class="block hover:text-pink-500 border-b border-pink-200 pb-2">📝 To-do</a>
                    <a href="#" class="block hover:text-pink-500 border-b border-pink-200 pb-2">📔 Journal</a>
                    <a href="#" class="block hover:text-pink-500 border-b border-pink-200 pb-2">💰 Budget</a>
                    <a href="#" class="block hover:text-pink-500 border-b border-pink-200 pb-2">📆 Calendrier</a>
                    <a href="#" class="block hover:text-pink-500 border-b border-pink-200 pb-2">🍰 Recettes</a>
                    <a href="#" class="block hover:text-pink-500 border-b border-pink-200 pb-2">🧮 Outils de calcul</a>
                    <button @click="open = false" class="mt-4 text-pink-500 hover:underline">✖️ Fermer</button>
                </div>
            </div>
        </div>

        <!-- ⚙️ MENU ORDI -->
        <div class="hidden sm:flex gap-4 items-center">
            <a href="{{ route('profile.edit') }}" title="Réglages" class="hover:scale-110 transition">⚙️</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Déconnexion" class="hover:scale-110 transition">🚪</button>
            </form>
        </div>
    </header>

    <!-- 🔸 CONTENU -->
    <main class="flex-1 p-4">
        @yield('content')
    </main>

    @yield('scripts') <!-- Pour TinyMCE ou JS spécifique aux vues -->
</body>
</html>
