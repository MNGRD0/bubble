@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-xl font-bold mb-4">Calendrier : {{ $calendrier->nom }}</h2>
    <p>Ce calendrier contiendra ses événements liés plus tard.</p>
</div>
@endsection
