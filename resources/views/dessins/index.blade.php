@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white border border-pink-300 shadow-xl rounded-xl p-4" style="background-color: #ffeef5">
    {{-- Barre style Windows XP --}}
    <div class="flex items-center justify-between bg-pink-200 text-pink-900 font-bold px-3 py-2 rounded-t-lg border-b border-pink-400">
        <span>Bubble Paint</span>
        <div class="flex gap-1 items-center">
            <button class="w-4 h-4 bg-yellow-300 rounded-sm border border-yellow-600"></button>
            <button class="w-4 h-4 bg-green-400 rounded-sm border border-green-600"></button>
            <button onclick="clearCanvas()" class="w-4 h-4 bg-red-500 rounded-sm border border-red-700"></button>
        </div>
    </div>

    {{-- Outils --}}
    <div class="flex flex-wrap md:flex-nowrap items-center justify-between px-3 py-3 bg-pink-100 border-b border-pink-300 gap-3">
        {{-- Taille du pinceau --}}
        <div class="flex items-center gap-2 text-sm">
            <span class="font-semibold">Taille:</span>
            <div class="flex gap-1">
                <button onclick="setBrushSize(2)" class="w-5 h-5 bg-pink-300 rounded-full border border-pink-400"></button>
                <button onclick="setBrushSize(5)" class="w-6 h-6 bg-pink-400 rounded-full border border-pink-500"></button>
                <button onclick="setBrushSize(10)" class="w-8 h-8 bg-pink-500 rounded-full border border-pink-600"></button>
            </div>
        </div>

        {{-- Couleur --}}
        <div class="flex items-center gap-2">
            <span class="text-sm font-semibold">Couleur:</span>
            <input type="color" id="brush-color" value="#ff69b4" class="w-8 h-8 border border-pink-400 rounded-full overflow-hidden appearance-none">
        </div>

        {{-- Actions --}}
        <div class="flex gap-2">
            <button onclick="clearCanvas()" class="bg-white text-pink-600 border border-pink-400 px-2 py-1 rounded hover:bg-pink-100 text-sm">🧹 Effacer</button>
            <button onclick="saveDrawing()" class="bg-pink-500 text-white px-3 py-1 rounded hover:bg-pink-600 text-sm">💾 Sauvegarder</button>
        </div>
    </div>

    {{-- Zone de dessin --}}
    <div class="p-4 bg-white border border-pink-300 rounded-b-xl overflow-x-auto">
        <canvas id="drawingCanvas" class="border border-gray-300 rounded shadow-md w-full max-w-full sm:w-[800px] sm:h-[500px] touch-none" style="width: 100%; height: 500px;"></canvas>
    </div>
</div>

{{-- Dessins enregistrés --}}
@if ($dessins->count())
    <h3 class="text-pink-600 font-bold mt-6 mb-2">🎨 Voir les dessins enregistrés</h3>

    {{-- Supprimer tous les dessins --}}
    <form action="{{ route('dessins.destroyAll') }}" method="POST" onsubmit="return confirm('Supprimer TOUS les dessins ?')" class="mb-4">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
            🗑️ Supprimer tous les dessins
        </button>
    </form>

    <div class="flex flex-wrap gap-3">
        @foreach ($dessins as $dessin)
            <div class="relative w-24 h-24 border border-pink-300 rounded shadow-sm overflow-hidden">
                {{-- Supprimer ce dessin --}}
                <form action="{{ route('dessins.destroy', $dessin) }}" method="POST" 
                      class="absolute top-0 left-0 z-10"
                      onsubmit="return confirm('Supprimer ce dessin ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-br">✕</button>
                </form>

                {{-- Télécharger le dessin --}}
                <a href="{{ asset('storage/' . $dessin->chemin) }}" download 
                   class="absolute top-0 right-0 z-10 bg-pink-400 text-white text-xs px-1 rounded-bl">💾</a>

                {{-- Cliquer pour charger --}}
                <img onclick="loadDrawing('{{ asset('storage/' . $dessin->chemin) }}')" 
                     src="{{ asset('storage/' . $dessin->chemin) }}" 
                     alt="dessin" 
                     class="w-full h-full object-cover cursor-pointer">
            </div>
        @endforeach
    </div>
@endif

<script>
let canvas = document.getElementById('drawingCanvas');
let ctx = canvas.getContext('2d');
let painting = false;
let currentSize = 5;

// Retina fix
const dpr = window.devicePixelRatio || 1;
function resizeCanvas() {
    const styleHeight = +getComputedStyle(canvas).getPropertyValue("height").slice(0, -2);
    const styleWidth = +getComputedStyle(canvas).getPropertyValue("width").slice(0, -2);
    canvas.width = styleWidth * dpr;
    canvas.height = styleHeight * dpr;
    ctx.scale(dpr, dpr);
}
resizeCanvas();
window.addEventListener('resize', resizeCanvas);

function getCoords(e) {
    let rect = canvas.getBoundingClientRect();
    let clientX = e.touches ? e.touches[0].clientX : e.clientX;
    let clientY = e.touches ? e.touches[0].clientY : e.clientY;
    return {
        x: clientX - rect.left,
        y: clientY - rect.top
    };
}

function startPosition(e) {
    e.preventDefault();
    painting = true;
    const { x, y } = getCoords(e);
    ctx.beginPath();
    ctx.moveTo(x, y);
}
function draw(e) {
    if (!painting) return;
    e.preventDefault();
    const { x, y } = getCoords(e);
    ctx.lineWidth = currentSize;
    ctx.lineCap = 'round';
    ctx.strokeStyle = document.getElementById('brush-color').value;
    ctx.lineTo(x, y);
    ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(x, y);
}
function endPosition(e) {
    e.preventDefault();
    painting = false;
    ctx.closePath();
}

function setBrushSize(size) {
    currentSize = size;
}
function clearCanvas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

function saveDrawing() {
    let dataUrl = canvas.toDataURL('image/png');
    fetch("{{ route('dessins.store') }}", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ image: dataUrl })
    })
    .then(response => {
        if (response.ok) {
            location.reload(); // recharge les dessins
        } else {
            alert("Erreur lors de l'enregistrement.");
        }
    })
    .catch(() => alert("Erreur réseau."));
}

function loadDrawing(url) {
    let img = new Image();
    img.onload = () => {
        clearCanvas();
        ctx.drawImage(img, 0, 0, canvas.width / dpr, canvas.height / dpr);
    };
    img.src = url;
}

// Événements
canvas.addEventListener('mousedown', startPosition);
canvas.addEventListener('mousemove', draw);
canvas.addEventListener('mouseup', endPosition);
canvas.addEventListener('mouseleave', endPosition);
canvas.addEventListener('touchstart', startPosition, { passive: false });
canvas.addEventListener('touchmove', draw, { passive: false });
canvas.addEventListener('touchend', endPosition);
</script>
@endsection
