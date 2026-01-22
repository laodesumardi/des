<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Display a listing of berita.
     */
    public function index(Request $request)
    {
        $query = Berita::with('user')->latest();

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
                  ->orWhere('konten', 'like', '%' . $request->search . '%');
            });
        }

        $berita = $query->paginate(10)->withQueryString();
        $kategoriList = Berita::getKategori();

        return view('admin.berita.index', compact('berita', 'kategoriList'));
    }

    /**
     * Show the form for creating a new berita.
     */
    public function create()
    {
        $kategoriList = Berita::getKategori();
        return view('admin.berita.create', compact('kategoriList'));
    }

    /**
     * Store a newly created berita.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'nullable|string|max:500',
            'konten' => 'required|string',
            'kategori' => 'required|string',
            'status' => 'required|in:draft,published',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = [
            'judul' => $request->judul,
            'ringkasan' => $request->ringkasan,
            'konten' => $request->konten,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ];

        // Set published_at jika status published
        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        // Handle gambar upload
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $this->uploadGambar($request->file('gambar'));
        }

        Berita::create($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified berita.
     */
    public function edit(Berita $beritum)
    {
        $berita = $beritum; // Laravel auto-binds 'beritum' for 'berita' resource
        $kategoriList = Berita::getKategori();
        return view('admin.berita.edit', compact('berita', 'kategoriList'));
    }

    /**
     * Update the specified berita.
     */
    public function update(Request $request, Berita $beritum)
    {
        $berita = $beritum;

        $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'nullable|string|max:500',
            'konten' => 'required|string',
            'kategori' => 'required|string',
            'status' => 'required|in:draft,published',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = [
            'judul' => $request->judul,
            'ringkasan' => $request->ringkasan,
            'konten' => $request->konten,
            'kategori' => $request->kategori,
            'status' => $request->status,
        ];

        // Set published_at jika status berubah ke published
        if ($request->status === 'published' && $berita->status !== 'published') {
            $data['published_at'] = now();
        }

        // Handle gambar upload
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($berita->gambar) {
                $this->deleteGambar($berita->gambar);
            }
            $data['gambar'] = $this->uploadGambar($request->file('gambar'));
        }

        // Handle remove gambar
        if ($request->has('hapus_gambar') && $request->hapus_gambar) {
            if ($berita->gambar) {
                $this->deleteGambar($berita->gambar);
            }
            $data['gambar'] = null;
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified berita.
     */
    public function destroy(Berita $beritum)
    {
        $berita = $beritum;

        // Delete gambar if exists
        if ($berita->gambar) {
            $this->deleteGambar($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus!');
    }

    /**
     * Upload gambar berita
     * Menyimpan langsung ke public/images/berita/ untuk akses langsung tanpa symlink
     */
    private function uploadGambar($file)
    {
        // Generate unique filename
        $filename = 'berita-' . time() . '-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        // Simpan langsung ke public/images/berita/
        $destinationPath = public_path('images/berita');
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        
        $file->move($destinationPath, $filename);
        
        // Return hanya filename untuk disimpan di database
        return $filename;
    }

    /**
     * Delete gambar berita
     */
    private function deleteGambar($filename)
    {
        if (empty($filename)) {
            return;
        }
        
        // Hapus dari public/images/berita/
        $filePath = public_path('images/berita/' . $filename);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
