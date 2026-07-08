<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $service = \App\Models\ContactService::first();
        
        if (!$service) {
            $service = \App\Models\ContactService::create([
                'service_name' => 'Pusat Pelayanan Administrasi',
                'is_active' => true,
            ]);
        }

        return view('admin.contact-services.index', compact('service'));
    }

    public function store(Request $request)
    {
        $service = \App\Models\ContactService::first();

        if (!$service) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $validated = $request->validate([
            'service_name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'officer_name' => 'nullable|string|max:150',
            'phone' => 'nullable|string|max:20',
            'office_hours' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $service->update($validated);

        return redirect()->route('admin.contact-services.index')->with('success', 'Data Administrasi Online berhasil diperbarui.');
    }
}
