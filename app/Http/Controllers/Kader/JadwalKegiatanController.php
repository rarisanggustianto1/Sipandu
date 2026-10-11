<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\JadwalKegiatan;
use App\Models\Posyandu;
use Illuminate\Http\Request;

class JadwalKegiatanController extends Controller
{
    public function index()
    {
        $jadwal = JadwalKegiatan::with('posyandu')->latest('tanggal_kegiatan')->paginate(10);
        return view('kader.jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $posyandu = Posyandu::all();
        return view('kader.jadwal.create', compact('posyandu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'posyandu_id'      => 'required|exists:posyandu,id',
            'nama_kegiatan'    => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'jam_mulai'        => 'required',
            'jam_selesai'      => 'required',
            'lokasi'           => 'required|string',
            'keterangan'       => 'nullable|string',
        ]);

        JadwalKegiatan::create($request->all());

        return redirect()->route('kader.jadwal.index')
            ->with('success', 'Jadwal kegiatan posyandu berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $jadwal = JadwalKegiatan::with(['posyandu', 'pemeriksaan.peserta'])->findOrFail($id);
        return view('kader.jadwal.show', compact('jadwal'));
    }

    public function edit(string $id)
    {
        $jadwal = JadwalKegiatan::findOrFail($id);
        $posyandu = Posyandu::all();
        return view('kader.jadwal.edit', compact('jadwal', 'posyandu'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'posyandu_id'      => 'required|exists:posyandu,id',
            'nama_kegiatan'    => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'jam_mulai'        => 'required',
            'jam_selesai'      => 'required',
            'lokasi'           => 'required|string',
            'keterangan'       => 'nullable|string',
        ]);

        $jadwal = JadwalKegiatan::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->route('kader.jadwal.index')
            ->with('success', 'Jadwal kegiatan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $jadwal = JadwalKegiatan::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('kader.jadwal.index')
            ->with('success', 'Jadwal kegiatan berhasil dihapus.');
    }
}