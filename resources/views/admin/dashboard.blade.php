@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <!-- Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-600 mt-1">Selamat datang kembali, <span class="font-medium text-[#1e3a8a]">{{ Auth::user()->name }}</span></p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <!-- Total Penduduk -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-[#1e3a8a]/10 p-2.5 sm:p-3 rounded-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">Aktif</span>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ number_format($stats['total_penduduk']) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Penduduk</p>
        </div>

        <!-- Total Berita -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-blue-500/10 p-2.5 sm:p-3 rounded-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-full">{{ $stats['total_berita_published'] }} Published</span>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ number_format($stats['total_berita']) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Berita</p>
        </div>

        <!-- Total UMKM -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-green-500/10 p-2.5 sm:p-3 rounded-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">{{ $stats['total_umkm_published'] }} Published</span>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ number_format($stats['total_umkm']) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total UMKM</p>
        </div>

        <!-- Total Galeri -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-yellow-500/10 p-2.5 sm:p-3 rounded-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">{{ $stats['total_galeri_published'] }} Published</span>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ number_format($stats['total_galeri']) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Galeri</p>
        </div>
    </div>

    <!-- Pengajuan Layanan Stats Row -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 mb-6 sm:mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Pengajuan Layanan</h3>
            <a href="{{ route('admin.pengajuan-layanan.index') }}" class="text-sm text-[#1e3a8a] hover:underline">Kelola Pengajuan</a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_pengajuan_layanan'] }}</p>
                <p class="text-sm text-gray-500">Total Pengajuan</p>
            </div>
            <div class="bg-yellow-50 rounded-lg p-4 text-center border border-yellow-200">
                <p class="text-3xl font-bold text-yellow-600">{{ $stats['pengajuan_layanan_masuk'] }}</p>
                <p class="text-sm text-yellow-700">Menunggu</p>
            </div>
            <div class="bg-blue-50 rounded-lg p-4 text-center border border-blue-200">
                <p class="text-3xl font-bold text-blue-600">{{ $stats['pengajuan_layanan_diproses'] }}</p>
                <p class="text-sm text-blue-700">Diproses</p>
            </div>
            <div class="bg-green-50 rounded-lg p-4 text-center border border-green-200">
                <p class="text-3xl font-bold text-green-600">{{ $stats['pengajuan_layanan_selesai'] }}</p>
                <p class="text-sm text-green-700">Selesai</p>
            </div>
        </div>
    </div>

    <!-- Pengaduan Stats Row -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 mb-6 sm:mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Pengaduan & Aspirasi Masyarakat</h3>
            <a href="{{ route('admin.pengaduan.index') }}" class="text-sm text-[#1e3a8a] hover:underline">Kelola Pengaduan</a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_pengaduan'] }}</p>
                <p class="text-sm text-gray-500">Total Pengaduan</p>
            </div>
            <div class="bg-yellow-50 rounded-lg p-4 text-center border border-yellow-200">
                <p class="text-3xl font-bold text-yellow-600">{{ $stats['pengaduan_masuk'] }}</p>
                <p class="text-sm text-yellow-700">Menunggu</p>
            </div>
            <div class="bg-blue-50 rounded-lg p-4 text-center border border-blue-200">
                <p class="text-3xl font-bold text-blue-600">{{ $stats['pengaduan_diproses'] }}</p>
                <p class="text-sm text-blue-700">Diproses</p>
            </div>
            <div class="bg-green-50 rounded-lg p-4 text-center border border-green-200">
                <p class="text-3xl font-bold text-green-600">{{ $stats['pengaduan_selesai'] }}</p>
                <p class="text-sm text-green-700">Selesai</p>
            </div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-gradient-to-br from-[#1e3a8a] to-blue-700 rounded-xl p-4 sm:p-6 text-white">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-2 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ number_format($stats['total_views']) }}</p>
                    <p class="text-xs text-blue-100">Total Views Berita</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl p-4 sm:p-6 text-white">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-2 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ number_format($pendudukStats['laki_laki']) }}</p>
                    <p class="text-xs text-green-100">Laki-laki</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl p-4 sm:p-6 text-white">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-2 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ number_format($pendudukStats['perempuan']) }}</p>
                    <p class="text-xs text-pink-100">Perempuan</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl p-4 sm:p-6 text-white">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-2 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ number_format($stats['total_perangkat']) }}</p>
                    <p class="text-xs text-purple-100">Perangkat Desa</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 sm:mb-8">
        <!-- Grafik Jenis Kelamin -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Komposisi Penduduk</h3>
            <div class="flex items-center justify-center" style="height: 200px;">
                <canvas id="genderChart"></canvas>
            </div>
            <div class="flex justify-center gap-6 mt-4">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                    <span class="text-sm text-gray-600">Laki-laki ({{ $pendudukStats['laki_laki'] }})</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-pink-500"></span>
                    <span class="text-sm text-gray-600">Perempuan ({{ $pendudukStats['perempuan'] }})</span>
                </div>
            </div>
        </div>

        <!-- Grafik Berita per Bulan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Berita per Bulan</h3>
            <canvas id="beritaChart" class="w-full" style="max-height: 280px;"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 sm:mb-8">
        <!-- Grafik Pendidikan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tingkat Pendidikan</h3>
            <canvas id="pendidikanChart" class="w-full" style="max-height: 280px;"></canvas>
        </div>

        <!-- Grafik UMKM per Kategori -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">UMKM per Kategori</h3>
            <canvas id="umkmChart" class="w-full" style="max-height: 280px;"></canvas>
        </div>
    </div>

    <!-- Content Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6 sm:mb-8">
        <!-- Aksi Cepat -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.berita.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-200 group">
                    <div class="bg-blue-500/10 p-2 rounded-lg group-hover:bg-blue-500/20 transition-colors">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Tambah Berita Baru</span>
                </a>
                <a href="{{ route('admin.galeri.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-200 group">
                    <div class="bg-yellow-500/10 p-2 rounded-lg group-hover:bg-yellow-500/20 transition-colors">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Upload Foto Galeri</span>
                </a>
                <a href="{{ route('admin.umkm.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-200 group">
                    <div class="bg-green-500/10 p-2 rounded-lg group-hover:bg-green-500/20 transition-colors">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Tambah UMKM Baru</span>
                </a>
                <a href="{{ route('admin.penduduk.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-200 group">
                    <div class="bg-[#1e3a8a]/10 p-2 rounded-lg group-hover:bg-[#1e3a8a]/20 transition-colors">
                        <svg class="w-5 h-5 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Tambah Data Penduduk</span>
                </a>
                <a href="{{ route('admin.contents.edit', 'beranda') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-200 group">
                    <div class="bg-purple-500/10 p-2 rounded-lg group-hover:bg-purple-500/20 transition-colors">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Edit Halaman Beranda</span>
                </a>
            </div>
        </div>

        <!-- Aktivitas Terkini -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Terkini</h3>
            <div class="space-y-4 max-h-[400px] overflow-y-auto">
                @forelse($aktivitas as $item)
                <div class="flex items-start gap-3 pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                    <div class="
                        @if($item['color'] === 'blue') bg-blue-100 text-blue-600
                        @elseif($item['color'] === 'green') bg-green-100 text-green-600
                        @elseif($item['color'] === 'yellow') bg-yellow-100 text-yellow-600
                        @else bg-gray-100 text-gray-600
                        @endif
                        p-2 rounded-full flex-shrink-0">
                        @if($item['icon'] === 'newspaper')
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        @elseif($item['icon'] === 'photo')
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $item['action'] }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Str::limit($item['title'], 30) }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $item['time']->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada aktivitas</p>
                @endforelse
            </div>
        </div>

        <!-- Berita Populer -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Berita Populer</h3>
                <a href="{{ route('admin.berita.index') }}" class="text-sm text-[#1e3a8a] hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-4 max-h-[400px] overflow-y-auto">
                @forelse($beritaPopuler as $berita)
                <a href="{{ route('admin.berita.edit', $berita->id) }}" class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group">
                    <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100">
                        @if($berita->gambar)
                        <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 group-hover:text-[#1e3a8a] truncate transition-colors">{{ Str::limit($berita->judul, 40) }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs text-gray-500">{{ $berita->created_at->format('d M Y') }}</span>
                            <span class="text-xs text-gray-300">•</span>
                            <span class="text-xs text-blue-600 font-medium">{{ number_format($berita->views) }} views</span>
                        </div>
                    </div>
                </a>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada berita</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- UMKM Terbaru -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">UMKM Terbaru</h3>
                <a href="{{ route('admin.umkm.index') }}" class="text-sm text-[#1e3a8a] hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                @forelse($umkmTerbaru as $umkm)
                <a href="{{ route('admin.umkm.edit', $umkm->id) }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-100 group">
                    <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100">
                        @if($umkm->gambar)
                        <img src="{{ $umkm->gambar_url }}" alt="{{ $umkm->nama_usaha }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 group-hover:text-[#1e3a8a] truncate transition-colors">{{ $umkm->nama_usaha }}</p>
                        <p class="text-xs text-gray-500">{{ $umkm->nama_pemilik }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $umkm->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($umkm->status) }}
                    </span>
                </a>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada UMKM</p>
                @endforelse
            </div>
        </div>

        <!-- Galeri Terbaru -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Galeri Terbaru</h3>
                <a href="{{ route('admin.galeri.index') }}" class="text-sm text-[#1e3a8a] hover:underline">Lihat Semua</a>
            </div>
            <div class="grid grid-cols-3 gap-2">
                @forelse($galeriTerbaru as $foto)
                <a href="{{ route('admin.galeri.edit', $foto->id) }}" class="aspect-square rounded-lg overflow-hidden bg-gray-100 group relative">
                    @if($foto->gambar)
                    <img src="{{ $foto->gambar_url }}" alt="{{ $foto->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                        <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif
                </a>
                @empty
                <div class="col-span-3 text-sm text-gray-500 text-center py-8">Belum ada foto</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Pengajuan Layanan Terbaru -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 mt-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Pengajuan Layanan Terbaru</h3>
            <a href="{{ route('admin.pengajuan-layanan.index') }}" class="text-sm text-[#1e3a8a] hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Pengirim</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Jenis Layanan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">NIK</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengajuanLayananTerbaru as $pengajuan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $pengajuan->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $pengajuan->telepon }}</p>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">{{ $pengajuan->jenis_layanan_label }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-sm text-gray-900">{{ $pengajuan->nik }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-sm text-gray-500">{{ $pengajuan->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $pengajuan->created_at->format('H:i') }}</p>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $statusColors = [
                                    'masuk' => 'bg-yellow-100 text-yellow-700',
                                    'diproses' => 'bg-blue-100 text-blue-700',
                                    'selesai' => 'bg-green-100 text-green-700',
                                    'ditolak' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$pengajuan->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $pengajuan->status_label }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.pengajuan-layanan.show', $pengajuan->id) }}" class="inline-flex items-center gap-1 text-sm text-[#1e3a8a] hover:underline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">
                            Belum ada pengajuan layanan masuk
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pengaduan Terbaru -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 mt-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Pengaduan & Aspirasi Terbaru</h3>
            <a href="{{ route('admin.pengaduan.index') }}" class="text-sm text-[#1e3a8a] hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Pengirim</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Judul</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengaduanTerbaru as $pengaduan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $pengaduan->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $pengaduan->telepon }}</p>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-sm text-gray-900 truncate max-w-[200px]">{{ $pengaduan->judul }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">{{ \App\Models\Pengaduan::getKategori()[$pengaduan->kategori] ?? $pengaduan->kategori }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-sm text-gray-500">{{ $pengaduan->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $pengaduan->created_at->format('H:i') }}</p>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $statusColors = [
                                    'masuk' => 'bg-yellow-100 text-yellow-700',
                                    'diproses' => 'bg-blue-100 text-blue-700',
                                    'selesai' => 'bg-green-100 text-green-700',
                                    'ditolak' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$pengaduan->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $pengaduan->status_label }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.pengaduan.show', $pengaduan->id) }}" class="inline-flex items-center gap-1 text-sm text-[#1e3a8a] hover:underline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">
                            Belum ada pengaduan masuk
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart Colors
    const colors = {
        primary: '#1e3a8a',
        blue: '#3b82f6',
        green: '#22c55e',
        yellow: '#eab308',
        pink: '#ec4899',
        purple: '#8b5cf6',
        orange: '#f97316',
        cyan: '#06b6d4',
    };

    // Gender Chart (Doughnut)
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [{{ $pendudukStats['laki_laki'] }}, {{ $pendudukStats['perempuan'] }}],
                backgroundColor: [colors.blue, colors.pink],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '60%'
        }
    });

    // Berita per Bulan Chart (Bar)
    const beritaCtx = document.getElementById('beritaChart').getContext('2d');
    new Chart(beritaCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($beritaPerBulan, 'bulan')) !!},
            datasets: [{
                label: 'Jumlah Berita',
                data: {!! json_encode(array_column($beritaPerBulan, 'total')) !!},
                backgroundColor: colors.primary,
                borderRadius: 6,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    grid: {
                        display: true,
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Pendidikan Chart (Horizontal Bar)
    const pendidikanCtx = document.getElementById('pendidikanChart').getContext('2d');
    new Chart(pendidikanCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($pendidikanStats)) !!},
            datasets: [{
                label: 'Jumlah',
                data: {!! json_encode(array_values($pendidikanStats)) !!},
                backgroundColor: [
                    colors.primary,
                    colors.blue,
                    colors.green,
                    colors.yellow,
                    colors.purple,
                    colors.orange,
                    colors.cyan
                ],
                borderRadius: 4,
                barThickness: 20
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        drawBorder: false
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // UMKM per Kategori Chart (Doughnut)
    const umkmCtx = document.getElementById('umkmChart').getContext('2d');
    const kategoriLabels = @json($kategoriLabels);
    const umkmData = @json($umkmKategori);
    
    // Transform data
    const umkmLabels = [];
    const umkmValues = [];
    for (const key in umkmData) {
        umkmLabels.push(kategoriLabels[key] || key);
        umkmValues.push(umkmData[key]);
    }

    new Chart(umkmCtx, {
        type: 'doughnut',
        data: {
            labels: umkmLabels.length > 0 ? umkmLabels : ['Belum ada data'],
            datasets: [{
                data: umkmValues.length > 0 ? umkmValues : [1],
                backgroundColor: umkmValues.length > 0 ? [
                    colors.primary,
                    colors.blue,
                    colors.green,
                    colors.yellow,
                    colors.purple,
                    colors.orange,
                    colors.cyan
                ] : ['#e5e7eb'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        padding: 10,
                        font: {
                            size: 11
                        }
                    }
                }
            },
            cutout: '50%'
        }
    });
});
</script>
@endsection
