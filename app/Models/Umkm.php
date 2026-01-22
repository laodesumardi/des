<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkm';

    protected $fillable = [
        'nama_usaha',
        'nama_pemilik',
        'deskripsi',
        'alamat',
        'whatsapp',
        'gambar',
        'kategori',
        'harga_mulai',
        'status',
        'user_id',
        'urutan',
    ];

    protected $casts = [
        'harga_mulai' => 'decimal:0',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk umkm yang dipublish
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope untuk filter kategori
     */
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Get URL gambar dengan fallback
     * Menggunakan asset() untuk akses langsung dari public/images/
     */
    public function getGambarUrlAttribute()
    {
        if (empty($this->gambar)) {
            return asset('images/default-umkm.jpg');
        }
        
        // Gunakan asset() untuk akses langsung dari public/images/umkm/
        return asset('images/umkm/' . $this->gambar);
    }

    /**
     * Get WhatsApp URL
     */
    public function getWhatsappUrlAttribute()
    {
        // Bersihkan nomor dari karakter non-digit
        $nomor = preg_replace('/[^0-9]/', '', $this->whatsapp);
        
        // Jika dimulai dengan 0, ganti dengan 62
        if (substr($nomor, 0, 1) === '0') {
            $nomor = '62' . substr($nomor, 1);
        }
        
        // Jika tidak dimulai dengan 62, tambahkan 62
        if (substr($nomor, 0, 2) !== '62') {
            $nomor = '62' . $nomor;
        }
        
        $pesan = urlencode("Halo, saya tertarik dengan produk {$this->nama_usaha}. Apakah masih tersedia?");
        
        return "https://wa.me/{$nomor}?text={$pesan}";
    }

    /**
     * Format harga
     */
    public function getHargaFormatAttribute()
    {
        if ($this->harga_mulai) {
            return 'Rp ' . number_format($this->harga_mulai, 0, ',', '.');
        }
        return null;
    }

    /**
     * Kategori yang tersedia
     */
    public static function getKategori()
    {
        return [
            'makanan' => 'Makanan & Minuman',
            'kerajinan' => 'Kerajinan Tangan',
            'pertanian' => 'Hasil Pertanian',
            'peternakan' => 'Hasil Peternakan',
            'fashion' => 'Fashion & Pakaian',
            'jasa' => 'Jasa',
            'lainnya' => 'Lainnya',
        ];
    }
}
