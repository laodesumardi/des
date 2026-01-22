@extends('layouts.app')

@section('title', 'UMKM Desa - Website Resmi Pemerintah Desa')

@section('content')
<div class="w-full">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="mb-6 sm:mb-8 scroll-animate" data-animation="fade-up">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#1e3a8a] mb-2">UMKM Desa</h1>
            <p class="text-gray-600 text-sm sm:text-base md:text-lg">Produk dan jasa dari warga desa yang bisa Anda dukung</p>
        </div>

        <!-- Kategori -->
        <div class="mb-6 flex flex-wrap gap-2 scroll-animate" data-animation="fade-up" data-delay="100">
            <a href="{{ route('umkm') }}" class="px-4 py-2 {{ !request('kategori') ? 'bg-[#1e3a8a] text-white' : 'bg-gray-200 text-gray-700' }} text-sm font-medium hover:bg-blue-900 hover:text-white transition-colors rounded-lg">Semua</a>
            @foreach($kategoriList as $key => $label)
            <a href="{{ route('umkm', ['kategori' => $key]) }}" class="px-4 py-2 {{ request('kategori') === $key ? 'bg-[#1e3a8a] text-white' : 'bg-gray-200 text-gray-700' }} text-sm font-medium hover:bg-blue-900 hover:text-white transition-colors rounded-lg">{{ $label }}</a>
            @endforeach
        </div>

        @if($umkm->count() > 0)
        <!-- Grid UMKM -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($umkm as $index => $item)
            <div class="scroll-animate bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg hover:border-[#1e3a8a] transition-all group" 
                data-animation="fade-up" data-delay="{{ 200 + ($index * 50) }}">
                <!-- Gambar -->
                <div class="aspect-[4/3] relative overflow-hidden bg-gray-100">
                    @if($item->gambar)
                    <img src="{{ $item->gambar_url }}" alt="{{ $item->nama_usaha }}" 
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif
                    
                    <!-- Category Badge -->
                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-white/90 text-[#1e3a8a] shadow-sm">{{ $kategoriList[$item->kategori] ?? $item->kategori }}</span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 text-lg mb-1 group-hover:text-[#1e3a8a] transition-colors">{{ $item->nama_usaha }}</h3>
                    <p class="text-sm text-gray-600 mb-2">{{ $item->nama_pemilik }}</p>
                    
                    @if($item->deskripsi)
                    <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ Str::limit($item->deskripsi, 80) }}</p>
                    @endif

                    @if($item->alamat)
                    <div class="flex items-start gap-2 text-sm text-gray-500 mb-3">
                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="line-clamp-1">{{ $item->alamat }}</span>
                    </div>
                    @endif

                    @if($item->harga_mulai)
                    <div class="mb-4">
                        <span class="text-lg font-bold text-green-600">{{ $item->harga_format }}</span>
                        <span class="text-xs text-gray-500">mulai dari</span>
                    </div>
                    @endif

                    <!-- WhatsApp Button -->
                    <a href="{{ $item->whatsapp_url }}" target="_blank" rel="noopener"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-medium shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Hubungi via WhatsApp
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="scroll-animate mt-8" data-animation="fade-up">
            {{ $umkm->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white border border-gray-200 rounded-lg p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada UMKM Terdaftar</h3>
            <p class="text-gray-500">Data UMKM desa akan segera tersedia.</p>
        </div>
        @endif

        <!-- Info Section -->
        <div class="scroll-animate mt-12 bg-gradient-to-r from-[#1e3a8a] to-blue-700 rounded-xl p-6 md:p-8 text-white" data-animation="fade-up">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h3 class="text-xl font-bold mb-2">Ingin Mendaftarkan Usaha Anda?</h3>
                    <p class="text-blue-100">Jika Anda warga desa dan memiliki usaha yang ingin dipromosikan, silakan hubungi kantor desa untuk mendaftarkan UMKM Anda secara gratis.</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('kontak') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-[#1e3a8a] rounded-lg hover:bg-blue-50 transition-colors font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
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
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
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
@endsection
