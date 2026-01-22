<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Penduduk extends Model
{
    protected $table = 'penduduk';
    
    protected $fillable = [
        'nik',
        'no_kk',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'rt',
        'rw',
        'pendidikan',
        'agama',
        'pekerjaan',
        'status_perkawinan',
        'kewarganegaraan',
        'dusun',
        'status_dalam_keluarga',
        'is_kepala_keluarga',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'is_kepala_keluarga' => 'boolean',
    ];

    /**
     * Hitung usia penduduk
     */
    public function getUsiaAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : 0;
    }

    /**
     * Get total penduduk
     */
    public static function getTotalPenduduk()
    {
        return self::count();
    }

    /**
     * Get total kepala keluarga
     */
    public static function getTotalKepalaKeluarga()
    {
        return self::where('is_kepala_keluarga', true)->count();
    }

    /**
     * Get total laki-laki
     */
    public static function getTotalLakiLaki()
    {
        return self::where('jenis_kelamin', 'Laki-laki')->count();
    }

    /**
     * Get total perempuan
     */
    public static function getTotalPerempuan()
    {
        return self::where('jenis_kelamin', 'Perempuan')->count();
    }

    /**
     * Get statistik berdasarkan kelompok umur
     */
    public static function getStatistikKelompokUmur()
    {
        $kelompokUmur = [
            '0-4' => [0, 4],
            '5-9' => [5, 9],
            '10-14' => [10, 14],
            '15-19' => [15, 19],
            '20-24' => [20, 24],
            '25-29' => [25, 29],
            '30-34' => [30, 34],
            '35-39' => [35, 39],
            '40-44' => [40, 44],
            '45-49' => [45, 49],
            '50-54' => [50, 54],
            '55-59' => [55, 59],
            '60-64' => [60, 64],
            '65-69' => [65, 69],
            '70-74' => [70, 74],
            '75+' => [75, 200],
        ];

        $hasil = [];
        foreach ($kelompokUmur as $label => $range) {
            $tanggalMin = Carbon::now()->subYears($range[1] + 1)->addDay();
            $tanggalMax = Carbon::now()->subYears($range[0]);
            
            $lakiLaki = self::where('jenis_kelamin', 'Laki-laki')
                ->whereBetween('tanggal_lahir', [$tanggalMin, $tanggalMax])
                ->count();
            
            $perempuan = self::where('jenis_kelamin', 'Perempuan')
                ->whereBetween('tanggal_lahir', [$tanggalMin, $tanggalMax])
                ->count();
            
            $hasil[] = [
                'kelompok' => $label,
                'laki_laki' => $lakiLaki,
                'perempuan' => $perempuan,
                'total' => $lakiLaki + $perempuan,
            ];
        }
        
        return $hasil;
    }

    /**
     * Get statistik berdasarkan dusun
     */
    public static function getStatistikDusun()
    {
        return self::select('dusun', DB::raw('count(*) as total'))
            ->whereNotNull('dusun')
            ->where('dusun', '!=', '')
            ->groupBy('dusun')
            ->orderBy('dusun')
            ->get();
    }

    /**
     * Get statistik berdasarkan pendidikan
     */
    public static function getStatistikPendidikan()
    {
        return self::select('pendidikan', DB::raw('count(*) as total'))
            ->whereNotNull('pendidikan')
            ->where('pendidikan', '!=', '')
            ->groupBy('pendidikan')
            ->orderByDesc('total')
            ->get();
    }

    /**
     * Get statistik berdasarkan pekerjaan
     */
    public static function getStatistikPekerjaan()
    {
        return self::select('pekerjaan', DB::raw('count(*) as total'))
            ->whereNotNull('pekerjaan')
            ->where('pekerjaan', '!=', '')
            ->groupBy('pekerjaan')
            ->orderByDesc('total')
            ->get();
    }

    /**
     * Get statistik berdasarkan status perkawinan
     */
    public static function getStatistikPerkawinan()
    {
        return self::select('status_perkawinan', DB::raw('count(*) as total'))
            ->whereNotNull('status_perkawinan')
            ->where('status_perkawinan', '!=', '')
            ->groupBy('status_perkawinan')
            ->orderByDesc('total')
            ->get();
    }

    /**
     * Get statistik berdasarkan agama
     */
    public static function getStatistikAgama()
    {
        return self::select('agama', DB::raw('count(*) as total'))
            ->whereNotNull('agama')
            ->where('agama', '!=', '')
            ->groupBy('agama')
            ->orderByDesc('total')
            ->get();
    }

    /**
     * Get statistik wajib pilih (usia >= 17 tahun)
     */
    public static function getStatistikWajibPilih()
    {
        $tanggalBatas = Carbon::now()->subYears(17);
        
        $lakiLaki = self::where('jenis_kelamin', 'Laki-laki')
            ->where('tanggal_lahir', '<=', $tanggalBatas)
            ->count();
        
        $perempuan = self::where('jenis_kelamin', 'Perempuan')
            ->where('tanggal_lahir', '<=', $tanggalBatas)
            ->count();
        
        return [
            'laki_laki' => $lakiLaki,
            'perempuan' => $perempuan,
            'total' => $lakiLaki + $perempuan,
        ];
    }

    /**
     * Get semua statistik untuk infografis
     */
    public static function getAllStatistik()
    {
        return [
            'total_penduduk' => self::getTotalPenduduk(),
            'total_kk' => self::getTotalKepalaKeluarga(),
            'total_laki_laki' => self::getTotalLakiLaki(),
            'total_perempuan' => self::getTotalPerempuan(),
            'kelompok_umur' => self::getStatistikKelompokUmur(),
            'dusun' => self::getStatistikDusun(),
            'pendidikan' => self::getStatistikPendidikan(),
            'pekerjaan' => self::getStatistikPekerjaan(),
            'perkawinan' => self::getStatistikPerkawinan(),
            'agama' => self::getStatistikAgama(),
            'wajib_pilih' => self::getStatistikWajibPilih(),
        ];
    }
}
