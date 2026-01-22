@extends('layouts.app')

@section('title', 'Berita & Pengumuman - Website Resmi Pemerintah Desa')

@section('content')
<div class="w-full">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="mb-6 sm:mb-8 scroll-animate" data-animation="fade-up">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#1e3a8a] mb-2">Berita & Pengumuman</h1>
            <p class="text-gray-600 text-sm sm:text-base md:text-lg">Informasi terbaru dari pemerintah desa</p>
        </div>

        <!-- Filter Kategori -->
        <div class="mb-4 sm:mb-6 flex flex-wrap gap-2 scroll-animate" data-animation="fade-up" data-delay="100">
            <a href="{{ route('berita') }}" class="px-3 sm:px-4 py-1.5 sm:py-2 {{ !request('kategori') ? 'bg-[#1e3a8a] text-white' : 'bg-gray-200 text-gray-700' }} text-xs sm:text-sm font-medium hover:bg-blue-900 hover:text-white transition-colors rounded-lg">Semua</a>
            @foreach($kategoriList as $key => $label)
            <a href="{{ route('berita', ['kategori' => $key]) }}" class="px-3 sm:px-4 py-1.5 sm:py-2 {{ request('kategori') === $key ? 'bg-[#1e3a8a] text-white' : 'bg-gray-200 text-gray-700' }} text-xs sm:text-sm font-medium hover:bg-blue-900 hover:text-white transition-colors rounded-lg">{{ $label }}</a>
            @endforeach
        </div>

        @if($berita->count() > 0)
        <!-- Daftar Berita -->
        <div class="space-y-4 sm:space-y-6" id="berita-list-content">
            @foreach($berita as $index => $item)
            <article class="scroll-animate bg-white border border-gray-200 p-4 sm:p-6 md:p-8 hover:border-[#1e3a8a] transition-colors group rounded-lg" data-animation="fade-up" data-delay="{{ 200 + ($index * 100) }}">
                <div class="flex flex-col md:flex-row gap-4 sm:gap-6">
                    <!-- Gambar -->
                    <div class="flex-shrink-0 w-full md:w-64">
                        <div class="aspect-video md:aspect-square bg-gray-100 overflow-hidden rounded-lg">
                            @if($item->gambar)
                            <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- Konten -->
                    <div class="flex-1">
                        <div class="flex items-start gap-2 sm:gap-4 mb-3 sm:mb-4">
                            <span class="bg-blue-100 text-[#1e3a8a] px-3 sm:px-4 py-1 sm:py-1.5 text-xs font-semibold rounded-full">{{ $kategoriList[$item->kategori] ?? $item->kategori }}</span>
                            <time class="text-xs sm:text-sm text-gray-500">{{ $item->published_at ? $item->published_at->translatedFormat('d F Y') : $item->created_at->translatedFormat('d F Y') }}</time>
                        </div>
                        <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-2 sm:mb-3 group-hover:text-[#1e3a8a] transition-colors">
                            {{ $item->judul }}
                        </h2>
                        <p class="text-gray-700 text-sm sm:text-base md:text-lg leading-relaxed mb-3 sm:mb-4">
                            {{ Str::limit(strip_tags($item->ringkasan ?? $item->konten), 200) }}
                        </p>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('berita.show', $item->slug) }}" class="text-[#1e3a8a] text-xs sm:text-sm font-medium hover:underline inline-flex items-center gap-1">
                                Baca selengkapnya
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            <span class="text-xs text-gray-400 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ number_format($item->views) }}
                            </span>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="scroll-animate mt-8" data-animation="fade-up">
            {{ $berita->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white border border-gray-200 rounded-lg p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Berita</h3>
            <p class="text-gray-500">Berita dan pengumuman akan segera tersedia.</p>
        </div>
        @endif
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
