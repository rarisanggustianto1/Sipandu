<?php

namespace App\Http\Controllers\Dinas;

use App\Http\Controllers\Controller;
use App\Models\Dinas\Edukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Smalot\PdfParser\Parser;

class EdukasiController extends Controller
{
    public function index()
    {
        $edukasi = Edukasi::latest()->paginate(10);

        return view('dinas.edukasi.index', compact('edukasi'));
    }

    public function create()
    {
        return view('dinas.edukasi.create');
    }

    public function importPdf(Request $request)
    {
        $request->validate([
            'pdf' => [
                'required',
                'file',
                'mimes:pdf',
                'max:10240',
            ],
        ]);

        $parser = new Parser();

        try {
            $pdf = $parser->parseFile(
                $request->file('pdf')->getRealPath()
            );

            $isi = trim($pdf->getText());
        } catch (\Throwable $e) {
            return back()->withErrors([
                'pdf' => 'PDF tidak dapat dibaca. Gunakan PDF berbasis teks yang valid.',
            ]);
        }

        if ($isi === '') {
            return back()->withErrors([
                'pdf' => 'Teks PDF tidak ditemukan. PDF hasil scan membutuhkan OCR.',
            ]);
        }

        return redirect()
            ->route('dinas.edukasi.create')
            ->withInput([
                'judul' => $request->input('judul', ''),
                'isi' => $isi,
                'kategori' => $request->input('kategori', 'umum'),
                'status_aktif' => $request->input('status_aktif', '0'),
                'tanggal_publikasi' => $request->input('tanggal_publikasi', ''),
            ])
            ->with('success', 'PDF berhasil diimpor. Periksa dan edit isi artikel sebelum menyimpan.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => [
                'required',
                Rule::in(['umum', 'balita', 'ibu_hamil', 'lansia']),
            ],
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'tanggal_publikasi' => 'nullable|date',
            'status_aktif' => 'required|boolean',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')
                ->store('edukasi', 'public');
        }

        Edukasi::create($validated);

        return redirect()
            ->route('dinas.edukasi.index')
            ->with('success', 'Artikel edukasi berhasil ditambahkan.');
    }

    public function edit(Edukasi $edukasi)
    {
        return view('dinas.edukasi.edit', compact('edukasi'));
    }

    public function update(Request $request, Edukasi $edukasi)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => [
                'required',
                Rule::in(['umum', 'balita', 'ibu_hamil', 'lansia']),
            ],
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'tanggal_publikasi' => 'nullable|date',
            'status_aktif' => 'required|boolean',
        ]);

        if ($request->hasFile('gambar')) {
            $newImage = $request->file('gambar')
                ->store('edukasi', 'public');

            $oldImage = $edukasi->gambar;

            $validated['gambar'] = $newImage;

            $edukasi->update($validated);

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        } else {
            unset($validated['gambar']);
            $edukasi->update($validated);
        }

        return redirect()
            ->route('dinas.edukasi.index')
            ->with('success', 'Artikel edukasi berhasil diperbarui.');
    }

    public function destroy(Edukasi $edukasi)
    {
        $gambar = $edukasi->gambar;

        $edukasi->delete();

        if ($gambar) {
            Storage::disk('public')->delete($gambar);
        }

        return redirect()
            ->route('dinas.edukasi.index')
            ->with('success', 'Artikel edukasi berhasil dihapus.');
    }
}
