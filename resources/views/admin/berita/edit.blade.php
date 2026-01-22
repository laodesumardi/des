@extends('admin.layouts.app')

@section('title', 'Edit Berita')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('admin.berita.index') }}" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Berita</h1>
                <p class="text-gray-600">Perbarui konten berita "{{ Str::limit($berita->judul, 50) }}"</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" id="form-update-berita">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Judul -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <label for="judul" class="block text-sm font-semibold text-gray-700 mb-2">Judul Berita <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $berita->judul) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg"
                        placeholder="Masukkan judul berita...">
                    @error('judul')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ringkasan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <label for="ringkasan" class="block text-sm font-semibold text-gray-700 mb-2">Ringkasan</label>
                    <textarea name="ringkasan" id="ringkasan" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Tulis ringkasan singkat berita (opsional)...">{{ old('ringkasan', $berita->ringkasan ?? '') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Maksimal 500 karakter. Jika kosong, akan diambil dari awal konten.</p>
                    @error('ringkasan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konten -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <label for="konten" class="block text-sm font-semibold text-gray-700 mb-2">Konten Berita <span class="text-red-500">*</span></label>
                    <textarea name="konten" id="konten" rows="15" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Tulis isi berita secara lengkap...">{{ old('konten', $berita->konten) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Anda dapat menggunakan format HTML sederhana untuk styling.</p>
                    @error('konten')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm">
                            <p class="text-blue-800 font-medium">Informasi Berita</p>
                            <p class="text-blue-600 mt-1">Dibuat: {{ $berita->created_at->format('d M Y, H:i') }}</p>
                            <p class="text-blue-600">Dilihat: {{ number_format($berita->views) }} kali</p>
                            @if($berita->published_at)
                            <p class="text-blue-600">Dipublish: {{ $berita->published_at->format('d M Y, H:i') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Publish Options -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Opsi Publikasi</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="draft" {{ old('status', $berita->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $berita->status) === 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>

                        <div>
                            <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select name="kategori" id="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @foreach($kategoriList as $key => $label)
                                <option value="{{ $key }}" {{ old('kategori', $berita->kategori) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Gambar -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Gambar Utama</h3>
                    
                    <div class="space-y-4">
                        <!-- Current Image -->
                        @if($berita->gambar)
                        <div id="current-gambar" class="relative">
                            <div class="w-full aspect-video rounded-lg overflow-hidden bg-gray-100">
                                <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
                            </div>
                            <div class="mt-2 flex items-center gap-2">
                                <label class="flex items-center gap-2 text-sm text-gray-600">
                                    <input type="checkbox" name="hapus_gambar" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500" onchange="toggleRemoveImage(this)">
                                    Hapus gambar ini
                                </label>
                            </div>
                        </div>
                        @endif

                        <!-- New Image Preview -->
                        <div id="gambar-preview" class="{{ $berita->gambar ? 'hidden' : '' }} w-full aspect-video rounded-lg overflow-hidden bg-gray-100">
                            <img id="gambar-preview-img" src="" alt="Preview" class="w-full h-full object-cover">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="gambar" class="cursor-pointer">
                                <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden" onchange="previewGambar(event)">
                                <span class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium w-full justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $berita->gambar ? 'Ganti Gambar' : 'Pilih Gambar' }}
                                </span>
                            </label>
                            <span id="gambar-filename" class="text-xs text-gray-500 text-center">{{ $berita->gambar ? $berita->gambar : 'Belum ada gambar dipilih' }}</span>
                        </div>
                        <p class="text-xs text-gray-500">Format: JPG, PNG, WebP. Maks 5MB. Ukuran optimal: 1200x630px</p>
                        @error('gambar')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="space-y-3">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-[#1e3a8a] text-white rounded-lg hover:bg-blue-800 transition-colors font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('berita.show', $berita->slug) }}" target="_blank" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Lihat Berita
                        </a>
                        <a href="{{ route('admin.berita.index') }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Delete Form - Dipindahkan keluar dari form update -->
    <div class="mt-6">
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <h3 class="text-sm font-semibold text-red-800 mb-2">Zona Bahaya</h3>
            <p class="text-xs text-red-600 mb-4">Menghapus berita tidak dapat dibatalkan.</p>
            <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini? Tindakan ini tidak dapat dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus Berita
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function previewGambar(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('gambar-preview').classList.remove('hidden');
            document.getElementById('gambar-preview-img').src = e.target.result;
            
            // Hide current image if exists
            const currentGambar = document.getElementById('current-gambar');
            if (currentGambar) {
                currentGambar.classList.add('hidden');
            }
        };
        reader.readAsDataURL(file);
        document.getElementById('gambar-filename').textContent = file.name;
    }
}

function toggleRemoveImage(checkbox) {
    const currentGambar = document.getElementById('current-gambar');
    if (checkbox.checked) {
        currentGambar.style.opacity = '0.5';
    } else {
        currentGambar.style.opacity = '1';
    }
}
</script>
@endsection
