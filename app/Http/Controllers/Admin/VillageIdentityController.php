<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\VillageIdentity;

class VillageIdentityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $identities = VillageIdentity::all();
        return view('admin.village-identities.index', compact('identities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $identity = VillageIdentity::findOrFail($id);
        return view('admin.village-identities.edit', compact('identity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $identity = VillageIdentity::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $validated['updated_at'] = now();

        $identity->update($validated);

        return redirect()->route('admin.village-identities.index')->with('success', 'Profil Desa ' . $identity->title . ' berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }
}
