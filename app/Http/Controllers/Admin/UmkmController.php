<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    /**
     * Display a listing of umkm.
     */
    public function index(Request $request)
    {
        $query = Umkm::with('user')->orderBy('urutan')->latest();

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by kategori
        if ($request->has('kategori') && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_usaha', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_pemilik', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        $umkm = $query->paginate(12)->withQueryString();
        $kategoriList = Umkm::getKategori();

        return view('admin.umkm.index', compact('umkm', 'kategoriList'));
    }

    /**
     * Show the form for creating a new umkm.
     */
    public function create()
    {
        $kategoriList = Umkm::getKategori();
        return view('admin.umkm.create', compact('kategoriList'));
    }

    /**
     * Store a newly created umkm.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:2000',
            'alamat' => 'nullable|string|max:500',
            'whatsapp' => 'required|string|max:20',
            'kategori' => 'required|string',
            'harga_mulai' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,published',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $data = [
            'nama_usaha' => $request->nama_usaha,
            'nama_pemilik' => $request->nama_pemilik,
            'deskripsi' => $request->deskripsi,
            'alamat' => $request->alamat,
            'whatsapp' => $request->whatsapp,
            'kategori' => $request->kategori,
            'harga_mulai' => $request->harga_mulai,
            'status' => $request->status,
            'user_id' => Auth::id(),
            'urutan' => $request->urutan ?? 0,
        ];

        // Handle gambar upload
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $this->uploadGambar($request->file('gambar'));
        }

        Umkm::create($data);

        return redirect()->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified umkm.
     */
    public function edit(Umkm $umkm)
    {
        $kategoriList = Umkm::getKategori();
        return view('admin.umkm.edit', compact('umkm', 'kategoriList'));
    }

    /**
     * Update the specified umkm.
     */
    public function update(Request $request, Umkm $umkm)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:2000',
            'alamat' => 'nullable|string|max:500',
            'whatsapp' => 'required|string|max:20',
            'kategori' => 'required|string',
            'harga_mulai' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,published',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $data = [
            'nama_usaha' => $request->nama_usaha,
            'nama_pemilik' => $request->nama_pemilik,
            'whatsapp' => $request->whatsapp,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'urutan' => $request->urutan ?? 0,
        ];

        // Handle deskripsi - hanya update jika diisi, jika kosong tetap null
        if ($request->has('deskripsi')) {
            $data['deskripsi'] = $request->deskripsi ?: null;
        }

        // Handle alamat - hanya update jika diisi, jika kosong tetap null
        if ($request->has('alamat')) {
            $data['alamat'] = $request->alamat ?: null;
        }

        // Handle harga_mulai - hanya update jika diisi, jika kosong tetap null
        if ($request->has('harga_mulai')) {
            $data['harga_mulai'] = $request->harga_mulai ?: null;
        }

        // Handle gambar upload
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($umkm->gambar) {
                $this->deleteGambar($umkm->gambar);
            }
            $data['gambar'] = $this->uploadGambar($request->file('gambar'));
        }

        // Handle remove gambar - hanya jika checkbox dicentang
        if ($request->has('hapus_gambar') && $request->hapus_gambar == '1') {
            if ($umkm->gambar) {
                $this->deleteGambar($umkm->gambar);
            }
            $data['gambar'] = null;
        }
        // Jika tidak ada file baru dan tidak ada checkbox hapus, pertahankan gambar lama
        elseif (!$request->hasFile('gambar')) {
            // Jangan ubah gambar jika tidak ada perubahan
            // Gambar tetap menggunakan yang lama
        }

        $umkm->update($data);

        return redirect()->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil diperbarui!');
    }

    /**
     * Remove the specified umkm.
     */
    public function destroy(Umkm $umkm)
    {
        // Delete gambar if exists
        if ($umkm->gambar) {
            $this->deleteGambar($umkm->gambar);
        }

        $umkm->delete();

        return redirect()->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil dihapus!');
    }

    /**
     * Upload gambar umkm
     * Menyimpan langsung ke public/images/umkm/ untuk akses langsung tanpa symlink
     */
    private function uploadGambar($file)
    {
        // Generate unique filename
        $filename = 'umkm-' . time() . '-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        // Simpan langsung ke public/images/umkm/
        $destinationPath = public_path('images/umkm');
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        
        $file->move($destinationPath, $filename);
        
        // Return hanya filename untuk disimpan di database
        return $filename;
    }

    /**
     * Delete gambar umkm
     */
    private function deleteGambar($filename)
    {
        if (empty($filename)) {
            return;
        }
        
        // Hapus dari public/images/umkm/
        $filePath = public_path('images/umkm/' . $filename);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
