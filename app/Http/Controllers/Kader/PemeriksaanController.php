<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Pemeriksaan;
use App\Models\Pengukuran;
use App\Models\Imunisasi;
use App\Models\JadwalKegiatan;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemeriksaanController extends Controller
{
    public function index()
    {
        $pemeriksaan = Pemeriksaan::with(['peserta', 'jadwalKegiatan', 'pengukuran', 'imunisasi'])
            ->latest()
            ->paginate(10);

        return view('kader.pemeriksaan.index', compact('pemeriksaan'));
    }

    public function create()
    {
        $jadwal = JadwalKegiatan::all();
        $peserta = Peserta::all();

        return view('kader.pemeriksaan.create', compact('jadwal', 'peserta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_kegiatan_id' => 'required|exists:jadwal_kegiatan,id',
            'peserta_id'         => 'required|exists:peserta,id',
            'tanggal_periksa'    => 'required|date',
            'berat_badan'        => 'required|numeric',
            'tinggi_badan'       => 'required|numeric',
            'lingkar_kepala'     => 'nullable|numeric',
            'lingkar_lengan'     => 'nullable|numeric',
            'jenis_vaksin'       => 'nullable|string',
            'vitamin'            => 'nullable|string',
            'obat_cacing'        => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Simpan Data Utama Pemeriksaan
            $pemeriksaan = Pemeriksaan::create([
                'jadwal_kegiatan_id' => $request->jadwal_kegiatan_id,
                'peserta_id'         => $request->peserta_id,
                'user_id'            => auth()->id(),
                'tanggal_periksa'    => $request->tanggal_periksa,
                'keluhan'            => $request->keluhan,
                'catatan'            => $request->catatan,
            ]);

            // 2. Simpan Data Pengukuran Fisik (BB/TB)
            Pengukuran::create([
                'pemeriksaan_id' => $pemeriksaan->id,
                'berat_badan'    => $request->berat_badan,
                'tinggi_badan'   => $request->tinggi_badan,
                'lingkar_kepala' => $request->lingkar_kepala,
                'lingkar_lengan' => $request->lingkar_lengan,
                'status_gizi'    => $request->status_gizi ?? 'Normal',
            ]);

            // 3. Simpan Data Imunisasi/Vitamin (Jika ada)
            if ($request->jenis_vaksin || $request->vitamin || $request->filled('obat_cacing')) {
                Imunisasi::create([
                    'pemeriksaan_id' => $pemeriksaan->id,
                    'jenis_vaksin'   => $request->jenis_vaksin,
                    'vitamin'        => $request->vitamin,
                    'obat_cacing'    => $request->boolean('obat_cacing'),
                    'keterangan'     => $request->keterangan_imunisasi,
                ]);
            }
        });

        return redirect()->route('kader.pemeriksaan.index')
            ->with('success', 'Data pemeriksaan posyandu berhasil disimpan.');
    }

    public function show(string $id)
    {
        $pemeriksaan = Pemeriksaan::with(['peserta', 'jadwalKegiatan', 'pengukuran', 'imunisasi'])->findOrFail($id);
        return view('kader.pemeriksaan.show', compact('pemeriksaan'));
    }

    public function destroy(string $id)
    {
        $pemeriksaan = Pemeriksaan::findOrFail($id);
        $pemeriksaan->delete();

        return redirect()->route('kader.pemeriksaan.index')
            ->with('success', 'Data pemeriksaan berhasil dihapus.');
    }
}