<?php

namespace App\Imports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Carbon\Carbon;

class PendudukImport implements ToModel, WithHeadingRow, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    private $rowCount = 0;
    private $skippedRows = [];

    public function model(array $row)
    {
        // Konversi NIK dari scientific notation jika perlu
        $nik = $this->convertScientificToString($row['nik'] ?? null);
        $noKk = $this->convertScientificToString($row['no_kk'] ?? null);

        // Skip jika NIK kosong atau tidak valid
        if (empty($nik) || strlen($nik) < 10) {
            $this->skippedRows[] = "NIK kosong atau tidak valid";
            return null;
        }

        // Cek duplikat NIK
        if (Penduduk::where('nik', $nik)->exists()) {
            $this->skippedRows[] = "NIK {$nik} sudah ada di database";
            return null;
        }

        // Nama wajib diisi
        $nama = trim($row['nama'] ?? '');
        if (empty($nama)) {
            $this->skippedRows[] = "Nama kosong untuk NIK {$nik}";
            return null;
        }

        $this->rowCount++;

        // Parse tanggal lahir
        $tanggalLahir = $this->parseTanggalLahir($row['tanggal_lahir'] ?? null);

        // Normalize jenis kelamin
        $jenisKelamin = $this->normalizeJenisKelamin($row['jenis_kelamin'] ?? null);

        return new Penduduk([
            'nik' => $nik,
            'no_kk' => $noKk,
            'nama' => $nama,
            'tempat_lahir' => trim($row['tempat_lahir'] ?? ''),
            'tanggal_lahir' => $tanggalLahir,
            'jenis_kelamin' => $jenisKelamin,
            'agama' => $this->normalizeValue($row['agama'] ?? null),
            'pendidikan' => $this->normalizeValue($row['pendidikan'] ?? null),
            'pekerjaan' => $this->normalizeValue($row['pekerjaan'] ?? null),
            'status_perkawinan' => $this->normalizeValue($row['status_perkawinan'] ?? null),
            'kewarganegaraan' => $this->normalizeValue($row['kewarganegaraan'] ?? null) ?: 'WNI',
            'dusun' => $this->normalizeValue($row['dusun'] ?? null),
            'rt' => $this->normalizeRT($row['rt'] ?? null),
            'rw' => $this->normalizeRT($row['rw'] ?? null),
            'alamat' => trim($row['alamat'] ?? ''),
            'status_dalam_keluarga' => $this->normalizeValue($row['status_dalam_keluarga'] ?? null),
            'is_kepala_keluarga' => $this->parseBoolean($row['is_kepala_keluarga'] ?? false),
        ]);
    }

    /**
     * Konversi scientific notation ke string (untuk NIK/No KK)
     */
    private function convertScientificToString($value)
    {
        if (empty($value)) {
            return null;
        }

        // Jika sudah string dan bukan scientific notation
        if (is_string($value) && !preg_match('/[eE]/', $value)) {
            return preg_replace('/[^0-9]/', '', $value);
        }

        // Jika numeric (termasuk scientific notation)
        if (is_numeric($value)) {
            // Gunakan sprintf untuk menghindari scientific notation
            $str = sprintf('%.0f', (float) $value);
            return $str;
        }

        // Handle string dengan scientific notation
        if (is_string($value) && preg_match('/[eE]/', $value)) {
            $str = sprintf('%.0f', (float) $value);
            return $str;
        }

        return preg_replace('/[^0-9]/', '', (string) $value);
    }

    /**
     * Parse tanggal lahir dari berbagai format
     */
    private function parseTanggalLahir($value)
    {
        if (empty($value)) {
            return null;
        }

        try {
            // Jika numeric (Excel date serial number)
            if (is_numeric($value)) {
                // Excel date serial: jumlah hari sejak 1900-01-01
                $unixTimestamp = ($value - 25569) * 86400;
                return Carbon::createFromTimestamp($unixTimestamp)->format('Y-m-d');
            }

            // Coba parse berbagai format tanggal
            $formats = [
                'Y-m-d',
                'd-m-Y',
                'd/m/Y',
                'Y/m/d',
                'd-M-Y',
                'd M Y',
            ];

            foreach ($formats as $format) {
                try {
                    $date = Carbon::createFromFormat($format, $value);
                    if ($date) {
                        return $date->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            // Fallback: gunakan Carbon::parse
            return Carbon::parse($value)->format('Y-m-d');

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Normalize jenis kelamin
     */
    private function normalizeJenisKelamin($value)
    {
        if (empty($value)) {
            return 'Laki-laki';
        }

        $value = strtolower(trim((string) $value));

        if (in_array($value, ['l', 'laki-laki', 'laki', 'pria', 'male', 'm', '1'])) {
            return 'Laki-laki';
        }

        if (in_array($value, ['p', 'perempuan', 'wanita', 'female', 'f', '2'])) {
            return 'Perempuan';
        }

        return 'Laki-laki';
    }

    /**
     * Normalize RT/RW ke format 3 digit
     */
    private function normalizeRT($value)
    {
        if (empty($value)) {
            return '001';
        }

        // Konversi ke integer lalu ke string dengan padding
        $intVal = intval($value);
        if ($intVal <= 0) {
            return '001';
        }

        return str_pad((string) $intVal, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Normalize value (trim whitespace)
     */
    private function normalizeValue($value)
    {
        if (empty($value)) {
            return null;
        }

        $trimmed = trim((string) $value);
        return $trimmed === '' ? null : $trimmed;
    }

    /**
     * Parse boolean dari berbagai format
     */
    private function parseBoolean($value)
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (bool) $value;
        }

        $value = strtolower(trim((string) $value));
        return in_array($value, ['ya', 'yes', '1', 'true', 'y', 'kepala keluarga']);
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function getSkippedRows(): array
    {
        return $this->skippedRows;
    }
}
