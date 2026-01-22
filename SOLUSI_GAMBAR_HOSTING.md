# 🔧 Solusi Masalah Gambar di Shared Hosting (Hostinger)

## 📋 Ringkasan Masalah

Gambar muncul di local tapi tidak muncul di hosting Hostinger. Ini adalah masalah umum di shared hosting karena:
- Case sensitivity (Linux vs Windows)
- Permission folder
- Path handling yang berbeda
- Symlink storage yang tidak berfungsi

## ✅ Solusi yang Telah Diterapkan

### 1. **ImageHelper yang Diperbaiki**

File: `app/Helpers/ImageHelper.php`

**Fitur Baru:**
- ✅ `getImageUrl($subfolder, $filename, $fallback)` - Method utama untuk URL gambar yang aman
- ✅ Case-insensitive file search (untuk kompatibilitas Windows/Linux)
- ✅ Fallback otomatis jika gambar tidak ditemukan
- ✅ Cache buster dengan filemtime
- ✅ `ensureSubfolderExists()` - Membuat folder dengan permission yang benar

**Cara Penggunaan:**
```php
// Di Model (sudah diimplementasikan)
$berita->gambar_url  // Otomatis menggunakan ImageHelper

// Di View/Controller
use App\Helpers\ImageHelper;

$imageUrl = ImageHelper::getImageUrl('berita', $filename, asset('images/default.jpg'));
```

### 2. **Model dengan Accessor yang Aman**

File yang sudah diperbaiki:
- ✅ `app/Models/Berita.php` - `getGambarUrlAttribute()`
- ✅ `app/Models/Galeri.php` - `getGambarUrlAttribute()`
- ✅ `app/Models/Umkm.php` - `getGambarUrlAttribute()`

**Cara Penggunaan di View:**
```blade
{{-- Otomatis menggunakan helper yang aman --}}
<img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}">

{{-- Atau langsung dengan helper --}}
<img src="{{ \App\Helpers\ImageHelper::getImageUrl('berita', $berita->gambar) }}" alt="{{ $berita->judul }}">
```

### 3. **.htaccess yang Diperbaiki**

File: `public/.htaccess`

**Perubahan:**
- ✅ Allow direct access ke file gambar (jpg, jpeg, png, gif, webp, etc.)
- ✅ Cache control untuk gambar (performance)
- ✅ Tidak mengintervensi request ke file statis

### 4. **Controller yang Diperbaiki**

File yang sudah diperbaiki:
- ✅ `app/Http/Controllers/Admin/BeritaController.php`
- ✅ `app/Http/Controllers/Admin/GaleriController.php`
- ✅ `app/Http/Controllers/Admin/UmkmController.php`

**Perubahan:**
- Menggunakan `ImageHelper::ensureSubfolderExists()` untuk membuat folder
- Error handling yang lebih baik
- Permission yang benar (755)

## 🚀 Langkah Deployment ke Hostinger

### Step 1: Upload File

1. Upload semua file ke `public_html` (atau folder root domain Anda)
2. Pastikan struktur folder tetap sama

### Step 2: Buat Folder Images

**Via SSH (jika tersedia):**
```bash
cd public_html
mkdir -p public/images/berita
mkdir -p public/images/galeri
mkdir -p public/images/umkm
mkdir -p public/images/uploads/layanan
mkdir -p public/images/uploads/pengaduan
chmod -R 755 public/images
```

**Via File Manager Hostinger:**
1. Buka File Manager di cPanel
2. Navigasi ke `public/images`
3. Buat folder: `berita`, `galeri`, `umkm`, `uploads`
4. Di dalam `uploads`, buat: `layanan`, `pengaduan`
5. Set permission semua folder ke **755**

### Step 3: Set Permission

**Via SSH:**
```bash
chmod -R 755 public/images
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

**Via File Manager:**
1. Pilih folder `public/images`
2. Klik kanan → Change Permissions
3. Set ke **755**
4. Centang "Apply to all files and folders"

### Step 4: Update .env

Pastikan `.env` di server memiliki:
```env
APP_URL=https://yourdomain.com
APP_ENV=production
APP_DEBUG=false
```

### Step 5: Clear Cache

**Via SSH:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
php artisan config:cache
```

**Via Terminal Hostinger (jika tersedia):**
- Gunakan terminal di cPanel atau SSH

### Step 6: Test dengan Checker Script

1. Upload `public/check-images.php` ke server
2. Akses: `https://yourdomain.com/check-images.php?check=yes`
3. Periksa hasil diagnosa
4. **PENTING:** Hapus file `check-images.php` setelah selesai!

## 🔍 Diagnosa Masalah

### Script Checker

File: `public/check-images.php`

**Cara Menggunakan:**
1. Upload ke `public_html/check-images.php`
2. Akses: `https://yourdomain.com/check-images.php?check=yes`
3. Script akan mengecek:
   - ✅ Struktur folder
   - ✅ Permission folder
   - ✅ File gambar yang ada
   - ✅ Konfigurasi Laravel
   - ✅ Test asset() URL

**⚠️ PENTING:** Hapus file ini setelah selesai untuk keamanan!

### Checklist Manual

Jika gambar masih tidak muncul, cek:

- [ ] Folder `public/images` ada dan permission 755
- [ ] Subfolder (`berita`, `galeri`, `umkm`) ada dan permission 755
- [ ] File gambar ada di folder yang benar
- [ ] Permission file gambar readable (644 atau 755)
- [ ] `.env` APP_URL sudah benar
- [ ] Cache sudah di-clear
- [ ] `.htaccess` sudah ter-upload
- [ ] Path di database benar (hanya filename, bukan full path)

### Masalah Umum dan Solusi

#### 1. Gambar 404 Not Found

**Penyebab:**
- File tidak ada di server
- Path salah
- Permission tidak benar

**Solusi:**
```bash
# Cek file ada atau tidak
ls -la public/images/berita/

# Set permission
chmod 755 public/images/berita
chmod 644 public/images/berita/*.jpg
```

#### 2. Gambar Blank/Tidak Load

**Penyebab:**
- File corrupt
- Permission tidak readable
- MIME type salah

**Solusi:**
- Re-upload gambar
- Set permission 644 untuk file
- Cek `.htaccess` allow file gambar

#### 3. Path Case Sensitivity

**Penyebab:**
- Linux case-sensitive, Windows tidak

**Solusi:**
- Gunakan `ImageHelper::getImageUrl()` yang sudah handle case-insensitive
- Pastikan filename di database sesuai dengan file di server

#### 4. Permission Denied

**Penyebab:**
- Folder tidak writable untuk upload
- File tidak readable untuk display

**Solusi:**
```bash
# Set permission folder
chmod 755 public/images
chmod 755 public/images/berita

# Set permission file
chmod 644 public/images/berita/*.jpg
```

## 📝 Best Practices

### 1. **Selalu Gunakan Helper**

❌ **JANGAN:**
```blade
<img src="{{ asset('images/berita/' . $berita->gambar) }}">
```

✅ **GUNAKAN:**
```blade
<img src="{{ $berita->gambar_url }}">
{{-- atau --}}
<img src="{{ \App\Helpers\ImageHelper::getImageUrl('berita', $berita->gambar) }}">
```

### 2. **Gunakan Accessor di Model**

✅ **DI MODEL:**
```php
public function getGambarUrlAttribute()
{
    return \App\Helpers\ImageHelper::getImageUrl(
        'berita',
        $this->gambar,
        asset('images/default-berita.jpg')
    );
}
```

✅ **DI VIEW:**
```blade
<img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}">
```

### 3. **Simpan Hanya Filename di Database**

❌ **JANGAN:**
```php
$data['gambar'] = 'images/berita/berita-123.jpg';  // JANGAN!
```

✅ **GUNAKAN:**
```php
$data['gambar'] = 'berita-123.jpg';  // Hanya filename
```

### 4. **Gunakan Fallback**

Selalu sediakan fallback image:
```php
ImageHelper::getImageUrl('berita', $filename, asset('images/default.jpg'))
```

## 🔐 Keamanan

### File yang Harus Dihapus Setelah Deployment

- ❌ `public/check-images.php` - Hapus setelah diagnosa
- ❌ `public/create-storage.php` - Hapus setelah setup
- ❌ `public/test-db.php` - Hapus setelah testing
- ❌ File `.env.example` - Jangan upload ke production

### Permission yang Benar

```
public/images/          → 755 (rwxr-xr-x)
public/images/berita/   → 755 (rwxr-xr-x)
public/images/*.jpg     → 644 (rw-r--r--)
storage/                → 755 (rwxr-xr-x)
bootstrap/cache/         → 755 (rwxr-xr-x)
```

## 📞 Support

Jika masih ada masalah:

1. ✅ Jalankan `check-images.php` untuk diagnosa
2. ✅ Cek error log: `storage/logs/laravel.log`
3. ✅ Cek browser console untuk error 404/403
4. ✅ Pastikan semua langkah di atas sudah dilakukan

## 🎯 Ringkasan Perubahan

### File yang Diubah:

1. ✅ `app/Helpers/ImageHelper.php` - Helper baru dengan `getImageUrl()`
2. ✅ `app/Models/Berita.php` - Accessor menggunakan helper
3. ✅ `app/Models/Galeri.php` - Accessor menggunakan helper
4. ✅ `app/Models/Umkm.php` - Accessor menggunakan helper
5. ✅ `app/Http/Controllers/Admin/BeritaController.php` - Upload method diperbaiki
6. ✅ `app/Http/Controllers/Admin/GaleriController.php` - Upload method diperbaiki
7. ✅ `app/Http/Controllers/Admin/UmkmController.php` - Upload method diperbaiki
8. ✅ `public/.htaccess` - Allow direct access ke gambar
9. ✅ `public/check-images.php` - Script diagnosa (BARU)

### File yang Tidak Perlu Diubah:

- View yang menggunakan `$model->gambar_url` sudah otomatis menggunakan helper baru
- View yang menggunakan `asset('images/...')` masih bisa digunakan, tapi disarankan pakai helper

---

**Terakhir Diupdate:** 21 Januari 2026
**Versi:** 1.0.0
