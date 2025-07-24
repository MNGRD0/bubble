<?php

namespace App\Http\Controllers;

use App\Models\Dessin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // AJOUTÉ

class DessinController extends Controller
{
        use AuthorizesRequests; // AJOUTÉ ICI
    public function index()
    {
        $dessins = Dessin::where('user_id', Auth::id())->latest()->get();
        return view('dessins.index', compact('dessins'));
    }

    public function create()
    {
        return view('dessins.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'image' => 'required|string',
    ]);

    $imageData = $request->input('image');
    [$type, $imageBase64] = explode(';base64,', $imageData);
    $extension = explode('/', explode(':', $type)[1])[1] ?? 'png';
    $imageName = 'dessin_' . time() . '.' . $extension;

    Storage::disk('public')->put("dessins/{$imageName}", base64_decode($imageBase64));

    $dessin = Dessin::create([
        'user_id' => Auth::id(),
        'nom' => $imageName,
        'chemin' => "dessins/{$imageName}",
    ]);

    return response()->json([
        'success' => true,
        'image_url' => asset('storage/dessins/' . $imageName),
        'dessin_id' => $dessin->id,
    ]);
}

    public function destroy(Dessin $dessin)
    {
        $this->authorize('delete', $dessin);

        if (Storage::disk('public')->exists($dessin->chemin)) {
            Storage::disk('public')->delete($dessin->chemin);
        }

        $dessin->delete();

        return back()->with('success', 'Dessin supprimé.');
    }

    public function destroyAll()
{
    $dessins = Dessin::where('user_id', Auth::id())->get();

    foreach ($dessins as $dessin) {
        if (Storage::disk('public')->exists($dessin->chemin)) {
            Storage::disk('public')->delete($dessin->chemin);
        }
        $dessin->delete();
    }

    return redirect()->route('dessins.index')->with('success', 'Tous les dessins ont été supprimés.');
}



    
}
