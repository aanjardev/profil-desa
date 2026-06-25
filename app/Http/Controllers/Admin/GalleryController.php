<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Dapatkan periode unik untuk dropdown filter
        $periods = Gallery::select('created_at')
            ->get()
            ->map(function ($item) {
                return $item->created_at->format('Y-m');
            })
            ->unique()
            ->sortDesc()
            ->values();

        $query = Gallery::query();

        // Filter berdasarkan periode jika ada
        if ($request->filled('period')) {
            $period = $request->period; // Format: YYYY-MM
            $parts = explode('-', $period);
            if (count($parts) === 2) {
                $query->whereYear('created_at', $parts[0])
                      ->whereMonth('created_at', $parts[1]);
            }
        }

        // Ambil data dengan pagination (15 per halaman)
        $galleries = $query->latest()->paginate(15);

        return view('admin.galleries.index', compact('galleries', 'periods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // max 2MB
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ], [
            'image.required' => 'Gambar wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('galleries', 'public');

            Gallery::create([
                'title' => $request->title,
                'description' => $request->description,
                'image_path' => $path,
            ]);

            return redirect()->route('admin.galleries.index')->with('success', 'Gambar berhasil ditambahkan ke galeri.');
        }

        return back()->withInput()->with('error', 'Gagal mengunggah gambar.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // max 2MB
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ], [
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        // Jika user mengupload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            
            // Simpan gambar baru
            $data['image_path'] = $request->file('image')->store('galleries', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Gambar galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        // Hapus file fisik jika ada
        if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Gambar berhasil dihapus dari galeri.');
    }
}
