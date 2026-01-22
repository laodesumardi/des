@extends('layouts.app')

@section('title', 'Kontak & Aspirasi - Website Resmi Pemerintah Desa')

@php
    use App\Models\Content;
    
    // Helper function untuk mendapatkan konten
    $getContent = function($section, $key, $default = '') {
        $content = Content::where('page', 'kontak')
            ->where('section', $section)
            ->where('key', $key)
            ->first();
        return $content ? $content->content : $default;
    };
    
    // Header
    $headerTitle = $getContent('header', 'title', 'Kontak & Aspirasi');
    $headerSubtitle = $getContent('header', 'subtitle', 'Hubungi kami atau sampaikan aspirasi Anda');
    
    // Alamat
    $namaKantor = $getContent('alamat', 'nama_kantor', 'Kantor Pemerintah Desa');
    $alamatLengkap = $getContent('alamat', 'alamat_lengkap', "Jalan Raya Desa No. 123\nKecamatan, Kabupaten\nProvinsi\nKode Pos 12345");
    
    // Telepon
    $telepon = $getContent('telepon', 'telepon', '(021) 1234-5678');
    $fax = $getContent('telepon', 'fax', '(021) 1234-5679');
    $email = $getContent('telepon', 'email', 'info@desa.go.id');
    
    // Jam
    $hariKerja = $getContent('jam', 'hari_kerja', 'Senin - Jumat');
    $waktu = $getContent('jam', 'waktu', '08:00 - 15:00 WIB');
    $istirahat = $getContent('jam', 'istirahat', '12:00 - 13:00 WIB');
    $hariLibur = $getContent('jam', 'hari_libur', 'Sabtu, Minggu, dan Hari Libur Nasional');
    
    // Perangkat
    $jabatan1 = $getContent('perangkat', 'jabatan_1', 'Kepala Desa');
    $telepon1 = $getContent('perangkat', 'telepon_1', '(021) 1234-5680');
    $jabatan2 = $getContent('perangkat', 'jabatan_2', 'Sekretaris');
    $telepon2 = $getContent('perangkat', 'telepon_2', '(021) 1234-5681');
    $jabatan3 = $getContent('perangkat', 'jabatan_3', 'Kaur Kesra');
    $telepon3 = $getContent('perangkat', 'telepon_3', '(021) 1234-5682');
    
    // Peta
    $petaEmbedUrl = $getContent('peta', 'embed_url', '');
@endphp

@section('content')
    <div class="container mx-auto px-4 sm:px-6">
        <div class="mb-6 sm:mb-8 scroll-animate" data-animation="fade-up">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#1e3a8a] mb-2">{{ $headerTitle }}</h1>
            <p class="text-gray-600 text-sm sm:text-base md:text-lg">{{ $headerSubtitle }}</p>
        </div>

    <!-- Informasi Kontak Resmi -->
    <div class="scroll-animate bg-white border border-gray-200 p-6 md:p-8 mb-8" data-animation="fade-up" data-delay="100">
        <h2 class="text-xl md:text-2xl font-bold text-[#1e3a8a] mb-6 pb-3 border-b-2 border-[#1e3a8a]">Kontak Resmi Pemerintah Desa</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-gray-50 border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Alamat Kantor</h3>
                <p class="text-gray-700 text-sm leading-relaxed">
                    {{ $namaKantor }}<br>
                    {!! nl2br(e($alamatLengkap)) !!}
                </p>
            </div>
            <div class="bg-gray-50 border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Kontak Telepon</h3>
                <p class="text-gray-700 text-sm space-y-1">
                    <strong>Telepon:</strong><br>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $telepon) }}" class="text-[#1e3a8a] hover:underline font-medium">{{ $telepon }}</a><br><br>
                    @if($fax)
                    <strong>Faksimili:</strong><br>
                    {{ $fax }}<br><br>
                    @endif
                    <strong>Email:</strong><br>
                    <a href="mailto:{{ $email }}" class="text-[#1e3a8a] hover:underline font-medium">{{ $email }}</a>
                </p>
            </div>
            <div class="bg-gray-50 border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Jam Pelayanan</h3>
                <p class="text-gray-700 text-sm">
                    <strong>Hari Kerja:</strong> {{ $hariKerja }}<br>
                    <strong>Waktu:</strong> {{ $waktu }}<br>
                    @if($istirahat)
                    <strong>Istirahat:</strong> {{ $istirahat }}<br>
                    @endif
                    <strong>Hari Libur:</strong> {{ $hariLibur }}
                </p>
            </div>
            <div class="bg-gray-50 border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Kontak Perangkat</h3>
                <p class="text-gray-700 text-sm space-y-1">
                    @if($jabatan1 && $telepon1)
                    <strong>{{ $jabatan1 }}:</strong><br>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $telepon1) }}" class="text-[#1e3a8a] hover:underline font-medium">{{ $telepon1 }}</a><br><br>
                    @endif
                    @if($jabatan2 && $telepon2)
                    <strong>{{ $jabatan2 }}:</strong><br>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $telepon2) }}" class="text-[#1e3a8a] hover:underline font-medium">{{ $telepon2 }}</a><br><br>
                    @endif
                    @if($jabatan3 && $telepon3)
                    <strong>{{ $jabatan3 }}:</strong><br>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $telepon3) }}" class="text-[#1e3a8a] hover:underline font-medium">{{ $telepon3 }}</a>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
    <div class="scroll-animate bg-green-50 border border-green-200 p-4 mb-8 rounded-lg flex items-start gap-3" data-animation="fade-up">
        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <p class="font-medium text-green-800">Berhasil!</p>
            <p class="text-green-700 text-sm">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="scroll-animate bg-red-50 border border-red-200 p-4 mb-8 rounded-lg flex items-start gap-3" data-animation="fade-up">
        <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <p class="font-medium text-red-800">Gagal!</p>
            <p class="text-red-700 text-sm">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="scroll-animate bg-red-50 border border-red-200 p-4 mb-8 rounded-lg" data-animation="fade-up">
        <p class="font-medium text-red-800 mb-2">Terjadi kesalahan:</p>
        <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Pengaduan/Aspirasi Warga -->
    <div class="scroll-animate bg-white border border-gray-200 p-6 md:p-8 mb-8 rounded-lg" data-animation="fade-up">
        <h2 class="text-xl md:text-2xl font-bold text-[#1e3a8a] mb-4 pb-3 border-b-2 border-[#1e3a8a]">Formulir Pengaduan & Aspirasi</h2>
        <p class="text-gray-700 text-base mb-6">
            Formulir ini digunakan untuk menyampaikan pengaduan, aspirasi, saran, atau masukan kepada Pemerintah Desa. 
            Kami menghargai setiap aspirasi yang disampaikan dan akan menindaklanjuti sesuai dengan mekanisme 
            yang berlaku.
        </p>
        
        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-600">*</span>
                    </label>
                    <input type="text" id="nama" name="nama" required value="{{ old('nama') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a]"
                        placeholder="Masukkan nama lengkap">
                    @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                        NIK (Opsional)
                    </label>
                    <input type="text" id="nik" name="nik" value="{{ old('nik') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a]"
                        placeholder="16 digit NIK" maxlength="16">
                    @error('nik')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon <span class="text-red-600">*</span>
                    </label>
                    <input type="tel" id="telepon" name="telepon" required value="{{ old('telepon') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a]"
                        placeholder="Contoh: 08123456789">
                    @error('telepon')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email (Opsional)
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a]"
                        placeholder="email@contoh.com">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                    Alamat (Opsional)
                </label>
                <textarea id="alamat" name="alamat" rows="2"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a]"
                    placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-600">*</span>
                    </label>
                    <select id="kategori" name="kategori" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a]">
                        <option value="">Pilih kategori</option>
                        @foreach($kategoriList as $key => $label)
                        <option value="{{ $key }}" {{ old('kategori') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('kategori')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul/Subjek <span class="text-red-600">*</span>
                    </label>
                    <input type="text" id="judul" name="judul" required value="{{ old('judul') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a]"
                        placeholder="Judul pengaduan/aspirasi">
                    @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="isi" class="block text-sm font-medium text-gray-700 mb-2">
                    Isi Pengaduan/Aspirasi <span class="text-red-600">*</span>
                </label>
                <textarea id="isi" name="isi" rows="6" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a]"
                    placeholder="Tuliskan pengaduan atau aspirasi Anda secara lengkap dan jelas...">{{ old('isi') }}</textarea>
                @error('isi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="lampiran" class="block text-sm font-medium text-gray-700 mb-2">
                    Lampiran (Opsional)
                </label>
                <input type="file" id="lampiran" name="lampiran" accept=".pdf,.jpg,.jpeg,.png"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-[#1e3a8a]">
                <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG. Maksimal 5MB</p>
                @error('lampiran')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg text-sm text-gray-700">
                <p class="font-semibold mb-2">Ketentuan:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>Pastikan data yang diisi sudah benar</li>
                    <li>Pengaduan akan ditindaklanjuti dalam 3-7 hari kerja</li>
                    <li>Gunakan bahasa yang sopan dan jelas</li>
                </ul>
            </div>

            <div class="flex gap-3">
                <button type="submit" id="submitBtn" class="bg-[#1e3a8a] text-white px-6 py-2.5 text-sm font-medium hover:bg-blue-900 transition-colors rounded-lg flex items-center gap-2">
                    <span id="submitText">Kirim Pengaduan</span>
                    <svg id="submitSpinner" class="hidden animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
                <button type="reset" class="bg-gray-200 text-gray-700 px-6 py-2.5 text-sm font-medium hover:bg-gray-300 transition-colors rounded-lg">
                    Reset
                </button>
            </div>
        </form>
        
        <script>
            document.querySelector('form[action="{{ route('pengaduan.store') }}"]').addEventListener('submit', function(e) {
                var btn = document.getElementById('submitBtn');
                var text = document.getElementById('submitText');
                var spinner = document.getElementById('submitSpinner');
                
                text.textContent = 'Mengirim...';
                spinner.classList.remove('hidden');
                btn.disabled = true;
                btn.classList.add('opacity-75', 'cursor-not-allowed');
            });
        </script>
    </div>

    <!-- Peta Lokasi -->
    <div class="scroll-animate bg-white border border-gray-200 p-6 md:p-8" data-animation="fade-up" data-delay="100">
        <h2 class="text-xl md:text-2xl font-bold text-[#1e3a8a] mb-4 pb-3 border-b-2 border-[#1e3a8a]">Peta Lokasi Kantor Desa</h2>
        @if($petaEmbedUrl)
        <div class="w-full h-64 md:h-80">
            <iframe 
                src="{{ $petaEmbedUrl }}" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        @else
        <div class="bg-gray-100 border border-gray-200 h-64 md:h-80 flex items-center justify-center">
            <div class="text-center">
                <svg class="w-20 h-20 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <p class="text-gray-500 text-sm md:text-base">Peta lokasi kantor desa akan ditampilkan di sini</p>
            </div>
        </div>
        @endif
        <p class="text-sm text-gray-600 mt-4">
            Untuk informasi lebih lanjut mengenai lokasi kantor desa, silakan hubungi nomor telepon yang tertera di atas.
        </p>
    </div>

    <style>
        .scroll-animate {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .scroll-animate.animate-active {
            opacity: 1;
            transform: translateY(0);
        }
        .scroll-animate[data-animation="fade-up"] {
            opacity: 0;
            transform: translateY(20px);
        }
        .scroll-animate[data-animation="fade-up"].animate-active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const element = entry.target;
                        const delay = parseInt(element.dataset.delay) || 0;
                        setTimeout(() => {
                            element.classList.add('animate-active');
                        }, delay);
                        observer.unobserve(element);
                    }
                });
            }, { root: null, rootMargin: '0px', threshold: 0.1 });
            document.querySelectorAll('.scroll-animate').forEach(el => observer.observe(el));
        });
    </script>
    </div>
@endsection
