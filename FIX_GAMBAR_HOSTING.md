# 🔧 Fix: Gambar Tidak Muncul di Hostinger

## 🎯 Masalah

Gambar tidak muncul meskipun symbolic link `storage` sudah ada.

## 🔍 Penyebab

**Gambar aplikasi disimpan di `public/images/`, BUKAN di `storage/app/public`!**

- ✅ **Gambar aplikasi:** `public/images/berita/`, `public/images/galeri/`, `public/images/umkm/`
- ✅ **Symbolic link storage:** Hanya untuk Laravel storage (opsional)
- ❌ **Tidak ada hubungan:** Symbolic link storage tidak mempengaruhi gambar aplikasi

## ✅ Solusi

### 1. Pastikan Folder Images Ada

**Via SSH:**
```bash
cd public_html
mkdir -p images/berita
mkdir -p images/galeri
mkdir -p images/umkm
mkdir -p images/uploads/layanan
mkdir -p images/uploads/pengaduan
chmod -R 755 images
```

**Via Browser:**
Akses: `https://yourdomain.com/symlink`

Script akan otomatis membuat semua folder yang diperlukan.

### 2. Set Permission

```bash
chmod -R 755 public_html/images
chmod -R 644 public_html/images/*/*.jpg  # Jika ada file
```

### 3. Verifikasi Struktur Folder

Pastikan struktur folder seperti ini:
```
public_html/
├── images/
│   ├── berita/
│   ├── galeri/
│   ├── umkm/
│   └── uploads/
│       ├── layanan/
│       └── pengaduan/
└── storage/  (symbolic link, opsional)
```

### 4. Test Upload Gambar

1. Login ke admin panel
2. Upload gambar (berita, galeri, atau UMKM)
3. Cek apakah file muncul di `public_html/images/[folder]/`
4. Cek apakah gambar muncul di frontend

## 🔍 Troubleshooting

### Gambar 404 Not Found

**Cek:**
1. File ada di `public_html/images/berita/`?
   ```bash
   ls -la public_html/images/berita/
   ```

2. Permission file benar?
   ```bash
   chmod 644 public_html/images/berita/*.jpg
   ```

3. Path di database benar?
   - Harus hanya filename: `berita-123.jpg`
   - Bukan full path: `images/berita/berita-123.jpg`

### Permission Denied

**Solusi:**
```bash
chmod -R 755 public_html/images
find public_html/images -type f -exec chmod 644 {} \;
```

### Folder Tidak Ada

**Solusi:**
```bash
mkdir -p public_html/images/{berita,galeri,umkm,uploads/{layanan,pengaduan}}
chmod -R 755 public_html/images
```

## 📝 Catatan Penting

1. **Gambar aplikasi** = `public/images/` (langsung di public)
2. **Laravel storage** = `storage/app/public` (butuh symbolic link)
3. **Keduanya berbeda!** Symbolic link storage tidak mempengaruhi gambar aplikasi

## ✅ Checklist

- [ ] Folder `public_html/images` ada
- [ ] Subfolder (berita, galeri, umkm) ada
- [ ] Permission folder 755
- [ ] Permission file gambar 644
- [ ] File gambar ada di folder yang benar
- [ ] Path di database hanya filename (bukan full path)
- [ ] Clear cache: `php artisan optimize:clear`

## 🚀 Quick Fix

Jalankan via browser:
```
https://yourdomain.com/symlink
```

Atau via SSH:
```bash
cd public_html
mkdir -p images/{berita,galeri,umkm,uploads/{layanan,pengaduan}}
chmod -R 755 images
```

---

**Terakhir Diupdate:** 21 Januari 2026
