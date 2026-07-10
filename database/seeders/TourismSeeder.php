<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tourism;
use Illuminate\Support\Str;

class TourismSeeder extends Seeder
{
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
            Tourism::updateOrCreate(
                ['slug' => Str::slug($w['name'])],
                [
                    'name' => $w['name'],
                    'description' => $w['description'],
                    'location' => $w['location'],
                    'is_active' => true,
                    'main_image' => '',
                ]
            );
        }
    }
}
