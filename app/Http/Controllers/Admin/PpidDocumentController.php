<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpidDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PpidDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PpidDocument::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('register_no', 'like', '%' . $request->search . '%')
                  ->orWhere('year', 'like', '%' . $request->search . '%');
        }

        // Urutkan berdasarkan tahun terbaru, lalu nomor register
        $documents = $query->orderBy('year', 'desc')
                           ->orderBy('register_no', 'asc')
                           ->paginate(15)
                           ->withQueryString();

        return view('admin.ppid-documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ppid-documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'register_no'      => 'nullable|string|max:50',
            'year'             => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'title'            => 'required|string|max:255',
            'category'         => 'required|string|max:100',
            'established_date' => 'nullable|date',
            'document_file'    => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240', // Max 10MB
            'file_label'       => 'nullable|string|max:100',
            'is_active'        => 'boolean',
        ], [
            'title.required'    => 'Judul produk hukum wajib diisi.',
            'year.required'     => 'Tahun register wajib diisi.',
            'category.required' => 'Jenis produk hukum wajib diisi.',
            'document_file.mimes'=> 'File harus berformat PDF atau Word/Excel.',
            'document_file.max'  => 'Ukuran file maksimal 10MB.',
        ]);

        $filePath = null;
        if ($request->hasFile('document_file')) {
            $filePath = $request->file('document_file')->store('ppid_documents', 'public');
        }

        PpidDocument::create([
            'register_no'      => $request->register_no,
            'year'             => $request->year,
            'title'            => $request->title,
            'category'         => $request->category,
            'established_date' => $request->established_date,
            'file_path'        => $filePath,
            'file_label'       => $request->file_label,
            'is_active'        => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.ppid-documents.index')
            ->with('success', 'Dokumen / Produk Hukum berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PpidDocument $ppidDocument)
    {
        return view('admin.ppid-documents.edit', compact('ppidDocument'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PpidDocument $ppidDocument)
    {
        $request->validate([
            'register_no'      => 'nullable|string|max:50',
            'year'             => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'title'            => 'required|string|max:255',
            'category'         => 'required|string|max:100',
            'established_date' => 'nullable|date',
            'document_file'    => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'file_label'       => 'nullable|string|max:100',
            'is_active'        => 'boolean',
        ], [
            'title.required'    => 'Judul produk hukum wajib diisi.',
            'year.required'     => 'Tahun register wajib diisi.',
            'category.required' => 'Jenis produk hukum wajib diisi.',
        ]);

        $filePath = $ppidDocument->file_path;
        
        if ($request->has('remove_file') && $request->remove_file == '1') {
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = null;
        }

        if ($request->hasFile('document_file')) {
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('document_file')->store('ppid_documents', 'public');
        }

        $ppidDocument->update([
            'register_no'      => $request->register_no,
            'year'             => $request->year,
            'title'            => $request->title,
            'category'         => $request->category,
            'established_date' => $request->established_date,
            'file_path'        => $filePath,
            'file_label'       => $request->file_label,
            'is_active'        => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.ppid-documents.index')
            ->with('success', 'Dokumen / Produk Hukum berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PpidDocument $ppidDocument)
    {
        if ($ppidDocument->file_path) {
            Storage::disk('public')->delete($ppidDocument->file_path);
        }
        
        $ppidDocument->delete();

        return redirect()->route('admin.ppid-documents.index')
            ->with('success', 'Dokumen / Produk Hukum berhasil dihapus.');
    }
}
