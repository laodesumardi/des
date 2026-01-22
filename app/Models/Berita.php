<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'gambar',
        'kategori',
        'status',
        'user_id',
        'published_at',
        'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Boot method untuk auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = static::generateUniqueSlug($berita->judul);
            }
        });

        static::updating(function ($berita) {
            if ($berita->isDirty('judul')) {
                $berita->slug = static::generateUniqueSlug($berita->judul, $berita->id);
            }
        });
    }

    /**
     * Generate unique slug
     */
    public static function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        $query = static::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
            $query = static::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk berita yang dipublish
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope untuk filter kategori
     */
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Get URL gambar dengan fallback untuk shared hosting
     */
    public function getGambarUrlAttribute()
    {
        return \App\Helpers\ImageHelper::getImageUrl(
            'berita',
            $this->gambar,
            asset('images/default-berita.jpg')
        );
    }

    /**
     * Format tanggal publish
     */
    public function getTanggalPublishAttribute()
    {
        if ($this->published_at) {
            return $this->published_at->translatedFormat('d F Y');
        }
        return $this->created_at->translatedFormat('d F Y');
    }

    /**
     * Get ringkasan atau potong konten
     */
    public function getRingkasanPendekAttribute()
    {
        if ($this->ringkasan) {
            return Str::limit(strip_tags($this->ringkasan), 150);
        }
        return Str::limit(strip_tags($this->konten), 150);
    }

    /**
     * Increment views
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Kategori yang tersedia
     */
    public static function getKategori()
    {
        return [
            'umum' => 'Berita Umum',
            'pembangunan' => 'Pembangunan',
            'kesehatan' => 'Kesehatan',
            'pendidikan' => 'Pendidikan',
            'sosial' => 'Sosial',
            'kegiatan' => 'Kegiatan Desa',
            'pengumuman' => 'Pengumuman',
        ];
    }
}
