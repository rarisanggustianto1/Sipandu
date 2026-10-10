<?php

namespace App\Http\Controllers;

use App\Http\Requests\RespondPengaduanRequest;
use App\Models\Pengaduan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $pengaduan = Pengaduan::whereHas('posyandu', function ($query) {
            $query->where('puskesmas_id', auth()->user()->puskesmas_id);
        })
            ->with(['pelapor', 'posyandu'])
            ->when($request->query('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->query('search'), function ($query, $search) {
                $query->where('judul', 'ilike', "%{$search}%");
            })
            ->latest()
            ->get();

        return response()->json($pengaduan);
    }

    public function show(string $pengaduan): JsonResponse
    {
        $data = $this->findOwnedPengaduan($pengaduan);

        return response()->json($data->load(['pelapor', 'posyandu']));
    }

    public function update(RespondPengaduanRequest $request, string $pengaduan): JsonResponse
    {
        $data = $this->findOwnedPengaduan($pengaduan);

        if ($data->status === 'selesai') {
            return response()->json([
                'message' => 'Pengaduan sudah selesai dan tidak dapat diubah lagi.',
            ], 409);
        }

        $data->update($request->validated());

        return response()->json($data->fresh());
    }

    private function findOwnedPengaduan(string $id): Pengaduan
    {
        // Scoping: hanya pengaduan dari posyandu milik puskesmas yang login
        return Pengaduan::whereHas('posyandu', function ($query) {
            $query->where('puskesmas_id', auth()->user()->puskesmas_id);
        })->findOrFail($id);
    }
}
