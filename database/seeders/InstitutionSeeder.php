<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Institution;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $institutions = [
            [
                'name' => 'Badan Permusyawaratan Desa (BPD)',
                'type' => 'BPD',
                'description' => 'BPD adalah lembaga yang melaksanakan fungsi pemerintahan yang anggotanya merupakan wakil dari penduduk Desa berdasarkan keterwakilan wilayah dan ditetapkan secara demokratis.',
                'contact_person' => 'Bpk. Ahmad (081234567890)',
            ],
            [
                'name' => 'Lembaga Pemberdayaan Masyarakat Desa (LPMD)',
                'type' => 'LPMD',
                'description' => 'LPMD merupakan wadah yang dibentuk atas prakarsa masyarakat sebagai mitra Pemerintah Desa dalam menampung dan mewujudkan aspirasi serta kebutuhan masyarakat di bidang pembangunan.',
                'contact_person' => 'Bpk. Budi (082345678901)',
            ],
            [
                'name' => 'Pemberdayaan Kesejahteraan Keluarga (PKK)',
                'type' => 'PKK',
                'description' => 'PKK adalah gerakan nasional dalam pembangunan masyarakat yang tumbuh dari bawah, yang pengelolaannya dari, oleh, dan untuk masyarakat menuju terwujudnya keluarga yang beriman dan bertaqwa.',
                'contact_person' => 'Ibu Siti (083456789012)',
            ],
            [
                'name' => 'Karang Taruna',
                'type' => 'Karang Taruna',
                'description' => 'Karang Taruna adalah organisasi kepemudaan di desa yang berfungsi sebagai wadah pengembangan generasi muda, yang tumbuh dan berkembang atas dasar kesadaran dan tanggung jawab sosial.',
                'contact_person' => 'Sdr. Dimas (084567890123)',
            ],
            [
                'name' => 'Badan Usaha Milik Desa (BUMDes)',
                'type' => 'BUMDes',
                'description' => 'BUMDes adalah badan usaha yang seluruh atau sebagian besar modalnya dimiliki oleh Desa melalui penyertaan secara langsung yang berasal dari kekayaan Desa yang dipisahkan guna mengelola aset, jasa pelayanan, dan usaha lainnya.',
                'contact_person' => 'Bpk. Eko (085678901234)',
            ],
        ];

        foreach ($institutions as $inst) {
            Institution::updateOrCreate(
                ['name' => $inst['name']], // Match by name
                [
                    'type' => $inst['type'],
                    'description' => $inst['description'],
                    'contact_person' => $inst['contact_person'],
                    'is_active' => true,
                    'logo' => null,
                    'images' => null,
                ]
            );
        }
    }
}
