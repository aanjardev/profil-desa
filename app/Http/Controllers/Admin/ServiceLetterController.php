<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceLetter;
use Illuminate\Http\Request;

class ServiceLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ServiceLetter::query();

        if ($request->filled('search')) {
            $query->where('letter_name', 'like', '%' . $request->search . '%')
                  ->orWhere('requirements', 'like', '%' . $request->search . '%');
        }

        $serviceLetters = $query->ordered()->paginate(10)->withQueryString();

        return view('admin.service-letters.index', compact('serviceLetters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.service-letters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'letter_name'    => 'required|string|max:255',
            'requirements'   => 'required|string',
            'estimated_time' => 'nullable|string|max:100',
            'fee'            => 'nullable|string|max:100',
            'is_active'      => 'nullable|boolean',
        ], [
            'letter_name.required'  => 'Nama layanan surat wajib diisi.',
            'requirements.required' => 'Persyaratan wajib diisi.',
        ]);

        $maxOrder = ServiceLetter::max('order_num') ?? 0;

        ServiceLetter::create([
            'letter_name'    => $request->letter_name,
            'requirements'   => $request->requirements,
            'estimated_time' => $request->estimated_time,
            'fee'            => $request->fee,
            'is_active'      => $request->boolean('is_active', true),
            'order_num'      => $maxOrder + 1,
        ]);

        return redirect()->route('admin.service-letters.index')
            ->with('success', 'Layanan Surat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceLetter $serviceLetter)
    {
        return view('admin.service-letters.show', compact('serviceLetter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceLetter $serviceLetter)
    {
        return view('admin.service-letters.edit', compact('serviceLetter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceLetter $serviceLetter)
    {
        $request->validate([
            'letter_name'    => 'required|string|max:255',
            'requirements'   => 'required|string',
            'estimated_time' => 'nullable|string|max:100',
            'fee'            => 'nullable|string|max:100',
            'is_active'      => 'nullable|boolean',
        ], [
            'letter_name.required'  => 'Nama layanan surat wajib diisi.',
            'requirements.required' => 'Persyaratan wajib diisi.',
        ]);

        $serviceLetter->update([
            'letter_name'    => $request->letter_name,
            'requirements'   => $request->requirements,
            'estimated_time' => $request->estimated_time,
            'fee'            => $request->fee,
            'is_active'      => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.service-letters.index')
            ->with('success', 'Layanan Surat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceLetter $serviceLetter)
    {
        $serviceLetter->delete();

        return redirect()->route('admin.service-letters.index')
            ->with('success', 'Layanan Surat berhasil dihapus.');
    }
}
