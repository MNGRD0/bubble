@extends('layouts.app')

@section('content')
<div class="container max-w-lg">
    <h2 class="text-xl font-bold mb-4">Modifier l’événement</h2>

    <form action="{{ route('evenements.update', $evenement) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1">Titre</label>
            <input type="text" name="titre" value="{{ $evenement->titre }}" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Date et heure</label>
            <input type="datetime-local" name="date" value="{{ $evenement->date->format('Y-m-d\TH:i') }}" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Sticker</label>
            <select name="sticker_id" class="w-full p-2 border rounded" required>
                @foreach ($stickers as $sticker)
                    <option value="{{ $sticker->id }}" @if($evenement->sticker_id == $sticker->id) selected @endif>
                        {{ $sticker->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Calendrier</label>
            <select name="calendrier_id" class="w-full p-2 border rounded" required>
                @foreach ($calendriers as $calendrier)
                    <option value="{{ $calendrier->id }}" @if($evenement->calendrier_id == $calendrier->id) selected @endif>
                        {{ $calendrier->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Description</label>
            <texta
