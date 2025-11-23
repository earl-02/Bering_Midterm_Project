<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalGames = Game::count();
        $totalPlatforms = Platform::count();
        $recentAdded = Game::with('platform')->latest()->limit(5)->get();
        $platforms = Platform::orderBy('name')->get();
        $games = Game::with('platform')->orderBy('title')->get();

        return view('dashboard', compact('totalGames', 'totalPlatforms', 'recentAdded', 'platforms', 'games'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'nullable|string|max:255',
            'release_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'platform_id' => 'nullable|exists:platforms,id',
            'description' => 'nullable|string',
        ]);

        Game::create($data);

        return redirect()->route('dashboard')->with('success', 'Game added.');
    }

    public function update(Request $request, Game $game)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'nullable|string|max:255',
            'release_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'platform_id' => 'nullable|exists:platforms,id',
            'description' => 'nullable|string',
        ]);

        $game->update($data);

        return redirect()->route('dashboard')->with('success', 'Game updated.');
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->route('dashboard')->with('success', 'Game deleted.');
    }
}
