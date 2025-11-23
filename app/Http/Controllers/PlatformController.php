<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $platforms = Platform::withCount('games')->orderBy('name')->get();
        return view('platforms.index', compact('platforms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:platforms,name',
            'manufacturer' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Platform::create($data);

        return redirect()->route('platforms.index')->with('success', 'Platform added.');
    }

    public function update(Request $request, Platform $platform)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:platforms,name,' . $platform->id,
            'manufacturer' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $platform->update($data);

        return redirect()->route('platforms.index')->with('success', 'Platform updated.');
    }

    public function destroy(Platform $platform)
    {
        $platform->delete();

        return redirect()->route('platforms.index')->with('success', 'Platform deleted.');
    }
}
