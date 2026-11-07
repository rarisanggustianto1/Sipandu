<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use Illuminate\Http\Request;

class EdukasiController extends Controller
{
    /**
     * Menampilkan daftar edukasi & materi kesehatan untuk Peserta (Read-Only).
     */
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');

        // Query dari database jika tabel edukasi ada isinya
        $query = Edukasi::query();

        // Hanya tampilkan yang aktif jika field status_aktif ada
        try {
            $query->where('status_aktif', true);
            if ($kategori && $kategori !== 'semua') {
                $query->where('kategori', $kategori);
            }
            $artikels = $query->latest('tanggal_publikasi')->paginate(9);
        } catch (\Throwable $e) {
            $artikels = collect([]);
        }

        return view('peserta.edukasi.index', compact('artikels', 'kategori'));
    }

    /**
     * Menampilkan detail materi edukasi (Read-Only).
     */
    public function show($id)
    {
        try {
            $edukasi = Edukasi::findOrFail($id);
        } catch (\Throwable $e) {
            $edukasi = null;
        }

        return view('peserta.edukasi.show', compact('edukasi', 'id'));
    }
}
