<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        use App\Models\Content;
        use App\Helpers\ImageHelper;
        
        // Get settings
        $headerNamaDesa = Content::getContent('settings', 'general', 'nama_desa') ?: Content::getContent('beranda', 'header_website', 'nama_desa', 'Pemerintah Desa');
        $headerSubtitle = Content::getContent('settings', 'general', 'tagline') ?: Content::getContent('beranda', 'header_website', 'subtitle', 'Website Resmi Informasi Desa');
        $metaDescription = Content::getContent('settings', 'seo', 'meta_description', 'Website Resmi Pemerintah Desa');
        $metaKeywords = Content::getContent('settings', 'seo', 'meta_keywords', '');
        
        // Find header background image
        $headerBgImage = ImageHelper::findImage('header-bg', 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?w=1920&q=80');
        
        // Find logo
        $logoPath = null;
        foreach (glob(public_path('images/logo-*')) as $file) {
            $logoPath = basename($file);
            break;
        }
        if (!$logoPath) {
            foreach (glob(public_path('images/logo.*')) as $file) {
                $logoPath = basename($file);
                break;
            }
        }
        
        // Find favicon
        $faviconPath = null;
        foreach (glob(public_path('images/favicon-*')) as $file) {
            $faviconPath = 'images/' . basename($file);
            break;
        }
        if (!$faviconPath) {
            foreach (glob(public_path('images/favicon.*')) as $file) {
                $faviconPath = 'images/' . basename($file);
                break;
            }
        }
        
        // Social media
        $socialFacebook = Content::getContent('settings', 'social', 'facebook', '');
        $socialInstagram = Content::getContent('settings', 'social', 'instagram', '');
        $socialYoutube = Content::getContent('settings', 'social', 'youtube', '');
        $socialTwitter = Content::getContent('settings', 'social', 'twitter', '');
        
        // Footer
        $footerText = Content::getContent('settings', 'footer', 'footer_text', 'Dikelola oleh Tim IT Pemerintah Desa');
    @endphp
    <meta name="description" content="{{ $metaDescription }}">
    @if($metaKeywords)
    <meta name="keywords" content="{{ $metaKeywords }}">
    @endif
    <title>@yield('title', 'Website Resmi ' . $headerNamaDesa)</title>
    
    <!-- Favicon -->
    @if($faviconPath)
    <link rel="icon" type="image/x-icon" href="{{ asset($faviconPath) }}?v={{ time() }}">
    <link rel="shortcut icon" href="{{ asset($faviconPath) }}?v={{ time() }}">
    @else
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif
    
    @php
        $manifestPath = public_path('build/manifest.json');
        $cssFile = 'build/assets/app.css';
        $jsFile = 'build/assets/app.js';
        
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            if (isset($manifest['resources/css/app.css']['file'])) {
                $cssFile = 'build/' . $manifest['resources/css/app.css']['file'];
            }
            if (isset($manifest['resources/js/app.js']['file'])) {
                $jsFile = 'build/' . $manifest['resources/js/app.js']['file'];
            }
        }
    @endphp
    <link rel="stylesheet" href="{{ asset($cssFile) }}">
    <script src="{{ asset($jsFile) }}" defer></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="relative bg-[#1e3a8a] text-white header-animate overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 header-bg"></div>
        <div class="container mx-auto px-4 py-8 md:py-12 relative z-10">
            <div class="flex items-center gap-4 md:gap-6">
                <!-- Logo -->
                <div class="logo-animate px-4 py-3 md:px-5 md:py-4 flex items-center justify-center overflow-hidden">
                    @if($logoPath)
                    <img src="{{ asset('images/' . $logoPath) }}?v={{ time() }}" alt="{{ $headerNamaDesa }}" class="w-16 h-16 md:w-20 md:h-20 object-contain">
                    @else
                    <svg class="w-16 h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    @endif
                </div>
                <!-- Nama Desa -->
                <div class="header-text-animate flex-1">
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-1 drop-shadow-lg">{{ $headerNamaDesa }}</h1>
                    <p class="text-sm md:text-base text-blue-100 drop-shadow-md">{{ $headerSubtitle }}</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigasi Sticky -->
    <nav id="sticky-nav" class="sticky top-0 z-50 bg-blue-900 text-white shadow-lg nav-animate">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <!-- Menu Desktop -->
                <div class="hidden md:flex flex-wrap">
                    <a href="{{ route('beranda') }}" class="menu-item-animate px-4 py-3 text-sm font-medium hover:bg-[#1e3a8a] transition-colors {{ request()->routeIs('beranda') ? 'bg-[#1e3a8a] border-b-2 border-white' : '' }}">Beranda</a>
                    <a href="{{ route('profil') }}" class="menu-item-animate px-4 py-3 text-sm font-medium hover:bg-[#1e3a8a] transition-colors {{ request()->routeIs('profil') ? 'bg-[#1e3a8a] border-b-2 border-white' : '' }}">Profil Desa</a>
                    <a href="{{ route('pemerintahan') }}" class="menu-item-animate px-4 py-3 text-sm font-medium hover:bg-[#1e3a8a] transition-colors {{ request()->routeIs('pemerintahan') ? 'bg-[#1e3a8a] border-b-2 border-white' : '' }}">Pemerintahan</a>
                    <a href="{{ route('berita') }}" class="menu-item-animate px-4 py-3 text-sm font-medium hover:bg-[#1e3a8a] transition-colors {{ request()->routeIs('berita') ? 'bg-[#1e3a8a] border-b-2 border-white' : '' }}">Berita</a>
                    <a href="{{ route('layanan') }}" class="menu-item-animate px-4 py-3 text-sm font-medium hover:bg-[#1e3a8a] transition-colors {{ request()->routeIs('layanan') ? 'bg-[#1e3a8a] border-b-2 border-white' : '' }}">Layanan</a>
                    <div class="relative group">
                        <button class="menu-item-animate px-4 py-3 text-sm font-medium hover:bg-[#1e3a8a] transition-colors flex items-center gap-1 {{ request()->routeIs('data') || request()->routeIs('infografis.*') ? 'bg-[#1e3a8a] border-b-2 border-white' : '' }}">
                            Infografis
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-0 w-48 bg-white rounded-b-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ route('data') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-[#1e3a8a] hover:text-white transition-colors {{ request()->routeIs('data') ? 'bg-[#1e3a8a] text-white' : '' }}">Statistik Umum</a>
                            <a href="{{ route('infografis.penduduk') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-[#1e3a8a] hover:text-white transition-colors rounded-b-lg {{ request()->routeIs('infografis.penduduk') ? 'bg-[#1e3a8a] text-white' : '' }}">Statistik Penduduk</a>
                        </div>
                    </div>
                    <a href="{{ route('galeri') }}" class="menu-item-animate px-4 py-3 text-sm font-medium hover:bg-[#1e3a8a] transition-colors {{ request()->routeIs('galeri') ? 'bg-[#1e3a8a] border-b-2 border-white' : '' }}">Galeri</a>
                    <a href="{{ route('umkm') }}" class="menu-item-animate px-4 py-3 text-sm font-medium hover:bg-[#1e3a8a] transition-colors {{ request()->routeIs('umkm') ? 'bg-[#1e3a8a] border-b-2 border-white' : '' }}">Ekonomi & UMKM</a>
                    <a href="{{ route('kontak') }}" class="menu-item-animate px-4 py-3 text-sm font-medium hover:bg-[#1e3a8a] transition-colors {{ request()->routeIs('kontak') ? 'bg-[#1e3a8a] border-b-2 border-white' : '' }}">Kontak</a>
                </div>
                <!-- Tombol Mobile Menu -->
                <button id="mobile-menu-btn" class="md:hidden p-3 hover:bg-[#1e3a8a] transition-colors rounded-lg -webkit-tap-highlight-color:transparent" aria-label="Toggle menu" style="-webkit-tap-highlight-color: transparent;">
                    <svg id="menu-icon" class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="close-icon" class="w-7 h-7 text-white hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <!-- Menu Mobile -->
                <div id="mobile-menu" class="hidden md:hidden border-t border-blue-600 mobile-menu-container bg-white">
                    <a href="{{ route('beranda') }}" class="mobile-menu-item block px-5 py-3.5 text-base font-medium text-gray-800 hover:bg-[#1e3a8a] hover:text-white transition-colors border-b border-gray-100 {{ request()->routeIs('beranda') ? 'bg-[#1e3a8a] text-white' : '' }}">Beranda</a>
                    <a href="{{ route('profil') }}" class="mobile-menu-item block px-5 py-3.5 text-base font-medium text-gray-800 hover:bg-[#1e3a8a] hover:text-white transition-colors border-b border-gray-100 {{ request()->routeIs('profil') ? 'bg-[#1e3a8a] text-white' : '' }}">Profil Desa</a>
                    <a href="{{ route('pemerintahan') }}" class="mobile-menu-item block px-5 py-3.5 text-base font-medium text-gray-800 hover:bg-[#1e3a8a] hover:text-white transition-colors border-b border-gray-100 {{ request()->routeIs('pemerintahan') ? 'bg-[#1e3a8a] text-white' : '' }}">Pemerintahan Desa</a>
                    <a href="{{ route('berita') }}" class="mobile-menu-item block px-5 py-3.5 text-base font-medium text-gray-800 hover:bg-[#1e3a8a] hover:text-white transition-colors border-b border-gray-100 {{ request()->routeIs('berita') ? 'bg-[#1e3a8a] text-white' : '' }}">Berita & Pengumuman</a>
                    <a href="{{ route('layanan') }}" class="mobile-menu-item block px-5 py-3.5 text-base font-medium text-gray-800 hover:bg-[#1e3a8a] hover:text-white transition-colors border-b border-gray-100 {{ request()->routeIs('layanan') ? 'bg-[#1e3a8a] text-white' : '' }}">Layanan Desa</a>
                    <a href="{{ route('data') }}" class="mobile-menu-item block px-5 py-3.5 text-base font-medium text-gray-800 hover:bg-[#1e3a8a] hover:text-white transition-colors border-b border-gray-100 {{ request()->routeIs('data') ? 'bg-[#1e3a8a] text-white' : '' }}">Statistik Umum</a>
                    <a href="{{ route('infografis.penduduk') }}" class="mobile-menu-item block px-5 py-3.5 text-base font-medium text-gray-800 hover:bg-[#1e3a8a] hover:text-white transition-colors border-b border-gray-100 {{ request()->routeIs('infografis.penduduk') ? 'bg-[#1e3a8a] text-white' : '' }}">Statistik Penduduk</a>
                    <a href="{{ route('galeri') }}" class="mobile-menu-item block px-5 py-3.5 text-base font-medium text-gray-800 hover:bg-[#1e3a8a] hover:text-white transition-colors border-b border-gray-100 {{ request()->routeIs('galeri') ? 'bg-[#1e3a8a] text-white' : '' }}">Galeri</a>
                    <a href="{{ route('umkm') }}" class="mobile-menu-item block px-5 py-3.5 text-base font-medium text-gray-800 hover:bg-[#1e3a8a] hover:text-white transition-colors border-b border-gray-100 {{ request()->routeIs('umkm') ? 'bg-[#1e3a8a] text-white' : '' }}">Ekonomi & UMKM</a>
                    <a href="{{ route('kontak') }}" class="mobile-menu-item block px-5 py-3.5 text-base font-medium text-gray-800 hover:bg-[#1e3a8a] hover:text-white transition-colors border-b border-gray-100 {{ request()->routeIs('kontak') ? 'bg-[#1e3a8a] text-white' : '' }}">Kontak & Aspirasi</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Pengumuman Penting Banner (Fixed at top, below nav) -->
    @php
        $pengumumanAktif = \App\Models\Pengumuman::active()->penting()->latest()->first();
    @endphp
    @if($pengumumanAktif)
    <div class="bg-gradient-to-r from-red-600 via-red-500 to-red-600 text-white py-3 px-4 shadow-lg" id="pengumuman-banner">
        <div class="container mx-auto flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 flex-1 min-w-0">
                <span class="flex-shrink-0 px-2.5 py-1 bg-white text-red-600 text-xs font-bold rounded uppercase animate-pulse shadow">
                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Penting
                </span>
                <p class="text-sm md:text-base font-medium truncate">{{ $pengumumanAktif->judul }}</p>
            </div>
            <button onclick="document.getElementById('pengumuman-banner').style.display='none'" class="flex-shrink-0 p-1.5 hover:bg-white/20 rounded-full transition-colors" aria-label="Tutup">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main class="{{ !request()->routeIs('beranda') ? 'pt-6 sm:pt-8 md:pt-10' : '' }}">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>

    <!-- Footer -->
    @php
        $footerKontak = Content::where('page', 'kontak')->where('section', 'telepon')->get()->keyBy('key');
        $footerAlamat = Content::where('page', 'kontak')->where('section', 'alamat')->get()->keyBy('key');
        $agendaMendatang = \App\Models\Agenda::upcoming()->take(3)->get();
    @endphp
    <footer class="bg-[#1e3a8a] text-white mt-16">
        <div class="container mx-auto px-4 py-10 md:py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
                <!-- Tentang Desa -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 overflow-hidden">
                            @if($logoPath)
                            <img src="{{ asset('images/' . $logoPath) }}?v={{ time() }}" alt="{{ $headerNamaDesa }}" class="w-8 h-8 object-contain">
                            @else
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            @endif
                        </div>
                        <h3 class="text-lg font-bold">{{ $headerNamaDesa }}</h3>
                    </div>
                    <p class="text-blue-200 text-sm leading-relaxed mb-4">
                        Website resmi Pemerintah Desa untuk menyampaikan informasi, kebijakan, dan layanan publik yang transparan dan akuntabel kepada seluruh masyarakat.
                    </p>
                    <div class="flex gap-3">
                        @if($socialFacebook)
                        <a href="{{ $socialFacebook }}" target="_blank" rel="noopener noreferrer" class="bg-white/10 hover:bg-white/20 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        @else
                        <a href="#" class="bg-white/10 hover:bg-white/20 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        @endif
                        @if($socialInstagram)
                        <a href="{{ $socialInstagram }}" target="_blank" rel="noopener noreferrer" class="bg-white/10 hover:bg-white/20 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        @else
                        <a href="#" class="bg-white/10 hover:bg-white/20 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        @endif
                        @if($socialYoutube)
                        <a href="{{ $socialYoutube }}" target="_blank" rel="noopener noreferrer" class="bg-white/10 hover:bg-white/20 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                        </a>
                        @else
                        <a href="#" class="bg-white/10 hover:bg-white/20 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Link Menu -->
                <div>
                    <h3 class="text-lg font-bold mb-4 pb-2 border-b border-blue-700">Menu Utama</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('beranda') }}" class="text-blue-200 hover:text-white transition-colors flex items-center gap-2"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>Beranda</a></li>
                        <li><a href="{{ route('profil') }}" class="text-blue-200 hover:text-white transition-colors flex items-center gap-2"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>Profil Desa</a></li>
                        <li><a href="{{ route('pemerintahan') }}" class="text-blue-200 hover:text-white transition-colors flex items-center gap-2"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>Pemerintahan</a></li>
                        <li><a href="{{ route('berita') }}" class="text-blue-200 hover:text-white transition-colors flex items-center gap-2"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>Berita</a></li>
                        <li><a href="{{ route('layanan') }}" class="text-blue-200 hover:text-white transition-colors flex items-center gap-2"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>Layanan</a></li>
                        <li><a href="{{ route('umkm') }}" class="text-blue-200 hover:text-white transition-colors flex items-center gap-2"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>UMKM</a></li>
                        <li><a href="{{ route('kontak') }}" class="text-blue-200 hover:text-white transition-colors flex items-center gap-2"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>Kontak</a></li>
                    </ul>
                </div>

                <!-- Agenda Mendatang -->
                <div>
                    <h3 class="text-lg font-bold mb-4 pb-2 border-b border-blue-700">Agenda Mendatang</h3>
                    @if($agendaMendatang->count() > 0)
                    <ul class="space-y-3 text-sm">
                        @foreach($agendaMendatang as $agenda)
                        <li class="flex items-start gap-3">
                            <div class="bg-white/10 rounded-lg p-2 text-center min-w-[50px]">
                                <span class="text-lg font-bold">{{ $agenda->tanggal_mulai->format('d') }}</span>
                                <span class="text-xs block text-blue-200">{{ $agenda->tanggal_mulai->translatedFormat('M') }}</span>
                            </div>
                            <div>
                                <p class="text-white font-medium">{{ Str::limit($agenda->judul, 30) }}</p>
                                <p class="text-blue-200 text-xs">{{ $agenda->lokasi ?? 'Lokasi TBA' }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-blue-200 text-sm">Belum ada agenda mendatang</p>
                    @endif
                </div>

                <!-- Kontak -->
                <div>
                    <h3 class="text-lg font-bold mb-4 pb-2 border-b border-blue-700">Hubungi Kami</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-300 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-blue-200">{{ $footerAlamat['alamat_lengkap']->content ?? 'Jalan Raya Desa No. 123, Kecamatan, Kabupaten' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $footerKontak['telepon']->content ?? '') }}" class="text-blue-200 hover:text-white transition-colors">{{ $footerKontak['telepon']->content ?? '(021) 1234-5678' }}</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:{{ $footerKontak['email']->content ?? 'info@desa.go.id' }}" class="text-blue-200 hover:text-white transition-colors">{{ $footerKontak['email']->content ?? 'info@desa.go.id' }}</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-blue-200">Senin - Jumat: 08:00 - 15:00</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-blue-700 pt-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm text-blue-200">
                    &copy; {{ date('Y') }} {{ $headerNamaDesa }}. Hak Cipta Dilindungi.
                </p>
                <p class="text-xs text-blue-300">
                    {{ $footerText }}
                </p>
            </div>
        </div>
    </footer>

    <style>
        /* Sticky Navigation dengan Shadow */
        #sticky-nav.scrolled {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Header Animation */
        .header-animate {
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInDown 0.8s ease-out forwards;
        }

        .logo-animate {
            opacity: 0;
            transform: scale(0.8) rotate(-10deg);
            animation: fadeInScale 0.8s ease-out 0.2s forwards;
        }

        .header-text-animate {
            opacity: 0;
            transform: translateX(-20px);
            animation: fadeInLeft 0.8s ease-out 0.3s forwards;
        }

        /* Navigation Animation */
        .nav-animate {
            opacity: 0;
            transform: translateY(-10px);
            animation: fadeInDown 0.6s ease-out 0.5s forwards;
        }

        .menu-item-animate {
            opacity: 0;
            transform: translateY(-10px);
            animation: fadeInUp 0.5s ease-out forwards;
        }

        .menu-item-animate.animated {
            opacity: 1;
            transform: translateY(0);
        }

        /* Header Background Image */
        .header-bg {
            background-image: url('{{ $headerBgImage }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        @media (max-width: 768px) {
            .header-bg {
                background-attachment: scroll;
            }
        }

        /* Mobile Menu Animation */
        .mobile-menu-container {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            -webkit-transition: max-height 0.3s ease-out;
        }

        .mobile-menu-container.show {
            max-height: 1000px;
        }

        .mobile-menu-item {
            opacity: 0;
            transform: translateX(-20px);
            transition: opacity 0.3s ease-out, transform 0.3s ease-out, background-color 0.2s ease-out, color 0.2s ease-out;
            -webkit-transition: opacity 0.3s ease-out, transform 0.3s ease-out, background-color 0.2s ease-out, color 0.2s ease-out;
            min-height: 48px; /* Minimum touch target size for Android */
            display: flex;
            align-items: center;
            -webkit-tap-highlight-color: rgba(30, 58, 138, 0.1);
        }

        .mobile-menu-container.show .mobile-menu-item {
            opacity: 1;
            transform: translateX(0);
            -webkit-transform: translateX(0);
        }
        
        /* Better touch feedback for Android */
        .mobile-menu-item:active {
            background-color: rgba(30, 58, 138, 0.2);
        }
        
        /* Improve mobile menu container */
        .mobile-menu-container {
            background-color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu-container.show .mobile-menu-item:nth-child(1) { transition-delay: 0.05s; -webkit-transition-delay: 0.05s; }
        .mobile-menu-container.show .mobile-menu-item:nth-child(2) { transition-delay: 0.1s; -webkit-transition-delay: 0.1s; }
        .mobile-menu-container.show .mobile-menu-item:nth-child(3) { transition-delay: 0.15s; -webkit-transition-delay: 0.15s; }
        .mobile-menu-container.show .mobile-menu-item:nth-child(4) { transition-delay: 0.2s; -webkit-transition-delay: 0.2s; }
        .mobile-menu-container.show .mobile-menu-item:nth-child(5) { transition-delay: 0.25s; -webkit-transition-delay: 0.25s; }
        .mobile-menu-container.show .mobile-menu-item:nth-child(6) { transition-delay: 0.3s; -webkit-transition-delay: 0.3s; }
        .mobile-menu-container.show .mobile-menu-item:nth-child(7) { transition-delay: 0.35s; -webkit-transition-delay: 0.35s; }
        .mobile-menu-container.show .mobile-menu-item:nth-child(8) { transition-delay: 0.4s; -webkit-transition-delay: 0.4s; }
        .mobile-menu-container.show .mobile-menu-item:nth-child(9) { transition-delay: 0.45s; -webkit-transition-delay: 0.45s; }
        .mobile-menu-container.show .mobile-menu-item:nth-child(10) { transition-delay: 0.5s; -webkit-transition-delay: 0.5s; }
        .mobile-menu-container.show .mobile-menu-item:nth-child(11) { transition-delay: 0.55s; -webkit-transition-delay: 0.55s; }

        /* Keyframes */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8) rotate(-10deg);
            }
            to {
                opacity: 1;
                transform: scale(1) rotate(0deg);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hide Scrollbar */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
    <script>
        // Toggle Mobile Menu dengan Animasi
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');
            
            if (menu.classList.contains('hidden')) {
                // Open menu
                menu.classList.remove('hidden');
                // Force reflow untuk memastikan animasi berjalan
                void menu.offsetHeight;
                setTimeout(function() {
                    menu.classList.add('show');
                }, 10);
                menuIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            } else {
                // Close menu
                menu.classList.remove('show');
                setTimeout(function() {
                    menu.classList.add('hidden');
                }, 300);
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        });

        // Sticky Navigation dengan Shadow saat Scroll
        window.addEventListener('scroll', function() {
            const stickyNav = document.getElementById('sticky-nav');
            const scrollPosition = window.scrollY;
            
            if (scrollPosition > 50) {
                stickyNav.classList.add('scrolled');
            } else {
                stickyNav.classList.remove('scrolled');
            }
        });

        // Menu Items Animation dengan Stagger
        document.addEventListener('DOMContentLoaded', function() {
            const menuItems = document.querySelectorAll('.menu-item-animate');
            menuItems.forEach((item, index) => {
                item.style.animationDelay = `${0.6 + (index * 0.05)}s`;
                setTimeout(() => {
                    item.classList.add('animated');
                }, 600 + (index * 50));
            });
        });
    </script>
</body>
</html>
