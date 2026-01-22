<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        use App\Models\Content;
        
        // Get settings
        $adminNamaDesa = Content::getContent('settings', 'general', 'nama_desa') ?: Content::getContent('beranda', 'header_website', 'nama_desa', 'Pemerintah Desa');
        
        // Find logo
        $adminLogoPath = null;
        foreach (glob(public_path('images/logo-*')) as $file) {
            $adminLogoPath = basename($file);
            break;
        }
        if (!$adminLogoPath) {
            foreach (glob(public_path('images/logo.*')) as $file) {
                $adminLogoPath = basename($file);
                break;
            }
        }
        
        // Find favicon
        $adminFaviconPath = null;
        foreach (glob(public_path('images/favicon-*')) as $file) {
            $adminFaviconPath = 'images/' . basename($file);
            break;
        }
        if (!$adminFaviconPath) {
            foreach (glob(public_path('images/favicon.*')) as $file) {
                $adminFaviconPath = 'images/' . basename($file);
                break;
            }
        }
    @endphp
    <meta name="description" content="Dashboard Admin - Website Resmi {{ $adminNamaDesa }}">
    <title>@yield('title', 'Dashboard Admin') - {{ $adminNamaDesa }}</title>
    
    <!-- Favicon -->
    @if($adminFaviconPath)
    <link rel="icon" type="image/x-icon" href="{{ asset($adminFaviconPath) }}?v={{ time() }}">
    <link rel="shortcut icon" href="{{ asset($adminFaviconPath) }}?v={{ time() }}">
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
    
    <style>
        .sidebar-link.active {
            background-color: #1e3a8a;
            color: white;
        }
        .sidebar-link:hover {
            background-color: rgba(30, 58, 138, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-[#1e3a8a] text-white">
                <!-- Logo -->
                <div class="flex items-center gap-3 px-6 py-6 border-b border-blue-800">
                    <div class="bg-white text-[#1e3a8a] px-3 py-2 rounded-lg flex items-center justify-center overflow-hidden">
                        @if($adminLogoPath)
                        <img src="{{ asset('images/' . $adminLogoPath) }}?v={{ time() }}" alt="{{ $adminNamaDesa }}" class="w-6 h-6 object-contain">
                        @else
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">Admin Panel</h1>
                        <p class="text-xs text-blue-200">{{ $adminNamaDesa }}</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.contents.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.contents.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="text-sm font-medium">Kelola Konten</span>
                    </a>
                    <a href="{{ route('admin.berita.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.berita.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <span class="text-sm font-medium">Berita</span>
                    </a>
                    <a href="{{ route('admin.galeri.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.galeri.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-medium">Galeri</span>
                    </a>
                    <a href="{{ route('admin.umkm.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.umkm.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-medium">UMKM</span>
                    </a>
                    <a href="{{ route('admin.penduduk.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.penduduk.index') || request()->routeIs('admin.penduduk.create') || request()->routeIs('admin.penduduk.edit') || request()->routeIs('admin.penduduk.show') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">Data Penduduk</span>
                    </a>
                    <a href="{{ route('admin.penduduk.infografis') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.penduduk.infografis') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="text-sm font-medium">Infografis Penduduk</span>
                    </a>
                    
                    <div class="pt-4 mt-4 border-t border-blue-800">
                        <p class="px-4 text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2">Layanan</p>
                    </div>
                    
                    <a href="{{ route('admin.pengajuan-layanan.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.pengajuan-layanan.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-sm font-medium">Pengajuan Layanan</span>
                    </a>
                    <a href="{{ route('admin.pengaduan.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.pengaduan.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        <span class="text-sm font-medium">Pengaduan</span>
                    </a>
                    <a href="{{ route('admin.agenda.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.agenda.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-medium">Agenda</span>
                    </a>
                    <a href="{{ route('admin.pengumuman.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.pengumuman.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                        <span class="text-sm font-medium">Pengumuman</span>
                    </a>
                    
                    <div class="pt-4 mt-4 border-t border-blue-800">
                        <p class="px-4 text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2">Pengaturan</p>
                    </div>
                    
                    <a href="{{ route('admin.settings.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.settings.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">Pengaturan</span>
                    </a>
                    
                    <a href="{{ route('beranda') }}" target="_blank" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors text-blue-200 hover:bg-blue-800 mt-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        <span class="text-sm font-medium">Lihat Website</span>
                    </a>
                </nav>

                <!-- User Info & Logout -->
                <div class="px-4 py-4 border-t border-blue-800">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="bg-white/20 p-2 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-blue-200 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 rounded-lg text-blue-200 hover:bg-blue-800 transition-colors text-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar Toggle -->
        <div class="md:hidden fixed top-0 left-0 right-0 bg-[#1e3a8a] text-white p-4 z-50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                @if($adminLogoPath)
                <div class="bg-white p-1.5 rounded-lg">
                    <img src="{{ asset('images/' . $adminLogoPath) }}?v={{ time() }}" alt="{{ $adminNamaDesa }}" class="w-5 h-5 object-contain">
                </div>
                @endif
                <h1 class="text-lg font-bold">Admin Panel</h1>
            </div>
            <button id="mobile-menu-toggle" class="p-2 hover:bg-blue-800 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Sidebar -->
        <div id="mobile-sidebar" class="md:hidden fixed inset-0 z-40 transform -translate-x-full transition-transform duration-300 ease-in-out">
            <div class="flex h-full">
                <div class="flex flex-col w-72 max-w-[85vw] bg-[#1e3a8a] text-white h-full shadow-2xl">
                    <!-- Mobile Sidebar Header -->
                    <div class="flex items-center justify-between px-4 py-4 border-b border-blue-800">
                        <div class="flex items-center gap-3">
                            <div class="bg-white text-[#1e3a8a] p-2 rounded-lg flex items-center justify-center">
                                @if($adminLogoPath)
                                <img src="{{ asset('images/' . $adminLogoPath) }}?v={{ time() }}" alt="{{ $adminNamaDesa }}" class="w-6 h-6 object-contain">
                                @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                @endif
                            </div>
                            <div>
                                <h1 class="text-base font-bold">Admin Panel</h1>
                                <p class="text-xs text-blue-200">{{ Str::limit($adminNamaDesa, 20) }}</p>
                            </div>
                        </div>
                        <button id="mobile-sidebar-close" class="p-2 hover:bg-blue-800 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Mobile Navigation - Scrollable -->
                    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                        <!-- Menu Utama -->
                        <p class="px-3 text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2">Menu Utama</p>
                        
                        <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="text-sm font-medium">Dashboard</span>
                        </a>
                        
                        <a href="{{ route('admin.contents.index') }}" class="mobile-nav-link sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.contents.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span class="text-sm font-medium">Kelola Konten</span>
                        </a>
                        
                        <a href="{{ route('admin.berita.index') }}" class="mobile-nav-link sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.berita.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                            <span class="text-sm font-medium">Berita</span>
                        </a>
                        
                        <a href="{{ route('admin.galeri.index') }}" class="mobile-nav-link sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.galeri.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium">Galeri</span>
                        </a>
                        
                        <a href="{{ route('admin.umkm.index') }}" class="mobile-nav-link sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.umkm.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium">UMKM</span>
                        </a>
                        
                        <!-- Data Penduduk Section -->
                        <div class="pt-3 mt-3 border-t border-blue-800">
                            <p class="px-3 text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2">Data Penduduk</p>
                        </div>
                        
                        <a href="{{ route('admin.penduduk.index') }}" class="mobile-nav-link sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.penduduk.index') || request()->routeIs('admin.penduduk.create') || request()->routeIs('admin.penduduk.edit') || request()->routeIs('admin.penduduk.show') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="text-sm font-medium">Data Penduduk</span>
                        </a>
                        
                        <a href="{{ route('admin.penduduk.infografis') }}" class="mobile-nav-link sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.penduduk.infografis') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span class="text-sm font-medium">Infografis Penduduk</span>
                        </a>
                        
                        <!-- Layanan Section -->
                        <div class="pt-3 mt-3 border-t border-blue-800">
                            <p class="px-3 text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2">Layanan</p>
                        </div>
                        
                        <a href="{{ route('admin.pengajuan-layanan.index') }}" class="mobile-nav-link sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.pengajuan-layanan.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm font-medium">Pengajuan Layanan</span>
                        </a>
                        
                        <a href="{{ route('admin.pengaduan.index') }}" class="mobile-nav-link sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.pengaduan.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                            <span class="text-sm font-medium">Pengaduan</span>
                        </a>
                        
                        <a href="{{ route('admin.agenda.index') }}" class="mobile-nav-link sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.agenda.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium">Agenda</span>
                        </a>
                        
                        <a href="{{ route('admin.pengumuman.index') }}" class="mobile-nav-link sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.pengumuman.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                            </svg>
                            <span class="text-sm font-medium">Pengumuman</span>
                        </a>
                        
                        <!-- Pengaturan Section -->
                        <div class="pt-3 mt-3 border-t border-blue-800">
                            <p class="px-3 text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2">Pengaturan</p>
                        </div>
                        
                        <a href="{{ route('admin.settings.index') }}" class="mobile-nav-link sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.settings.*') ? 'active' : 'text-blue-200 hover:bg-blue-800' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-sm font-medium">Pengaturan</span>
                        </a>
                        
                        <!-- Lihat Website -->
                        <a href="{{ route('beranda') }}" target="_blank" class="mobile-nav-link sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors text-blue-200 hover:bg-blue-800 mt-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            <span class="text-sm font-medium">Lihat Website</span>
                        </a>
                    </nav>
                    
                    <!-- Mobile User Info & Logout -->
                    <div class="px-3 py-3 border-t border-blue-800 bg-blue-900/30">
                        <div class="flex items-center gap-3 mb-3 p-2 bg-blue-800/50 rounded-lg">
                            <div class="bg-white/20 p-2 rounded-full">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-blue-200 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-red-500/20 text-red-200 hover:bg-red-500/30 transition-colors text-sm font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Overlay -->
                <div class="flex-1 bg-black/50 backdrop-blur-sm" id="mobile-sidebar-overlay"></div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden md:ml-0">
            <!-- Top Bar -->
            @php
                $pengaduanBaru = \App\Models\Pengaduan::where('status', 'masuk')->latest()->take(5)->get();
                $totalPengaduanBaru = \App\Models\Pengaduan::where('status', 'masuk')->count();
            @endphp
            <header class="bg-white shadow-sm border-b border-gray-200 md:pt-0 pt-16">
                <div class="px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">@yield('title', 'Dashboard')</h2>
                        </div>
                        <div class="flex items-center gap-4">
                            <!-- Notification Bell -->
                            <div class="relative" x-data="{ open: false }">
                                <button onclick="toggleNotification()" class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-full transition-colors" id="notification-btn">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    @if($totalPengaduanBaru > 0)
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">{{ $totalPengaduanBaru > 9 ? '9+' : $totalPengaduanBaru }}</span>
                                    @endif
                                </button>
                                <!-- Notification Dropdown -->
                                <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 z-50">
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <div class="flex items-center justify-between">
                                            <h3 class="font-semibold text-gray-900">Notifikasi</h3>
                                            @if($totalPengaduanBaru > 0)
                                            <span class="px-2 py-0.5 text-xs font-medium bg-red-100 text-red-600 rounded-full">{{ $totalPengaduanBaru }} Baru</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="max-h-80 overflow-y-auto">
                                        @forelse($pengaduanBaru as $notif)
                                        <a href="{{ route('admin.pengaduan.show', $notif->id) }}" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-50 last:border-0">
                                            <div class="flex items-start gap-3">
                                                <div class="bg-yellow-100 p-2 rounded-full flex-shrink-0">
                                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $notif->judul }}</p>
                                                    <p class="text-xs text-gray-500">{{ $notif->nama }} - {{ $notif->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                        @empty
                                        <div class="px-4 py-6 text-center">
                                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <p class="text-sm text-gray-500">Tidak ada notifikasi baru</p>
                                        </div>
                                        @endforelse
                                    </div>
                                    @if($totalPengaduanBaru > 0)
                                    <div class="px-4 py-3 border-t border-gray-100">
                                        <a href="{{ route('admin.pengaduan.index') }}" class="block text-center text-sm font-medium text-[#1e3a8a] hover:underline">Lihat Semua Pengaduan</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="hidden sm:flex items-center gap-3">
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                </div>
                                <div class="bg-[#1e3a8a]/10 p-2 rounded-full">
                                    <svg class="w-6 h-6 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Mobile sidebar functions
        function openMobileSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            sidebar.classList.remove('-translate-x-full');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            sidebar.classList.add('-translate-x-full');
            document.body.style.overflow = '';
        }

        // Mobile sidebar toggle
        document.getElementById('mobile-menu-toggle')?.addEventListener('click', openMobileSidebar);
        document.getElementById('mobile-sidebar-close')?.addEventListener('click', closeMobileSidebar);
        document.getElementById('mobile-sidebar-overlay')?.addEventListener('click', closeMobileSidebar);

        // Close sidebar when clicking on a link (for better UX)
        document.querySelectorAll('#mobile-sidebar .mobile-nav-link').forEach(function(link) {
            link.addEventListener('click', function() {
                // Small delay to allow navigation
                setTimeout(closeMobileSidebar, 100);
            });
        });

        // Close sidebar on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeMobileSidebar();
            }
        });

        // Notification toggle
        function toggleNotification() {
            const dropdown = document.getElementById('notification-dropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close notification dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('notification-dropdown');
            const btn = document.getElementById('notification-btn');
            if (dropdown && btn && !dropdown.contains(event.target) && !btn.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
