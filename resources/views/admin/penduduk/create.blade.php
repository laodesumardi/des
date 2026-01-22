@extends('admin.layouts.app')

@section('title', 'Tambah Data Penduduk')

@section('content')
<div class="p-4 sm:p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('admin.penduduk.index') }}" class="hover:text-[#1e3a8a]">Data Penduduk</a>
            <span>/</span>
            <span class="text-gray-700">Tambah</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Tambah Data Penduduk</h1>
        <p class="text-gray-500 text-sm mt-1">Tambahkan data penduduk baru secara manual atau import dari Excel</p>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Tab Navigation -->
    <div class="bg-white border rounded-lg mb-6">
        <div class="flex border-b">
            <button type="button" id="tab-manual" class="tab-btn flex-1 px-6 py-4 text-sm font-medium text-center border-b-2 border-[#1e3a8a] text-[#1e3a8a] bg-blue-50/50" onclick="switchTab('manual')">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Input Manual
            </button>
            <button type="button" id="tab-import" class="tab-btn flex-1 px-6 py-4 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50" onclick="switchTab('import')">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Import dari Excel
            </button>
        </div>
    </div>

    <!-- Tab Content: Manual Input -->
    <div id="content-manual" class="tab-content">
        <div class="bg-white border rounded-lg p-6">
            <form action="{{ route('admin.penduduk.store') }}" method="POST">
                @csrf
                
                <!-- Data Identitas -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Data Identitas</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">NIK <span class="text-red-500">*</span></label>
                            <input type="text" name="nik" value="{{ old('nik') }}" required maxlength="16" pattern="[0-9]{16}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm"
                                placeholder="Masukkan NIK (16 digit)">
                            @error('nik')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">No. KK</label>
                            <input type="text" name="no_kk" value="{{ old('no_kk') }}" maxlength="16" pattern="[0-9]{16}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm"
                                placeholder="Masukkan No. KK (16 digit)">
                            @error('no_kk')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm"
                                placeholder="Masukkan nama lengkap">
                            @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm"
                                placeholder="Masukkan tempat lahir">
                            @error('tempat_lahir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm">
                            @error('tanggal_lahir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Data Kependudukan -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Data Kependudukan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Agama</label>
                            <select name="agama" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm">
                                <option value="">Pilih Agama</option>
                                @foreach($agamaOptions as $agama)
                                    <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Pendidikan</label>
                            <select name="pendidikan" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm">
                                <option value="">Pilih Pendidikan</option>
                                @foreach($pendidikanOptions as $pendidikan)
                                    <option value="{{ $pendidikan }}" {{ old('pendidikan') == $pendidikan ? 'selected' : '' }}>{{ $pendidikan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Pekerjaan</label>
                            <select name="pekerjaan" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm">
                                <option value="">Pilih Pekerjaan</option>
                                @foreach($pekerjaanOptions as $pekerjaan)
                                    <option value="{{ $pekerjaan }}" {{ old('pekerjaan') == $pekerjaan ? 'selected' : '' }}>{{ $pekerjaan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Status Perkawinan</label>
                            <select name="status_perkawinan" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm">
                                <option value="">Pilih Status</option>
                                @foreach($statusPerkawinanOptions as $status)
                                    <option value="{{ $status }}" {{ old('status_perkawinan') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Status dalam Keluarga</label>
                            <select name="status_dalam_keluarga" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm">
                                <option value="">Pilih Status</option>
                                @foreach($statusKeluargaOptions as $status)
                                    <option value="{{ $status }}" {{ old('status_dalam_keluarga') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Kewarganegaraan</label>
                            <select name="kewarganegaraan" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm">
                                <option value="WNI" {{ old('kewarganegaraan', 'WNI') == 'WNI' ? 'selected' : '' }}>WNI</option>
                                <option value="WNA" {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_kepala_keluarga" value="1" {{ old('is_kepala_keluarga') ? 'checked' : '' }}
                                class="w-4 h-4 text-[#1e3a8a] border-gray-300 rounded focus:ring-[#1e3a8a]">
                            <span class="text-sm font-medium text-gray-700">Kepala Keluarga</span>
                        </label>
                    </div>
                </div>

                <!-- Data Alamat -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Data Alamat</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">RT <span class="text-red-500">*</span></label>
                            <input type="number" name="rt" value="{{ old('rt') }}" required min="1" max="999"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm"
                                placeholder="RT">
                            @error('rt')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">RW <span class="text-red-500">*</span></label>
                            <input type="number" name="rw" value="{{ old('rw') }}" required min="1" max="999"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm"
                                placeholder="RW">
                            @error('rw')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Dusun/Lingkungan</label>
                            <input type="text" name="dusun" value="{{ old('dusun') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm"
                                placeholder="Masukkan nama dusun/lingkungan">
                        </div>
                    </div>

                    <div class="mt-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat" rows="3" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-sm"
                            placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                        @error('alamat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t">
                    <button type="submit" class="bg-[#1e3a8a] text-white px-6 py-2.5 rounded-lg hover:bg-blue-900 transition-colors text-sm font-medium">
                        Simpan Data
                    </button>
                    <a href="{{ route('admin.penduduk.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tab Content: Import Excel -->
    <div id="content-import" class="tab-content hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Upload Form -->
            <div class="bg-white border rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Upload File Excel</h2>
                
                <form action="{{ route('admin.penduduk.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-[#1e3a8a] transition-colors" id="dropzone">
                        <input type="file" name="file" id="file-input" accept=".xlsx,.xls,.csv" class="hidden" required>
                        
                        <div id="upload-placeholder">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-gray-600 mb-2">Drag & drop file Excel di sini, atau</p>
                            <button type="button" onclick="document.getElementById('file-input').click()" class="text-[#1e3a8a] font-medium hover:underline">
                                Pilih File
                            </button>
                            <p class="text-xs text-gray-400 mt-2">Format: .xlsx, .xls, .csv (Max: 10MB)</p>
                        </div>
                        
                        <div id="file-preview" class="hidden">
                            <svg class="w-12 h-12 mx-auto text-green-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-800 font-medium" id="file-name"></p>
                            <p class="text-xs text-gray-400" id="file-size"></p>
                            <button type="button" onclick="clearFile()" class="text-red-500 text-sm mt-2 hover:underline">Hapus</button>
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-4 bg-[#1e3a8a] text-white px-6 py-3 rounded-lg hover:bg-blue-900 transition-colors text-sm font-medium flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Import Data
                    </button>
                </form>
            </div>

            <!-- Instructions -->
            <div class="bg-white border rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Petunjuk Import</h2>
                
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#1e3a8a] text-white rounded-full flex items-center justify-center text-sm font-medium">1</div>
                        <div>
                            <p class="font-medium text-gray-800">Download Template</p>
                            <p class="text-sm text-gray-500">Gunakan template yang sudah disediakan untuk memastikan format data sesuai.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#1e3a8a] text-white rounded-full flex items-center justify-center text-sm font-medium">2</div>
                        <div>
                            <p class="font-medium text-gray-800">Isi Data</p>
                            <p class="text-sm text-gray-500">Isi data penduduk sesuai kolom yang tersedia. Kolom NIK dan Nama wajib diisi.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#1e3a8a] text-white rounded-full flex items-center justify-center text-sm font-medium">3</div>
                        <div>
                            <p class="font-medium text-gray-800">Upload File</p>
                            <p class="text-sm text-gray-500">Upload file Excel yang sudah diisi. Data duplikat (NIK sama) akan otomatis dilewati.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t">
                    <a href="{{ route('admin.penduduk.template') }}" class="inline-flex items-center gap-2 bg-green-600 text-white px-5 py-2.5 rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Template Excel
                    </a>
                </div>

                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <h3 class="font-medium text-yellow-800 mb-2">Format Kolom:</h3>
                    <div class="text-xs text-yellow-700 space-y-1">
                        <p><strong>nik</strong> - 16 digit (wajib)</p>
                        <p><strong>nama</strong> - Nama lengkap (wajib)</p>
                        <p><strong>jenis_kelamin</strong> - Laki-laki / Perempuan</p>
                        <p><strong>tanggal_lahir</strong> - Format: YYYY-MM-DD</p>
                        <p><strong>is_kepala_keluarga</strong> - Ya / Tidak / 1 / 0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tab) {
    // Reset all tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-[#1e3a8a]', 'text-[#1e3a8a]', 'bg-blue-50/50');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });

    // Activate selected tab
    document.getElementById('tab-' + tab).classList.remove('border-transparent', 'text-gray-500');
    document.getElementById('tab-' + tab).classList.add('border-[#1e3a8a]', 'text-[#1e3a8a]', 'bg-blue-50/50');
    document.getElementById('content-' + tab).classList.remove('hidden');
}

// File upload handling
const fileInput = document.getElementById('file-input');
const dropzone = document.getElementById('dropzone');
const uploadPlaceholder = document.getElementById('upload-placeholder');
const filePreview = document.getElementById('file-preview');
const fileName = document.getElementById('file-name');
const fileSize = document.getElementById('file-size');

fileInput.addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
        showFilePreview(e.target.files[0]);
    }
});

dropzone.addEventListener('dragover', function(e) {
    e.preventDefault();
    dropzone.classList.add('border-[#1e3a8a]', 'bg-blue-50');
});

dropzone.addEventListener('dragleave', function(e) {
    e.preventDefault();
    dropzone.classList.remove('border-[#1e3a8a]', 'bg-blue-50');
});

dropzone.addEventListener('drop', function(e) {
    e.preventDefault();
    dropzone.classList.remove('border-[#1e3a8a]', 'bg-blue-50');
    
    if (e.dataTransfer.files.length > 0) {
        fileInput.files = e.dataTransfer.files;
        showFilePreview(e.dataTransfer.files[0]);
    }
});

function showFilePreview(file) {
    fileName.textContent = file.name;
    fileSize.textContent = formatFileSize(file.size);
    uploadPlaceholder.classList.add('hidden');
    filePreview.classList.remove('hidden');
}

function clearFile() {
    fileInput.value = '';
    uploadPlaceholder.classList.remove('hidden');
    filePreview.classList.add('hidden');
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}
</script>
@endsection
