<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Ekonomi', 'Sosial', 'Pendidikan', 'Infrastruktur', 'Kesehatan'];

        // 6 Berita dengan kategori random
        for ($i = 1; $i <= 6; $i++) {
            $cat = $categories[array_rand($categories)];
            Post::create([
                'title' => 'Berita Desa ' . $i,
                'slug' => 'berita-desa-' . $i,
                'content' => 'Ini adalah konten berita desa ' . $i . ' tentang ' . $cat . '. Desa Tulungrejo terus berkembang dan memberikan manfaat bagi warganya.',
                'excerpt' => 'Ini adalah ringkasan berita desa ' . $i . ' mengenai bidang ' . $cat . '.',
                'category' => $cat,
                'is_published' => true,
                'is_featured' => $i === 1 ? true : false,
                'views' => rand(10, 100),
                'user_id' => 1,
            ]);
        }
    }
}
