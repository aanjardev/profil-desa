<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TourismUmkm;
use Illuminate\Support\Str;

class TourismUmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wisata = [
            [
                'name' => 'Candi Borobudur',
                'description' => 'Candi Borobudur adalah candi Buddha terbesar di dunia yang terletak di Magelang, Jawa Tengah. Memiliki ribuan panel relief yang menceritakan perjalanan Sang Buddha.',
                'location' => 'Magelang, Jawa Tengah',
            ],
            [
                'name' => 'Pantai Kuta',
                'description' => 'Salah satu destinasi paling populer di Bali yang terkenal dengan pasir putihnya dan ombak yang cocok untuk para peselancar dari seluruh dunia.',
                'location' => 'Badung, Bali',
            ],
            [
                'name' => 'Gunung Bromo',
                'description' => 'Gunung berapi aktif di Jawa Timur yang menawarkan pemandangan matahari terbit yang sangat memukau dan lautan pasir yang luas.',
                'location' => 'Probolinggo, Jawa Timur',
            ],
            [
                'name' => 'Raja Ampat',
                'description' => 'Kepulauan di Papua Barat yang menjadi surga bagi para penyelam karena keanekaragaman hayati bawah lautnya yang luar biasa.',
                'location' => 'Raja Ampat, Papua Barat',
            ],
        ];

        foreach ($wisata as $w) {
            TourismUmkm::create([
                'name' => $w['name'],
                'slug' => Str::slug($w['name']),
                'description' => $w['description'],
                'type' => 'wisata',
                'location' => $w['location'],
                'is_active' => true,
            ]);
        }

        $umkm = [
            [
                'name' => 'Batik Tulis Lasem',
                'description' => 'Kerajinan batik tulis khas pesisir dengan perpaduan warna yang berani dan motif yang dipengaruhi oleh budaya Tionghoa dan Jawa.',
                'location' => 'Rembang, Jawa Tengah',
            ],
            [
                'name' => 'Kopi Gayo',
                'description' => 'Kopi arabika berkualitas tinggi yang ditanam di dataran tinggi Gayo, Aceh. Terkenal dengan aroma yang khas dan keasaman yang rendah.',
                'location' => 'Aceh Tengah, Aceh',
            ],
            [
                'name' => 'Kerajinan Perak Kotagede',
                'description' => 'Pusat kerajinan perak di Yogyakarta yang menghasilkan berbagai perhiasan dan pajangan indah dengan teknik ukir tradisional.',
                'location' => 'Yogyakarta',
            ],
            [
                'name' => 'Kain Tenun Sumba',
                'description' => 'Kain tenun ikat tradisional dari Sumba Timur yang terkenal dengan motif figuratif manusia dan hewan yang sarat akan makna simbolis.',
                'location' => 'Sumba Timur, NTT',
            ],
        ];

        foreach ($umkm as $u) {
            TourismUmkm::create([
                'name' => $u['name'],
                'slug' => Str::slug($u['name']),
                'description' => $u['description'],
                'type' => 'umkm',
                'location' => $u['location'],
                'is_active' => true,
            ]);
        }
    }
}
