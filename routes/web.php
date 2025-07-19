<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/accueil', function () {
    return view('accueil');
})->middleware(['auth', 'verified'])->name('accueil');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return redirect('/accueil');
});

Route::get('/islam', [App\Http\Controllers\IslamicController::class, 'index'])->middleware(['auth']);

Route::middleware('auth')->group(function () {
    // Afficher toutes les catégories
    Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');

    // Créer une catégorie
    Route::post('/todo/category', [TodoController::class, 'storeCategory'])->name('todo.storeCategory');

    // Afficher une catégorie spécifique avec ses tâches
    Route::get('/todo/category/{id}', [TodoController::class, 'showCategory'])->name('todo.showCategory');

    // Ajouter une tâche à une catégorie
    Route::post('/todo/category/{id}/task', [TodoController::class, 'storeTask'])->name('todo.storeTask');

    // Marquer une tâche comme terminée
    Route::patch('/todo/task/{id}/complete', [TodoController::class, 'completeTask'])->name('todo.completeTask');

    // Supprimer une tâche à l'intérieur du groupe
    Route::delete('/todo/task/{id}', [TodoController::class, 'destroyTask'])->name('todo.destroyTaskInsideGroup');
});

// Supprimer une catégorie
Route::delete('/todo/category/{categoryId}', [TodoController::class, 'destroyCategory'])->name('todo.destroyCategory');

// Supprimer une tâche en dehors du groupe d'authentification
Route::delete('/todo/task/{taskId}', [TodoController::class, 'destroyTask'])->name('todo.destroyTaskOutsideGroup');

// Restaurer une tâche
Route::patch('/todo/restore/{taskId}', [TodoController::class, 'restoreTask'])->name('todo.restoreTask');


require __DIR__.'/auth.php';
