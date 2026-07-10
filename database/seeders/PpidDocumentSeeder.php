<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PpidDocument;

class PpidDocumentSeeder extends Seeder
{
    public function run()
    {
        PpidDocument::truncate(); // hapus data sebelumnya jika ada

        $data = [
            ['1', '2016', 'Struktur Organisasi Tata Kerja Pemerintah Desa Tulungrejo', 'Peraturan Desa', '2016-01-08', 'SOTK Desa TUlungrejo'],
            ['2', '2020', 'Kewenangan Desa Berdasarkan Hak Asal Usul dan Kewenangan Lokal Berskala Desa', 'Peraturan Desa', '2020-02-05', 'Perdes Kewenangan Desa Tulungrejo'],
            ['2', '2021', 'Badan Usaha Milik Desa', 'Peraturan Desa', '2021-10-05', 'Perdes Bumdes'],
            ['1', '2022', 'Laporan Pertanggungjawaban Realisasi APBDesa Tahun Anggaran 2021', 'Peraturan Desa', '2022-01-28', 'Perdes No.1 Tahun 2022 – LAPORAN REALISASI APBDES 2021'],
            ['2', '2022', 'Rencana Kerja Pemerintah Desa (RKP Desa) Tahun Anggaran 2023', 'Peraturan Desa', '2022-09-30', 'PERDES No.2 Tahun 2022 – RKP AWAL 2023'],
            ['3', '2022', 'Anggaran Pendapatan dan Belanja Desa Perubahan (APBDesa P) Tahun Anggaran 2022', 'Peraturan Desa', '2022-12-07', 'PERDES No.3 Tahun 2022 – APBDES PERUBAHAN 2022'],
            ['4', '2022', 'Anggaran Pendapatan dan Belanja Desa (APBDesa) Tahun Anggaran 2023', 'Peraturan Desa', '2022-12-31', 'PERDES No.4 Tahun 2022 – APBDES 2023 AWAL'],
            ['1', '2023', 'Laporan Pertanggungjawaban Realisasi Pelaksanaan Anggaran Pendapatan dan Belanja Desa (Realisasi APBDesa) Tahun Anggaran 2022', 'Peraturan Desa', '2023-01-06', 'PERDES NO.1 TAHUN 2023 – REALISASI APBDES 2022'],
            ['6', '2023', 'Rencana Kerja Pemerintah Desa (RKP Desa) Tahun Anggaran 2024', 'Peraturan Desa', '2023-11-03', 'PERDES NO.6 TAHUN 2023 – RKP 2024 AWAL'],
            ['7', '2023', 'Perubahan Peraturan Desa Tulungrejo Nomor 2 Tahun 2022 Tentang Rencana Kerja Pemerintah Desa (RKP Desa) Tahun Anggaran 2023', 'Peraturan Desa', '2023-11-03', 'PERDES NO.7 TAHUN 2023 – RKP PERUBAHAN 2023'],
        ];

        foreach ($data as $item) {
            PpidDocument::create([
                'register_no' => $item[0],
                'year' => $item[1],
                'title' => $item[2],
                'category' => $item[3],
                'established_date' => $item[4],
                'file_label' => $item[5],
                'file_path' => '',
                'is_active' => true,
            ]);
        }
    }
}
