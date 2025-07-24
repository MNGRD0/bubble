@extends('layouts.app')

@section('content')
@php
    use Carbon\Carbon;

    $monthStart = Carbon::create($date->year, $date->month, 1);
    $monthTitle = ucfirst($monthStart->translatedFormat('F Y'));

    // Calculer la date du début (lundi avant le 1er du mois)
    $firstDayOfWeek = ($monthStart->dayOfWeekIso - 1);
    $start = $monthStart->copy()->subDays($firstDayOfWeek);

    // Générer les 42 jours (6 semaines * 7 jours)
    $days = [];
    $current = $start->copy();
    for ($i = 0; $i < 42; $i++) {
        $days[] = $current->copy();
        $current->addDay();
    }
@endphp

<div class="container mx-auto px-4">
    {{-- Navigation mois --}}
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('evenements.mois', [$date->copy()->subMonth()->year, $date->copy()->subMonth()->month]) }}"
           class="text-pink-500 text-lg font-bold hover:underline">←</a>

        <h2 class="text-2xl font-bold text-pink-600">{{ $monthTitle }}</h2>

        <a href="{{ route('evenements.mois', [$date->copy()->addMonth()->year, $date->copy()->addMonth()->month]) }}"
           class="text-pink-500 text-lg font-bold hover:underline">→</a>
    </div>

    {{-- Jours de la semaine --}}
    <div class="grid grid-cols-7 text-center font-semibold text-white bg-pink-400 rounded-t">
        @foreach (['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $day)
            <div class="py-2 border border-pink-300">{{ $day }}</div>
        @endforeach
    </div>

    {{-- Grille 6x7 --}}
    <div class="grid grid-cols-7 bg-pink-100 border border-pink-300">
        @foreach ($days as $day)
            @php
                $isCurrentMonth = $day->month === $date->month;
                $dayKey = $day->format('Y-m-d');
            @endphp

            <div class="h-[100px] p-1 text-sm border border-pink-200 relative 
                {{ $isCurrentMonth ? 'bg-white' : 'bg-pink-50 text-gray-400' }}">
                
                {{-- Numéro du jour --}}
                <div class="text-xs font-bold text-right">{{ $day->day }}</div>

                {{-- Événements du jour --}}
                @if ($evenements->has($dayKey))
                    @foreach ($evenements[$dayKey] as $event)
                        <div class="mt-1 px-1 py-0.5 text-xs rounded text-white truncate"
                             style="background-color: {{ $event->sticker->couleur }}">
                            {{ $event->titre }}
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
