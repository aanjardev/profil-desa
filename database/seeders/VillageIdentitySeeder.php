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
                'key' => 'profil-singkat',
                'title' => 'Profil Singkat',
                'content' => "Desa Tulungrejo merupakan salah satu desa agrowisata unggulan yang terletak di wilayah Kecamatan Bumiaji, Kota Batu, Provinsi Jawa Timur. Dikelilingi oleh hamparan pegunungan yang hijau dengan udara pegunungan yang sejuk, desa ini dikenal luas sebagai sentra penghasil apel berkualitas tinggi di nusantara.\n\nDengan letak geografis di ketinggian rata-rata 1.200 mdpl, Desa Tulungrejo menawarkan pesona alam yang asri dipadukan dengan kearifan lokal masyarakat agraris. Perpaduan harmonis antara potensi alam dan budaya gotong-royong menjadikan desa ini tidak hanya makmur secara ekonomi pertanian, tetapi juga menjadi destinasi pariwisata favorit bagi wisatawan domestik maupun mancanegara yang ingin merasakan langsung sensasi memetik apel di kebun milik petani lokal.",
                'updated_at' => now(),
            ],
            [
                'key' => 'sejarah',
                'title' => 'Sejarah Desa',
                'content' => "Sejarah Desa Tulungrejo bermula jauh sebelum masa kemerdekaan, di mana kawasan lereng Gunung Arjuna ini mulai dibuka oleh para sesepuh pembabat alas yang berasal dari Mataram Islam. Nama Tulungrejo sendiri diambil dari dua suku kata bahasa Jawa kuno, yakni 'Tulung' yang berarti saling tolong-menolong (gotong royong), dan 'Rejo' yang bermakna makmur, subur, atau ramai.\n\nPenamaan ini adalah wujud doa dan harapan para pendiri desa agar masyarakat yang mendiami kawasan ini selalu mengedepankan semangat persatuan, bahu-membahu, sehingga kelak wilayah ini menjadi desa yang gemah ripah loh jinawi (makmur dan sejahtera).\n\nSeiring berjalannya waktu, pada era 1970-an, budidaya apel mulai masuk dan berkembang pesat di desa ini, mengubah wajah Tulungrejo dari desa pertanian palawija tradisional menjadi pusat percontohan agrobisnis apel yang mengubah taraf hidup masyarakatnya secara drastis.",
                'updated_at' => now(),
            ],
            [
                'key' => 'visi-misi',
                'title' => 'Visi & Misi',
                'content' => "VISI:\n\"Terwujudnya Desa Tulungrejo yang Maju, Mandiri, Berbudaya, dan Sejahtera Berbasis Potensi Pertanian dan Agrowisata Unggulan.\"\n\nMISI:\n1. Meningkatkan tata kelola Pemerintahan Desa yang bersih, transparan, akuntabel, dan responsif melalui pemanfaatan teknologi informasi (Digitalisasi Desa).\n2. Mengoptimalkan potensi pertanian hortikultura, khususnya apel dan sayuran organik, guna meningkatkan nilai tambah ekonomi masyarakat.\n3. Mengembangkan ekosistem Agrowisata yang terintegrasi dengan UMKM lokal (Oleh-oleh, Kerajinan, dan Kuliner) sebagai penggerak utama ekonomi desa.\n4. Membangun dan meningkatkan infrastruktur dasar dan fasilitas publik yang memadai serta berwawasan lingkungan.\n5. Menjaga dan melestarikan warisan seni budaya lokal serta kearifan tradisional sebagai identitas dan jatidiri masyarakat Desa Tulungrejo.\n6. Meningkatkan kualitas sumber daya manusia melalui pemerataan layanan kesehatan dasar, pendidikan, dan pemberdayaan perempuan serta pemuda.",
                'updated_at' => now(),
            ],
            [
                'key' => 'geografis',
                'title' => 'Kondisi Geografis',
                'content' => "Secara geografis, Desa Tulungrejo berada di kawasan dataran tinggi pegunungan dengan topografi yang berbukit-bukit dan kemiringan lereng yang bervariasi. Desa ini berada di ketinggian antara 1.200 hingga 1.700 meter di atas permukaan laut (mdpl), tepat di lereng selatan kaki Gunung Arjuna-Welirang.\n\nKondisi iklim di desa ini tergolong tropis basah (tipe iklim pegunungan) dengan suhu udara rata-rata harian berkisar antara 15°C hingga 22°C, dan tingkat curah hujan tahunan yang cukup tinggi. Kombinasi antara suhu sejuk, sinar matahari yang melimpah, dan tanah vulkanik (andosol) yang sangat subur, membuat wilayah ini sangat ideal untuk perkebunan buah-buahan subtropis seperti Apel, Jeruk, Strawberry, serta berbagai jenis sayuran organik kualitas premium.\n\nBatas-batas administratif Desa Tulungrejo meliputi:\n- Sebelah Utara: Kawasan Hutan Lindung Gunung Arjuna\n- Sebelah Selatan: Desa Punten dan Desa Gunungsari\n- Sebelah Barat: Desa Sumbergondo\n- Sebelah Timur: Desa Giripurno",
                'updated_at' => now(),
            ],
            [
                'key' => 'demografi',
                'title' => 'Kondisi Demografi',
                'content' => "Berdasarkan pemutakhiran data kependudukan terbaru, Desa Tulungrejo memiliki populasi lebih dari 8.500 jiwa yang tergabung dalam sekitar 2.600 Kepala Keluarga (KK). Struktur penduduk didominasi oleh usia produktif, yang memberikan keuntungan demografis tersendiri bagi pergerakan ekonomi desa.\n\nMayoritas penduduk Desa Tulungrejo bekerja pada sektor primer agrikultur (sekitar 65%), yang meliputi petani pemilik lahan, buruh tani, dan pengepul hasil bumi. Sektor pariwisata, perdagangan, dan UMKM menyerap sekitar 20% tenaga kerja, sementara sisanya bekerja sebagai pegawai negeri, karyawan swasta, dan profesi lainnya.\n\nKehidupan sosial kemasyarakatan diwarnai dengan kuatnya ikatan kekerabatan dan toleransi yang tinggi. Tingkat partisipasi masyarakat dalam kegiatan komunal seperti gotong-royong kebersihan lingkungan, ronda malam, dan kelompok tani (Gapoktan) masih sangat lestari.",
                'updated_at' => now(),
            ],
            [
                'key' => 'wilayah-dusun',
                'title' => 'Pembagian Wilayah',
                'content' => "Secara administratif, Desa Tulungrejo dibagi menjadi 4 (empat) wilayah Dusun, 18 Rukun Warga (RW), dan 72 Rukun Tetangga (RT). Masing-masing dusun dikepalai oleh seorang Kepala Dusun (Kasun) yang bertugas membantu Kepala Desa dalam pelayanan kewilayahan.\n\nAdapun pembagian wilayah tersebut terdiri dari:\n\n1. Dusun Krajan (Pusat Pemerintahan)\nMenjadi pusat denyut nadi administrasi pemerintahan desa dan fasilitas pelayanan publik utama seperti Puskesmas Pembantu dan pusat pendidikan dasar.\n\n2. Dusun Junggo\nMerupakan dusun yang terkenal dengan hamparan perkebunan apel yang sangat luas. Dusun ini adalah destinasi utama wisatawan yang ingin mengikuti tur petik apel langsung dari pohonnya.\n\n3. Dusun Gerdu\nKawasan yang banyak mengembangkan potensi florikultura (tanaman hias potong) dan sayuran organik. Wilayah ini memiliki lanskap perbukitan yang sangat memanjakan mata.\n\n4. Dusun Wonorejo\nBerbatasan langsung dengan kawasan hutan lindung, dusun ini dikembangkan sebagai penyangga ekologis desa dengan potensi wisata alam dan petualangan seperti camping ground dan outbond.",
                'updated_at' => now(),
            ]
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
