<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agendas = [
            [
                'title' => 'Kerja Bakti Bersih Desa',
                'slug' => 'kerja-bakti-bersih-desa',
                'description' => 'Kegiatan rutin kerja bakti gotong royong membersihkan lingkungan desa, saluran air, dan fasilitas umum. Diharapkan seluruh warga dapat berpartisipasi dengan membawa alat kebersihan masing-masing.',
                'start_date' => now()->addDays(2)->format('Y-m-d'),
                'end_date' => now()->addDays(2)->format('Y-m-d'),
                'start_time' => '07:00:00',
                'end_time' => '11:00:00',
                'location' => 'Seluruh Wilayah RT/RW Desa',
                'maps_link' => null,
                'audience' => 'Umum',
                'organizer' => 'Pemerintah Desa',
                'contact_person' => 'Bapak Kepala Dusun',
                'image' => null,
                'status' => 'published',
                'is_active' => true,
            ],
            [
                'title' => 'Lomba 17 Agustus Tingkat Desa',
                'slug' => 'lomba-17-agustus-tingkat-desa',
                'description' => 'Peringatan Hari Kemerdekaan Republik Indonesia ke-80. Akan ada berbagai perlombaan menarik seperti panjat pinang, tarik tambang, dan lomba anak-anak.',
                'start_date' => now()->addMonth()->format('Y-m-d'),
                'end_date' => now()->addMonth()->addDays(1)->format('Y-m-d'),
                'start_time' => '08:00:00',
                'end_time' => '16:00:00',
                'location' => 'Lapangan Utama Desa',
                'maps_link' => 'https://maps.google.com/?q=lapangan+desa',
                'audience' => 'Umum',
                'organizer' => 'Karang Taruna',
                'contact_person' => 'Ketua Pemuda (081234567890)',
                'image' => null,
                'status' => 'published',
                'is_active' => true,
            ],
            [
                'title' => 'Rapat Koordinasi BPD',
                'slug' => 'rapat-koordinasi-bpd',
                'description' => 'Rapat koordinasi bulanan Badan Permusyawaratan Desa membahas program kerja dan pengawasan anggaran.',
                'start_date' => now()->addDays(5)->format('Y-m-d'),
                'end_date' => null,
                'start_time' => '19:30:00',
                'end_time' => '22:00:00',
                'location' => 'Balai Desa',
                'maps_link' => null,
                'audience' => 'Perangkat Desa & BPD',
                'organizer' => 'BPD',
                'contact_person' => 'Sekretaris BPD',
                'image' => null,
                'status' => 'published',
                'is_active' => true,
            ],
            [
                'title' => 'Posyandu Balita dan Lansia',
                'slug' => 'posyandu-balita-dan-lansia',
                'description' => 'Kegiatan rutin pos pelayanan terpadu untuk pemeriksaan kesehatan balita, pemberian vitamin, dan cek kesehatan dasar bagi lansia.',
                'start_date' => now()->addDays(7)->format('Y-m-d'),
                'end_date' => now()->addDays(7)->format('Y-m-d'),
                'start_time' => '08:00:00',
                'end_time' => '12:00:00',
                'location' => 'Polindes / Poskesdes',
                'maps_link' => null,
                'audience' => 'Ibu & Balita, Lansia',
                'organizer' => 'Kader Posyandu & Bidan Desa',
                'contact_person' => 'Bidan Desa',
                'image' => null,
                'status' => 'published',
                'is_active' => true,
            ],
        ];

        foreach ($agendas as $agenda) {
            \App\Models\Agenda::create($agenda);
        }
    }
}
