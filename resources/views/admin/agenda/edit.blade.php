@extends('admin.layouts.app')

@section('title', 'Edit Agenda')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.agenda.index') }}" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Agenda</h1>
                <p class="text-gray-600">{{ Str::limit($agenda->judul, 50) }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.agenda.update', $agenda->id) }}" method="POST" id="form-update-agenda">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Agenda <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" value="{{ old('judul', $agenda->judul) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="deskripsi" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('deskripsi', $agenda->deskripsi ?? '') }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $agenda->tanggal_mulai?->format('Y-m-d')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $agenda->tanggal_selesai?->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                                <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', $agenda->waktu_mulai) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                                <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai', $agenda->waktu_selesai) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                            <input type="text" name="lokasi" value="{{ old('lokasi', $agenda->lokasi ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
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
                                <option value="{{ $key }}" {{ old('kategori', $agenda->kategori) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="akan_datang" {{ old('status', $agenda->status) === 'akan_datang' ? 'selected' : '' }}>Akan Datang</option>
                                <option value="berlangsung" {{ old('status', $agenda->status) === 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                                <option value="selesai" {{ old('status', $agenda->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ old('status', $agenda->status) === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <button type="submit" class="w-full px-4 py-3 bg-[#1e3a8a] text-white rounded-lg hover:bg-blue-800 font-medium">Simpan Perubahan</button>
                    <a href="{{ route('admin.agenda.index') }}" class="w-full mt-3 block text-center px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Batal</a>
                </div>
            </div>
        </div>
    </form>

    <!-- Delete Form - Dipindahkan keluar dari form update -->
    <div class="mt-6">
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <h3 class="text-sm font-semibold text-red-800 mb-2">Zona Bahaya</h3>
            <p class="text-xs text-red-600 mb-4">Menghapus agenda tidak dapat dibatalkan.</p>
            <form action="{{ route('admin.agenda.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini? Tindakan ini tidak dapat dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">Hapus Agenda</button>
            </form>
        </div>
    </div>
</div>
@endsection
