<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query()->published()->latest();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Category Filter
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        // Archive Filter (Month/Year)
        if ($month = $request->input('month')) {
            $query->whereMonth('created_at', $month);
        }
        if ($year = $request->input('year')) {
            $query->whereYear('created_at', $year);
        }

        $posts = $query->paginate(5)->withQueryString();

        // Sidebar Data
        // Because category can be empty, we filter out null/empty categories
        $categories = Post::published()->whereNotNull('category')->where('category', '!=', '')
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')->get();

        $popularPosts = Post::published()->orderBy('views', 'desc')->take(4)->get();
        $recentPosts = Post::published()->latest()->take(4)->get();
        
        // Group for Archives
        $archives = Post::published()
            ->selectRaw('YEAR(created_at) year, MONTH(created_at) month, count(*) published')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function($archive) {
                $archive->month_name = Carbon::create()->month($archive->month)->translatedFormat('F');
                return $archive;
            });
            
        // Highlight Posts (Top 3 for portal-like header)
        $highlightPosts = Post::published()->orderBy('is_featured', 'desc')->latest()->take(3)->get();

        return view('user.berita.index', compact('posts', 'categories', 'popularPosts', 'recentPosts', 'archives', 'highlightPosts'));
    }

    public function show($slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();
        
        // Increment views
        $post->incrementViews();

        // Sidebar Data
        $categories = Post::published()->whereNotNull('category')->where('category', '!=', '')
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')->get();
            
        $popularPosts = Post::published()->orderBy('views', 'desc')->take(4)->get();
        $recentPosts = Post::published()->latest()->take(4)->get();
        
        // Group for Archives
        $archives = Post::published()
            ->selectRaw('YEAR(created_at) year, MONTH(created_at) month, count(*) published')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function($archive) {
                $archive->month_name = Carbon::create()->month($archive->month)->translatedFormat('F');
                return $archive;
            });

        return view('user.berita.show', compact('post', 'categories', 'popularPosts', 'recentPosts', 'archives'));
    }
}
