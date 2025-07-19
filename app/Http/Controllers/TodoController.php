<?php

namespace App\Http\Controllers;

// On importe les classes nécessaires
use Illuminate\Http\Request;      // Pour lire les données du formulaire ou de l'URL
use App\Models\Category;          // Le modèle des catégories de tâches
use App\Models\Task;              // Le modèle des tâches
use Auth;                         // Pour accéder à l'utilisateur connecté

class TodoController extends Controller
{
    // 🟢 Affiche la page principale avec toutes les catégories de l’utilisateur connecté
    public function index()
    {
        // On lit le paramètre "sort_by" de l’URL ou formulaire (par défaut : ordre alphabétique croissant)
        $sortBy = request('sort_by', 'name_asc');

        // En fonction du tri choisi, on récupère les catégories de l’utilisateur triées différemment
        switch ($sortBy) {
            case 'name_desc':
                $categories = Category::where('user_id', Auth::id())->orderBy('name', 'desc')->get();
                break;
            case 'created_at_desc':
                $categories = Category::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
                break;
            case 'created_at_asc':
                $categories = Category::where('user_id', Auth::id())->orderBy('created_at', 'asc')->get();
                break;
            case 'name_asc':
            default:
                $categories = Category::where('user_id', Auth::id())->orderBy('name', 'asc')->get();
                break;
        }

        // On affiche la vue avec la variable $categories
        return view('todo.index', compact('categories'));
    }

    // 🟢 Crée une nouvelle catégorie de tâches
    public function storeCategory(Request $request)
    {
        // On valide que le champ "name" est présent, texte, et pas trop long
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // On enregistre la catégorie dans la base de données avec le nom et l’utilisateur connecté
        Category::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        // On redirige vers la page des to-do avec un message flash
        return redirect()->route('todo.index')->with('task_added', 'Catégorie ajoutée avec succès !');
    }

    // 🟢 Affiche les tâches d’une seule catégorie
    public function showCategory($id)
    {
        // On récupère la catégorie (ou erreur 404 si elle n’existe pas)
        $category = Category::findOrFail($id);
        // On récupère toutes les tâches liées à cette catégorie (relation dans le modèle)
        $tasks = $category->tasks;

        // On affiche la vue avec les données
        return view('todo.show', compact('category', 'tasks'));
    }

    // 🟢 Ajoute une tâche à une catégorie
    public function storeTask(Request $request, $categoryId)
    {
        // On valide le champ "task"
        $request->validate([
            'task' => 'required|string|max:255',
        ]);

        // On crée la tâche en la liant à la bonne catégorie
        Task::create([
            'name' => $request->task,
            'category_id' => $categoryId,
            'completed' => false, // La tâche est non terminée au début
        ]);

        // On retourne à la page de la catégorie avec un message flash
        return redirect()->route('todo.show', $categoryId)->with('task_added', 'Tâche ajoutée avec succès !');
    }

    // 🟢 Marque une tâche comme terminée
    public function completeTask($taskId)
    {
        // On récupère la tâche
        $task = Task::findOrFail($taskId);
        $task->completed = true; // On la coche comme terminée
        $task->save(); // On enregistre

        return back(); // On revient à la page précédente
    }

    // 🟢 Restaure une tâche (la remet en "non terminée")
    public function restoreTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->completed = false; // On la décoche
        $task->save();

        return back();
    }

    // 🟢 Supprime une tâche de la base
    public function destroyTask($taskId)
    {
        Task::findOrFail($taskId)->delete(); // Trouve et supprime

        return back()->with('task_added', 'Tâche supprimée avec succès !');
    }

    // 🟢 Supprime une catégorie entière
    public function destroyCategory($categoryId)
    {
        Category::findOrFail($categoryId)->delete();

        return redirect()->route('todo.index')->with('task_added', 'Catégorie supprimée avec succès !');
    }
}
