<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // 3 Berita
        for ($i = 1; $i <= 3; $i++) {
            Post::create([
                'title' => 'Berita Desa ' . $i,
                'slug' => 'berita-desa-' . $i,
                'content' => 'Ini adalah konten berita desa ' . $i . '. Desa Tulungrejo terus berkembang.',
                'excerpt' => 'Ini adalah ringkasan berita desa ' . $i . '.',
                'category' => 'berita',
                'is_published' => true,
                'is_featured' => true,
                'views' => rand(10, 100),
                'user_id' => 1,
            ]);
        }

        // 3 Pengumuman
        for ($i = 1; $i <= 3; $i++) {
            Post::create([
                'title' => 'Pengumuman Penting ' . $i,
                'slug' => 'pengumuman-penting-' . $i,
                'content' => 'Ini adalah detail pengumuman penting ke-' . $i . ' untuk warga desa Tulungrejo.',
                'excerpt' => 'Ringkasan pengumuman ' . $i,
                'category' => 'pengumuman',
                'is_published' => true,
                'is_featured' => false,
                'views' => rand(5, 50),
                'user_id' => 1,
            ]);
        }
    }
}
