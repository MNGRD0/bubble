<?php

namespace App\Http\Controllers;

// On importe la classe Request (pour récupérer les infos du formulaire ou URL)
use Illuminate\Http\Request;
// On importe le client HTTP de Laravel pour appeler l'API AlAdhan
use Illuminate\Support\Facades\Http;

class IslamicController extends Controller
{
    // La méthode qui va afficher la page avec les horaires de prière
    public function index(Request $request)
    {
        // On récupère la ville depuis l’URL ou le formulaire, ou on met "Paris" par défaut
        $city = $request->input('ville', 'Paris');
        // Pareil pour le pays, on met "France" si rien n’est précisé
        $country = $request->input('pays', 'France');

        // On appelle l’API AlAdhan avec la ville et le pays choisis
        $response = Http::get("https://api.aladhan.com/v1/timingsByCity", [
            'city' => $city,
            'country' => $country,
            'method' => 2, // méthode de calcul (2 = Muslim World League)
        ]);

        // Si la réponse n’est pas correcte, on retourne en arrière avec une erreur
        if (!$response->ok()) {
            return back()->withErrors(['api' => 'Impossible de récupérer les horaires pour cette ville.']);
        }

        // On transforme la réponse JSON de l’API en tableau PHP
        $data = $response->json();

        // On prend uniquement les horaires des 5 prières principales
        $timings = collect($data['data']['timings'])->only([
            'Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'
        ]);

        // ------------------------------
        // Calcul de la prochaine prière
        // ------------------------------

        $now = now(); // l’heure actuelle
        $nextName = null; // nom de la prochaine prière (on initialise)

        // On parcourt chaque horaire pour voir laquelle est la prochaine
        foreach ($timings as $name => $time) {
            $timeHM = substr($time, 0, 5); // on ne garde que HH:MM
            $dt = now()->setTimeFromTimeString($timeHM); // on crée une heure avec la date d’aujourd’hui
            if ($now->lt($dt)) { // si l'heure actuelle est avant cette prière
                $nextName = $name; // on note le nom
                $next = $dt;       // et l'heure
                break; // on arrête la boucle dès qu’on en trouve une
            }
        }

        // Si toutes les prières sont passées (ex: il est 23h), on prépare Fajr du lendemain
        if (!isset($next)) {
            $nextName = 'Fajr';
            $next = now()->addDay()->setTimeFromTimeString(substr($timings['Fajr'], 0, 5));
        }

        // On calcule la différence de temps entre maintenant et la prochaine prière
        $diff = $next->diff($now);

        // On retourne la vue 'islamic.index' avec toutes les données nécessaires
        return view('islamic.index', [
            'city' => ucfirst($city),      // ville avec majuscule au début
            'country' => ucfirst($country),// idem pour le pays
            'timings' => $timings,         // les 5 horaires de prière
            'nextName' => $nextName,       // la prochaine prière à venir
            'diff' => $diff,               // différence de temps pour le compte à rebours
        ]);
    }
}
