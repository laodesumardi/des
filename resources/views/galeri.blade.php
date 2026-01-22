@extends('layouts.app')

@section('title', 'Galeri - Website Resmi Pemerintah Desa')

@section('content')
<div class="w-full">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="mb-6 sm:mb-8 scroll-animate" data-animation="fade-up">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#1e3a8a] mb-2">Galeri Desa</h1>
            <p class="text-gray-600 text-sm sm:text-base md:text-lg">Dokumentasi kegiatan dan momen penting desa</p>
        </div>

        <!-- Kategori -->
        <div class="mb-6 flex flex-wrap gap-2 scroll-animate" data-animation="fade-up" data-delay="100">
            <a href="{{ route('galeri') }}" class="px-4 py-2 {{ !request('kategori') ? 'bg-[#1e3a8a] text-white' : 'bg-gray-200 text-gray-700' }} text-sm font-medium hover:bg-blue-900 hover:text-white transition-colors rounded-lg">Semua</a>
            @foreach($kategoriList as $key => $label)
            <a href="{{ route('galeri', ['kategori' => $key]) }}" class="px-4 py-2 {{ request('kategori') === $key ? 'bg-[#1e3a8a] text-white' : 'bg-gray-200 text-gray-700' }} text-sm font-medium hover:bg-blue-900 hover:text-white transition-colors rounded-lg">{{ $label }}</a>
            @endforeach
        </div>

        @if($galeri->count() > 0)
        <!-- Grid Galeri -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($galeri as $index => $item)
            <div class="scroll-animate group relative bg-white border border-gray-200 rounded-lg overflow-hidden hover:border-[#1e3a8a] transition-all cursor-pointer" 
                data-animation="scale-fade" data-delay="{{ 200 + ($index * 50) }}"
                onclick="openLightbox('{{ $item->gambar_url }}', '{{ $item->judul }}', '{{ $item->deskripsi }}')">
                <div class="aspect-square bg-gray-100 overflow-hidden">
                    <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" 
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="absolute bottom-0 left-0 right-0 p-3 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                    <p class="text-white text-sm font-semibold line-clamp-1">{{ $item->judul }}</p>
                    <p class="text-white/80 text-xs">{{ $item->created_at->translatedFormat('d F Y') }}</p>
                </div>
                <!-- Category Badge -->
                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-white/90 text-gray-700">{{ $kategoriList[$item->kategori] ?? $item->kategori }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="scroll-animate mt-8" data-animation="fade-up">
            {{ $galeri->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white border border-gray-200 rounded-lg p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Foto</h3>
            <p class="text-gray-500">Galeri foto akan segera tersedia.</p>
        </div>
        @endif
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 z-50 hidden bg-black/90 flex items-center justify-center p-4" onclick="closeLightbox(event)">
    <button onclick="closeLightbox(event)" class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
    <div class="max-w-4xl w-full" onclick="event.stopPropagation()">
        <img id="lightbox-img" src="" alt="" class="w-full max-h-[70vh] object-contain rounded-lg">
        <div class="mt-4 text-center">
            <h3 id="lightbox-title" class="text-white text-xl font-semibold"></h3>
            <p id="lightbox-desc" class="text-white/80 mt-2"></p>
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
    .scroll-animate[data-animation="scale-fade"] {
        opacity: 0;
        transform: scale(0.9);
    }
    .scroll-animate[data-animation="scale-fade"].animate-active {
        opacity: 1;
        transform: scale(1);
    }
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
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

    function openLightbox(src, title, desc) {
        const lightbox = document.getElementById('lightbox');
        document.getElementById('lightbox-img').src = src;
        document.getElementById('lightbox-title').textContent = title;
        document.getElementById('lightbox-desc').textContent = desc || '';
        lightbox.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox(event) {
        if (event) event.stopPropagation();
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeLightbox();
    });
</script>
@endsection
