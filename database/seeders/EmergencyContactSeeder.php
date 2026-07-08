<?php

namespace Database\Seeders;

use App\Models\EmergencyContact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmergencyContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'name' => 'Polsek Setempat',
                'phone' => '110',
                'description' => 'Layanan darurat kepolisian untuk laporan keamanan.',
                'category' => 'Keamanan',
                'address' => 'Jl. Bhayangkara No. 1',
                'order_num' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Pemadam Kebakaran',
                'phone' => '113',
                'description' => 'Layanan darurat untuk penanganan kebakaran dan penyelamatan.',
                'category' => 'Bencana',
                'address' => 'Kantor Dinas Damkar Terdekat',
                'order_num' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Puskesmas Desa',
                'phone' => '119',
                'description' => 'Layanan kesehatan darurat dan ambulans 24 jam.',
                'category' => 'Kesehatan',
                'address' => 'Jl. Kesehatan No. 2, Samping Balai Desa',
                'order_num' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Badan Penanggulangan Bencana',
                'phone' => '117',
                'description' => 'Untuk pelaporan bencana alam seperti banjir, longsor, dll.',
                'category' => 'Bencana',
                'address' => 'Kantor BPBD Kabupaten',
                'order_num' => 4,
                'is_active' => true,
            ]
        ];

        foreach ($contacts as $contact) {
            EmergencyContact::create($contact);
        }
    }
}
