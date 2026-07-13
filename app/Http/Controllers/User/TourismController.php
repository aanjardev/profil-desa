<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tourism;

class TourismController extends Controller
{
    public function index(Request $request)
    {
        $query = Tourism::where('is_active', true);
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $tourisms = $query->latest()->paginate(9)->withQueryString();
        
        return view('user.pariwisata.index', compact('tourisms'));
    }

    public function show($slug)
    {
        $tourism = Tourism::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        return view('user.pariwisata.show', compact('tourism'));
    }
}
