<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RtRw;
use Illuminate\Http\Request;

class RtRwController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $rtRws = RtRw::query()
            ->when($search, function ($query) use ($search) {
                $query->where('head_name', 'like', "%{$search}%")
                      ->orWhere('rw_number', 'like', "%{$search}%")
                      ->orWhere('rt_number', 'like', "%{$search}%");
            })
            ->orderBy('rw_number', 'asc')
            ->orderBy('rt_number', 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.rt-rw.index', compact('rtRws'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rt-rw.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rw_number' => 'required|string|max:10',
            'rt_number' => 'nullable|string|max:10',
            'head_name' => 'nullable|string|max:150',
            'head_phone' => 'nullable|string|max:20',
            'total_kk' => 'nullable|integer|min:0',
            'total_male' => 'nullable|integer|min:0',
            'total_female' => 'nullable|integer|min:0',
            'total_penduduk' => 'nullable|integer|min:0',
            'area_name' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        RtRw::create($validated);

        return redirect()->route('admin.rt-rws.index')->with('success', 'Data RT/RW berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RtRw $rtRw)
    {
        return view('admin.rt-rw.edit', compact('rtRw'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RtRw $rtRw)
    {
        $validated = $request->validate([
            'rw_number' => 'required|string|max:10',
            'rt_number' => 'nullable|string|max:10',
            'head_name' => 'nullable|string|max:150',
            'head_phone' => 'nullable|string|max:20',
            'total_kk' => 'nullable|integer|min:0',
            'total_male' => 'nullable|integer|min:0',
            'total_female' => 'nullable|integer|min:0',
            'total_penduduk' => 'nullable|integer|min:0',
            'area_name' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $rtRw->update($validated);

        return redirect()->route('admin.rt-rws.index')->with('success', 'Data RT/RW berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RtRw $rtRw)
    {
        $rtRw->delete();
        return redirect()->route('admin.rt-rws.index')->with('success', 'Data RT/RW berhasil dihapus.');
    }
}
