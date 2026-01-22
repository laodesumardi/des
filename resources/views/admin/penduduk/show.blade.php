@extends('admin.layouts.app')

@section('title', 'Detail Penduduk - ' . $penduduk->nama)

@section('content')
<div class="p-4 sm:p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('admin.penduduk.index') }}" class="hover:text-[#1e3a8a]">Data Penduduk</a>
            <span>/</span>
            <span class="text-gray-700">Detail</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-bold text-gray-900">Detail Data Penduduk</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.penduduk.edit', $penduduk->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.penduduk.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors text-sm font-medium">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white border rounded-lg p-6 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $penduduk->nama }}</h2>
                <p class="text-gray-500 text-sm mb-4">NIK: {{ $penduduk->nik }}</p>
                
                <div class="flex justify-center gap-2 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $penduduk->jenis_kelamin == 'Laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                        {{ $penduduk->jenis_kelamin }}
                    </span>
                    @if($penduduk->is_kepala_keluarga)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Kepala Keluarga
                        </span>
                    @endif
                </div>

                <div class="border-t pt-4 space-y-3 text-left">
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Umur</span>
                        <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($penduduk->tanggal_lahir)->age }} Tahun</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Agama</span>
                        <span class="font-medium text-gray-900">{{ $penduduk->agama ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Status</span>
                        <span class="font-medium text-gray-900">{{ $penduduk->status_perkawinan ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Data Identitas -->
            <div class="bg-white border rounded-lg">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="font-semibold text-gray-900">Data Identitas</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">NIK</label>
                            <p class="font-mono text-gray-900 mt-1">{{ $penduduk->nik }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">No. Kartu Keluarga</label>
                            <p class="font-mono text-gray-900 mt-1">{{ $penduduk->no_kk ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">Nama Lengkap</label>
                            <p class="text-gray-900 mt-1 font-medium">{{ $penduduk->nama }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">Jenis Kelamin</label>
                            <p class="text-gray-900 mt-1">{{ $penduduk->jenis_kelamin }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">Tempat Lahir</label>
                            <p class="text-gray-900 mt-1">{{ $penduduk->tempat_lahir }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">Tanggal Lahir</label>
                            <p class="text-gray-900 mt-1">{{ \Carbon\Carbon::parse($penduduk->tanggal_lahir)->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Kependudukan -->
            <div class="bg-white border rounded-lg">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="font-semibold text-gray-900">Data Kependudukan</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">Agama</label>
                            <p class="text-gray-900 mt-1">{{ $penduduk->agama ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">Pendidikan Terakhir</label>
                            <p class="text-gray-900 mt-1">{{ $penduduk->pendidikan ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">Pekerjaan</label>
                            <p class="text-gray-900 mt-1">{{ $penduduk->pekerjaan ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">Status Perkawinan</label>
                            <p class="text-gray-900 mt-1">{{ $penduduk->status_perkawinan ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">Status dalam Keluarga</label>
                            <p class="text-gray-900 mt-1">{{ $penduduk->status_dalam_keluarga ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">Kewarganegaraan</label>
                            <p class="text-gray-900 mt-1">{{ $penduduk->kewarganegaraan ?? 'WNI' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Alamat -->
            <div class="bg-white border rounded-lg">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="font-semibold text-gray-900">Data Alamat</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">RT</label>
                            <p class="text-gray-900 mt-1">{{ $penduduk->rt }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">RW</label>
                            <p class="text-gray-900 mt-1">{{ $penduduk->rw }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wide">Dusun/Lingkungan</label>
                            <p class="text-gray-900 mt-1">{{ $penduduk->dusun ?? '-' }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Alamat Lengkap</label>
                        <p class="text-gray-900 mt-1">{{ $penduduk->alamat }}</p>
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            <div class="bg-gray-50 border rounded-lg p-4">
                <div class="flex flex-wrap gap-6 text-sm text-gray-500">
                    <div>
                        <span>Dibuat:</span>
                        <span class="text-gray-700 ml-1">{{ $penduduk->created_at->translatedFormat('d M Y H:i') }}</span>
                    </div>
                    <div>
                        <span>Diperbarui:</span>
                        <span class="text-gray-700 ml-1">{{ $penduduk->updated_at->translatedFormat('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
