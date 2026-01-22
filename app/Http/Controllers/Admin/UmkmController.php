<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            'deskripsi' => $request->deskripsi,
            'alamat' => $request->alamat,
            'whatsapp' => $request->whatsapp,
            'kategori' => $request->kategori,
            'harga_mulai' => $request->harga_mulai,
            'status' => $request->status,
            'urutan' => $request->urutan ?? 0,
        ];

        // Handle gambar upload
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($umkm->gambar) {
                $this->deleteGambar($umkm->gambar);
            }
            $data['gambar'] = $this->uploadGambar($request->file('gambar'));
        }

        // Handle remove gambar
        if ($request->has('hapus_gambar') && $request->hapus_gambar) {
            if ($umkm->gambar) {
                $this->deleteGambar($umkm->gambar);
            }
            $data['gambar'] = null;
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
     * Menggunakan Storage disk 'public' untuk kompatibilitas shared hosting
     */
    private function uploadGambar($file)
    {
        // Generate unique filename
        $filename = 'umkm-' . time() . '-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        // Simpan ke storage/app/public/images/umkm/
        $path = $file->storeAs('images/umkm', $filename, 'public');
        
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
        
        // Hapus dari storage/app/public/images/umkm/
        Storage::disk('public')->delete('images/umkm/' . $filename);
    }
}
