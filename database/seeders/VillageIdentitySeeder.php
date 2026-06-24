<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VillageIdentity;

class VillageIdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'key' => 'sejarah',
                'title' => 'Sejarah Desa',
                'content' => "Desa Tulungrejo merupakan salah satu desa yang terletak di Kecamatan Bumiaji, Kota Batu, Provinsi Jawa Timur. Desa ini memiliki sejarah yang panjang dan kaya akan nilai budaya serta kearifan lokal. Nama Tulungrejo sendiri secara etimologis berasal dari kata 'Tulung' yang berarti pertolongan dan 'Rejo' yang berarti makmur atau ramai. Sehingga Tulungrejo mengandung doa dan harapan agar desa ini senantiasa mendapatkan pertolongan menuju kemakmuran dan keramaian yang membawa berkah bagi seluruh warganya.\n\nSejak zaman dahulu, masyarakat Tulungrejo hidup berdampingan secara harmonis dengan mengandalkan sektor pertanian dan perkebunan sebagai mata pencaharian utama.",
                'updated_at' => now(),
            ],
            [
                'key' => 'visi-misi',
                'title' => 'Visi & Misi',
                'content' => "VISI:\n\"Terwujudnya Desa Tulungrejo yang maju, mandiri, sejahtera, dan berbudaya berbasis pertanian dan pariwisata.\"\n\nMISI:\n1. Meningkatkan kualitas pelayanan publik dan tata kelola pemerintahan desa yang bersih, transparan, akuntabel, dan berbasis teknologi informasi.\n2. Mengembangkan potensi sektor pertanian organik, perkebunan hortikultura, serta pariwisata berbasis masyarakat untuk meningkatkan perekonomian lokal.\n3. Meningkatkan pembangunan dan pemeliharaan infrastruktur desa secara merata guna memperlancar mobilitas ekonomi dan sosial.\n4. Mendorong pelestarian nilai-nilai seni budaya lokal serta kearifan tradisional masyarakat sebagai identitas jati diri desa.\n5. Meningkatkan kualitas sumber daya manusia melalui penguatan program pendidikan formal/non-formal serta layanan kesehatan yang terjangkau.",
                'updated_at' => now(),
            ],
            [
                'key' => 'geografis',
                'title' => 'Kondisi Geografis',
                'content' => "Desa Tulungrejo berada di kawasan dataran tinggi lereng Gunung Arjuna-Welirang dengan ketinggian rata-rata berkisar antara 1.200 meter di atas permukaan laut. Keadaan geografis yang berbukit-bukit dan berhawa sejuk ini memberikan tingkat kesuburan tanah yang sangat tinggi. Karakteristik ini menjadikan wilayah Desa Tulungrejo sangat ideal untuk pembudidayaan tanaman hortikultura seperti apel, jeruk, sayuran organik, dan bunga potong.\n\nBatas-batas wilayah administrasi Desa Tulungrejo secara umum dikelilingi oleh area hutan konservasi di sebelah utara dan timur, serta berbatasan langsung dengan wilayah desa tetangga di Kecamatan Bumiaji lainnya di sebelah selatan dan barat.",
                'updated_at' => now(),
            ],
            [
                'key' => 'demografi',
                'title' => 'Kondisi Demografi',
                'content' => "Desa Tulungrejo dihuni oleh ribuan kepala keluarga yang memiliki dinamika sosial yang sangat erat. Mayoritas penduduk menggantungkan hidupnya pada sektor pertanian, baik sebagai pemilik lahan pertanian, buruh tani, maupun pelaku usaha mikro kecil dan menengah (UMKM) pengolah hasil tani.\n\nTingkat kepadatan penduduk tergolong sedang dengan persebaran permukiman yang terpusat di beberapa dusun utama. Kerukunan antarumat beragama dan budaya gotong royong yang kental menjadi pilar utama penyangga ketenteraman dan ketertiban kehidupan sosial kemasyarakatan sehari-hari di desa ini.",
                'updated_at' => now(),
            ],
        ];

        foreach ($data as $item) {
            VillageIdentity::updateOrCreate(
                ['key' => $item['key']],
                [
                    'title' => $item['title'],
                    'content' => $item['content'],
                    'updated_at' => $item['updated_at'],
                ]
            );
        }
    }
}
