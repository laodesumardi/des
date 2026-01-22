<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function beranda()
    {
        // Ambil data statistik dari database penduduk (sama seperti halaman data)
        $penduduk = \App\Models\Penduduk::orderBy('rt')->orderBy('nama')->get();
        
        // Analisis statistik otomatis
        $statistik = [
            'jumlah_penduduk' => $penduduk->count(),
            'laki_laki' => $penduduk->where('jenis_kelamin', 'Laki-laki')->count(),
            'perempuan' => $penduduk->where('jenis_kelamin', 'Perempuan')->count(),
            'kepala_keluarga' => $penduduk->groupBy('rt')->count(), // Estimasi berdasarkan RT
        ];
        
        // Ambil berita terbaru (4 berita)
        $beritaTerbaru = \App\Models\Berita::published()
            ->latest('published_at')
            ->limit(4)
            ->get();
        
        // Ambil galeri terbaru (8 galeri)
        $galeriTerbaru = \App\Models\Galeri::published()
            ->orderBy('urutan')
            ->latest()
            ->limit(8)
            ->get();
        
        // Ambil agenda mendatang (5 agenda)
        $agendaTerbaru = \App\Models\Agenda::where('status', '!=', 'dibatalkan')
            ->where('tanggal_mulai', '>=', now()->startOfDay())
            ->orderBy('tanggal_mulai', 'asc')
            ->limit(5)
            ->get();
        
        // Ambil perangkat desa
        $perangkatDesa = \App\Models\PerangkatDesa::orderBy('urutan')->orderBy('id')->get();
        
        return view('beranda', compact('statistik', 'beritaTerbaru', 'galeriTerbaru', 'agendaTerbaru', 'perangkatDesa'));
    }

    public function profil()
    {
        return view('profil');
    }

    public function pemerintahan()
    {
        $perangkatDesa = \App\Models\PerangkatDesa::orderBy('urutan')->orderBy('id')->get();
        return view('pemerintahan', compact('perangkatDesa'));
    }

    public function berita()
    {
        $berita = \App\Models\Berita::published()
            ->latest('published_at')
            ->paginate(10);
        
        $kategoriList = \App\Models\Berita::getKategori();
        
        return view('berita', compact('berita', 'kategoriList'));
    }

    public function beritaShow($slug)
    {
        $berita = \App\Models\Berita::where('slug', $slug)->firstOrFail();
        
        // Increment views
        $berita->incrementViews();
        
        // Get related berita
        $relatedBerita = \App\Models\Berita::published()
            ->where('id', '!=', $berita->id)
            ->where('kategori', $berita->kategori)
            ->latest('published_at')
            ->limit(3)
            ->get();
        
        $kategoriList = \App\Models\Berita::getKategori();
        
        return view('berita-detail', compact('berita', 'relatedBerita', 'kategoriList'));
    }

    public function layanan()
    {
        $jenisLayananList = \App\Models\PengajuanLayanan::getJenisLayanan();
        return view('layanan', compact('jenisLayananList'));
    }

    public function cekStatusLayanan(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'nama_cek' => 'required|string|max:255',
            'nik_cek' => 'required|string|size:16',
        ], [
            'nama_cek.required' => 'Nama lengkap wajib diisi',
            'nik_cek.required' => 'NIK wajib diisi',
            'nik_cek.size' => 'NIK harus 16 digit',
        ]);

        $pengajuan = \App\Models\PengajuanLayanan::where('nama', $request->nama_cek)
            ->where('nik', $request->nik_cek)
            ->orderBy('created_at', 'desc')
            ->get();

        $jenisLayananList = \App\Models\PengajuanLayanan::getJenisLayanan();

        if ($pengajuan->isEmpty()) {
            return redirect()->route('layanan')
                ->with('status_not_found', true)
                ->with('cek_nama', $request->nama_cek)
                ->with('cek_nik', $request->nik_cek)
                ->withInput();
        }

        return redirect()->route('layanan')
            ->with('status_found', true)
            ->with('pengajuan_results', $pengajuan)
            ->with('cek_nama', $request->nama_cek)
            ->with('cek_nik', $request->nik_cek);
    }

    public function storePengajuanLayanan(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'jenis_layanan' => 'required|string',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'jenis_layanan.required' => 'Jenis layanan wajib dipilih',
            'nama.required' => 'Nama lengkap wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'telepon.required' => 'Nomor telepon wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'berkas.required' => 'Berkas wajib diunggah',
            'berkas.mimes' => 'Format file harus PDF, JPG, atau PNG',
            'berkas.max' => 'Ukuran file maksimal 2MB',
        ]);

        try {
            $data = $request->only(['jenis_layanan', 'nama', 'nik', 'telepon', 'alamat', 'keterangan']);

            // Handle berkas
            if ($request->hasFile('berkas')) {
                $file = $request->file('berkas');
                $filename = 'berkas-' . time() . '-' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
                
                $uploadPath = public_path('uploads/layanan');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $file->move($uploadPath, $filename);
                $data['berkas'] = $filename;
            }

            $pengajuan = \App\Models\PengajuanLayanan::create($data);
            
            \Illuminate\Support\Facades\Log::info('Pengajuan layanan berhasil disimpan', ['id' => $pengajuan->id, 'nama' => $pengajuan->nama]);

            return redirect()->route('layanan')->with('success', 'Pengajuan layanan Anda telah berhasil dikirim. Silakan tunggu proses verifikasi dari petugas desa.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal menyimpan pengajuan layanan', ['error' => $e->getMessage()]);
            return redirect()->route('layanan')->with('error', 'Terjadi kesalahan saat mengirim pengajuan: ' . $e->getMessage())->withInput();
        }
    }

    public function data()
    {
        // Ambil semua data penduduk untuk statistik (tidak dipaginasi)
        $allPenduduk = \App\Models\Penduduk::all();
        
        // Analisis statistik otomatis dari semua data
        $statistik = [
            'jumlah_penduduk' => $allPenduduk->count(),
            'laki_laki' => $allPenduduk->where('jenis_kelamin', 'Laki-laki')->count(),
            'perempuan' => $allPenduduk->where('jenis_kelamin', 'Perempuan')->count(),
            'kepala_keluarga' => $allPenduduk->where('is_kepala_keluarga', true)->count(),
        ];
        
        // Hitung statistik pendidikan otomatis dari semua data penduduk
        $pendidikanStats = [
            'Tidak Sekolah' => $allPenduduk->where('pendidikan', 'Tidak/Belum Sekolah')->count(),
            'SD/Sederajat' => $allPenduduk->where('pendidikan', 'SD/Sederajat')->count(),
            'SMP/Sederajat' => $allPenduduk->where('pendidikan', 'SMP/Sederajat')->count(),
            'SMA/Sederajat' => $allPenduduk->where('pendidikan', 'SMA/Sederajat')->count(),
            'Diploma' => $allPenduduk->whereIn('pendidikan', ['D1/D2', 'D3'])->count(),
            'S1/Sederajat' => $allPenduduk->where('pendidikan', 'S1/D4')->count(),
            'S2/Sederajat' => $allPenduduk->whereIn('pendidikan', ['S2', 'S3'])->count(),
        ];
        
        // Hitung jumlah SD/Sederajat secara eksplisit
        $sdSederajatCount = $allPenduduk->where('pendidikan', 'SD/Sederajat')->count();
        
        // Data untuk grafik
        $chartData = [
            'jenis_kelamin' => [
                'labels' => ['Laki-laki', 'Perempuan'],
                'data' => [
                    $statistik['laki_laki'],
                    $statistik['perempuan'],
                ],
            ],
            'sd_sederajat' => [
                'label' => 'SD/Sederajat',
                'data' => $sdSederajatCount,
                'total' => $statistik['jumlah_penduduk'],
            ],
        ];
        
        // Hitung total pendidikan berdasarkan jumlah penduduk (otomatis)
        $pendidikanTotal = $statistik['jumlah_penduduk'];
        
        // Ambil data penduduk dengan pagination untuk ditampilkan di tabel
        $penduduk = \App\Models\Penduduk::orderBy('rt')->orderBy('nama')->paginate(20);
        
        return view('data', compact('penduduk', 'statistik', 'chartData', 'pendidikanTotal', 'pendidikanStats'));
    }

    public function kesehatan()
    {
        return view('kesehatan');
    }

    public function galeri()
    {
        $galeri = \App\Models\Galeri::published()
            ->orderBy('urutan')
            ->latest()
            ->paginate(12);
        
        $kategoriList = \App\Models\Galeri::getKategori();
        
        return view('galeri', compact('galeri', 'kategoriList'));
    }

    public function umkm()
    {
        $umkm = \App\Models\Umkm::published()
            ->orderBy('urutan')
            ->latest()
            ->paginate(12);
        
        $kategoriList = \App\Models\Umkm::getKategori();
        
        return view('umkm', compact('umkm', 'kategoriList'));
    }

    public function kontak()
    {
        $kategoriList = \App\Models\Pengaduan::getKategori();
        return view('kontak', compact('kategoriList'));
    }

    public function storePengaduan(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16',
            'email' => 'nullable|email|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'kategori' => 'required|string',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|max:5000',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi',
            'telepon.required' => 'Nomor telepon wajib diisi',
            'kategori.required' => 'Kategori wajib dipilih',
            'judul.required' => 'Judul/Subjek wajib diisi',
            'isi.required' => 'Isi pengaduan wajib diisi',
            'nik.max' => 'NIK maksimal 16 digit',
            'email.email' => 'Format email tidak valid',
            'lampiran.mimes' => 'Format file harus PDF, JPG, atau PNG',
            'lampiran.max' => 'Ukuran file maksimal 5MB',
        ]);

        try {
            $data = $request->only(['nama', 'nik', 'email', 'telepon', 'alamat', 'kategori', 'judul', 'isi']);

            // Handle lampiran
            if ($request->hasFile('lampiran')) {
                $file = $request->file('lampiran');
                $filename = 'lampiran-' . time() . '-' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
                
                $uploadPath = public_path('uploads/pengaduan');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $file->move($uploadPath, $filename);
                $data['lampiran'] = $filename;
            }

            $pengaduan = \App\Models\Pengaduan::create($data);
            
            \Illuminate\Support\Facades\Log::info('Pengaduan berhasil disimpan', ['id' => $pengaduan->id, 'nama' => $pengaduan->nama]);

            return redirect()->route('kontak')->with('success', 'Pengaduan Anda telah berhasil dikirim. Kami akan segera menindaklanjuti.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal menyimpan pengaduan', ['error' => $e->getMessage()]);
            return redirect()->route('kontak')->with('error', 'Terjadi kesalahan saat mengirim pengaduan: ' . $e->getMessage())->withInput();
        }
    }

    public function infografisPenduduk()
    {
        $statistik = \App\Models\Penduduk::getAllStatistik();
        return view('infografis.penduduk', compact('statistik'));
    }
}
