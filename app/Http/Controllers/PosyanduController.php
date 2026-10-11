<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePosyanduRequest;
use App\Models\Posyandu;
use Illuminate\Http\JsonResponse;

class PosyanduController extends Controller
{
    public function index(): JsonResponse
    {
        $posyandu = Posyandu::where('puskesmas_id', auth()->user()->puskesmas_id)
            ->withCount('pengaduans')
            ->latest()
            ->get();

        return response()->json($posyandu);
    }

    public function store(StorePosyanduRequest $request): JsonResponse
    {
        $posyandu = Posyandu::create(
            $request->validated() + ['puskesmas_id' => auth()->user()->puskesmas_id]
        );

        return response()->json($posyandu, 201);
    }

    public function show(string $posyandu): JsonResponse
    {
        return response()->json($this->findOwnedPosyandu($posyandu)->load('pengaduans.pelapor'));
    }

    public function update(StorePosyanduRequest $request, string $posyandu): JsonResponse
    {
        $data = $this->findOwnedPosyandu($posyandu);
        $data->update($request->validated());

        return response()->json($data->fresh());
    }

    public function destroy(string $posyandu): JsonResponse
    {
        $this->findOwnedPosyandu($posyandu)->delete();

        return response()->json(null, 204);
    }

    private function findOwnedPosyandu(string $id): Posyandu
    {
        return Posyandu::where('puskesmas_id', auth()->user()->puskesmas_id)
            ->findOrFail($id);
    }
}
