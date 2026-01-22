<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Umkm;
use App\Models\PerangkatDesa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first admin user
        $adminUser = User::where('role', 'admin')->first();
        if (!$adminUser) {
            $adminUser = User::first();
        }
        
        if (!$adminUser) {
            $this->command->error('Tidak ada user admin ditemukan. Silakan jalankan AdminUserSeeder terlebih dahulu.');
            return;
        }

        // Seed Berita (15 items)
        $this->seedBerita($adminUser);
        
        // Seed Galeri (15 items)
        $this->seedGaleri($adminUser);
        
        // Seed UMKM (15 items)
        $this->seedUmkm($adminUser);
        
        // Seed Perangkat Desa (15 items)
        $this->seedPerangkatDesa();
        
        $this->command->info('Berhasil menambahkan 15 data untuk Berita, Galeri, UMKM, dan Perangkat Desa!');
    }

    private function seedBerita($user)
    {
        $kategoriList = Berita::getKategori();
        $kategoriKeys = array_keys($kategoriList);
        
        $beritaData = [
            [
                'judul' => 'Pembangunan Jembatan Desa Selesai Dibangun',
                'ringkasan' => 'Jembatan penghubung antar dusun telah selesai dibangun dan siap digunakan oleh masyarakat.',
                'konten' => '<p>Pemerintah Desa dengan bangga mengumumkan bahwa pembangunan jembatan penghubung antar dusun telah selesai dikerjakan. Jembatan ini akan memudahkan akses transportasi dan meningkatkan konektivitas antar wilayah desa.</p><p>Proyek ini merupakan bagian dari program pembangunan infrastruktur desa yang bertujuan untuk meningkatkan kesejahteraan masyarakat.</p>',
                'kategori' => 'pembangunan',
            ],
            [
                'judul' => 'Program Vaksinasi Gratis untuk Warga Desa',
                'ringkasan' => 'Pemerintah Desa mengadakan program vaksinasi gratis untuk seluruh warga desa.',
                'konten' => '<p>Dalam rangka meningkatkan kesehatan masyarakat, Pemerintah Desa mengadakan program vaksinasi gratis untuk seluruh warga. Program ini akan dilaksanakan di Balai Desa setiap hari Sabtu dan Minggu.</p><p>Masyarakat diharapkan membawa KTP dan kartu keluarga saat datang untuk vaksinasi.</p>',
                'kategori' => 'kesehatan',
            ],
            [
                'judul' => 'Pelatihan Kewirausahaan untuk Pemuda Desa',
                'ringkasan' => 'Pemerintah Desa mengadakan pelatihan kewirausahaan untuk meningkatkan kemampuan pemuda dalam berbisnis.',
                'konten' => '<p>Program pelatihan kewirausahaan ini ditujukan untuk pemuda desa yang ingin mengembangkan usaha. Pelatihan akan mencakup manajemen keuangan, pemasaran digital, dan strategi bisnis.</p><p>Pendaftaran dibuka mulai tanggal 1 hingga 15 setiap bulannya.</p>',
                'kategori' => 'pendidikan',
            ],
            [
                'judul' => 'Gotong Royong Pembersihan Lingkungan Desa',
                'ringkasan' => 'Kegiatan gotong royong membersihkan lingkungan desa dilaksanakan setiap bulan untuk menjaga kebersihan.',
                'konten' => '<p>Kegiatan gotong royong ini merupakan tradisi yang terus dilestarikan untuk menjaga kebersihan dan keindahan lingkungan desa. Semua warga diharapkan berpartisipasi dalam kegiatan ini.</p><p>Kegiatan dilaksanakan setiap hari Minggu pagi di seluruh wilayah desa.</p>',
                'kategori' => 'kegiatan',
            ],
            [
                'judul' => 'Pengumuman Penerima Bantuan Sosial Tahap 2',
                'ringkasan' => 'Daftar penerima bantuan sosial tahap 2 telah ditetapkan dan dapat dilihat di kantor desa.',
                'konten' => '<p>Pemerintah Desa mengumumkan daftar penerima bantuan sosial tahap 2. Daftar lengkap dapat dilihat di papan pengumuman kantor desa atau melalui website resmi desa.</p><p>Penerima bantuan diharapkan membawa dokumen yang diperlukan untuk proses pencairan.</p>',
                'kategori' => 'pengumuman',
            ],
            [
                'judul' => 'Festival Budaya Desa Tahun 2024',
                'ringkasan' => 'Festival budaya desa akan diselenggarakan untuk melestarikan budaya dan tradisi lokal.',
                'konten' => '<p>Festival budaya desa akan menampilkan berbagai kesenian tradisional, kuliner khas daerah, dan pameran kerajinan tangan. Acara ini terbuka untuk umum dan gratis.</p><p>Festival akan dilaksanakan selama 3 hari berturut-turut di lapangan desa.</p>',
                'kategori' => 'budaya',
            ],
            [
                'judul' => 'Pembentukan Kelompok Tani Baru',
                'ringkasan' => 'Pemerintah Desa mendukung pembentukan kelompok tani baru untuk meningkatkan produktivitas pertanian.',
                'konten' => '<p>Kelompok tani baru ini akan mendapatkan bantuan bibit, pupuk, dan pelatihan teknik pertanian modern. Program ini bertujuan untuk meningkatkan hasil panen dan kesejahteraan petani.</p><p>Pendaftaran kelompok tani dibuka di kantor desa.</p>',
                'kategori' => 'pembangunan',
            ],
            [
                'judul' => 'Program Beasiswa untuk Anak Berprestasi',
                'ringkasan' => 'Pemerintah Desa memberikan beasiswa untuk anak-anak yang berprestasi di bidang akademik dan non-akademik.',
                'konten' => '<p>Program beasiswa ini diberikan kepada siswa yang memiliki prestasi akademik atau non-akademik yang membanggakan. Beasiswa dapat digunakan untuk biaya pendidikan dan pengembangan bakat.</p><p>Pendaftaran beasiswa dibuka setiap awal tahun ajaran baru.</p>',
                'kategori' => 'pendidikan',
            ],
            [
                'judul' => 'Pembangunan Posyandu Baru di Dusun Makmur',
                'ringkasan' => 'Posyandu baru telah dibangun untuk meningkatkan pelayanan kesehatan ibu dan anak.',
                'konten' => '<p>Posyandu baru ini dilengkapi dengan fasilitas modern untuk memberikan pelayanan kesehatan yang lebih baik bagi ibu dan anak. Posyandu akan buka setiap hari Selasa dan Kamis.</p><p>Pelayanan di posyandu ini gratis untuk seluruh warga desa.</p>',
                'kategori' => 'kesehatan',
            ],
            [
                'judul' => 'Kegiatan Senam Sehat untuk Lansia',
                'ringkasan' => 'Program senam sehat rutin untuk lansia dilaksanakan setiap minggu untuk menjaga kebugaran.',
                'konten' => '<p>Kegiatan senam sehat ini diadakan setiap hari Minggu pagi di lapangan desa. Program ini bertujuan untuk menjaga kesehatan dan kebugaran para lansia di desa.</p><p>Kegiatan ini gratis dan terbuka untuk semua lansia di desa.</p>',
                'kategori' => 'kesehatan',
            ],
            [
                'judul' => 'Peluncuran Website Resmi Desa',
                'ringkasan' => 'Website resmi desa telah diluncurkan untuk memberikan informasi yang lebih mudah diakses oleh masyarakat.',
                'konten' => '<p>Website resmi desa ini menyediakan berbagai informasi penting seperti pengumuman, layanan administrasi, dan data desa. Masyarakat dapat mengakses website melalui alamat resmi desa.</p><p>Website akan terus diperbarui dengan informasi terbaru.</p>',
                'kategori' => 'umum',
            ],
            [
                'judul' => 'Program Pemberdayaan Perempuan Desa',
                'ringkasan' => 'Program pemberdayaan perempuan untuk meningkatkan keterampilan dan ekonomi keluarga.',
                'konten' => '<p>Program ini memberikan pelatihan keterampilan seperti menjahit, memasak, dan kerajinan tangan. Tujuannya adalah meningkatkan ekonomi keluarga melalui pemberdayaan perempuan.</p><p>Program dilaksanakan setiap hari Rabu dan Jumat di balai desa.</p>',
                'kategori' => 'sosial',
            ],
            [
                'judul' => 'Pemilihan Ketua RT dan RW Periode Baru',
                'ringkasan' => 'Pemilihan ketua RT dan RW periode baru akan dilaksanakan untuk memilih pemimpin yang baru.',
                'konten' => '<p>Pemilihan ketua RT dan RW akan dilaksanakan secara demokratis dengan melibatkan seluruh warga di masing-masing wilayah. Proses pemilihan akan dilakukan secara transparan dan jujur.</p><p>Pendaftaran calon ketua RT dan RW dibuka di kantor desa.</p>',
                'kategori' => 'umum',
            ],
            [
                'judul' => 'Pembangunan Taman Bermain untuk Anak',
                'ringkasan' => 'Taman bermain baru telah dibangun untuk memberikan ruang bermain yang aman bagi anak-anak.',
                'konten' => '<p>Taman bermain ini dilengkapi dengan berbagai permainan yang aman dan edukatif. Taman ini diharapkan dapat menjadi tempat bermain yang menyenangkan bagi anak-anak desa.</p><p>Taman bermain buka setiap hari dari pagi hingga sore hari.</p>',
                'kategori' => 'pembangunan',
            ],
            [
                'judul' => 'Kegiatan Bakti Sosial untuk Warga Miskin',
                'ringkasan' => 'Kegiatan bakti sosial memberikan bantuan sembako dan kebutuhan pokok untuk warga yang membutuhkan.',
                'konten' => '<p>Kegiatan bakti sosial ini merupakan bentuk kepedulian masyarakat desa terhadap warga yang membutuhkan. Bantuan diberikan dalam bentuk sembako dan kebutuhan pokok lainnya.</p><p>Kegiatan dilaksanakan setiap bulan di berbagai lokasi di desa.</p>',
                'kategori' => 'sosial',
            ],
        ];

        foreach ($beritaData as $index => $data) {
            // Cek apakah berita dengan judul yang sama sudah ada
            $existingBerita = Berita::where('judul', $data['judul'])->first();
            if ($existingBerita) {
                continue; // Skip jika sudah ada
            }
            
            // Generate unique slug dengan timestamp
            $baseSlug = Str::slug($data['judul']);
            $slug = $baseSlug . '-' . time() . '-' . $index;
            
            Berita::create([
                'judul' => $data['judul'],
                'slug' => $slug,
                'ringkasan' => $data['ringkasan'],
                'konten' => $data['konten'],
                'kategori' => $data['kategori'],
                'status' => 'published',
                'user_id' => $user->id,
                'published_at' => Carbon::now()->subDays(rand(1, 30)),
                'views' => rand(10, 500),
            ]);
        }
    }

    private function seedGaleri($user)
    {
        $kategoriList = Galeri::getKategori();
        $kategoriKeys = array_keys($kategoriList);
        
        $galeriData = [
            ['judul' => 'Kegiatan Gotong Royong', 'deskripsi' => 'Dokumentasi kegiatan gotong royong membersihkan lingkungan desa', 'kategori' => 'kegiatan'],
            ['judul' => 'Pembangunan Jembatan', 'deskripsi' => 'Proses pembangunan jembatan penghubung antar dusun', 'kategori' => 'pembangunan'],
            ['judul' => 'Pemandangan Sawah', 'deskripsi' => 'Pemandangan sawah yang menghijau di musim tanam', 'kategori' => 'alam'],
            ['judul' => 'Festival Budaya', 'deskripsi' => 'Momen indah dari festival budaya desa tahun 2024', 'kategori' => 'budaya'],
            ['judul' => 'Balai Desa', 'deskripsi' => 'Gedung balai desa yang baru direnovasi', 'kategori' => 'fasilitas'],
            ['judul' => 'Kegiatan Posyandu', 'deskripsi' => 'Aktivitas pelayanan kesehatan di posyandu desa', 'kategori' => 'kegiatan'],
            ['judul' => 'Pemandangan Gunung', 'deskripsi' => 'Pemandangan gunung yang mengelilingi desa', 'kategori' => 'alam'],
            ['judul' => 'Tari Tradisional', 'deskripsi' => 'Pertunjukan tari tradisional dalam acara adat', 'kategori' => 'budaya'],
            ['judul' => 'Pembangunan Jalan', 'deskripsi' => 'Proses pengerasan jalan desa untuk akses yang lebih baik', 'kategori' => 'pembangunan'],
            ['judul' => 'Lapangan Desa', 'deskripsi' => 'Lapangan desa yang digunakan untuk berbagai kegiatan', 'kategori' => 'fasilitas'],
            ['judul' => 'Kegiatan Pasar', 'deskripsi' => 'Suasana pasar tradisional di desa', 'kategori' => 'umum'],
            ['judul' => 'Sungai Desa', 'deskripsi' => 'Pemandangan sungai yang mengalir di tengah desa', 'kategori' => 'alam'],
            ['judul' => 'Upacara Adat', 'deskripsi' => 'Dokumentasi upacara adat yang dilaksanakan di desa', 'kategori' => 'budaya'],
            ['judul' => 'Kegiatan Olahraga', 'deskripsi' => 'Turnamen olahraga antar RT di desa', 'kategori' => 'kegiatan'],
            ['judul' => 'Taman Desa', 'deskripsi' => 'Taman desa yang baru dibangun untuk rekreasi warga', 'kategori' => 'fasilitas'],
        ];

        foreach ($galeriData as $index => $data) {
            // Cek apakah galeri dengan judul yang sama sudah ada
            $existingGaleri = Galeri::where('judul', $data['judul'])->first();
            if ($existingGaleri) {
                continue; // Skip jika sudah ada
            }
            
            Galeri::create([
                'judul' => $data['judul'],
                'deskripsi' => $data['deskripsi'],
                'gambar' => '', // Gambar akan diupload manual melalui admin
                'kategori' => $data['kategori'],
                'status' => 'published',
                'user_id' => $user->id,
                'urutan' => $index + 1,
            ]);
        }
    }

    private function seedUmkm($user)
    {
        $kategoriList = Umkm::getKategori();
        $kategoriKeys = array_keys($kategoriList);
        
        $umkmData = [
            [
                'nama_usaha' => 'Warung Makan Bu Siti',
                'nama_pemilik' => 'Siti Aminah',
                'deskripsi' => 'Menyediakan berbagai masakan tradisional dan minuman segar',
                'alamat' => 'RT 01 RW 02, Dusun Makmur',
                'whatsapp' => '081234567890',
                'kategori' => 'makanan',
                'harga_mulai' => 10000,
            ],
            [
                'nama_usaha' => 'Kerajinan Anyaman Bambu',
                'nama_pemilik' => 'Ahmad Hidayat',
                'deskripsi' => 'Produk kerajinan anyaman bambu berkualitas tinggi',
                'alamat' => 'RT 02 RW 01, Dusun Sejahtera',
                'whatsapp' => '081234567891',
                'kategori' => 'kerajinan',
                'harga_mulai' => 50000,
            ],
            [
                'nama_usaha' => 'Toko Beras Organik',
                'nama_pemilik' => 'Budi Santoso',
                'deskripsi' => 'Menjual beras organik hasil pertanian lokal',
                'alamat' => 'RT 03 RW 02, Dusun Makmur',
                'whatsapp' => '081234567892',
                'kategori' => 'pertanian',
                'harga_mulai' => 15000,
            ],
            [
                'nama_usaha' => 'Peternakan Ayam Kampung',
                'nama_pemilik' => 'Suryadi',
                'deskripsi' => 'Menjual ayam kampung segar dan telur ayam',
                'alamat' => 'RT 01 RW 03, Dusun Sejahtera',
                'whatsapp' => '081234567893',
                'kategori' => 'peternakan',
                'harga_mulai' => 35000,
            ],
            [
                'nama_usaha' => 'Toko Pakaian Batik',
                'nama_pemilik' => 'Rina Wati',
                'deskripsi' => 'Menjual pakaian batik dengan berbagai motif khas daerah',
                'alamat' => 'RT 02 RW 02, Dusun Makmur',
                'whatsapp' => '081234567894',
                'kategori' => 'fashion',
                'harga_mulai' => 150000,
            ],
            [
                'nama_usaha' => 'Jasa Service Elektronik',
                'nama_pemilik' => 'Dedi Kurniawan',
                'deskripsi' => 'Melayani perbaikan berbagai peralatan elektronik',
                'alamat' => 'RT 03 RW 01, Dusun Sejahtera',
                'whatsapp' => '081234567895',
                'kategori' => 'jasa',
                'harga_mulai' => null,
            ],
            [
                'nama_usaha' => 'Kedai Kopi Desa',
                'nama_pemilik' => 'Andi Pratama',
                'deskripsi' => 'Kedai kopi dengan berbagai varian kopi lokal dan modern',
                'alamat' => 'RT 01 RW 01, Dusun Makmur',
                'whatsapp' => '081234567896',
                'kategori' => 'makanan',
                'harga_mulai' => 8000,
            ],
            [
                'nama_usaha' => 'Kerajinan Gerabah',
                'nama_pemilik' => 'Mariyati',
                'deskripsi' => 'Produk gerabah tradisional untuk keperluan rumah tangga',
                'alamat' => 'RT 02 RW 03, Dusun Sejahtera',
                'whatsapp' => '081234567897',
                'kategori' => 'kerajinan',
                'harga_mulai' => 30000,
            ],
            [
                'nama_usaha' => 'Toko Sayuran Segar',
                'nama_pemilik' => 'Joko Widodo',
                'deskripsi' => 'Menjual sayuran segar hasil kebun sendiri',
                'alamat' => 'RT 03 RW 03, Dusun Makmur',
                'whatsapp' => '081234567898',
                'kategori' => 'pertanian',
                'harga_mulai' => 5000,
            ],
            [
                'nama_usaha' => 'Peternakan Kambing',
                'nama_pemilik' => 'Sukardi',
                'deskripsi' => 'Menjual kambing dan susu kambing segar',
                'alamat' => 'RT 01 RW 02, Dusun Sejahtera',
                'whatsapp' => '081234567899',
                'kategori' => 'peternakan',
                'harga_mulai' => 500000,
            ],
            [
                'nama_usaha' => 'Butik Pakaian Muslim',
                'nama_pemilik' => 'Fatimah',
                'deskripsi' => 'Menjual pakaian muslim dengan model modern dan tradisional',
                'alamat' => 'RT 02 RW 01, Dusun Makmur',
                'whatsapp' => '081234567900',
                'kategori' => 'fashion',
                'harga_mulai' => 200000,
            ],
            [
                'nama_usaha' => 'Jasa Fotografi',
                'nama_pemilik' => 'Rudi Hartono',
                'deskripsi' => 'Melayani jasa fotografi untuk acara pernikahan, khitanan, dan acara lainnya',
                'alamat' => 'RT 03 RW 02, Dusun Sejahtera',
                'whatsapp' => '081234567901',
                'kategori' => 'jasa',
                'harga_mulai' => null,
            ],
            [
                'nama_usaha' => 'Warung Tegal Bu Rini',
                'nama_pemilik' => 'Rini Sari',
                'deskripsi' => 'Menyediakan berbagai masakan khas Tegal dengan harga terjangkau',
                'alamat' => 'RT 01 RW 03, Dusun Makmur',
                'whatsapp' => '081234567902',
                'kategori' => 'makanan',
                'harga_mulai' => 12000,
            ],
            [
                'nama_usaha' => 'Kerajinan Tenun',
                'nama_pemilik' => 'Siti Nurhaliza',
                'deskripsi' => 'Produk tenun tradisional dengan motif khas daerah',
                'alamat' => 'RT 02 RW 02, Dusun Sejahtera',
                'whatsapp' => '081234567903',
                'kategori' => 'kerajinan',
                'harga_mulai' => 250000,
            ],
            [
                'nama_usaha' => 'Toko Buah Segar',
                'nama_pemilik' => 'Bambang Sutrisno',
                'deskripsi' => 'Menjual berbagai buah segar dari kebun lokal',
                'alamat' => 'RT 03 RW 01, Dusun Makmur',
                'whatsapp' => '081234567904',
                'kategori' => 'pertanian',
                'harga_mulai' => 20000,
            ],
        ];

        foreach ($umkmData as $index => $data) {
            // Cek apakah UMKM dengan nama usaha yang sama sudah ada
            $existingUmkm = Umkm::where('nama_usaha', $data['nama_usaha'])->first();
            if ($existingUmkm) {
                continue; // Skip jika sudah ada
            }
            
            Umkm::create([
                'nama_usaha' => $data['nama_usaha'],
                'nama_pemilik' => $data['nama_pemilik'],
                'deskripsi' => $data['deskripsi'],
                'alamat' => $data['alamat'],
                'whatsapp' => $data['whatsapp'],
                'kategori' => $data['kategori'],
                'harga_mulai' => $data['harga_mulai'],
                'status' => 'published',
                'user_id' => $user->id,
                'urutan' => $index + 1,
            ]);
        }
    }

    private function seedPerangkatDesa()
    {
        $perangkatData = [
            ['jabatan' => 'Kepala Desa', 'nama' => 'Dr. H. Ahmad Fauzi, S.Sos., M.M.', 'nip' => '197001011990031001', 'urutan' => 1],
            ['jabatan' => 'Sekretaris Desa', 'nama' => 'Siti Nurhaliza, S.E.', 'nip' => '197502151995122001', 'urutan' => 2],
            ['jabatan' => 'Kasi Pemerintahan', 'nama' => 'Bambang Sutrisno, S.Pd.', 'nip' => '198003201998031002', 'urutan' => 3],
            ['jabatan' => 'Kasi Kesejahteraan', 'nama' => 'Rina Wati, S.Sos.', 'nip' => '198204251999122002', 'urutan' => 4],
            ['jabatan' => 'Kasi Pelayanan', 'nama' => 'Dedi Kurniawan, S.Kom.', 'nip' => '198505301999031003', 'urutan' => 5],
            ['jabatan' => 'Kaur Keuangan', 'nama' => 'Mariyati, S.E.', 'nip' => '198706151999122003', 'urutan' => 6],
            ['jabatan' => 'Kaur Tata Usaha', 'nama' => 'Andi Pratama, S.Pd.', 'nip' => '198807201999031004', 'urutan' => 7],
            ['jabatan' => 'Kaur Perencanaan', 'nama' => 'Joko Widodo, S.T.', 'nip' => '198908251999122004', 'urutan' => 8],
            ['jabatan' => 'Kadus Dusun Makmur', 'nama' => 'Sukardi, S.Pd.', 'nip' => '199009301999031005', 'urutan' => 9],
            ['jabatan' => 'Kadus Dusun Sejahtera', 'nama' => 'Rudi Hartono, S.E.', 'nip' => '199110151999122005', 'urutan' => 10],
            ['jabatan' => 'Kadus Dusun Aman', 'nama' => 'Fatimah, S.Pd.', 'nip' => '199211201999031006', 'urutan' => 11],
            ['jabatan' => 'Kadus Dusun Sentosa', 'nama' => 'Suryadi, S.Sos.', 'nip' => '199312251999122006', 'urutan' => 12],
            ['jabatan' => 'Kadus Dusun Bahagia', 'nama' => 'Ahmad Hidayat, S.T.', 'nip' => '199401301999031007', 'urutan' => 13],
            ['jabatan' => 'Kadus Dusun Maju', 'nama' => 'Budi Santoso, S.Pd.', 'nip' => '199502151999122007', 'urutan' => 14],
            ['jabatan' => 'Kadus Dusun Jaya', 'nama' => 'Rini Sari, S.E.', 'nip' => '199603201999031008', 'urutan' => 15],
        ];

        foreach ($perangkatData as $data) {
            // Cek apakah perangkat desa dengan nama yang sama sudah ada
            $existingPerangkat = PerangkatDesa::where('nama', $data['nama'])->first();
            if ($existingPerangkat) {
                continue; // Skip jika sudah ada
            }
            
            PerangkatDesa::create([
                'jabatan' => $data['jabatan'],
                'nama' => $data['nama'],
                'nip' => $data['nip'],
                'urutan' => $data['urutan'],
            ]);
        }
    }
}
