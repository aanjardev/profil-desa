<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tourism;
use App\Models\Umkm;
use App\Models\Agenda;
use App\Models\Gallery;
use App\Models\VillageStatistic;
use App\Models\WebSetting;
use App\Models\VillageIdentity;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch 5 latest Berita (1 large highlight, 4 smaller)
        $berita = Post::published()->latest()->take(5)->get();
        
        // Fetch Tourism & UMKM
        $wisata = Tourism::where('is_active', true)->latest()->take(3)->get();
        $umkm = Umkm::where('is_active', true)->latest()->take(3)->get();
        
        // Fetch Agendas
        $agendas = Agenda::where('start_date', '>=', now()->format('Y-m-d'))->orderBy('start_date')->take(3)->get();
        
        // Fetch Galleries
        $galleries = Gallery::latest()->take(6)->get();
        
        // Fetch Statistics
        $statistics = [
            'luas_wilayah' => VillageStatistic::getValueByKey('luas_wilayah', '-'),
            'jumlah_penduduk' => VillageStatistic::getValueByKey('jumlah_penduduk', '-'),
            'jumlah_rt_rw' => VillageStatistic::getValueByKey('jumlah_rt_rw', '-'),
        ];
        
        // Settings and Identity
        $setting = WebSetting::first();
        $profil_singkat = VillageIdentity::getContentByKey('profil_singkat', 'Desa Tulungrejo merupakan desa yang asri dan memiliki banyak potensi wisata serta UMKM.');
        $sejarah = VillageIdentity::getContentByKey('sejarah', 'Sejarah desa belum diisi.');
        $geografis = VillageIdentity::getContentByKey('geografis', 'Letak geografis desa belum diisi.');
        $pembagian_wilayah = VillageIdentity::getContentByKey('pembagian_wilayah', 'Pembagian wilayah desa belum diisi.');
        
        // If there's no youtube URL in setting, fallback
        if ($setting && !$setting->youtube_video_url) {
            $setting->youtube_video_url = 'https://www.youtube.com/watch?v=LXb3EKWsInQ';
        }

        return view('user.home', compact(
            'berita', 
            'wisata', 
            'umkm', 
            'agendas', 
            'galleries', 
            'statistics', 
            'setting', 
            'profil_singkat',
            'sejarah',
            'geografis',
            'pembagian_wilayah'
        ));
    }
}
