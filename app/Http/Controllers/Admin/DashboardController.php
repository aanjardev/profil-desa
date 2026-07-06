<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Umkm;
use App\Models\Tourism;
use App\Models\PpidDocument;
use App\Models\User;
use App\Models\ServiceLetter;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Utama
        $stats = [
            'posts' => Post::count(),
            'umkm' => Umkm::count(),
            'tourism' => Tourism::count(),
            'ppid' => PpidDocument::count(),
            'users' => User::count(),
            'letters' => ServiceLetter::count(),
        ];

        // Aktivitas Terkini: 5 Berita/Artikel Terbaru
        $recentPosts = Post::orderBy('created_at', 'desc')->take(5)->get();

        // Aktivitas Terkini: 5 Dokumen PPID Terbaru
        $recentDocuments = PpidDocument::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentDocuments'));
    }
}
