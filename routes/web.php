<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\UmkmController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\PengajuanLayananController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Artisan;

// Public Routes
Route::get('/', [PageController::class, 'beranda'])->name('beranda');
Route::get('/profil', [PageController::class, 'profil'])->name('profil');
Route::get('/pemerintahan', [PageController::class, 'pemerintahan'])->name('pemerintahan');
Route::get('/berita', [PageController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [PageController::class, 'beritaShow'])->name('berita.show');
Route::get('/layanan', [PageController::class, 'layanan'])->name('layanan');
Route::post('/layanan/pengajuan', [PageController::class, 'storePengajuanLayanan'])->name('layanan.store');
Route::post('/layanan/cek-status', [PageController::class, 'cekStatusLayanan'])->name('layanan.cek-status');
Route::get('/data', [PageController::class, 'data'])->name('data');
Route::get('/galeri', [PageController::class, 'galeri'])->name('galeri');
Route::get('/ekonomi-umkm', [PageController::class, 'umkm'])->name('umkm');
Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');
Route::post('/pengaduan', [PageController::class, 'storePengaduan'])->name('pengaduan.store');

// Infografis Routes
Route::get('/infografis/penduduk', [PageController::class, 'infografisPenduduk'])->name('infografis.penduduk');

// Admin Login Routes (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'login']);
});

// Admin Routes (Authenticated & Admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Content Management Routes
    Route::get('/contents', [\App\Http\Controllers\Admin\ContentController::class, 'index'])->name('contents.index');
    Route::get('/contents/{page}/edit', [\App\Http\Controllers\Admin\ContentController::class, 'edit'])->name('contents.edit');
    Route::put('/contents/{page}', [\App\Http\Controllers\Admin\ContentController::class, 'update'])->name('contents.update');
    Route::post('/contents/upload-foto', [\App\Http\Controllers\Admin\ContentController::class, 'uploadFoto'])->name('contents.upload-foto');
    Route::post('/contents/upload-struktur', [\App\Http\Controllers\Admin\ContentController::class, 'uploadStruktur'])->name('contents.upload-struktur');
    Route::post('/contents/upload-hero', [\App\Http\Controllers\Admin\ContentController::class, 'uploadHero'])->name('contents.upload-hero');
    Route::post('/contents/upload-header-bg', [\App\Http\Controllers\Admin\ContentController::class, 'uploadHeaderBg'])->name('contents.upload-header-bg');

    // Perangkat Desa Routes
    Route::post('/perangkat-desa', [\App\Http\Controllers\Admin\PerangkatDesaController::class, 'store'])->name('perangkat-desa.store');
    Route::put('/perangkat-desa/{id}', [\App\Http\Controllers\Admin\PerangkatDesaController::class, 'update'])->name('perangkat-desa.update');
    Route::delete('/perangkat-desa/{id}', [\App\Http\Controllers\Admin\PerangkatDesaController::class, 'destroy'])->name('perangkat-desa.destroy');

    // Penduduk Routes
    Route::resource('penduduk', \App\Http\Controllers\Admin\PendudukController::class);
    Route::get('penduduk-infografis', [\App\Http\Controllers\Admin\PendudukController::class, 'infografis'])->name('penduduk.infografis');
    Route::post('penduduk-import', [\App\Http\Controllers\Admin\PendudukController::class, 'import'])->name('penduduk.import');
    Route::get('penduduk-template', [\App\Http\Controllers\Admin\PendudukController::class, 'downloadTemplate'])->name('penduduk.template');

    // Berita Routes
    Route::resource('berita', BeritaController::class);

    // Galeri Routes
    Route::resource('galeri', GaleriController::class);

    // UMKM Routes
    Route::resource('umkm', UmkmController::class);

    // Pengaduan Routes
    Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::put('pengaduan/{pengaduan}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.update-status');
    Route::delete('pengaduan/{pengaduan}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');

    // Agenda Routes
    Route::resource('agenda', AgendaController::class)->except(['show']);

    // Pengumuman Routes
    Route::resource('pengumuman', PengumumanController::class)->except(['show']);

    // Pengajuan Layanan Routes
    Route::get('pengajuan-layanan', [PengajuanLayananController::class, 'index'])->name('pengajuan-layanan.index');
    Route::get('pengajuan-layanan/{pengajuanLayanan}', [PengajuanLayananController::class, 'show'])->name('pengajuan-layanan.show');
    Route::put('pengajuan-layanan/{pengajuanLayanan}/status', [PengajuanLayananController::class, 'updateStatus'])->name('pengajuan-layanan.update-status');
    Route::delete('pengajuan-layanan/{pengajuanLayanan}', [PengajuanLayananController::class, 'destroy'])->name('pengajuan-layanan.destroy');

    // Settings Routes
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings/general', [SettingController::class, 'updateGeneral'])->name('settings.update-general');
    Route::put('settings/contact', [SettingController::class, 'updateContact'])->name('settings.update-contact');
    Route::put('settings/hours', [SettingController::class, 'updateHours'])->name('settings.update-hours');
    Route::put('settings/social', [SettingController::class, 'updateSocial'])->name('settings.update-social');
    Route::put('settings/seo', [SettingController::class, 'updateSeo'])->name('settings.update-seo');
    Route::post('settings/upload-logo', [SettingController::class, 'uploadLogo'])->name('settings.upload-logo');
    Route::post('settings/upload-favicon', [SettingController::class, 'uploadFavicon'])->name('settings.upload-favicon');
    Route::delete('settings/delete-logo', [SettingController::class, 'deleteLogo'])->name('settings.delete-logo');
    Route::delete('settings/delete-favicon', [SettingController::class, 'deleteFavicon'])->name('settings.delete-favicon');
});

Route::get('/symlink', function () {
    $results = [];
    
    // 1. Buat symbolic link storage (PENTING untuk Storage::url())
    try {
        Artisan::call('storage:link');
        $results[] = '✅ Symbolic link storage berhasil dibuat';
    } catch (\Exception $e) {
        $results[] = '⚠️ Symbolic link storage: ' . $e->getMessage();
        $results[] = '💡 Alternatif: Buat manual via SSH: <code>ln -s ../storage/app/public storage</code>';
    }
    
    // 2. Buat folder di storage/app/public/images/
    $storageImagesPath = storage_path('app/public/images');
    $subfolders = ['berita', 'galeri', 'umkm', 'uploads/layanan', 'uploads/pengaduan'];
    
    if (!is_dir($storageImagesPath)) {
        mkdir($storageImagesPath, 0755, true);
        $results[] = '✅ Folder storage/app/public/images dibuat';
    } else {
        $results[] = '✅ Folder storage/app/public/images sudah ada';
    }
    
    foreach ($subfolders as $subfolder) {
        $fullPath = $storageImagesPath . '/' . $subfolder;
        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0755, true);
            $results[] = "✅ Folder storage/app/public/images/$subfolder dibuat";
        }
    }
    
    // 3. Set permission
    if (is_dir($storageImagesPath)) {
        chmod($storageImagesPath, 0755);
        $results[] = '✅ Permission folder storage/app/public/images diatur (755)';
    }
    
    // 4. Verifikasi
    $storageLink = public_path('storage');
    $storageExists = is_link($storageLink) || is_dir($storageLink);
    $storageImagesExists = is_dir($storageImagesPath);
    
    $html = '<!DOCTYPE html><html><head><title>Setup Storage Symlink</title>';
    $html .= '<style>body{font-family:Arial;max-width:800px;margin:50px auto;padding:20px;}';
    $html .= '.success{color:#28a745;background:#d4edda;padding:10px;margin:5px 0;border-radius:5px;}';
    $html .= '.error{color:#dc3545;background:#f8d7da;padding:10px;margin:5px 0;border-radius:5px;}';
    $html .= '.info{color:#17a2b8;background:#d1ecf1;padding:10px;margin:5px 0;border-radius:5px;}';
    $html .= '.warning{color:#856404;background:#fff3cd;padding:10px;margin:5px 0;border-radius:5px;}';
    $html .= 'pre{background:#f8f9fa;padding:10px;border-radius:5px;overflow-x:auto;}</style></head><body>';
    $html .= '<h1>🔗 Setup Storage Symlink</h1>';
    
    foreach ($results as $result) {
        $html .= '<div class="success">' . htmlspecialchars($result) . '</div>';
    }
    
    $html .= '<h2>📋 Verifikasi</h2>';
    
    if ($storageExists) {
        $html .= '<div class="success">✅ Storage symlink ada di: <code>public/storage</code></div>';
    } else {
        $html .= '<div class="error">❌ Storage symlink tidak ada!</div>';
        $html .= '<div class="warning">';
        $html .= '<p><strong>Solusi Manual via SSH:</strong></p>';
        $html .= '<pre>cd public_html<br>ln -s ../storage/app/public storage</pre>';
        $html .= '</div>';
    }
    
    if ($storageImagesExists) {
        $html .= '<div class="success">✅ Folder storage/app/public/images ada</div>';
        
        // Cek subfolder
        foreach ($subfolders as $subfolder) {
            $fullPath = $storageImagesPath . '/' . $subfolder;
            if (is_dir($fullPath)) {
                $html .= '<div class="success">✅ Folder images/' . htmlspecialchars($subfolder) . ' ada</div>';
            } else {
                $html .= '<div class="error">❌ Folder images/' . htmlspecialchars($subfolder) . ' tidak ada</div>';
            }
        }
    } else {
        $html .= '<div class="error">❌ Folder storage/app/public/images tidak ada</div>';
    }
    
    $html .= '<h2>📝 Cara Menampilkan Gambar</h2>';
    $html .= '<div class="info">';
    $html .= '<p><strong>Jika file ada di:</strong> <code>storage/app/public/images/berita/foto.jpg</code></p>';
    $html .= '<p><strong>Gunakan di Blade:</strong></p>';
    $html .= '<pre>&lt;img src="{{ asset(\'storage/images/berita/foto.jpg\') }}" alt=""&gt;</pre>';
    $html .= '<p><strong>Atau:</strong></p>';
    $html .= '<pre>&lt;img src="{{ Storage::url(\'images/berita/foto.jpg\') }}" alt=""&gt;</pre>';
    $html .= '<p><strong>Via Model Accessor:</strong></p>';
    $html .= '<pre>&lt;img src="{{ $berita->gambar_url }}" alt=""&gt;</pre>';
    $html .= '</div>';
    
    $html .= '<h2>🔧 Jika Masih Ada Masalah</h2>';
    $html .= '<div class="info">';
    $html .= '<p>1. Pastikan symlink <code>public/storage</code> → <code>storage/app/public</code> ada</p>';
    $html .= '<p>2. Pastikan folder <code>storage/app/public/images</code> ada dengan permission 755</p>';
    $html .= '<p>3. Cek permission file gambar (harus 644 atau 755)</p>';
    $html .= '<p>4. Clear cache: <code>php artisan optimize:clear</code></p>';
    $html .= '</div>';
    
    $html .= '<p style="margin-top:30px;padding:15px;background:#fff3cd;border-left:4px solid #ffc107;">';
    $html .= '<strong>⚠️ PENTING:</strong> Hapus route /symlink setelah setup selesai untuk keamanan!';
    $html .= '</p>';
    
    $html .= '</body></html>';
    
    return $html;
});
