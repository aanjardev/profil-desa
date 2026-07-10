<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactService;

class ContactServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cukup ambil data pertama, jika kosong biarkan bernilai null (jangan di-create otomatis)
        $service = ContactService::first();

        return view('admin.contact-services.index', compact('service'));
    }

    public function store(Request $request)
    {
        $service = ContactService::first();

        $validated = $request->validate([
            'service_name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'officer_name' => 'nullable|string|max:150',
            'phone' => 'nullable|string|max:20',
            'office_hours' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        if (!$service) {
            ContactService::create($validated);
            $message = 'Data Administrasi Online berhasil ditambahkan.';
        } else {
            $service->update($validated);
            $message = 'Data Administrasi Online berhasil diperbarui.';
        }

        return redirect()->route('admin.contact-services.index')->with('success', $message);
    }
}
