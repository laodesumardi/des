@extends('admin.layouts.app')

@section('title', 'Edit Pengumuman')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.pengumuman.index') }}" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Pengumuman</h1>
                <p class="text-gray-600">{{ Str::limit($pengumuman->judul, 50) }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" id="form-update-pengumuman">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Pengumuman <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" value="{{ old('judul', $pengumuman->judul) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman <span class="text-red-500">*</span></label>
                            <textarea name="isi" rows="10" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('isi', $pengumuman->isi) }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai Tampil</label>
                                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $pengumuman->tanggal_mulai?->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai Tampil</label>
                                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $pengumuman->tanggal_selesai?->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Opsi</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select name="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                @foreach($kategoriList as $key => $label)
                                <option value="{{ $key }}" {{ old('kategori', $pengumuman->kategori) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="published" {{ old('status', $pengumuman->status) === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ old('status', $pengumuman->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_penting" id="is_penting" value="1" {{ old('is_penting', $pengumuman->is_penting) ? 'checked' : '' }} class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                            <label for="is_penting" class="text-sm font-medium text-gray-700">Tandai sebagai Penting</label>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <button type="submit" class="w-full px-4 py-3 bg-[#1e3a8a] text-white rounded-lg hover:bg-blue-800 font-medium">Simpan Perubahan</button>
                    <a href="{{ route('admin.pengumuman.index') }}" class="w-full mt-3 block text-center px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Batal</a>
                </div>
            </div>
        </div>
    </form>

    <!-- Delete Form - Dipindahkan keluar dari form update -->
    <div class="mt-6">
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <h3 class="text-sm font-semibold text-red-800 mb-2">Zona Bahaya</h3>
            <p class="text-xs text-red-600 mb-4">Menghapus pengumuman tidak dapat dibatalkan.</p>
            <form id="delete-form-{{ $pengumuman->id }}" action="{{ route('admin.pengumuman.destroy', $pengumuman->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" onclick="openDeleteModal('delete-form-{{ $pengumuman->id }}', 'Apakah Anda yakin ingin menghapus pengumuman &quot;{{ addslashes($pengumuman->judul) }}&quot;? Tindakan ini tidak dapat dibatalkan.')" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus Pengumuman
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
