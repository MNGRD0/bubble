@extends('layouts.app')

@section('head')
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue&family=Indie+Flower&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-3xl font-bold text-center text-pink-600 mb-6">📖 {{ $journal->nom }}</h1>

    <div class="mb-6">
        <a href="{{ route('journaux.index') }}" class="text-pink-600 hover:underline">
            ← Retour à mes journaux
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 🌸 Fenêtre style Windows XP kawaii -->
    <div class="bg-white border border-pink-300 rounded-xl shadow-lg overflow-hidden">

        <!-- Barre de titre rose pastel avec 3 ronds -->
        <div class="bg-pink-400 px-3 py-2 flex items-center justify-between text-sm text-white font-bold">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 bg-pink-300 rounded-full"></span>
                <span class="w-3 h-3 bg-pink-200 rounded-full"></span>
                <span class="w-3 h-3 bg-pink-100 rounded-full"></span>
                <span class="ml-4">Éditeur de journal</span>
            </div>
            <form action="{{ route('journaux.destroy', $journal) }}" method="POST" onsubmit="return confirm('Supprimer ce journal ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-white hover:underline">✖</button>
            </form>
        </div>

        <!-- Formulaire d’écriture de page -->
        <form action="{{ route('journaux.update', $journal) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

           <label for="nom" class="block font-semibold text-pink-600 mb-1 mt-4 ml-4">Nom du journal</label>
<input type="text" name="nom" id="nom" 
       value="{{ old('nom', $journal->nom) }}"
       class="w-full max-w-md mx-auto px-4 py-2 text-lg border border-pink-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400"
       style="height: 36px; margin-left: 1rem; margin-right: 1rem; margin-bottom: 1rem;" required>



            <textarea id="contenu" name="contenu" class="w-full min-h-[400px] p-4">{{ old('contenu', $journal->contenu) }}</textarea>

            <div class="text-center p-4">
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-6 rounded-xl shadow">
                    💾 Enregistrer le journal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.tiny.cloud/1/5bsq9nmeuyy5b50fu81il4isibw1if5p5z5n956351x3u1z9/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
tinymce.init({
    selector: '#contenu',
    height: 500,
    width: '100%',
    menubar: true,
    branding: false,
    plugins: 'lists link image imagetools emoticons codesample table paste wordcount autoresize',
    toolbar: 'undo redo | styleselect | fontselect fontsizeselect | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright | image link | bullist numlist | removeformat',
    font_family_formats: `
        Comic Neue=comic neue,cursive;
        Indie Flower=indie flower,cursive;
        Arial=arial,helvetica,sans-serif;
        Times New Roman=times new roman,times;
        Courier New=courier new,courier;
        Georgia=georgia,palatino;
        Verdana=verdana,geneva;
    `,
    image_caption: true,
    object_resizing: "img",
    image_advtab: true,
    content_style: `
        @import url('https://fonts.googleapis.com/css2?family=Comic+Neue&family=Indie+Flower&display=swap');
        body {
            font-family: 'Comic Neue', cursive;
            background-color: #ffffff;
            padding: 20px;
            font-size: 16px;
        }
        img {
            max-width: 100%;
            height: auto;
        }
    `,
    image_title: true,
    automatic_uploads: true,
    file_picker_types: 'image',
    file_picker_callback: function(cb, value, meta) {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.onchange = function() {
            const file = this.files[0];
            const reader = new FileReader();
            reader.onload = function () {
                cb(reader.result, { title: file.name });
            };
            reader.readAsDataURL(file);
        };
        input.click();
    }
});
</script>
@endsection
