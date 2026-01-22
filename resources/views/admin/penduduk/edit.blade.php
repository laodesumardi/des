@extends('admin.layouts.app')

@section('title', 'Edit Data Penduduk')

@section('content')
<div class="p-4 sm:p-6 md:p-8">
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Edit Data Penduduk</h1>
        <p class="text-gray-600 text-sm sm:text-base">Ubah data penduduk di bawah ini</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
        <form action="{{ route('admin.penduduk.update', $penduduk->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Data Identitas -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Data Identitas</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIK <span class="text-red-600">*</span></label>
                        <input type="text" name="nik" value="{{ old('nik', $penduduk->nik) }}" required maxlength="16" pattern="[0-9]{16}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white"
                            placeholder="Masukkan NIK (16 digit)">
                        @error('nik')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">No. KK</label>
                        <input type="text" name="no_kk" value="{{ old('no_kk', $penduduk->no_kk) }}" maxlength="16" pattern="[0-9]{16}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white"
                            placeholder="Masukkan No. KK (16 digit)">
                        @error('no_kk')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-600">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $penduduk->nama) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white"
                            placeholder="Masukkan nama lengkap">
                        @error('nama')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin <span class="text-red-600">*</span></label>
                        <select name="jenis_kelamin" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tempat Lahir <span class="text-red-600">*</span></label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white"
                            placeholder="Masukkan tempat lahir">
                        @error('tempat_lahir')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Lahir <span class="text-red-600">*</span></label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir->format('Y-m-d')) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white">
                        @error('tanggal_lahir')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Data Kependudukan -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Data Kependudukan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Agama</label>
                        <select name="agama"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white">
                            <option value="">Pilih Agama</option>
                            @foreach($agamaOptions as $agama)
                                <option value="{{ $agama }}" {{ old('agama', $penduduk->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                            @endforeach
                        </select>
                        @error('agama')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pendidikan</label>
                        <select name="pendidikan"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white">
                            <option value="">Pilih Pendidikan</option>
                            @foreach($pendidikanOptions as $pendidikan)
                                <option value="{{ $pendidikan }}" {{ old('pendidikan', $penduduk->pendidikan) == $pendidikan ? 'selected' : '' }}>{{ $pendidikan }}</option>
                            @endforeach
                        </select>
                        @error('pendidikan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pekerjaan</label>
                        <select name="pekerjaan"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white">
                            <option value="">Pilih Pekerjaan</option>
                            @foreach($pekerjaanOptions as $pekerjaan)
                                <option value="{{ $pekerjaan }}" {{ old('pekerjaan', $penduduk->pekerjaan) == $pekerjaan ? 'selected' : '' }}>{{ $pekerjaan }}</option>
                            @endforeach
                        </select>
                        @error('pekerjaan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status Perkawinan</label>
                        <select name="status_perkawinan"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white">
                            <option value="">Pilih Status Perkawinan</option>
                            @foreach($statusPerkawinanOptions as $status)
                                <option value="{{ $status }}" {{ old('status_perkawinan', $penduduk->status_perkawinan) == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('status_perkawinan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status dalam Keluarga</label>
                        <select name="status_dalam_keluarga"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white">
                            <option value="">Pilih Status dalam Keluarga</option>
                            @foreach($statusKeluargaOptions as $status)
                                <option value="{{ $status }}" {{ old('status_dalam_keluarga', $penduduk->status_dalam_keluarga) == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('status_dalam_keluarga')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kewarganegaraan</label>
                        <select name="kewarganegaraan"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white">
                            <option value="WNI" {{ old('kewarganegaraan', $penduduk->kewarganegaraan) == 'WNI' ? 'selected' : '' }}>WNI</option>
                            <option value="WNA" {{ old('kewarganegaraan', $penduduk->kewarganegaraan) == 'WNA' ? 'selected' : '' }}>WNA</option>
                        </select>
                        @error('kewarganegaraan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="is_kepala_keluarga" value="1" {{ old('is_kepala_keluarga', $penduduk->is_kepala_keluarga) ? 'checked' : '' }}
                            class="w-5 h-5 text-[#1e3a8a] border-gray-300 rounded focus:ring-[#1e3a8a]">
                        <span class="text-sm font-semibold text-gray-700">Kepala Keluarga</span>
                    </label>
                </div>
            </div>

            <!-- Data Alamat -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Data Alamat</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">RT <span class="text-red-600">*</span></label>
                        <input type="number" name="rt" value="{{ old('rt', (int)$penduduk->rt) }}" required min="1" max="999"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white"
                            placeholder="RT">
                        @error('rt')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">RW <span class="text-red-600">*</span></label>
                        <input type="number" name="rw" value="{{ old('rw', (int)$penduduk->rw) }}" required min="1" max="999"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white"
                            placeholder="RW">
                        @error('rw')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Dusun/Lingkungan</label>
                        <input type="text" name="dusun" value="{{ old('dusun', $penduduk->dusun) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white"
                            placeholder="Masukkan nama dusun/lingkungan">
                        @error('dusun')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap <span class="text-red-600">*</span></label>
                    <textarea name="alamat" rows="3" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] text-base text-gray-900 bg-white"
                        placeholder="Masukkan alamat lengkap">{{ old('alamat', $penduduk->alamat) }}</textarea>
                    @error('alamat')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-[#1e3a8a] text-white px-6 py-3 rounded-lg hover:bg-blue-900 transition-colors text-sm font-medium">
                    Update Data
                </button>
                <a href="{{ route('admin.penduduk.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors text-sm font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
