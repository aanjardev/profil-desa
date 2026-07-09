<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VillageStatistic;

class VillageStatisticSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            ['key' => 'luas_wilayah', 'value' => '120', 'label' => 'Luas Wilayah (Ha)', 'icon' => 'ti-map-alt'],
            ['key' => 'jumlah_penduduk', 'value' => '5400', 'label' => 'Jumlah Penduduk', 'icon' => 'ti-user'],
            ['key' => 'jumlah_rt_rw', 'value' => '42 / 10', 'label' => 'RT / RW', 'icon' => 'ti-home'],
        ];

        foreach ($stats as $stat) {
            VillageStatistic::updateOrCreate(
                ['key' => $stat['key']],
                $stat
            );
        }
    }
}
