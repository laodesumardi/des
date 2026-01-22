<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanLayanan;
use Illuminate\Http\Request;

class PengajuanLayananController extends Controller
{
    /**
     * Display a listing of pengajuan layanan
     */
    public function index(Request $request)
    {
        $query = PengajuanLayanan::latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by jenis layanan
        if ($request->filled('jenis_layanan')) {
            $query->where('jenis_layanan', $request->jenis_layanan);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }

        $pengajuan = $query->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total' => PengajuanLayanan::count(),
            'masuk' => PengajuanLayanan::where('status', 'masuk')->count(),
            'diproses' => PengajuanLayanan::where('status', 'diproses')->count(),
            'selesai' => PengajuanLayanan::where('status', 'selesai')->count(),
            'ditolak' => PengajuanLayanan::where('status', 'ditolak')->count(),
        ];

        $jenisLayananList = PengajuanLayanan::getJenisLayanan();

        return view('admin.pengajuan-layanan.index', compact('pengajuan', 'stats', 'jenisLayananList'));
    }

    /**
     * Display the specified pengajuan layanan
     */
    public function show(PengajuanLayanan $pengajuanLayanan)
    {
        $jenisLayananList = PengajuanLayanan::getJenisLayanan();
        return view('admin.pengajuan-layanan.show', compact('pengajuanLayanan', 'jenisLayananList'));
    }

    /**
     * Update status pengajuan layanan
     */
    public function updateStatus(Request $request, PengajuanLayanan $pengajuanLayanan)
    {
        $request->validate([
            'status' => 'required|in:masuk,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $pengajuanLayanan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
            'user_id' => auth()->id(),
            'diproses_at' => now(),
        ]);

        return redirect()->route('admin.pengajuan-layanan.show', $pengajuanLayanan)
            ->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    /**
     * Remove the specified pengajuan layanan
     */
    public function destroy(PengajuanLayanan $pengajuanLayanan)
    {
        // Hapus berkas jika ada
        if ($pengajuanLayanan->berkas) {
            $path = public_path('uploads/layanan/' . $pengajuanLayanan->berkas);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $pengajuanLayanan->delete();

        return redirect()->route('admin.pengajuan-layanan.index')
            ->with('success', 'Pengajuan layanan berhasil dihapus.');
    }
}
