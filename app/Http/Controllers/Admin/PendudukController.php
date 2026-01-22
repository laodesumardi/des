<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Imports\PendudukImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    // Opsi untuk dropdown
    protected $agamaOptions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'];
    protected $pendidikanOptions = ['Tidak/Belum Sekolah', 'Tidak Tamat SD', 'SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D1/D2', 'D3', 'S1/D4', 'S2', 'S3'];
    protected $pekerjaanOptions = ['Belum/Tidak Bekerja', 'Pelajar/Mahasiswa', 'PNS', 'TNI', 'Polri', 'Petani', 'Nelayan', 'Pedagang', 'Wiraswasta', 'Karyawan Swasta', 'Buruh', 'Pensiunan', 'Ibu Rumah Tangga', 'Guru', 'Dokter', 'Lainnya'];
    protected $statusPerkawinanOptions = ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'];
    protected $statusKeluargaOptions = ['Kepala Keluarga', 'Istri', 'Anak', 'Menantu', 'Cucu', 'Orang Tua', 'Mertua', 'Famili Lain', 'Pembantu', 'Lainnya'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Penduduk::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('no_kk', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        // Filter by jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter by dusun
        if ($request->filled('dusun')) {
            $query->where('dusun', $request->dusun);
        }

        // Filter by agama
        if ($request->filled('agama')) {
            $query->where('agama', $request->agama);
        }

        // Filter by pekerjaan
        if ($request->filled('pekerjaan')) {
            $query->where('pekerjaan', $request->pekerjaan);
        }

        // Filter by pendidikan
        if ($request->filled('pendidikan')) {
            $query->where('pendidikan', $request->pendidikan);
        }

        // Filter by status perkawinan
        if ($request->filled('status_perkawinan')) {
            $query->where('status_perkawinan', $request->status_perkawinan);
        }

        $penduduk = $query->orderBy('nama')->paginate(20)->withQueryString();

        // Get statistik
        $totalPenduduk = Penduduk::count();
        $totalLakiLaki = Penduduk::where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = Penduduk::where('jenis_kelamin', 'Perempuan')->count();
        $totalKK = Penduduk::where('is_kepala_keluarga', true)->count();

        // Get unique values for filters
        $dusunList = Penduduk::whereNotNull('dusun')->distinct()->pluck('dusun')->filter();
        $pekerjaanList = Penduduk::whereNotNull('pekerjaan')->distinct()->pluck('pekerjaan')->filter();

        return view('admin.penduduk.index', compact(
            'penduduk', 
            'totalPenduduk', 
            'totalLakiLaki', 
            'totalPerempuan', 
            'totalKK',
            'dusunList',
            'pekerjaanList'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.penduduk.create', [
            'agamaOptions' => $this->agamaOptions,
            'pendidikanOptions' => $this->pendidikanOptions,
            'pekerjaanOptions' => $this->pekerjaanOptions,
            'statusPerkawinanOptions' => $this->statusPerkawinanOptions,
            'statusKeluargaOptions' => $this->statusKeluargaOptions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16|unique:penduduk,nik',
            'no_kk' => 'nullable|string|size:16',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'rt' => 'required|numeric|min:1|max:999',
            'rw' => 'required|numeric|min:1|max:999',
            'dusun' => 'nullable|string|max:255',
            'pendidikan' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'status_perkawinan' => 'nullable|string|max:255',
            'kewarganegaraan' => 'nullable|string|max:255',
            'status_dalam_keluarga' => 'nullable|string|max:255',
            'is_kepala_keluarga' => 'nullable|boolean',
        ]);

        // Normalisasi RT dan RW: pad dengan leading zero untuk konsistensi (1 menjadi 001)
        $data = $request->all();
        $data['rt'] = str_pad((string)intval($data['rt']), 3, '0', STR_PAD_LEFT);
        $data['rw'] = str_pad((string)intval($data['rw']), 3, '0', STR_PAD_LEFT);
        $data['is_kepala_keluarga'] = $request->has('is_kepala_keluarga') ? 1 : 0;

        Penduduk::create($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data penduduk berhasil ditambahkan.'
            ]);
        }

        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penduduk = Penduduk::findOrFail($id);
        return view('admin.penduduk.show', compact('penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penduduk = Penduduk::findOrFail($id);
        return view('admin.penduduk.edit', [
            'penduduk' => $penduduk,
            'agamaOptions' => $this->agamaOptions,
            'pendidikanOptions' => $this->pendidikanOptions,
            'pekerjaanOptions' => $this->pekerjaanOptions,
            'statusPerkawinanOptions' => $this->statusPerkawinanOptions,
            'statusKeluargaOptions' => $this->statusKeluargaOptions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penduduk = Penduduk::findOrFail($id);

        $request->validate([
            'nik' => 'required|string|size:16|unique:penduduk,nik,' . $id,
            'no_kk' => 'nullable|string|size:16',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'rt' => 'required|numeric|min:1|max:999',
            'rw' => 'required|numeric|min:1|max:999',
            'dusun' => 'nullable|string|max:255',
            'pendidikan' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'status_perkawinan' => 'nullable|string|max:255',
            'kewarganegaraan' => 'nullable|string|max:255',
            'status_dalam_keluarga' => 'nullable|string|max:255',
            'is_kepala_keluarga' => 'nullable|boolean',
        ]);

        // Normalisasi RT dan RW: pad dengan leading zero untuk konsistensi (1 menjadi 001)
        $data = $request->all();
        $data['rt'] = str_pad((string)intval($data['rt']), 3, '0', STR_PAD_LEFT);
        $data['rw'] = str_pad((string)intval($data['rw']), 3, '0', STR_PAD_LEFT);
        $data['is_kepala_keluarga'] = $request->has('is_kepala_keluarga') ? 1 : 0;

        $penduduk->update($data);

        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $penduduk->delete();

        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }

    /**
     * Display infografis penduduk
     */
    public function infografis()
    {
        $statistik = Penduduk::getAllStatistik();
        return view('admin.penduduk.infografis', compact('statistik'));
    }

    /**
     * Import data penduduk from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240'
        ], [
            'file.required' => 'File Excel harus diupload.',
            'file.mimes' => 'File harus berformat .xlsx, .xls, atau .csv',
            'file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        try {
            $import = new PendudukImport();
            Excel::import($import, $request->file('file'));
            
            $rowCount = $import->getRowCount();
            $skippedRows = $import->getSkippedRows();
            $failures = $import->failures();
            $errors = $import->errors();
            
            if ($rowCount == 0) {
                $errorMessage = 'Tidak ada data yang berhasil diimport.';
                
                if (count($skippedRows) > 0) {
                    $errorMessage .= ' Alasan: ' . implode('; ', array_slice($skippedRows, 0, 3));
                    if (count($skippedRows) > 3) {
                        $errorMessage .= ' dan ' . (count($skippedRows) - 3) . ' lainnya.';
                    }
                }
                
                return redirect()->back()->with('error', $errorMessage);
            }
            
            $message = "{$rowCount} data penduduk berhasil diimport.";
            
            if (count($skippedRows) > 0) {
                $message .= " " . count($skippedRows) . " baris dilewati.";
            }

            return redirect()->route('admin.penduduk.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            \Log::error('Import Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->back()
                ->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel
     */
    public function downloadTemplate()
    {
        $templatePath = public_path('templates/template_penduduk.xlsx');
        
        if (!file_exists($templatePath)) {
            // Create template if not exists
            $this->createTemplate();
        }
        
        return response()->download($templatePath, 'template_data_penduduk.xlsx');
    }

    /**
     * Create Excel template
     */
    private function createTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Penduduk');
        
        // Headers
        $headers = [
            'A1' => 'nik',
            'B1' => 'no_kk',
            'C1' => 'nama',
            'D1' => 'tempat_lahir',
            'E1' => 'tanggal_lahir',
            'F1' => 'jenis_kelamin',
            'G1' => 'agama',
            'H1' => 'pendidikan',
            'I1' => 'pekerjaan',
            'J1' => 'status_perkawinan',
            'K1' => 'kewarganegaraan',
            'L1' => 'dusun',
            'M1' => 'rt',
            'N1' => 'rw',
            'O1' => 'alamat',
            'P1' => 'status_dalam_keluarga',
            'Q1' => 'is_kepala_keluarga',
        ];
        
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }
        
        // Set kolom NIK dan No KK sebagai TEXT agar tidak jadi scientific notation
        $sheet->getStyle('A:A')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $sheet->getStyle('B:B')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        
        // Example data - gunakan setCellValueExplicit untuk NIK dan No KK
        $sheet->setCellValueExplicit('A2', '7371012345678901', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('B2', '7371012345678901', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue('C2', 'Contoh Nama Lengkap');
        $sheet->setCellValue('D2', 'Makassar');
        $sheet->setCellValue('E2', '1990-01-15');
        $sheet->setCellValue('F2', 'Laki-laki');
        $sheet->setCellValue('G2', 'Islam');
        $sheet->setCellValue('H2', 'SMA/Sederajat');
        $sheet->setCellValue('I2', 'Wiraswasta');
        $sheet->setCellValue('J2', 'Kawin');
        $sheet->setCellValue('K2', 'WNI');
        $sheet->setCellValue('L2', 'Padaelo');
        $sheet->setCellValue('M2', '1');
        $sheet->setCellValue('N2', '1');
        $sheet->setCellValue('O2', 'Jl. Contoh No. 1');
        $sheet->setCellValue('P2', 'Kepala Keluarga');
        $sheet->setCellValue('Q2', 'Ya');
        
        // Contoh data ke-2
        $sheet->setCellValueExplicit('A3', '7371019876543210', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('B3', '7371012345678901', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue('C3', 'Contoh Nama Istri');
        $sheet->setCellValue('D3', 'Makassar');
        $sheet->setCellValue('E3', '1992-05-20');
        $sheet->setCellValue('F3', 'Perempuan');
        $sheet->setCellValue('G3', 'Islam');
        $sheet->setCellValue('H3', 'S1/D4');
        $sheet->setCellValue('I3', 'PNS');
        $sheet->setCellValue('J3', 'Kawin');
        $sheet->setCellValue('K3', 'WNI');
        $sheet->setCellValue('L3', 'Padaelo');
        $sheet->setCellValue('M3', '1');
        $sheet->setCellValue('N3', '1');
        $sheet->setCellValue('O3', 'Jl. Contoh No. 1');
        $sheet->setCellValue('P3', 'Istri');
        $sheet->setCellValue('Q3', 'Tidak');
        
        // Style headers
        $sheet->getStyle('A1:Q1')->getFont()->setBold(true);
        $sheet->getStyle('A1:Q1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF1E3A8A');
        $sheet->getStyle('A1:Q1')->getFont()->getColor()->setARGB('FFFFFFFF');
        
        // Style example rows
        $sheet->getStyle('A2:Q3')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFDE7');
        
        // Auto width
        foreach (range('A', 'Q') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Set minimum width untuk kolom NIK dan No KK
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        
        // Save
        $templateDir = public_path('templates');
        if (!is_dir($templateDir)) {
            mkdir($templateDir, 0755, true);
        }
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save(public_path('templates/template_penduduk.xlsx'));
    }
}
