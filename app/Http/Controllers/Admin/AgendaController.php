<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::with('user')->orderBy('tanggal_mulai', 'desc');

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('kategori') && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        $agenda = $query->paginate(15)->withQueryString();
        $kategoriList = Agenda::getKategori();

        return view('admin.agenda.index', compact('agenda', 'kategoriList'));
    }

    public function create()
    {
        $kategoriList = Agenda::getKategori();
        return view('admin.agenda.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:2000',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
            'lokasi' => 'nullable|string|max:255',
            'kategori' => 'required|string',
            'status' => 'required|in:akan_datang,berlangsung,selesai,dibatalkan',
        ]);

        Agenda::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'lokasi' => $request->lokasi,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil ditambahkan!');
    }

    public function edit(Agenda $agenda)
    {
        $kategoriList = Agenda::getKategori();
        return view('admin.agenda.edit', compact('agenda', 'kategoriList'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:2000',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
            'lokasi' => 'nullable|string|max:255',
            'kategori' => 'required|string',
            'status' => 'required|in:akan_datang,berlangsung,selesai,dibatalkan',
        ]);

        $data = [
            'judul' => $request->judul,
            'tanggal_mulai' => $request->tanggal_mulai,
            'kategori' => $request->kategori,
            'status' => $request->status,
        ];

        // Handle field nullable - hanya update jika diisi, jika kosong tetap null
        if ($request->has('deskripsi')) {
            $data['deskripsi'] = $request->deskripsi ?: null;
        }

        if ($request->has('tanggal_selesai')) {
            $data['tanggal_selesai'] = $request->tanggal_selesai ?: null;
        }

        if ($request->has('waktu_mulai')) {
            $data['waktu_mulai'] = $request->waktu_mulai ?: null;
        }

        if ($request->has('waktu_selesai')) {
            $data['waktu_selesai'] = $request->waktu_selesai ?: null;
        }

        if ($request->has('lokasi')) {
            $data['lokasi'] = $request->lokasi ?: null;
        }

        $agenda->update($data);

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil diperbarui!');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();
        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil dihapus!');
    }
}
