<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use Illuminate\Http\Request;

class EmergencyContactController extends Controller
{
    public function index()
    {
        $contacts = EmergencyContact::orderBy('order_num')->orderBy('name')->get();
        return view('admin.emergency-contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('admin.emergency-contacts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:20',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'order_num' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        EmergencyContact::create($validated);

        return redirect()->route('admin.emergency-contacts.index')->with('success', 'Kontak darurat berhasil ditambahkan.');
    }

    public function edit(EmergencyContact $emergencyContact)
    {
        return view('admin.emergency-contacts.edit', compact('emergencyContact'));
    }

    public function update(Request $request, EmergencyContact $emergencyContact)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:20',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'order_num' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $emergencyContact->update($validated);

        return redirect()->route('admin.emergency-contacts.index')->with('success', 'Kontak darurat berhasil diperbarui.');
    }

    public function destroy(EmergencyContact $emergencyContact)
    {
        $emergencyContact->delete();
        return redirect()->route('admin.emergency-contacts.index')->with('success', 'Kontak darurat berhasil dihapus.');
    }
}
