<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanLayanan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_layanan';

    protected $fillable = [
        'nama',
        'nik',
        'telepon',
        'alamat',
        'jenis_layanan',
        'berkas',
        'keterangan',
        'status',
        'catatan_admin',
        'user_id',
        'diproses_at',
    ];

    protected $casts = [
        'diproses_at' => 'datetime',
    ];

    /**
     * Relasi ke User (admin yang memproses)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk filter status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'masuk' => 'Masuk',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => $this->status,
        };
    }

    /**
     * Get status color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'masuk' => 'yellow',
            'diproses' => 'blue',
            'selesai' => 'green',
            'ditolak' => 'red',
            default => 'gray',
        };
    }

    /**
     * Jenis layanan yang tersedia
     */
    public static function getJenisLayanan()
    {
        return [
            'domisili' => 'Surat Keterangan Domisili',
            'sktm' => 'Surat Keterangan Tidak Mampu',
            'usaha' => 'Surat Keterangan Usaha',
            'ktp' => 'Surat Pengantar KTP',
            'kelakuan' => 'Surat Keterangan Kelakuan Baik',
            'kematian' => 'Surat Keterangan Kematian',
        ];
    }

    /**
     * Get jenis layanan label
     */
    public function getJenisLayananLabelAttribute()
    {
        return self::getJenisLayanan()[$this->jenis_layanan] ?? $this->jenis_layanan;
    }
}
