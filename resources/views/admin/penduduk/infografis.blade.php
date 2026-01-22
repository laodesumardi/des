@extends('admin.layouts.app')

@section('title', 'Infografis Penduduk')

@section('content')
<div class="p-4 sm:p-6 md:p-8">
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Infografis Penduduk</h1>
        <p class="text-gray-600 text-sm sm:text-base">Statistik dan demografi penduduk desa</p>
    </div>

    <!-- Ringkasan Jumlah Penduduk -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Total Penduduk</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($statistik['total_penduduk']) }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Kepala Keluarga</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($statistik['total_kk']) }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Laki-laki</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($statistik['total_laki_laki']) }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-pink-500 to-pink-700 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Perempuan</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($statistik['total_perempuan']) }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Statistik Kelompok Umur -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Berdasarkan Kelompok Umur</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2 px-3 font-medium text-gray-600">Kelompok</th>
                            <th class="text-center py-2 px-3 font-medium text-gray-600">L</th>
                            <th class="text-center py-2 px-3 font-medium text-gray-600">P</th>
                            <th class="text-center py-2 px-3 font-medium text-gray-600">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($statistik['kelompok_umur'] as $umur)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 px-3 font-medium text-gray-800">{{ $umur['kelompok'] }}</td>
                                <td class="py-2 px-3 text-center text-blue-700 font-semibold">{{ $umur['laki_laki'] }}</td>
                                <td class="py-2 px-3 text-center text-pink-700 font-semibold">{{ $umur['perempuan'] }}</td>
                                <td class="py-2 px-3 text-center font-bold text-gray-900">{{ $umur['total'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Statistik Dusun -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Berdasarkan Dusun</h2>
            @if($statistik['dusun']->count() > 0)
                <div class="space-y-3">
                    @php $maxDusun = $statistik['dusun']->max('total') ?: 1; @endphp
                    @foreach($statistik['dusun'] as $dusun)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-800">{{ $dusun->dusun ?: 'Tidak Diketahui' }}</span>
                                <span class="text-blue-700 font-semibold">{{ number_format($dusun->total) }} jiwa</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full" style="width: {{ ($dusun->total / $maxDusun) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-8">Belum ada data dusun</p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Statistik Pendidikan -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Berdasarkan Pendidikan</h2>
            @if($statistik['pendidikan']->count() > 0)
                <div class="space-y-3">
                    @php $maxPendidikan = $statistik['pendidikan']->max('total') ?: 1; @endphp
                    @foreach($statistik['pendidikan'] as $pendidikan)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-800">{{ $pendidikan->pendidikan }}</span>
                                <span class="text-green-700 font-semibold">{{ number_format($pendidikan->total) }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full" style="width: {{ ($pendidikan->total / $maxPendidikan) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-8">Belum ada data pendidikan</p>
            @endif
        </div>

        <!-- Statistik Pekerjaan -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Berdasarkan Pekerjaan</h2>
            @if($statistik['pekerjaan']->count() > 0)
                <div class="overflow-x-auto max-h-64">
                    <table class="w-full text-sm">
                        <thead class="sticky top-0 bg-white">
                            <tr class="border-b">
                                <th class="text-left py-2 px-3 font-medium text-gray-600">Jenis Pekerjaan</th>
                                <th class="text-right py-2 px-3 font-medium text-gray-600">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statistik['pekerjaan'] as $pekerjaan)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-2 px-3 text-gray-800">{{ $pekerjaan->pekerjaan }}</td>
                                    <td class="py-2 px-3 text-right font-bold text-[#1e3a8a]">{{ number_format($pekerjaan->total) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-gray-500 py-8">Belum ada data pekerjaan</p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Statistik Perkawinan -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Berdasarkan Perkawinan</h2>
            @if($statistik['perkawinan']->count() > 0)
                <div class="space-y-3">
                    @php 
                        $colors = ['bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-red-500'];
                        $maxPerkawinan = $statistik['perkawinan']->max('total') ?: 1;
                    @endphp
                    @php
                        $textColors = ['text-blue-700', 'text-green-700', 'text-yellow-700', 'text-red-700'];
                    @endphp
                    @foreach($statistik['perkawinan'] as $i => $perkawinan)
                        <div class="flex items-center gap-3 p-2 bg-gray-50 rounded-lg">
                            <div class="w-4 h-4 rounded {{ $colors[$i % count($colors)] }}"></div>
                            <div class="flex-1">
                                <div class="flex justify-between text-sm">
                                    <span class="font-medium text-gray-800">{{ $perkawinan->status_perkawinan }}</span>
                                    <span class="font-bold {{ $textColors[$i % count($textColors)] }}">{{ number_format($perkawinan->total) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-8">Belum ada data</p>
            @endif
        </div>

        <!-- Statistik Agama -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Berdasarkan Agama</h2>
            @if($statistik['agama']->count() > 0)
                <div class="space-y-3">
                    @php 
                        $colorAgama = ['bg-green-500', 'bg-blue-500', 'bg-purple-500', 'bg-orange-500', 'bg-red-500', 'bg-yellow-500', 'bg-gray-500'];
                        $maxAgama = $statistik['agama']->max('total') ?: 1;
                    @endphp
                    @php
                        $textColorAgama = ['text-green-700', 'text-blue-700', 'text-purple-700', 'text-orange-700', 'text-red-700', 'text-yellow-700', 'text-gray-700'];
                    @endphp
                    @foreach($statistik['agama'] as $i => $agama)
                        <div class="flex items-center gap-3 p-2 bg-gray-50 rounded-lg">
                            <div class="w-4 h-4 rounded {{ $colorAgama[$i % count($colorAgama)] }}"></div>
                            <div class="flex-1">
                                <div class="flex justify-between text-sm">
                                    <span class="font-medium text-gray-800">{{ $agama->agama }}</span>
                                    <span class="font-bold {{ $textColorAgama[$i % count($textColorAgama)] }}">{{ number_format($agama->total) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-8">Belum ada data</p>
            @endif
        </div>

        <!-- Statistik Wajib Pilih -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Wajib Pilih (17+)</h2>
            <div class="flex flex-col items-center justify-center h-40">
                <p class="text-4xl font-bold text-[#1e3a8a]">{{ number_format($statistik['wajib_pilih']['total']) }}</p>
                <p class="text-gray-600 mt-2">Pemilih</p>
                <div class="flex gap-6 mt-4 text-sm">
                    <div class="text-center">
                        <p class="font-semibold text-blue-600">{{ number_format($statistik['wajib_pilih']['laki_laki']) }}</p>
                        <p class="text-gray-500">Laki-laki</p>
                    </div>
                    <div class="text-center">
                        <p class="font-semibold text-pink-600">{{ number_format($statistik['wajib_pilih']['perempuan']) }}</p>
                        <p class="text-gray-500">Perempuan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Catatan -->
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <p class="font-semibold text-yellow-800">Catatan</p>
                <p class="text-sm text-yellow-700 mt-1">Data infografis ini diambil dari data penduduk yang telah diinput. Untuk memperbarui statistik, silakan tambahkan atau perbarui data penduduk melalui menu <a href="{{ route('admin.penduduk.index') }}" class="underline font-medium">Data Penduduk</a>.</p>
            </div>
        </div>
    </div>
</div>
@endsection
