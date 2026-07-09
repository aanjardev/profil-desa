<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            Gallery::create([
                'title' => 'Galeri Foto ' . $i,
                'description' => 'Deskripsi untuk galeri foto ' . $i,
                'image_path' => 'dummy/gallery-' . $i . '.jpg',
            ]);
        }
    }
}
