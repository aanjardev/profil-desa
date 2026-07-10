<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Umkm;
use Illuminate\Support\Str;

class UmkmSeeder extends Seeder
{
    public function run()
    {
        $umkm = [
            [
                'name' => 'Batik Tulis Lasem',
                'description' => 'Kerajinan batik tulis khas pesisir dengan perpaduan warna yang berani dan motif yang dipengaruhi oleh budaya Tionghoa dan Jawa.',
                'location' => 'Rembang, Jawa Tengah',
                'category' => 'Kerajinan',
            ],
            [
                'name' => 'Kopi Gayo',
                'description' => 'Kopi arabika berkualitas tinggi yang ditanam di dataran tinggi Gayo, Aceh. Terkenal dengan aroma yang khas dan keasaman yang rendah.',
                'location' => 'Aceh Tengah, Aceh',
                'category' => 'Kuliner',
            ],
            [
                'name' => 'Kerajinan Perak Kotagede',
                'description' => 'Pusat kerajinan perak di Yogyakarta yang menghasilkan berbagai perhiasan dan pajangan indah dengan teknik ukir tradisional.',
                'location' => 'Yogyakarta',
                'category' => 'Kerajinan',
            ],
            [
                'name' => 'Kain Tenun Sumba',
                'description' => 'Kain tenun ikat tradisional dari Sumba Timur yang terkenal dengan motif figuratif manusia dan hewan yang sarat akan makna simbolis.',
                'location' => 'Sumba Timur, NTT',
                'category' => 'Pakaian',
            ],
        ];

        foreach ($umkm as $u) {
            Umkm::updateOrCreate(
                ['slug' => Str::slug($u['name'])],
                [
                    'name' => $u['name'],
                    'description' => $u['description'],
                    'location' => $u['location'],
                    'category' => $u['category'],
                    'is_active' => true,
                    'main_image' => '',
                ]
            );
        }
    }
}
