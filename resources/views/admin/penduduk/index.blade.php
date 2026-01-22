@extends('admin.layouts.app')

@section('title', 'Data Penduduk')

@section('content')
<div class="p-4 sm:p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Data Penduduk</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola data kependudukan desa</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.penduduk.infografis') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Infografis
                </a>
                <a href="{{ route('admin.penduduk.create') }}" class="bg-[#1e3a8a] text-white px-4 py-2 rounded-lg hover:bg-blue-900 transition-colors text-sm font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Penduduk
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white border rounded-lg p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalPenduduk) }}</p>
                    <p class="text-xs text-gray-500">Total Penduduk</p>
                </div>
            </div>
        </div>
        <div class="bg-white border rounded-lg p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalLakiLaki) }}</p>
                    <p class="text-xs text-gray-500">Laki-laki</p>
                </div>
            </div>
        </div>
        <div class="bg-white border rounded-lg p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalPerempuan) }}</p>
                    <p class="text-xs text-gray-500">Perempuan</p>
                </div>
            </div>
        </div>
        <div class="bg-white border rounded-lg p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalKK) }}</p>
                    <p class="text-xs text-gray-500">Kepala Keluarga</p>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="bg-white border rounded-lg p-4 mb-4">
        <form action="{{ route('admin.penduduk.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Cari</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, No. KK, atau alamat..." 
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a]">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a]">
                        <option value="">Semua</option>
                        <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Dusun -->
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Dusun</label>
                    <select name="dusun" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a]">
                        <option value="">Semua Dusun</option>
                        @foreach($dusunList as $dusun)
                            <option value="{{ $dusun }}" {{ request('dusun') == $dusun ? 'selected' : '' }}>{{ $dusun }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Row 2 Filters -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-4">
                <!-- Agama -->
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Agama</label>
                    <select name="agama" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a]">
                        <option value="">Semua</option>
                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                            <option value="{{ $agama }}" {{ request('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pekerjaan -->
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Pekerjaan</label>
                    <select name="pekerjaan" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a]">
                        <option value="">Semua</option>
                        @foreach($pekerjaanList as $pekerjaan)
                            <option value="{{ $pekerjaan }}" {{ request('pekerjaan') == $pekerjaan ? 'selected' : '' }}>{{ $pekerjaan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pendidikan -->
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Pendidikan</label>
                    <select name="pendidikan" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a]">
                        <option value="">Semua</option>
                        @foreach(['Tidak/Belum Sekolah', 'Tidak Tamat SD', 'SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D1/D2', 'D3', 'S1/D4', 'S2', 'S3'] as $pendidikan)
                            <option value="{{ $pendidikan }}" {{ request('pendidikan') == $pendidikan ? 'selected' : '' }}>{{ $pendidikan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Perkawinan -->
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Status Perkawinan</label>
                    <select name="status_perkawinan" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a]">
                        <option value="">Semua</option>
                        @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                            <option value="{{ $status }}" {{ request('status_perkawinan') == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-[#1e3a8a] text-white px-4 py-2 rounded-lg hover:bg-blue-900 transition-colors text-sm font-medium">
                        Filter
                    </button>
                    <a href="{{ route('admin.penduduk.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm text-gray-600">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white border rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">NIK</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">L/P</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Umur</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Dusun</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Pekerjaan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penduduk as $index => $p)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-600">{{ $penduduk->firstItem() + $index }}</td>
                            <td class="px-4 py-3">
                                <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $p->nik }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900">{{ $p->nama }}</div>
                                <div class="text-xs text-gray-500">{{ $p->tempat_lahir }}, {{ \Carbon\Carbon::parse($p->tanggal_lahir)->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $p->jenis_kelamin == 'Laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ $p->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ \Carbon\Carbon::parse($p->tanggal_lahir)->age }} th
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $p->dusun ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $p->pekerjaan ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if($p->is_kepala_keluarga)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">KK</span>
                                @else
                                    <span class="text-gray-400 text-xs">{{ $p->status_dalam_keluarga ?? '-' }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.penduduk.show', $p->id) }}" class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.penduduk.edit', $p->id) }}" class="p-1.5 text-gray-500 hover:text-yellow-600 hover:bg-yellow-50 rounded" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.penduduk.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus data {{ $p->nama }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <p class="text-gray-500">Tidak ada data penduduk</p>
                                @if(request()->hasAny(['search', 'jenis_kelamin', 'dusun', 'agama', 'pekerjaan', 'pendidikan', 'status_perkawinan']))
                                    <p class="text-sm text-gray-400 mt-1">Coba ubah filter pencarian</p>
                                @else
                                    <a href="{{ route('admin.penduduk.create') }}" class="text-[#1e3a8a] text-sm hover:underline mt-2 inline-block">Tambah data pertama</a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($penduduk->hasPages())
            <div class="px-4 py-4 border-t bg-gray-50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <p class="text-sm text-gray-600">
                        Menampilkan <span class="font-medium">{{ $penduduk->firstItem() }}</span> - <span class="font-medium">{{ $penduduk->lastItem() }}</span> dari <span class="font-medium">{{ number_format($penduduk->total()) }}</span> data
                    </p>
                    
                    <!-- Custom Pagination -->
                    <div class="flex items-center gap-1">
                        <!-- Previous Button -->
                        @if($penduduk->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </span>
                        @else
                            <a href="{{ $penduduk->previousPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </a>
                        @endif

                        <!-- Page Numbers -->
                        @php
                            $currentPage = $penduduk->currentPage();
                            $lastPage = $penduduk->lastPage();
                            
                            // Determine which pages to show
                            $pages = [];
                            
                            if ($lastPage <= 7) {
                                // Show all pages if 7 or less
                                for ($i = 1; $i <= $lastPage; $i++) {
                                    $pages[] = $i;
                                }
                            } else {
                                // Always show first page
                                $pages[] = 1;
                                
                                if ($currentPage <= 3) {
                                    // Near the start
                                    for ($i = 2; $i <= 4; $i++) {
                                        $pages[] = $i;
                                    }
                                    $pages[] = '...';
                                    $pages[] = $lastPage;
                                } elseif ($currentPage >= $lastPage - 2) {
                                    // Near the end
                                    $pages[] = '...';
                                    for ($i = $lastPage - 3; $i <= $lastPage; $i++) {
                                        $pages[] = $i;
                                    }
                                } else {
                                    // In the middle
                                    $pages[] = '...';
                                    for ($i = $currentPage - 1; $i <= $currentPage + 1; $i++) {
                                        $pages[] = $i;
                                    }
                                    $pages[] = '...';
                                    $pages[] = $lastPage;
                                }
                            }
                        @endphp
                        
                        <div class="flex items-center gap-1">
                            @foreach($pages as $page)
                                @if($page == '...')
                                    <span class="px-2 text-sm text-gray-400">...</span>
                                @elseif($page == $currentPage)
                                    <span class="px-3 py-2 text-sm font-medium text-white bg-[#1e3a8a] rounded-lg">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $penduduk->url($page) }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        <!-- Next Button -->
                        @if($penduduk->hasMorePages())
                            <a href="{{ $penduduk->nextPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @else
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
