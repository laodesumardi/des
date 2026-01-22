<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GaleriController extends Controller
{
    /**
     * Display a listing of galeri.
     */
    public function index(Request $request)
    {
        $query = Galeri::with('user')->orderBy('urutan')->latest();

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
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        $galeri = $query->paginate(12)->withQueryString();
        $kategoriList = Galeri::getKategori();

        return view('admin.galeri.index', compact('galeri', 'kategoriList'));
    }

    /**
     * Show the form for creating a new galeri.
     */
    public function create()
    {
        $kategoriList = Galeri::getKategori();
        return view('admin.galeri.create', compact('kategoriList'));
    }

    /**
     * Store a newly created galeri.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'kategori' => 'required|string',
            'status' => 'required|in:draft,published',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'user_id' => Auth::id(),
            'urutan' => $request->urutan ?? 0,
        ];

        // Handle gambar upload
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $this->uploadGambar($request->file('gambar'));
        }

        Galeri::create($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto berhasil ditambahkan ke galeri!');
    }

    /**
     * Show the form for editing the specified galeri.
     */
    public function edit(Galeri $galeri)
    {
        $kategoriList = Galeri::getKategori();
        return view('admin.galeri.edit', compact('galeri', 'kategoriList'));
    }

    /**
     * Update the specified galeri.
     */
    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'kategori' => 'required|string',
            'status' => 'required|in:draft,published',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $data = [
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'urutan' => $request->urutan ?? 0,
        ];

        // Handle deskripsi - hanya update jika diisi, jika kosong tetap null
        if ($request->has('deskripsi')) {
            $data['deskripsi'] = $request->deskripsi ?: null;
        }

        // Handle gambar upload
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($galeri->gambar) {
                $this->deleteGambar($galeri->gambar);
            }
            $data['gambar'] = $this->uploadGambar($request->file('gambar'));
        }
        // Jika tidak ada file baru, pertahankan gambar lama
        // Gambar tetap menggunakan yang lama

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto galeri berhasil diperbarui!');
    }

    /**
     * Remove the specified galeri.
     */
    public function destroy(Galeri $galeri)
    {
        // Delete gambar if exists
        if ($galeri->gambar) {
            $this->deleteGambar($galeri->gambar);
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto galeri berhasil dihapus!');
    }

    /**
     * Upload gambar galeri
     * Menyimpan langsung ke public/images/galeri/ untuk akses langsung tanpa symlink
     */
    private function uploadGambar($file)
    {
        // Generate unique filename
        $filename = 'galeri-' . time() . '-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        // Simpan langsung ke public/images/galeri/
        $destinationPath = public_path('images/galeri');
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        
        $file->move($destinationPath, $filename);
        
        // Return hanya filename untuk disimpan di database
        return $filename;
    }

    /**
     * Delete gambar galeri
     */
    private function deleteGambar($filename)
    {
        if (empty($filename)) {
            return;
        }
        
        // Hapus dari public/images/galeri/
        $filePath = public_path('images/galeri/' . $filename);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
