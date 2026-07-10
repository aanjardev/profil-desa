<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Umkm;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $query = Umkm::where('is_active', true);
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $umkms = $query->latest()->paginate(9)->withQueryString();
        
        // Get unique categories with count for filter sidebar
        $categories = Umkm::where('is_active', true)
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->select('category', \DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();

        return view('user.umkm.index', compact('umkms', 'categories'));
    }

    public function show($slug)
    {
        $umkm = Umkm::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        return view('user.umkm.show', compact('umkm'));
    }
}
