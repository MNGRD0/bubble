<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\RecetteController;
use App\Http\Controllers\CategorieRecetteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Pages publiques
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'))->name('welcome');

// Redirige vers /accueil uniquement si l'utilisateur est connecté
Route::get('/dashboard', function () {
    return auth()->check() ? redirect('/accueil') : redirect('/login');
});

/*
|--------------------------------------------------------------------------
| Authentification requise
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | 🏠 Accueil (après login)
    |--------------------------------------------------------------------------
    */
    Route::get('/accueil', fn () => view('accueil'))->name('accueil');

    /*
    |--------------------------------------------------------------------------
    | 👤 Profil utilisateur
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | 📝 TODO
    |--------------------------------------------------------------------------
    */
    Route::prefix('todo')->name('todo.')->group(function () {
        Route::get('/', [TodoController::class, 'index'])->name('index');
        Route::post('/category', [TodoController::class, 'storeCategory'])->name('storeCategory');
        Route::get('/category/{id}', [TodoController::class, 'showCategory'])->name('showCategory');
        Route::post('/category/{id}/task', [TodoController::class, 'storeTask'])->name('storeTask');
        Route::patch('/task/{id}/complete', [TodoController::class, 'completeTask'])->name('completeTask');
    });

    /*
    |--------------------------------------------------------------------------
    | 🍰 Recettes & catégories personnalisées
    |--------------------------------------------------------------------------
    */
    Route::prefix('recettes')->name('recettes.')->group(function () {
    Route::get('/', [RecetteController::class, 'index'])->name('index');
    Route::post('/categories', [RecetteController::class, 'storeCategorie'])->name('categories.store');
    Route::delete('/categorie/{id}', [RecetteController::class, 'destroyCategorie'])->name('categorie.destroy');
    Route::get('/categorie/{id}', [RecetteController::class, 'showCategorie'])->name('categorie.show');

    Route::get('/{categorieId}/create', [RecetteController::class, 'create'])->name('create');
    Route::post('/', [RecetteController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [RecetteController::class, 'edit'])->name('edit');
    Route::put('/{recette}', [RecetteController::class, 'update'])->name('update');
    Route::delete('/{id}', [RecetteController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [RecetteController::class, 'show'])->name('show');

    // ✅ Routes correctes pour les catégories de recettes
    Route::get('/categories_recettes/{id}/edit', [CategorieRecetteController::class, 'edit'])->name('categories_recettes.edit');
    Route::put('/categories_recettes/{id}', [CategorieRecetteController::class, 'update'])->name('categories_recettes.update');
});



    /*
    |--------------------------------------------------------------------------
    | 🌄 Islam
    |--------------------------------------------------------------------------
    */
    Route::get('/islam', [App\Http\Controllers\IslamicController::class, 'index'])->name('islam');
});

/*
|--------------------------------------------------------------------------
| Routes publiques supplémentaires
|--------------------------------------------------------------------------
*/
// Tâches accessibles sans être dans le groupe auth
Route::delete('/todo/task/{taskId}', [TodoController::class, 'destroyTask'])->name('todo.destroyTaskOutsideGroup');
Route::patch('/todo/restore/{taskId}', [TodoController::class, 'restoreTask'])->name('todo.restoreTask');
Route::delete('/todo/category/{categoryId}', [TodoController::class, 'destroyCategory'])->name('todo.destroyCategory');

/*
|--------------------------------------------------------------------------
| Auth (login, register, etc.)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
