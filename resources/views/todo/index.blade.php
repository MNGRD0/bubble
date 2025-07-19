@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-md space-y-6">

    <!-- 📝 Titre -->
    <h1 class="text-2xl font-semibold text-pink-600 text-center">📝 Ma To-do List</h1>

    <!-- ✅ Message de succès -->
    @if(session('task_added'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">
            🟢 <strong>{{ session('task_added') }}</strong>
        </div>
    @endif

    <!-- ➕ Formulaire de création de catégorie -->
    <form method="POST" action="{{ route('todo.storeCategory') }}" class="space-y-4">
        @csrf
        <div>
            <label for="name" class="text-sm text-pink-600">Nouvelle catégorie :</label>
            <input type="text" name="name" id="name"
                   class="w-full p-3 border border-pink-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-400"
                   placeholder="Nom de la catégorie..." required>
        </div>
        <button type="submit" class="w-full bg-pink-500 text-white py-2 rounded-lg hover:bg-pink-600">
            Créer une catégorie
        </button>
    </form>

    <!-- 🔽 Filtre des catégories -->
    <form method="GET" action="{{ route('todo.index') }}" class="flex space-x-4 mb-6">
        <select name="sort_by"
                class="p-2 border border-pink-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-400 text-sm">
            <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>A à Z</option>
            <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Z à A</option>
            <option value="created_at_desc" {{ request('sort_by') == 'created_at_desc' ? 'selected' : '' }}>Dernier ajout</option>
            <option value="created_at_asc" {{ request('sort_by') == 'created_at_asc' ? 'selected' : '' }}>Ajout ancien</option>
        </select>
        <button type="submit"
                class="bg-pink-500 text-white py-2 px-3 rounded-lg hover:bg-pink-600 text-sm">
            Filtrer
        </button>
    </form>

    <!-- 📦 Liste des catégories -->
    <div class="space-y-4 mt-6">
        @foreach($categories as $category)
            <div class="relative flex flex-col sm:flex-row justify-between items-center p-4 bg-pink-100 rounded-lg shadow-md space-y-4 sm:space-y-0 sm:space-x-4">

                <!-- ❌ Bouton Supprimer en haut à droite (mobile) -->
                <form method="POST" action="{{ route('todo.destroyCategory', $category->id) }}"
                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');"
                      class="absolute sm:static top-2 right-2 sm:ml-auto sm:order-last">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-pink-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-pink-600 text-lg"
                            aria-label="Supprimer la catégorie" title="Supprimer">
                        -
                    </button>
                </form>

                <!-- 📂 Nom de la catégorie -->
                <div class="flex items-center space-x-2 w-full sm:w-auto">
                    <a href="{{ route('todo.showCategory', $category->id) }}"
                       class="text-pink-600 text-lg font-medium">
                        {{ $category->name }}
                    </a>
                </div>

                <!-- ➕ Ajouter une tâche -->
                <form method="POST" action="{{ route('todo.storeTask', $category->id) }}" class="w-full sm:w-auto">
                    @csrf
                    <div class="flex space-x-2">
                        <input type="text" name="task"
                               class="w-full sm:w-64 p-2 border rounded-lg"
                               placeholder="Nouvelle tâche" required>
                        <button type="submit"
                                class="bg-pink-500 text-white py-1 px-3 rounded-lg hover:bg-pink-600">
                            Ajouter
                        </button>
                    </div>
                </form>

            </div>
        @endforeach
    </div>
</div>

@endsection
