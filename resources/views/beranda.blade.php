@extends('layouts.app')

@section('title', 'Beranda')

@php
    use App\Models\Content;
    use App\Helpers\ImageHelper;
    
    function getContent($page, $section, $key, $default = '') {
        return Content::getContent($page, $section, $key, $default);
    }
    
    $heroImage1 = file_exists(public_path('images/hero-1.png')) 
        ? asset('images/hero-1.png') . '?v=' . filemtime(public_path('images/hero-1.png'))
        : 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?w=1920&q=80';
    $heroImage2 = file_exists(public_path('images/hero-2.png')) 
        ? asset('images/hero-2.png') . '?v=' . filemtime(public_path('images/hero-2.png'))
        : 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?w=1920&q=80';
    $heroImage3 = file_exists(public_path('images/hero-3.png')) 
        ? asset('images/hero-3.png') . '?v=' . filemtime(public_path('images/hero-3.png'))
        : 'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?w=1920&q=80';
@endphp

@section('content')
<!-- Hero Slider -->
<div class="relative w-full overflow-hidden bg-gray-900" style="height: 500px;">
    <div id="hero-slider" class="flex transition-transform duration-500 h-full">
        <div class="min-w-full h-full"><img src="{{ $heroImage1 }}" alt="Slide 1" class="w-full h-full object-cover"></div>
        <div class="min-w-full h-full"><img src="{{ $heroImage2 }}" alt="Slide 2" class="w-full h-full object-cover"></div>
        <div class="min-w-full h-full"><img src="{{ $heroImage3 }}" alt="Slide 3" class="w-full h-full object-cover"></div>
    </div>
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
        <button class="hero-dot w-2 h-2 bg-white/70 rounded-full hover:bg-white transition-colors" data-slide="0"></button>
        <button class="hero-dot w-2 h-2 bg-white/70 rounded-full hover:bg-white transition-colors" data-slide="1"></button>
        <button class="hero-dot w-2 h-2 bg-white/70 rounded-full hover:bg-white transition-colors" data-slide="2"></button>
    </div>
</div>

<!-- Statistik Penduduk -->
<div class="container mx-auto px-4 py-12">
    <div class="scroll-fade mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Data Kependudukan</h2>
        <p class="text-gray-500">Informasi statistik penduduk desa</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
        <div class="scroll-fade bg-white border border-gray-200 rounded-xl p-6 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
            <div class="text-3xl md:text-4xl font-bold text-[#1e3a8a] mb-2">{{ number_format($statistik['jumlah_penduduk'] ?? 0) }}</div>
            <div class="text-gray-600 text-sm font-medium">Jumlah Penduduk</div>
        </div>
        <div class="scroll-fade bg-white border border-gray-200 rounded-xl p-6 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300" style="transition-delay: 0.1s">
            <div class="text-3xl md:text-4xl font-bold text-[#1e3a8a] mb-2">{{ number_format($statistik['laki_laki'] ?? 0) }}</div>
            <div class="text-gray-600 text-sm font-medium">Laki-laki</div>
        </div>
        <div class="scroll-fade bg-white border border-gray-200 rounded-xl p-6 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300" style="transition-delay: 0.2s">
            <div class="text-3xl md:text-4xl font-bold text-[#1e3a8a] mb-2">{{ number_format($statistik['perempuan'] ?? 0) }}</div>
            <div class="text-gray-600 text-sm font-medium">Perempuan</div>
        </div>
        <div class="scroll-fade bg-white border border-gray-200 rounded-xl p-6 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300" style="transition-delay: 0.3s">
            <div class="text-3xl md:text-4xl font-bold text-[#1e3a8a] mb-2">{{ number_format($statistik['kepala_keluarga'] ?? 0) }}</div>
            <div class="text-gray-600 text-sm font-medium">Kepala Keluarga</div>
        </div>
    </div>
</div>

<!-- Sambutan Kepala Desa -->
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="scroll-fade mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">{{ getContent('beranda', 'sambutan', 'title', 'Sambutan Kepala Desa') }}</h2>
            <p class="text-gray-500">Pesan dari pimpinan desa untuk masyarakat</p>
        </div>
        <div class="scroll-fade bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-64 flex-shrink-0 p-6 md:p-8 bg-gray-50">
                    @php
                        $fotoKepala = getContent('beranda', 'sambutan', 'foto', 'images/kepala-desa.jpg');
                        if (!str_starts_with($fotoKepala, 'http') && !str_starts_with($fotoKepala, '/')) {
                            $fotoKepala = asset($fotoKepala);
                        }
                    @endphp
                    <img src="{{ $fotoKepala }}" alt="Kepala Desa" class="w-40 h-48 object-cover rounded-lg mx-auto border-2 border-gray-200 shadow-sm" onerror="this.src='https://via.placeholder.com/160x192?text=Foto'">
                    <div class="text-center mt-5">
                        <p class="font-semibold text-gray-800 text-lg">{{ getContent('beranda', 'sambutan', 'nama_kepala', 'Kepala Desa') }}</p>
                        <p class="text-sm text-[#1e3a8a] font-medium mt-1">Kepala Desa</p>
                    </div>
                </div>
                <div class="flex-1 p-6 md:p-8">
                    @php
                        $sambutanText = getContent('beranda', 'sambutan', 'content', "Assalamu'alaikum Warahmatullahi Wabarakatuh\n\nPuji syukur kehadirat Allah SWT, atas rahmat dan karunia-Nya, kami dapat menyampaikan sambutan melalui website resmi Pemerintah Desa ini.\n\nWebsite ini merupakan media komunikasi dan informasi antara Pemerintah Desa dengan seluruh masyarakat. Melalui website ini, kami berkomitmen untuk menyampaikan informasi yang transparan dan akurat.\n\nWassalamu'alaikum Warahmatullahi Wabarakatuh");
                    @endphp
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line text-base">{{ $sambutanText }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Perangkat Desa -->
@if($perangkatDesa->count() > 0)
<div class="container mx-auto px-4 py-12">
    <div class="scroll-fade flex justify-between items-end mb-8">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Perangkat Desa</h2>
            <p class="text-gray-500">Aparatur pemerintahan desa</p>
        </div>
        <a href="{{ route('pemerintahan') }}" class="text-[#1e3a8a] hover:underline text-sm font-medium">
            Lihat Semua →
        </a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
        @foreach($perangkatDesa->take(5) as $index => $perangkat)
        <div class="scroll-fade bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300" style="transition-delay: {{ $index * 0.1 }}s">
            <div class="h-44 bg-gray-100 overflow-hidden">
                @if($perangkat->foto)
                    @php
                        $fotoPath = $perangkat->foto;
                        if (!str_starts_with($fotoPath, 'images/')) {
                            $fotoPath = 'images/' . $fotoPath;
                        }
                    @endphp
                    <img src="{{ asset($fotoPath) }}" alt="{{ $perangkat->nama }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" onerror="this.src='https://via.placeholder.com/200x176?text=Foto'">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                @endif
            </div>
            <div class="p-4 text-center">
                <p class="font-semibold text-gray-800 text-sm mb-1">{{ $perangkat->nama }}</p>
                <p class="text-xs text-[#1e3a8a] font-medium">{{ $perangkat->jabatan }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Berita Terbaru -->
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="scroll-fade flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Berita Terbaru</h2>
                <p class="text-gray-500">Informasi dan kegiatan desa terkini</p>
            </div>
            <a href="{{ route('berita') }}" class="text-[#1e3a8a] hover:underline text-sm font-medium">
                Lihat Semua →
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($beritaTerbaru as $index => $berita)
            <article class="scroll-fade bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300" style="transition-delay: {{ $index * 0.1 }}s">
                <div class="h-44 bg-gray-100 overflow-hidden">
                    @if($berita->gambar)
                    <img src="{{ asset('images/berita/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" onerror="this.src='https://via.placeholder.com/400x176?text=Berita'">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    </div>
                    @endif
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs text-[#1e3a8a] bg-blue-50 px-2.5 py-1 rounded-full font-medium">{{ $berita->kategori ?? 'Berita' }}</span>
                        <span class="text-xs text-gray-400">{{ $berita->published_at ? $berita->published_at->format('d M Y') : $berita->created_at->format('d M Y') }}</span>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 text-base">{{ $berita->judul }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-2 mb-4">{{ Str::limit(strip_tags($berita->isi), 80) }}</p>
                    <a href="{{ route('berita.show', $berita->slug) }}" class="text-[#1e3a8a] text-sm font-medium hover:underline inline-flex items-center gap-1">
                        Baca selengkapnya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-12 text-gray-400">Belum ada berita</div>
            @endforelse
        </div>
    </div>
</div>

<!-- Galeri -->
<div class="container mx-auto px-4 py-12">
    <div class="scroll-fade flex justify-between items-end mb-8">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Galeri Kegiatan</h2>
            <p class="text-gray-500">Dokumentasi aktivitas dan program desa</p>
        </div>
        <a href="{{ route('galeri') }}" class="text-[#1e3a8a] hover:underline text-sm font-medium">
            Lihat Semua →
        </a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @forelse($galeriTerbaru as $index => $galeri)
        <div class="scroll-fade aspect-square rounded-xl overflow-hidden cursor-pointer border border-gray-200 shadow-sm hover:shadow-md hover:scale-105 transition-all duration-300" style="transition-delay: {{ $index * 0.05 }}s" onclick="openLightbox('{{ asset('images/galeri/' . $galeri->gambar) }}', '{{ $galeri->judul }}')">
            <img src="{{ asset('images/galeri/' . $galeri->gambar) }}" alt="{{ $galeri->judul }}" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/300x300?text=Foto'">
        </div>
        @empty
        <div class="col-span-4 text-center py-12 text-gray-400">Belum ada galeri</div>
        @endforelse
    </div>
</div>

<!-- Agenda Kegiatan -->
@if($agendaTerbaru->count() > 0)
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="scroll-fade mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Agenda Kegiatan</h2>
            <p class="text-gray-500">Jadwal kegiatan desa mendatang</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($agendaTerbaru as $index => $agenda)
            <div class="scroll-fade bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300" style="transition-delay: {{ $index * 0.1 }}s">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="bg-[#1e3a8a] text-white rounded-xl p-4 text-center w-18 shadow-sm">
                            <div class="text-2xl font-bold leading-none">{{ $agenda->tanggal_mulai->format('d') }}</div>
                            <div class="text-xs mt-1.5 font-medium">{{ $agenda->tanggal_mulai->translatedFormat('M') }}</div>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-800 mb-3 text-base">{{ $agenda->judul }}</h3>
                        <div class="space-y-2 text-xs text-gray-600">
                            <p class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#1e3a8a] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $agenda->waktu_mulai ? \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') : '-' }} WIB</span>
                            </p>
                            <p class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#1e3a8a] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                <span class="truncate">{{ $agenda->lokasi ?? 'Kantor Desa' }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Layanan -->
<div class="container mx-auto px-4 py-12">
    <div class="scroll-fade text-center mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Layanan Desa</h2>
        <p class="text-gray-500">Akses cepat ke berbagai layanan</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
        <a href="{{ route('layanan') }}" class="scroll-fade bg-white border border-gray-200 rounded-xl p-6 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
            <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <p class="font-semibold text-gray-800 text-sm mb-1">Layanan Surat</p>
            <p class="text-xs text-gray-500">Pengajuan dokumen</p>
        </a>
        <a href="{{ route('data') }}" class="scroll-fade bg-white border border-gray-200 rounded-xl p-6 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300" style="transition-delay: 0.1s">
            <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <p class="font-semibold text-gray-800 text-sm mb-1">Data Statistik</p>
            <p class="text-xs text-gray-500">Infografis desa</p>
        </a>
        <a href="{{ route('umkm') }}" class="scroll-fade bg-white border border-gray-200 rounded-xl p-6 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300" style="transition-delay: 0.2s">
            <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <p class="font-semibold text-gray-800 text-sm mb-1">UMKM Desa</p>
            <p class="text-xs text-gray-500">Produk lokal</p>
        </a>
        <a href="{{ route('kontak') }}" class="scroll-fade bg-white border border-gray-200 rounded-xl p-6 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300" style="transition-delay: 0.3s">
            <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <p class="font-semibold text-gray-800 text-sm mb-1">Hubungi Kami</p>
            <p class="text-xs text-gray-500">Kontak & lokasi</p>
        </a>
    </div>
</div>

<!-- Lightbox -->
<div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 p-4" onclick="closeLightbox()">
    <button class="absolute top-4 right-4 text-white/70 hover:text-white text-4xl transition-colors">&times;</button>
    <img id="lightbox-image" src="" alt="" class="max-w-full max-h-[90vh] object-contain rounded" onclick="event.stopPropagation()">
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Scroll Animation */
.scroll-fade {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

.scroll-fade.visible {
    opacity: 1;
    transform: translateY(0);
}
</style>

<script>
// Hero Slider
let currentSlide = 0;
const heroSlider = document.getElementById('hero-slider');
const heroDots = document.querySelectorAll('.hero-dot');

function showSlide(n) {
    currentSlide = n;
    heroSlider.style.transform = 'translateX(-' + (n * 100) + '%)';
    heroDots.forEach((dot, i) => {
        dot.classList.toggle('bg-white', i === n);
        dot.classList.toggle('bg-white/70', i !== n);
    });
}

heroDots.forEach((dot, i) => {
    dot.addEventListener('click', () => showSlide(i));
});

setInterval(() => {
    showSlide((currentSlide + 1) % 3);
}, 5000);

// Scroll Animation dengan Intersection Observer
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            // Optional: Unobserve setelah muncul untuk performa
            // observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe semua elemen dengan class scroll-fade
document.addEventListener('DOMContentLoaded', () => {
    const fadeElements = document.querySelectorAll('.scroll-fade');
    fadeElements.forEach(el => observer.observe(el));
});

// Lightbox
function openLightbox(src, title) {
    document.getElementById('lightbox-image').src = src;
    document.getElementById('lightbox').classList.remove('hidden');
    document.getElementById('lightbox').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.getElementById('lightbox').classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeLightbox();
});
</script>
@endsection
