<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\RecetteController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\EntreeJournalController;
use App\Http\Controllers\StickerController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\CalendrierController;
use App\Http\Controllers\DossierController;
use App\Http\Controllers\FichierController;
use App\Http\Controllers\DessinController;


use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('welcome');

Route::get('/dashboard', function () {
    return auth()->check() ? redirect('/accueil') : redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/accueil', fn () => view('accueil'))->name('accueil');

    // 👤 Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 📝 TODO
    Route::prefix('todo')->name('todo.')->group(function () {
        Route::get('/', [TodoController::class, 'index'])->name('index');
        Route::post('/category', [TodoController::class, 'storeCategory'])->name('storeCategory');
        Route::get('/category/{id}', [TodoController::class, 'showCategory'])->name('showCategory');
        Route::post('/category/{id}/task', [TodoController::class, 'storeTask'])->name('storeTask');
        Route::patch('/task/{id}/complete', [TodoController::class, 'completeTask'])->name('completeTask');
    });

    // 🍰 Recettes
    Route::prefix('recettes')->name('recettes.')->group(function () {
        Route::get('/', [RecetteController::class, 'index'])->name('index');
        Route::post('/categories', [RecetteController::class, 'storeCategorie'])->name('categories.store');
        Route::delete('/categorie/{id}', [RecetteController::class, 'destroyCategorie'])->name('categorie.destroy');
        Route::get('/categorie/{id}', [RecetteController::class, 'showCategorie'])->name('categorie.show');
        Route::get('/{categorieId}/create', [RecetteController::class, 'create'])->name('create');
        Route::post('/', [RecetteController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [RecetteController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RecetteController::class, 'update'])->name('update');
        Route::delete('/{id}', [RecetteController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [RecetteController::class, 'show'])->name('show');
    });

    // 💰 Budgets & Dépenses
    Route::prefix('budgets')->name('budgets.')->group(function () {
        Route::get('/', [BudgetController::class, 'index'])->name('index');
        Route::get('/create', [BudgetController::class, 'create'])->name('create');
        Route::post('/', [BudgetController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BudgetController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BudgetController::class, 'update'])->name('update');
        Route::delete('/{id}', [BudgetController::class, 'destroy'])->name('destroy');
        


    });
Route::get('/budgets/{id}', [App\Http\Controllers\BudgetController::class, 'show'])->name('budgets.show');
    Route::prefix('depenses')->name('depenses.')->group(function () {
        Route::get('/{budget}/create', [DepenseController::class, 'create'])->name('create');
        Route::post('/{budget}', [DepenseController::class, 'store'])->name('store');
        Route::delete('/{id}', [DepenseController::class, 'destroy'])->name('destroy');
    });

    // 🌄 Islam
    Route::get('/islam', [App\Http\Controllers\IslamicController::class, 'index'])->name('islam');
});

// 🔓 Tâches accessibles sans login
Route::delete('/todo/task/{taskId}', [TodoController::class, 'destroyTask'])->name('todo.destroyTaskOutsideGroup');
Route::patch('/todo/restore/{taskId}', [TodoController::class, 'restoreTask'])->name('todo.restoreTask');
Route::delete('/todo/category/{categoryId}', [TodoController::class, 'destroyCategory'])->name('todo.destroyCategory');

Route::get('/calculatrice', [\App\Http\Controllers\CalculatriceController::class, 'index'])->name('calculatrice.index');
Route::get('/reductions', function () {
    return view('calculatrice.reductions');
})->name('reductions');

// J O U R N A L


Route::middleware(['auth'])->group(function () {
    Route::get('/journaux', [JournalController::class, 'index'])->name('journaux.index');
    Route::get('/journaux/create', [JournalController::class, 'create'])->name('journaux.create');
    Route::post('/journaux', [JournalController::class, 'store'])->name('journaux.store');
    Route::get('/journaux/{journal}', [JournalController::class, 'show'])->name('journaux.show');
    Route::post('/journaux/{journal}/entrees', [\App\Http\Controllers\EntreeJournalController::class, 'store'])->name('entrees.store');
    Route::delete('/journaux/{journal}', [JournalController::class, 'destroy'])->name('journaux.destroy');
    Route::put('/journaux/{journal}', [JournalController::class, 'update'])->name('journaux.update');
Route::resource('journaux', JournalController::class);
Route::post('/journaux/{journal}/entrees', [EntreeJournalController::class, 'store'])->name('entrees.store');


// F I C H I E R ! 


});



Route::middleware(['auth'])->group(function () {
    Route::resource('dossiers', DossierController::class);
    Route::resource('fichiers', FichierController::class)->only(['create', 'store', 'destroy']);
});

// D E S S I N S : 



Route::middleware(['auth'])->group(function () {
    Route::get('/dessins', [DessinController::class, 'index'])->name('dessins.index');
    Route::post('/dessins', [DessinController::class, 'store'])->name('dessins.store');
    
Route::delete('/dessins/delete-all', [DessinController::class, 'destroyAll'])->name('dessins.destroyAll');
Route::delete('/dessins/{dessin}', [DessinController::class, 'destroy'])->name('dessins.destroy');

    
});


require __DIR__.'/auth.php';
