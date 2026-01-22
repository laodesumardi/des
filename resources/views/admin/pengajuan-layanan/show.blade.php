@extends('admin.layouts.app')

@section('title', 'Detail Pengajuan Layanan')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-8">
        <a href="{{ route('admin.pengajuan-layanan.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="text-sm font-medium">Kembali</span>
        </a>
        <div class="flex-1">
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Detail Pengajuan</h1>
                <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">#{{ $pengajuanLayanan->id }}</span>
            </div>
            <p class="text-gray-500 mt-1">Diajukan pada {{ $pengajuanLayanan->created_at->translatedFormat('l, d F Y - H:i') }} WIB</p>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3">
        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Status Banner -->
            @php
                $statusConfig = [
                    'masuk' => ['bg' => 'bg-gradient-to-r from-amber-500 to-orange-500', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => 'Menunggu Verifikasi'],
                    'diproses' => ['bg' => 'bg-gradient-to-r from-blue-500 to-indigo-500', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'text' => 'Sedang Diproses'],
                    'selesai' => ['bg' => 'bg-gradient-to-r from-emerald-500 to-green-500', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => 'Pengajuan Selesai'],
                    'ditolak' => ['bg' => 'bg-gradient-to-r from-red-500 to-rose-500', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => 'Pengajuan Ditolak'],
                ];
                $config = $statusConfig[$pengajuanLayanan->status] ?? ['bg' => 'bg-gray-500', 'icon' => '', 'text' => ''];
            @endphp
            <div class="{{ $config['bg'] }} rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white/80 text-sm">Status Pengajuan</p>
                        <p class="text-2xl font-bold">{{ $config['text'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Info Pemohon -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="bg-[#1e3a8a]/10 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Informasi Pemohon</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#1e3a8a] to-blue-600 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                            {{ strtoupper(substr($pengajuanLayanan->nama, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">{{ $pengajuanLayanan->nama }}</h4>
                            <p class="text-gray-500">Pemohon Layanan</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">NIK</p>
                            <code class="text-base font-mono text-gray-900 bg-gray-100 px-3 py-2 rounded-lg inline-block">{{ $pengajuanLayanan->nik }}</code>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Nomor Telepon</p>
                            <p class="text-base text-gray-900 flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ $pengajuanLayanan->telepon }}
                            </p>
                        </div>
                        <div class="sm:col-span-2 space-y-1">
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Alamat Lengkap</p>
                            <p class="text-base text-gray-900 flex items-start gap-2">
                                <svg class="w-4 h-4 text-gray-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $pengajuanLayanan->alamat }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Layanan -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Detail Layanan</h3>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Jenis Layanan yang Diajukan</p>
                        <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold bg-blue-50 text-blue-700 rounded-xl border border-blue-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            {{ $pengajuanLayanan->jenis_layanan_label }}
                        </span>
                    </div>
                    
                    @if($pengajuanLayanan->keterangan)
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Keterangan Tambahan</p>
                        <div class="bg-gray-50 rounded-xl p-4 text-gray-700 whitespace-pre-line">{{ $pengajuanLayanan->keterangan }}</div>
                    </div>
                    @endif
                    
                    @if($pengajuanLayanan->berkas)
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Berkas Lampiran</p>
                        <a href="{{ asset('uploads/layanan/' . $pengajuanLayanan->berkas) }}" target="_blank" 
                            class="inline-flex items-center gap-3 px-5 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-medium text-gray-700 transition-colors group">
                            <div class="bg-white p-2 rounded-lg shadow-sm group-hover:shadow transition-shadow">
                                <svg class="w-6 h-6 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium">Lihat Berkas</p>
                                <p class="text-xs text-gray-500">Klik untuk membuka</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Catatan Admin -->
            @if($pengajuanLayanan->catatan_admin)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="bg-purple-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Catatan Admin</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="bg-purple-50 rounded-xl p-4 text-gray-700 whitespace-pre-line border border-purple-100">{{ $pengajuanLayanan->catatan_admin }}</div>
                    @if($pengajuanLayanan->user)
                    <p class="text-sm text-gray-500 mt-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Diproses oleh <span class="font-medium">{{ $pengajuanLayanan->user->name }}</span>
                        @if($pengajuanLayanan->diproses_at)
                        pada {{ $pengajuanLayanan->diproses_at->translatedFormat('d F Y, H:i') }}
                        @endif
                    </p>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Update Status Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-semibold text-gray-900">Update Status</h3>
                </div>
                <form action="{{ route('admin.pengajuan-layanan.update-status', $pengajuanLayanan->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                            <div class="space-y-2">
                                @foreach(['masuk' => ['Masuk', 'amber'], 'diproses' => ['Diproses', 'blue'], 'selesai' => ['Selesai', 'emerald'], 'ditolak' => ['Ditolak', 'red']] as $value => $data)
                                <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-gray-50 transition-colors {{ $pengajuanLayanan->status === $value ? 'border-[#1e3a8a] bg-[#1e3a8a]/5' : 'border-gray-200' }}">
                                    <input type="radio" name="status" value="{{ $value }}" {{ $pengajuanLayanan->status === $value ? 'checked' : '' }} class="w-4 h-4 text-[#1e3a8a] focus:ring-[#1e3a8a]">
                                    <span class="w-2 h-2 rounded-full bg-{{ $data[1] }}-500"></span>
                                    <span class="text-sm font-medium text-gray-700">{{ $data[0] }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin</label>
                            <textarea name="catatan_admin" rows="4" 
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] transition-all resize-none"
                                placeholder="Tambahkan catatan untuk pemohon...">{{ $pengajuanLayanan->catatan_admin }}</textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-3 bg-[#1e3a8a] text-white rounded-xl text-sm font-semibold hover:bg-blue-900 transition-colors flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-semibold text-gray-900">Riwayat</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Pengajuan Dibuat</p>
                                <p class="text-xs text-gray-500">{{ $pengajuanLayanan->created_at->translatedFormat('d F Y, H:i') }}</p>
                            </div>
                        </div>
                        @if($pengajuanLayanan->diproses_at)
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Terakhir Diupdate</p>
                                <p class="text-xs text-gray-500">{{ $pengajuanLayanan->diproses_at->translatedFormat('d F Y, H:i') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-red-100 bg-red-50/50">
                    <h3 class="font-semibold text-red-700">Zona Bahaya</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-4">Menghapus pengajuan ini akan menghapus semua data terkait secara permanen.</p>
                    <form action="{{ route('admin.pengajuan-layanan.destroy', $pengajuanLayanan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengajuan ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-3 bg-red-600 text-white rounded-xl text-sm font-semibold hover:bg-red-700 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus Pengajuan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
