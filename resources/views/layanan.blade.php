@extends('layouts.app')

@section('title', 'Layanan Desa - Website Resmi Pemerintah Desa')

@php
    use App\Models\Content;
    function getContent($page, $section, $key, $default = '') {
        return Content::getContent($page, $section, $key, $default);
    }
    
    // Get header
    $headerTitle = getContent('layanan', 'header', 'title', 'Layanan Desa');
    $headerSubtitle = getContent('layanan', 'header', 'subtitle', 'Pelayanan administrasi yang tersedia untuk masyarakat');
    
    // Get jam pelayanan
    $jamHariKerja = getContent('layanan', 'jam', 'hari_kerja', 'Senin - Jumat');
    $jamWaktuPelayanan = getContent('layanan', 'jam', 'waktu_pelayanan', '08:00 - 15:00 WIB');
    $jamWaktuIstirahat = getContent('layanan', 'jam', 'waktu_istirahat', '12:00 - 13:00 WIB');
    
    // Get daftar layanan
    $layananList = [];
    for ($i = 1; $i <= 6; $i++) {
        $layananList[$i] = [
            'judul' => getContent('layanan', 'layanan_' . $i, 'judul', ''),
            'deskripsi' => getContent('layanan', 'layanan_' . $i, 'deskripsi', ''),
            'persyaratan' => getContent('layanan', 'layanan_' . $i, 'persyaratan', ''),
            'waktu' => getContent('layanan', 'layanan_' . $i, 'waktu', ''),
            'biaya' => getContent('layanan', 'layanan_' . $i, 'biaya', ''),
        ];
    }
    
    // Default values jika kosong
    if (empty($layananList[1]['judul'])) {
        $layananList[1] = ['judul' => 'Surat Keterangan Domisili', 'deskripsi' => 'Surat keterangan tempat tinggal untuk keperluan administrasi.', 'persyaratan' => 'KTP, Kartu Keluarga', 'waktu' => '1-2 hari kerja', 'biaya' => 'Gratis'];
        $layananList[2] = ['judul' => 'Surat Keterangan Tidak Mampu', 'deskripsi' => 'Surat keterangan untuk keperluan bantuan sosial.', 'persyaratan' => 'KTP, Kartu Keluarga, Surat RT/RW', 'waktu' => '2-3 hari kerja', 'biaya' => 'Gratis'];
        $layananList[3] = ['judul' => 'Surat Keterangan Usaha', 'deskripsi' => 'Surat keterangan untuk keperluan perizinan usaha.', 'persyaratan' => 'KTP, Kartu Keluarga, Surat RT/RW', 'waktu' => '2-3 hari kerja', 'biaya' => 'Gratis'];
        $layananList[4] = ['judul' => 'Surat Pengantar KTP', 'deskripsi' => 'Surat pengantar untuk pembuatan atau perpanjangan KTP.', 'persyaratan' => 'Kartu Keluarga, Surat RT/RW', 'waktu' => '1 hari kerja', 'biaya' => 'Gratis'];
        $layananList[5] = ['judul' => 'Surat Keterangan Kelakuan Baik', 'deskripsi' => 'Surat keterangan untuk keperluan pekerjaan atau pendidikan.', 'persyaratan' => 'KTP, Kartu Keluarga, Surat RT/RW', 'waktu' => '2-3 hari kerja', 'biaya' => 'Gratis'];
        $layananList[6] = ['judul' => 'Surat Keterangan Kematian', 'deskripsi' => 'Surat keterangan untuk keperluan administrasi kematian.', 'persyaratan' => 'KTP, Kartu Keluarga, Surat Keterangan Dokter', 'waktu' => '1 hari kerja', 'biaya' => 'Gratis'];
    }
@endphp

@section('content')
<div class="container mx-auto px-4 sm:px-6 py-6">
    
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ $headerTitle }}</h1>
        <p class="text-gray-600">{{ $headerSubtitle }}</p>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <p class="text-red-700">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
        <p class="font-medium text-red-700 mb-2">Terjadi kesalahan:</p>
        <ul class="list-disc list-inside text-red-600 text-sm">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Daftar Layanan -->
    <div class="mb-10">
        <h2 class="text-xl font-bold text-gray-900 mb-5 pb-2 border-b border-gray-200">Daftar Layanan Administrasi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($layananList as $index => $layanan)
                @if(!empty($layanan['judul']))
                <div class="bg-white border border-gray-200 rounded-lg p-5 hover:border-gray-300 transition-colors">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $layanan['judul'] }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ $layanan['deskripsi'] }}</p>
                    <div class="text-sm text-gray-500 space-y-1">
                        <p><span class="font-medium text-gray-700">Persyaratan:</span> {{ $layanan['persyaratan'] }}</p>
                        <p><span class="font-medium text-gray-700">Waktu:</span> {{ $layanan['waktu'] }}</p>
                        <p><span class="font-medium text-gray-700">Biaya:</span> {{ $layanan['biaya'] }}</p>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Cek Status Pengajuan -->
    <div class="bg-[#1e3a8a] rounded-lg p-6 mb-10" id="cek-status">
        <h2 class="text-xl font-bold text-white mb-1">Cek Status Pengajuan</h2>
        <p class="text-blue-200 text-sm mb-4">Lacak status pengajuan layanan Anda dengan memasukkan nama dan NIK</p>
        
        <form action="{{ route('layanan.cek-status') }}" method="POST" id="formCekStatus">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="nama_cek" class="block text-sm text-blue-100 mb-1">Nama Lengkap</label>
                    <input type="text" id="nama_cek" name="nama_cek" required 
                        value="{{ session('cek_nama', old('nama_cek')) }}"
                        class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-lg text-white placeholder-blue-200 text-sm focus:outline-none focus:border-white"
                        placeholder="Masukkan nama sesuai pengajuan">
                </div>
                <div>
                    <label for="nik_cek" class="block text-sm text-blue-100 mb-1">NIK (16 digit)</label>
                    <input type="text" id="nik_cek" name="nik_cek" required 
                        value="{{ session('cek_nik', old('nik_cek')) }}"
                        class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-lg text-white placeholder-blue-200 text-sm focus:outline-none focus:border-white"
                        placeholder="Masukkan NIK 16 digit"
                        maxlength="16" pattern="[0-9]{16}">
                </div>
            </div>
            <button type="submit" class="bg-white text-[#1e3a8a] px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors">
                Cek Status
            </button>
        </form>
    </div>

    <!-- Hasil Cek Status -->
    @if(session('status_found') && session('pengajuan_results'))
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-10">
        <div class="px-5 py-4 bg-green-50 border-b border-green-100">
            <h3 class="font-semibold text-green-800">Data Pengajuan Ditemukan</h3>
            <p class="text-sm text-green-600">{{ session('pengajuan_results')->count() }} pengajuan untuk {{ session('cek_nama') }}</p>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach(session('pengajuan_results') as $item)
            @php
                $statusColors = [
                    'masuk' => 'bg-yellow-100 text-yellow-800',
                    'diproses' => 'bg-blue-100 text-blue-800',
                    'selesai' => 'bg-green-100 text-green-800',
                    'ditolak' => 'bg-red-100 text-red-800',
                ];
                $statusLabels = [
                    'masuk' => 'Menunggu',
                    'diproses' => 'Diproses',
                    'selesai' => 'Selesai',
                    'ditolak' => 'Ditolak',
                ];
            @endphp
            <div class="p-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                    <div>
                        <p class="font-medium text-gray-900">{{ $item->jenis_layanan_label }}</p>
                        <p class="text-sm text-gray-500">Diajukan {{ $item->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                    <span class="inline-block px-3 py-1 text-xs font-medium rounded-full {{ $statusColors[$item->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $statusLabels[$item->status] ?? $item->status }}
                    </span>
                </div>
                
                <!-- Progress -->
                <div class="mb-3">
                    <div class="flex justify-between text-xs text-gray-400 mb-1">
                        <span>Diajukan</span>
                        <span>Verifikasi</span>
                        <span>Proses</span>
                        <span>Selesai</span>
                    </div>
                    <div class="h-1.5 bg-gray-200 rounded-full">
                        @php
                            $progress = match($item->status) {
                                'masuk' => '25%',
                                'diproses' => '65%',
                                'selesai' => '100%',
                                'ditolak' => '100%',
                                default => '0%'
                            };
                            $progressColor = $item->status === 'ditolak' ? 'bg-red-500' : ($item->status === 'selesai' ? 'bg-green-500' : 'bg-[#1e3a8a]');
                        @endphp
                        <div class="h-full {{ $progressColor }} rounded-full" style="width: {{ $progress }}"></div>
                    </div>
                </div>

                @if($item->catatan_admin)
                <div class="bg-gray-50 rounded p-3 text-sm">
                    <p class="text-gray-500 text-xs mb-1">Catatan Petugas:</p>
                    <p class="text-gray-700">{{ $item->catatan_admin }}</p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if(session('status_not_found'))
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-10">
        <div class="flex">
            <svg class="w-5 h-5 text-yellow-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <p class="font-medium text-yellow-800">Data Tidak Ditemukan</p>
                <p class="text-sm text-yellow-700">Tidak ditemukan pengajuan untuk nama "{{ session('cek_nama') }}" dengan NIK "{{ session('cek_nik') }}".</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Form Pengajuan -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-10">
        <h2 class="text-xl font-bold text-gray-900 mb-2">Formulir Pengajuan Layanan</h2>
        <p class="text-gray-600 text-sm mb-6">Isi formulir di bawah untuk mengajukan layanan administrasi</p>
        
        <form action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data" id="formPengajuan">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="jenis_layanan" class="block text-sm font-medium text-gray-700 mb-1">Jenis Layanan <span class="text-red-500">*</span></label>
                    <select id="jenis_layanan" name="jenis_layanan" required 
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-[#1e3a8a] focus:border-[#1e3a8a]">
                        <option value="">Pilih jenis layanan</option>
                        @foreach($jenisLayananList as $key => $label)
                        <option value="{{ $key }}" {{ old('jenis_layanan') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="nama" name="nama" required value="{{ old('nama') }}"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-[#1e3a8a] focus:border-[#1e3a8a]"
                        placeholder="Nama lengkap sesuai KTP">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK <span class="text-red-500">*</span></label>
                    <input type="text" id="nik" name="nik" required value="{{ old('nik') }}"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-[#1e3a8a] focus:border-[#1e3a8a]"
                        placeholder="16 digit NIK"
                        maxlength="16" pattern="[0-9]{16}">
                </div>

                <div>
                    <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon <span class="text-red-500">*</span></label>
                    <input type="tel" id="telepon" name="telepon" required value="{{ old('telepon') }}"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-[#1e3a8a] focus:border-[#1e3a8a]"
                        placeholder="No. telepon yang dapat dihubungi">
                </div>
            </div>

            <div class="mb-5">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                <textarea id="alamat" name="alamat" rows="2" required 
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-[#1e3a8a] focus:border-[#1e3a8a]"
                    placeholder="Alamat lengkap sesuai KK">{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-5">
                <label for="berkas" class="block text-sm font-medium text-gray-700 mb-1">Unggah Berkas <span class="text-red-500">*</span></label>
                <input type="file" id="berkas" name="berkas" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:bg-gray-100 file:text-gray-700"
                    accept=".pdf,.jpg,.jpeg,.png">
                <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG. Maks: 2MB</p>
            </div>

            <div class="mb-5">
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan (Opsional)</label>
                <textarea id="keterangan" name="keterangan" rows="2" 
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-[#1e3a8a] focus:border-[#1e3a8a]"
                    placeholder="Keterangan tambahan jika diperlukan">{{ old('keterangan') }}</textarea>
            </div>

            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-5">
                <p class="text-sm text-gray-700"><span class="font-medium">Catatan:</span> Pastikan data yang diisi sudah benar. Berkas harus jelas dan dapat dibaca.</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-[#1e3a8a] text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-800 transition-colors">
                    Kirim Pengajuan
                </button>
                <button type="reset" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                    Reset
                </button>
            </div>
        </form>
    </div>

    <!-- Jam Pelayanan -->
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Jam Pelayanan</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
            <div>
                <p class="text-sm text-gray-500">Hari Kerja</p>
                <p class="font-medium text-gray-900">{{ $jamHariKerja }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Waktu Pelayanan</p>
                <p class="font-medium text-gray-900">{{ $jamWaktuPelayanan }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Istirahat</p>
                <p class="font-medium text-gray-900">{{ $jamWaktuIstirahat }}</p>
            </div>
        </div>
        <p class="text-sm text-gray-600">
            Informasi lebih lanjut, hubungi kantor desa atau kunjungi halaman <a href="{{ route('kontak') }}" class="text-[#1e3a8a] hover:underline">Kontak</a>.
        </p>
    </div>
</div>
@endsection
