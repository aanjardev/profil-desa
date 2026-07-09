<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TourismUmkm;

class TourismUmkmSeeder extends Seeder
{
    public function run(): void
    {
        // 3 Wisata
        for ($i = 1; $i <= 3; $i++) {
            TourismUmkm::create([
                'name' => 'Wisata Indah ' . $i,
                'slug' => 'wisata-indah-' . $i,
                'description' => 'Destinasi wisata unggulan di Desa Tulungrejo.',
                'type' => 'wisata',
                'location' => 'Desa Tulungrejo',
                'is_active' => true,
            ]);
        }

        // 3 UMKM
        for ($i = 1; $i <= 3; $i++) {
            TourismUmkm::create([
                'name' => 'UMKM Khas ' . $i,
                'slug' => 'umkm-khas-' . $i,
                'description' => 'Produk unggulan UMKM Desa Tulungrejo.',
                'type' => 'umkm',
                'location' => 'Desa Tulungrejo',
                'is_active' => true,
            ]);
        }
    }
}
