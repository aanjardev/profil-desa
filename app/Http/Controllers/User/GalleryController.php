<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::query()->latest();

        // If you only want to show non-hero banners or everything, adapt here.
        // Assuming we show all or maybe hero_banners are just for homepage
        // For now, let's show all. Or if there's a specific logic, apply it.
        
        // Category Filter
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        // Archive Filter
        if ($month = $request->input('month')) {
            $query->whereMonth('created_at', $month);
        }
        if ($year = $request->input('year')) {
            $query->whereYear('created_at', $year);
        }

        $galleries = $query->paginate(6)->withQueryString();

        $categories = Gallery::whereNotNull('category')->where('category', '!=', '')
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')->get();

        $recentGalleries = Gallery::latest()->take(6)->get();

        $archives = Gallery::selectRaw('YEAR(created_at) year, MONTH(created_at) month, count(*) count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function($archive) {
                $archive->month_name = Carbon::create()->month((int)$archive->month)->translatedFormat('F');
                return $archive;
            });

        return view('user.galeri.index', compact('galleries', 'categories', 'recentGalleries', 'archives'));
    }

    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);

        $categories = Gallery::whereNotNull('category')->where('category', '!=', '')
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')->get();

        $recentGalleries = Gallery::latest()->take(6)->get();

        $archives = Gallery::selectRaw('YEAR(created_at) year, MONTH(created_at) month, count(*) count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function($archive) {
                $archive->month_name = Carbon::create()->month((int)$archive->month)->translatedFormat('F');
                return $archive;
            });

        return view('user.galeri.show', compact('gallery', 'categories', 'recentGalleries', 'archives'));
    }
}
