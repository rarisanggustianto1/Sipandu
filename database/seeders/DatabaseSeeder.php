<?php

namespace Database\Seeders;

use App\Models\Dinas\DinasKesehatan;
use App\Models\Dinas\Edukasi;
use App\Models\Peserta\Keluarga;
use App\Models\Kader\Kegiatan;
use App\Models\Kader\Pemeriksaan;
use App\Models\Kader\PemeriksaanBalita;
use App\Models\Peserta\Peserta;
use App\Models\Puskesmas\Puskesmas;
use App\Models\Puskesmas\Posyandu;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $dinas = DinasKesehatan::firstOrCreate([
            'nama_dinas' => 'Dinas Kesehatan Demo',
        ]);

        $puskesmas = Puskesmas::firstOrCreate(
            ['nama_puskesmas' => 'Puskesmas Demo'],
            [
                'dinas_kesehatan_id' => $dinas->id,
                'alamat' => 'Alamat Puskesmas Demo',
                'kecamatan' => 'Kecamatan Demo',
            ],
        );

        $posyandu = Posyandu::firstOrCreate(
            ['nama_posyandu' => 'Posyandu Demo'],
            [
                'puskesmas_id' => $puskesmas->id,
                'alamat' => 'Alamat Posyandu Demo',
                'kelurahan' => 'Kelurahan Demo',
                'kecamatan' => 'Kecamatan Demo',
            ],
        );

        $keluarga = Keluarga::firstOrCreate(
            ['no_kk' => '0000000000000001'],
            [
                'posyandu_id' => $posyandu->id,
                'nama_kepala_keluarga' => 'Keluarga Demo',
                'alamat' => 'Alamat Keluarga Demo',
            ],
        );

        // Demo Peserta dalam Keluarga
        $balita = Peserta::firstOrCreate(
            ['nik' => '1871010101240001'],
            [
                'keluarga_id' => $keluarga->id,
                'nama' => 'Sinta',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => now()->subMonths(24)->toDateString(),
                'kategori' => 'balita',
            ]
        );

        $bumil = Peserta::firstOrCreate(
            ['nik' => '1871010101960002'],
            [
                'keluarga_id' => $keluarga->id,
                'nama' => 'Siti Aminah',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => now()->subYears(28)->toDateString(),
                'kategori' => 'ibu_hamil',
            ]
        );

        $lansia = Peserta::firstOrCreate(
            ['nik' => '1871010101560003'],
            [
                'keluarga_id' => $keluarga->id,
                'nama' => 'Budi Santoso',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => now()->subYears(68)->toDateString(),
                'kategori' => 'lansia',
            ]
        );

        // Sample Kegiatan
        Kegiatan::firstOrCreate(
            ['nama_kegiatan' => 'Pelayanan Posyandu Rutin'],
            [
                'posyandu_id' => $posyandu->id,
                'jenis_kegiatan' => 'Posyandu Rutin',
                'deskripsi' => 'Penimbangan balita, imunisasi, dan penyuluhan gizi.',
                'tanggal_kegiatan' => now()->addDays(5)->toDateString(),
                'waktu_mulai' => '08:30:00',
                'lokasi' => 'Balai Posyandu Demo',
                'status' => 'terjadwal',
            ]
        );

        // Sample Pemeriksaan Balita
        $pemeriksaan = Pemeriksaan::firstOrCreate(
            [
                'peserta_id' => $balita->id,
                'tanggal_pemeriksaan' => now()->subMonth()->toDateString(),
            ],
            [
                'keluhan' => 'Nafsu makan agak menurun',
                'catatan' => 'Pertumbuhan baik, tingkatkan asupan protein.',
            ]
        );

        PemeriksaanBalita::firstOrCreate(
            ['pemeriksaan_id' => $pemeriksaan->id],
            [
                'berat_badan' => 11.5,
                'tinggi_badan' => 85.0,
                'lingkar_kepala' => 47.0,
                'perkembangan' => 'Sesuai Usia',
                'catatan_gizi' => 'Gizi Baik',
            ]
        );

        // Sample Edukasi
        Edukasi::firstOrCreate(
            ['judul' => 'Pentingnya ASI Eksklusif dan MPASI Bergizi'],
            [
                'isi' => 'Pemberian ASI eksklusif selama 6 bulan pertama sangat penting untuk perkembangan daya tahan tubuh bayi...',
                'kategori' => 'balita',
                'tanggal_publikasi' => now()->toDateString(),
                'status_aktif' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'kader@gmail.com'],
            [
                'name' => 'Kader Posyandu',
                'password' => bcrypt('password123'),
                'role' => 'kader',
                'puskesmas_id' => $puskesmas->id,
                'posyandu_id' => $posyandu->id,
            ],
        );

        User::updateOrCreate(
            ['email' => 'dinas@gmail.com'],
            [
                'name' => 'Dinas Kesehatan',
                'password' => bcrypt('password123'),
                'role' => 'dinas_kesehatan',
                'dinas_kesehatan_id' => $dinas->id,
            ],
        );

        User::updateOrCreate(
            ['email' => 'puskesmas@gmail.com'],
            [
                'name' => 'Petugas Puskesmas',
                'password' => bcrypt('password123'),
                'role' => 'tenaga_kesehatan',
                'puskesmas_id' => $puskesmas->id,
            ],
        );

        User::updateOrCreate(
            ['email' => 'peserta@gmail.com'],
            [
                'name' => 'Peserta Posyandu',
                'password' => bcrypt('password123'),
                'role' => 'keluarga',
                'posyandu_id' => $posyandu->id,
                'keluarga_id' => $keluarga->id,
            ],
        );
    }
}
