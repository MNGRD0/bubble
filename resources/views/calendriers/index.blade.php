@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-xl font-bold mb-4">Mes calendriers</h2>

    <p>Ici, tu pourras afficher, modifier ou supprimer tes calendriers personnalisés (ex: “Travail”, “Perso”, etc.).</p>

    <a href="{{ route('calendriers.create') }}" class="mt-4 inline-block bg-pink-500 text-white px-4 py-2 rounded">
        + Créer un nouveau calendrier
    </a>
</div>
@endsection
