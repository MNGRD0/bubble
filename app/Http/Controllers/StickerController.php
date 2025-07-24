
<?php

namespace App\Http\Controllers;

use App\Models\Sticker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StickerController extends Controller
{
    public function index()
    {
        $stickers = Sticker::where('user_id', Auth::id())->get();

        return view('stickers.index', compact('stickers'));
    }

    public function create()
    {
        return view('stickers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'couleur' => 'required|string', // HEX code, ex. #ff69b4
        ]);

        Sticker::create([
            'nom' => $request->nom,
            'couleur' => $request->couleur,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('stickers.index')->with('success', 'Sticker créé avec succès.');
    }

    public function edit(Sticker $sticker)
    {
        $this->authorize('update', $sticker);

        return view('stickers.edit', compact('sticker'));
    }

    public function update(Request $request, Sticker $sticker)
    {
        $this->authorize('update', $sticker);

        $request->validate([
            'nom' => 'required|string|max:100',
            'couleur' => 'required|string',
        ]);

        $sticker->update([
            'nom' => $request->nom,
            'couleur' => $request->couleur,
        ]);

        return redirect()->route('stickers.index')->with('success', 'Sticker mis à jour.');
    }

    public function destroy(Sticker $sticker)
    {
        $this->authorize('delete', $sticker);

        $sticker->delete();

        return redirect()->route('stickers.index')->with('success', 'Sticker supprimé.');
    }
}


