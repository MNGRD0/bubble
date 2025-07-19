@extends('layouts.app')
{{-- On utilise le layout principal de l'application (avec le header, le body, etc.) --}}

@section('content')
{{-- On injecte ici le contenu principal de la page --}}

<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl space-y-6">
    {{-- Conteneur central blanc, avec ombre douce, coins arrondis et espacement entre blocs --}}

    <!-- Bouton retour avec texte et symbole -->
    <div class="flex justify-start mb-4">
        <a href="{{ route('todo.index') }}" class="text-pink-500 text-lg hover:text-pink-600 flex items-center space-x-2">
            <span class="text-pink-500 text-xl">←</span> <!-- Flèche de retour -->
            <span>Retour</span>
        </a>
    </div>

    <!-- Titre de la catégorie -->
    <h1 class="text-2xl font-semibold text-pink-600 text-center">{{ $category->name }}</h1>
    {{-- Nom de la catégorie affiché en gros au centre --}}

    <!-- Message de succès pour l'ajout d'une tâche -->
    @if(session('task_added'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">
            🟢 <strong>{{ session('task_added') }}</strong>
        </div>
    @endif

    <!-- Formulaire pour ajouter une nouvelle tâche -->
    <form method="POST" action="{{ route('todo.storeTask', $category->id) }}" class="space-y-4 mt-6">
        @csrf
        {{-- Champ texte pour nommer la tâche --}}
        <div>
            <label for="task" class="text-sm text-pink-600">Nouvelle tâche :</label>
            <input type="text" name="task" id="task"
                class="w-full p-3 border border-pink-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-400"
                placeholder="Nom de la tâche..." required>
        </div>
        <button type="submit" class="w-full bg-pink-500 text-white py-2 rounded-lg hover:bg-pink-600">
            Ajouter la tâche
        </button>
    </form>

    <!-- Liste des tâches de la catégorie -->
    <div class="space-y-4 mt-6">
        <h2 class="text-lg font-semibold text-pink-600">Tâches en cours</h2>
        @foreach($tasks as $task)
            @if(!$task->completed)
                {{-- Affiche uniquement les tâches non terminées --}}
                <div class="flex justify-between items-center p-3 bg-pink-100 rounded-lg">
                    <div class="flex items-center space-x-2 w-full sm:w-auto">
                        {{-- Case à cocher pour marquer la tâche comme terminée --}}
                        <form method="POST" action="{{ route('todo.completeTask', $task->id) }}">
                            @csrf
                            @method('PATCH')
                            <input type="checkbox" name="completed" id="completed"
                                onchange="this.form.submit()" @if($task->completed) checked @endif>
                        </form>
                        <span class="text-pink-600 text-lg">{{ $task->name }}</span>
                    </div>

                    <!-- Bouton de suppression de la tâche -->
                    <form method="POST" action="{{ route('todo.destroyTask', $task->id) }}"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-pink-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-pink-600 text-lg"
                            aria-label="Supprimer la tâche" title="Supprimer la tâche">
                            -
                        </button>
                    </form>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Tâches terminées -->
    <div class="space-y-4 mt-6">
        <h2 class="text-lg font-semibold text-pink-600">Tâches terminées</h2>
        @foreach($tasks as $task)
            @if($task->completed)
                {{-- Affiche les tâches marquées comme terminées --}}
                <div class="flex justify-between items-center p-3 bg-pink-100 rounded-lg">
                    <div class="flex items-center space-x-2 w-full sm:w-auto">
                        <span class="text-pink-600 text-lg line-through">{{ $task->name }}</span>
                        {{-- Nom barré pour montrer qu'elle est finie --}}
                    </div>

                    <!-- Boutons pour restaurer ou supprimer -->
                    <div class="flex space-x-1">
                        <!-- Restaurer la tâche (la remet comme non terminée) -->
                        <form method="POST" action="{{ route('todo.restoreTask', $task->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-pink-600 text-lg"
                                aria-label="Restaurer la tâche" title="Restaurer la tâche">
                                ⟲
                            </button>
                        </form>

                        <!-- Supprimer définitivement la tâche -->
                        <form method="POST" action="{{ route('todo.destroyTask', $task->id) }}"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-pink-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-pink-600 text-lg"
                                aria-label="Supprimer la tâche" title="Supprimer la tâche">
                                -
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Formulaire pour supprimer la catégorie -->
    <form method="POST" action="{{ route('todo.destroyCategory', $category->id) }}"
        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');"
        class="mt-6 flex justify-center">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="bg-red-500 text-white py-2 px-6 rounded-lg flex items-center space-x-2 hover:bg-red-600 text-lg">
            <span>⚠️</span>
            <span>Supprimer la catégorie</span>
        </button>
    </form>

</div>
@endsection
