@extends('layouts.app') 
{{-- On utilise le layout principal de Laravel (layouts/app.blade.php) --}}

@section('content') 
{{-- Début de la section "content" qu’on va insérer dans le layout principal --}}

<div class="max-w-7xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">
    {{-- Conteneur principal avec fond blanc, bord arrondi, ombre, et espace entre les blocs --}}

    <div class="flex flex-col md:flex-row gap-8">
        {{-- Affichage en colonne sur mobile, en ligne (row) sur écrans moyens et plus --}}

        {{-- Colonne de gauche (Horaires de prière et formulaire) --}}
        <div class="flex-1 bg-pink-50 p-4 rounded-xl shadow-md">
            {{-- Prend toute la place dispo, fond rose clair, arrondi, ombre --}}

            {{-- Prochaine prière dans une carte --}}
            <div class="mt-6 bg-pink-50 border border-pink-300 rounded-xl p-4 text-center shadow">
                {{-- Carte avec fond rose, bordure rose, texte centré --}}

                <p class="text-sm text-pink-700 font-semibold">
                    🕰️ Prochaine prière : <span class="text-pink-900">{{ $nextName }}</span>
                    {{-- Affiche le nom de la prochaine prière calculée dans le contrôleur --}}
                </p>

                <p class="text-sm text-pink-700 mt-1">
                    ⏳ Dans : <span id="countdown" class="font-mono">--h --m --s</span>
                    {{-- Affiche un compte à rebours mis à jour par JavaScript --}}
                </p>
            </div>

            <h2 class="text-xl font-bold text-pink-600 text-center mt-6">Horaires de prière</h2>
            {{-- Titre au-dessus du tableau d’horaires --}}

            {{-- Formulaire --}}
            <form method="GET" action="/islam" class="space-y-2 mt-6">
                {{-- Formulaire qui recharge la page avec les horaires selon la ville/pays --}}

                <input name="ville" value="{{ request('ville') }}" placeholder="Ville"
                    class="w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-pink-400">
                {{-- Champ ville rempli automatiquement depuis l'URL si présent --}}

                <input name="pays" value="{{ request('pays') ?? 'France' }}" placeholder="Pays"
                    class="w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-pink-400">
                {{-- Champ pays, par défaut France --}}

                <button type="submit"
                    class="w-full bg-pink-500 text-white py-2 rounded-lg text-sm hover:bg-pink-600">
                    Voir les horaires
                </button>
                {{-- Bouton rose pour envoyer le formulaire --}}
            </form>

            {{-- Affichage des horaires --}}
            @if(isset($timings))
                {{-- Si on a les horaires, on les affiche --}}

                <div class="text-center text-pink-600 font-semibold mt-4">
                    {{ $city }}, {{ $country }}
                    {{-- Affiche la ville/pays choisis --}}
                </div>

                {{-- Grille des horaires - ligne 1 --}}
                <div class="flex justify-center gap-4 mt-6">
                    @php $i = 0; @endphp
                    @foreach ($timings as $name => $time)
                        @if ($i < 3)
                            <div class="w-20 h-20 bg-pink-100 border border-pink-300 rounded-full shadow flex flex-col items-center justify-center text-xs sm:text-sm">
                                {{-- Affiche les 3 premières prières dans des bulles rondes --}}
                                <div class="font-semibold text-pink-600">{{ $name }}</div>
                                <div class="font-mono text-gray-700 text-sm">{{ $time }}</div>
                            </div>
                        @endif
                        @php $i++; @endphp
                    @endforeach
                </div>

                {{-- Grille des horaires - ligne 2 --}}
                <div class="flex justify-center gap-4 mt-4">
                    @foreach ($timings as $name => $time)
                        @if ($loop->index >= 3)
                            <div class="w-20 h-20 bg-pink-100 border border-pink-300 rounded-full shadow flex flex-col items-center justify-center text-xs sm:text-sm">
                                {{-- Affiche les 2 autres prières restantes --}}
                                <div class="font-semibold text-pink-600">{{ $name }}</div>
                                <div class="font-mono text-gray-700 text-sm">{{ $time }}</div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Avertissement --}}
                <div class="mt-4 p-3 bg-yellow-100 text-yellow-800 text-sm rounded-lg">
                    ⚠️ Les horaires affichés sont indicatifs. Ils peuvent varier légèrement selon les écoles, mosquées ou méthodes de calcul locales.
                    {{-- Message d’information en bas --}}
                </div>
            @endif
        </div>

        {{-- Séparation Visuelle --}}
        <div class="w-px bg-pink-200 hidden md:block mx-6"></div>
        {{-- Petite ligne rose verticale visible en desktop uniquement --}}

        {{-- Colonne de droite (Boussole Qibla) --}}
        <div class="flex-1 bg-pink-50 p-4 rounded-xl shadow-md">
            <div class="text-center my-8">
                <h2 class="text-lg font-bold mb-4">🧭 Boussole Qibla</h2>

                {{-- Cercle avec flèche vers la Qibla --}}
                <div id="compass-container" class="relative w-60 h-60 mx-auto rounded-full border-4 border-pink-400">
                    <div id="needle" class="absolute top-0 left-1/2 w-1 h-28 bg-pink-600 origin-bottom transform -translate-x-1/2"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-pink-600 font-bold text-3xl">
                        🕋
                    </div>
                </div>

                <p id="status" class="mt-4 text-sm text-gray-600">Chargement de la boussole…</p>
                {{-- Texte mis à jour selon autorisation et alignement --}}
            </div>
        </div>
    </div>

    {{-- Script JavaScript pour compte à rebours et Qibla --}}
    <script>
        // Crée une date cible basée sur l’heure de la prochaine prière
        const target = new Date("{{ now()->addHours($diff->h)->addMinutes($diff->i)->addSeconds($diff->s)->format('c') }}");

        function tick() {
            const diff = (target - new Date()) / 1000;
            if (diff < 0) return document.getElementById('countdown').innerText = '0h 0m 0s';

            const h = Math.floor(diff / 3600),
                m = Math.floor((diff % 3600) / 60),
                s = Math.floor(diff % 60);

            document.getElementById('countdown').innerText = `${h}h ${m}m ${s}s`;
        }

        setInterval(tick, 1000); // Met à jour chaque seconde
        tick(); // Démarre le compte à rebours

        // Boussole vers la Qibla
        let qiblaAngle = null;

        navigator.geolocation.getCurrentPosition(pos => {
            const lat = pos.coords.latitude;
            const lon = pos.coords.longitude;

            fetch(`https://api.aladhan.com/v1/qibla/${lat}/${lon}`)
                .then(res => res.json())
                .then(data => {
                    qiblaAngle = data.data.direction;
                    document.getElementById("status").textContent = "Autorisation en attente...";
                    askPermission(); // Demande permission pour accéder à l’orientation
                });
        }, () => {
            document.getElementById("status").textContent = "📍 Position non autorisée.";
        });

        function askPermission() {
            if (
                typeof DeviceOrientationEvent !== "undefined" &&
                typeof DeviceOrientationEvent.requestPermission === "function"
            ) {
                DeviceOrientationEvent.requestPermission().then(state => {
                    if (state === "granted") {
                        window.addEventListener("deviceorientationabsolute", rotateNeedle, true);
                    } else {
                        document.getElementById("status").textContent = "⛔️ Permission refusée.";
                    }
                }).catch(() => {
                    document.getElementById("status").textContent = "Erreur lors de la demande de permission.";
                });
            } else {
                // Pour Android ou navigateurs où la permission est auto
                window.addEventListener("deviceorientationabsolute", rotateNeedle, true);
            }
        }

        function rotateNeedle(e) {
            if (!e.alpha || qiblaAngle === null) return;

            const compassHeading = 360 - e.alpha;
            const relativeAngle = (qiblaAngle - compassHeading + 360) % 360;

            const needle = document.getElementById("needle");
            needle.style.transform = `translateX(-50%) rotate(${relativeAngle}deg)`;

            const diff = Math.abs(relativeAngle - 0);
            if (diff < 5 || diff > 355) {
                document.getElementById("status").textContent = "✅ Bien aligné(e) vers la Qibla";
            } else {
                document.getElementById("status").textContent = "🔄 Oriente-toi vers la flèche 🕋";
            }
        }
    </script>
</div>
@endsection
