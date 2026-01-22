<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'kategori',
        'status',
        'user_id',
        'urutan',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk galeri yang dipublish
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
            return asset('images/default-galeri.jpg');
        }
        
        // Pastikan path benar dan file exists
        $imagePath = 'images/galeri/' . $this->gambar;
        $fullPath = public_path($imagePath);
        
        // Jika file tidak ada, return default
        if (!file_exists($fullPath)) {
            return asset('images/default-galeri.jpg');
        }
        
        // Gunakan asset() untuk akses langsung dari public/images/galeri/
        return asset($imagePath);
    }

    /**
     * Kategori yang tersedia
     */
    public static function getKategori()
    {
        return [
            'umum' => 'Umum',
            'kegiatan' => 'Kegiatan Desa',
            'pembangunan' => 'Pembangunan',
            'budaya' => 'Budaya & Tradisi',
            'alam' => 'Pemandangan Alam',
            'fasilitas' => 'Fasilitas Desa',
        ];
    }
}
