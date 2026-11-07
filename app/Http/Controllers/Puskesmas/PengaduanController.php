<?php

namespace App\Http\Controllers\Puskesmas;

use App\Http\Controllers\Controller;
use App\Http\Requests\RespondPengaduanRequest;
use App\Models\Puskesmas\Pengaduan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengaduanController extends Controller
{
    /**
     * Status yang tersedia. Harus sinkron dengan enum pada tabel `pengaduan`.
     */
    public const STATUS = ['baru', 'diproses', 'selesai'];

    public function index(Request $request): View
    {
        $pengaduan = $this->scopedQuery()
            ->with(['pelapor', 'posyandu'])
            ->when(
                $request->query('status'),
                fn (Builder $q, string $status) => $q->where('pengaduan.status', $status)
            )
            ->when(
                $request->query('search'),
                fn (Builder $q, string $search) => $q->whereRaw('LOWER(pengaduan.judul) LIKE ?', ['%' . strtolower($search) . '%'])
            )
            ->latest('pengaduan.created_at')
            ->get();

        return view('puskesmas.pengaduan.index', compact('pengaduan'));
    }

    public function show(string $pengaduan): View
    {
        $data = $this->scopedQuery()
            ->with(['pelapor', 'posyandu'])
            ->whereKey($pengaduan)
            ->firstOrFail();

        return view('puskesmas.pengaduan.show', compact('data'));
    }

    public function update(RespondPengaduanRequest $request, string $pengaduan): RedirectResponse
    {
        $data = $this->scopedQuery()->whereKey($pengaduan)->firstOrFail();

        if ($data->status === 'selesai') {
            return back()->with('error', 'Pengaduan ini sudah selesai dan tidak dapat diubah lagi.');
        }

        $data->update($request->validated());

        return redirect()
            ->route('puskesmas.pengaduan.show', $data->id)
            ->with('status', 'Tanggapan berhasil dikirim.');
    }

    /**
     * Batasi query hanya pengaduan milik Puskesmas pengguna.
     */
    private function scopedQuery(): Builder
    {
        return Pengaduan::query()
            ->whereHas('posyandu', fn (Builder $q) => $q->where('puskesmas_id', auth()->user()->puskesmas_id));
    }
}