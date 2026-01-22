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
