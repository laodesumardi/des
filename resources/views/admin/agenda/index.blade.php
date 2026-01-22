@extends('admin.layouts.app')

@section('title', 'Kelola Agenda')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Agenda & Kegiatan</h1>
            <p class="text-gray-600 mt-1">Kelola jadwal kegiatan desa</p>
        </div>
        <a href="{{ route('admin.agenda.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#1e3a8a] text-white rounded-lg hover:bg-blue-800">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Agenda
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari agenda..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="w-full md:w-40">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="all">Semua Status</option>
                    <option value="akan_datang" {{ request('status') === 'akan_datang' ? 'selected' : '' }}>Akan Datang</option>
                    <option value="berlangsung" {{ request('status') === 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-[#1e3a8a] text-white rounded-lg hover:bg-blue-800">Filter</button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Judul</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Waktu</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Lokasi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($agenda as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <p class="font-medium text-gray-900">{{ Str::limit($item->judul, 40) }}</p>
                            <span class="text-xs text-gray-500">{{ $kategoriList[$item->kategori] ?? $item->kategori }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $item->tanggal_format }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $item->waktu_format ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $item->lokasi ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                @if($item->status === 'akan_datang') bg-blue-100 text-blue-700
                                @elseif($item->status === 'berlangsung') bg-green-100 text-green-700
                                @elseif($item->status === 'selesai') bg-gray-100 text-gray-700
                                @else bg-red-100 text-red-700
                                @endif">{{ $item->status_label }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.agenda.edit', $item->id) }}" class="p-1.5 text-yellow-600 hover:bg-yellow-50 rounded">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.agenda.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="openDeleteModal('delete-form-{{ $item->id }}', 'Apakah Anda yakin ingin menghapus agenda &quot;{{ addslashes($item->judul) }}&quot;? Tindakan ini tidak dapat dibatalkan.')" class="p-1.5 text-red-600 hover:bg-red-50 rounded">
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
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada agenda</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $agenda->links() }}
        </div>
    </div>
</div>
@endsection
