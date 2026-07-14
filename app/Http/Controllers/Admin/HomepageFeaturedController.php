<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tourism;
use App\Models\Umkm;
use Illuminate\Http\Request;

class HomepageFeaturedController extends Controller
{
    public function index()
    {
        $tourisms = Tourism::where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('name')
            ->get();

        $umkms = Umkm::where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('name')
            ->get();

        $featuredTourismCount = $tourisms->where('is_featured', true)->count();
        $featuredUmkmCount    = $umkms->where('is_featured', true)->count();

        return view('admin.homepage-featured.index', compact(
            'tourisms',
            'umkms',
            'featuredTourismCount',
            'featuredUmkmCount'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'featured_tourisms'   => 'nullable|array|max:3',
            'featured_tourisms.*' => 'integer|exists:tourisms,id',
            'featured_umkms'      => 'nullable|array|max:3',
            'featured_umkms.*'    => 'integer|exists:umkms,id',
        ], [
            'featured_tourisms.max'  => 'Maksimal hanya 3 wisata yang dapat disematkan.',
            'featured_umkms.max'     => 'Maksimal hanya 3 UMKM yang dapat disematkan.',
        ]);

        $featuredTourismIds = $request->input('featured_tourisms', []);
        $featuredUmkmIds    = $request->input('featured_umkms', []);

        // Reset semua, lalu set yang dipilih
        Tourism::where('is_active', true)->update(['is_featured' => false]);
        if (!empty($featuredTourismIds)) {
            Tourism::whereIn('id', array_slice($featuredTourismIds, 0, 3))->update(['is_featured' => true]);
        }

        Umkm::where('is_active', true)->update(['is_featured' => false]);
        if (!empty($featuredUmkmIds)) {
            Umkm::whereIn('id', array_slice($featuredUmkmIds, 0, 3))->update(['is_featured' => true]);
        }

        return redirect()->route('admin.homepage-featured.index')
            ->with('success', 'Pengaturan beranda berhasil disimpan.');
    }
}
