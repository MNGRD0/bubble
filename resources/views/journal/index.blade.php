@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-center text-pink-600 mb-8">📚 Mes Journaux</h1>

    <!-- Bouton ajouter -->
    <div class="text-center mb-6">
        <a href="{{ route('journaux.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-xl shadow">
            ➕ Créer un nouveau journal
        </a>
    </div>

    @if($journaux->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-10">
            @foreach($journaux as $journal)
                <a href="{{ route('journaux.show', $journal) }}" class="block bg-white shadow rounded-2xl overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="h-40 bg-cover bg-center" style="background-image: url('{{ $journal->image ? asset('storage/' . $journal->image) : asset('images/default-journal.jpg') }}');">
                    </div>
                    <div class="p-4 text-center" style="background-color: {{ $journal->couleur ?? '#F9A8D4' }};">
                        <h2 class="text-lg font-bold text-white truncate">{{ $journal->nom }}</h2>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-500 mt-8">Tu n'as pas encore créé de journal.</p>
    @endif
</div>
@endsection
