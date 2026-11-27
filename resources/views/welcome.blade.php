<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SIPANDU membantu pemantauan tumbuh kembang dan kesehatan seluruh anggota keluarga.">
    <title>SIPANDU - Pantau Tumbuh Kembang Keluarga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans text-slate-900 antialiased">
    <div class="bg-teal-700 px-4 py-1.5 text-[10px] text-white/80">
        <div class="mx-auto flex max-w-6xl items-center justify-between">
            <span>Selamat datang di SIPANDU — Sistem Informasi Pemantauan Posyandu</span>
            <span class="hidden sm:inline">Emergency Hotline&nbsp;&nbsp; Pusat Layanan 24 Jam</span>
        </div>
    </div>

    <header class="border-b border-slate-100 bg-white">
        <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-5 sm:px-8">
            <x-sipandu-brand subtitle="Pemerintah Kota / Kabupaten" />
            <div class="flex items-center gap-3">
                <a href="#informasi" class="hidden text-xs font-semibold text-slate-600 hover:text-teal-700 sm:inline">Informasi</a>
                <a href="{{ route('login') }}" class="inline-flex rounded-md bg-teal-700 px-5 py-2.5 text-xs font-bold text-white transition hover:bg-teal-800">Masuk ke Akun</a>
            </div>
        </div>
    </header>

    <main>
        <section class="relative overflow-hidden" style="background: radial-gradient(circle at 78% 40%, #d7f2eb 0, #edf7f4 27%, #fff 68%);">
            <div class="mx-auto grid min-h-[500px] max-w-6xl items-center gap-10 px-5 py-12 sm:px-8 lg:grid-cols-[1fr_1fr]">
                <div class="max-w-[540px]">
                    <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-teal-100 bg-white px-3 py-1.5 text-[10px] font-bold text-teal-700 shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-teal-500"></span>
                        Badan / Sistem Informasi Pemerintah Kab. Bangka
                    </p>
                    <h1 class="text-[42px] font-black leading-[1.02] tracking-[-0.045em] text-slate-900 sm:text-[54px]">
                        Pantau Tumbuh<br>
                        Kembang &amp; Kesehatan<br>
                        <span class="text-teal-700">Seluruh Anggota</span><br>
                        Keluarga dari Mana<br>
                        Saja.
                    </h1>
                    <p class="mt-5 max-w-lg text-sm leading-6 text-slate-500">
                        Akses laporan KMS balita, status kehamilan ibu, dan riwayat kesehatan lansia secara terintegrasi dalam satu layanan digital Posyandu.
                    </p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('login') }}" class="inline-flex h-11 items-center rounded-md bg-teal-700 px-5 text-xs font-bold text-white shadow-md shadow-teal-700/15 hover:bg-teal-800">
                            Buka Akun Keluarga
                        </a>
                        <a href="#layanan" class="inline-flex h-11 items-center gap-2 rounded-md border border-slate-200 bg-white px-5 text-xs font-bold text-slate-700 hover:border-teal-200">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 2"/><circle cx="12" cy="12" r="9"/></svg>
                            Pelajari Posyandu
                        </a>
                    </div>
                    <div class="mt-8 flex flex-wrap gap-8 text-[10px] text-slate-500">
                        <div><strong class="block text-sm text-slate-900">100% Real-<br>Time</strong>Update data otomatis</div>
                        <div><strong class="block text-sm text-slate-900">Standar WHO</strong>Rujukan tumbuh kembang</div>
                        <div><strong class="block text-sm text-slate-900">Gratis &amp; Aman</strong>Data keluarga terlindungi</div>
                    </div>
                </div>

                <div class="relative hidden min-h-[420px] lg:block">
                    <div class="absolute right-2 top-16 h-[330px] w-[430px] rotate-[-1deg] overflow-hidden rounded-xl border-[10px] border-white bg-slate-200 shadow-[0_20px_50px_rgba(15,118,110,.18)]">
                        <img src="{{ asset('images/posyandu-hero.jpg') }}" alt="Layanan kesehatan keluarga" class="h-full w-full object-cover">
                    </div>
                    <div class="absolute right-[-24px] top-[54px] h-[270px] w-[300px] rounded-xl border border-slate-100 bg-white p-2 shadow-xl">
                        <img src="{{ asset('images/posyandu-anak.jpg') }}" alt="Pemantauan kesehatan anak" class="h-[205px] w-full rounded-lg object-cover">
                        <div class="mt-2 flex items-start gap-2">
                            <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-teal-100 text-teal-700">✓</span>
                            <div><strong class="block text-[9px]">Dashboard Kesehatan &amp; Anak</strong><span class="text-[8px] text-slate-400">KMS &amp; riwayat pemeriksaan</span></div>
                        </div>
                    </div>
                    <div class="absolute bottom-7 right-[-8px] rounded-lg border border-white/70 bg-teal-800/95 px-5 py-4 text-white shadow-xl">
                        <strong class="block text-[10px]">AKSES INFORMASI SEHAT</strong>
                        <span class="mt-1 block text-[8px] text-teal-100">Keluarga • Lansia • Ibu hamil • Balita</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="layanan" class="mx-auto max-w-6xl px-5 py-16 sm:px-8">
            <div class="mx-auto max-w-xl text-center">
                <p class="text-[9px] font-bold uppercase tracking-[0.18em] text-teal-700">LAYANAN KESEHATAN TERINTEGRASI</p>
                <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-900">Pemantauan Spesifik Sesuai Kebutuhan<br>Anggota Keluarga</h2>
                <p class="mt-3 text-[11px] leading-5 text-slate-500">SIPANDU mempermudah pemantauan kesehatan keluarga secara terpusat melalui fitur Posyandu yang mudah digunakan.</p>
            </div>
            <div class="mt-8 grid gap-5 md:grid-cols-3">
                @foreach ([
                    ['Pemeriksaan Balita', 'Posyandu Balita', 'Pemantauan tumbuh kembang, imunisasi, dan status gizi anak secara digital.', asset('images/posyandu-anak.jpg')],
                    ['Pemantauan Ibu Hamil', 'Pelayanan Bumil', 'Catatan pemeriksaan ibu hamil dan tindak lanjut kesehatan untuk dukungan layanan.', asset('images/posyandu-hero.jpg')],
                    ['Perawatan Lansia', 'Layanan Lansia', 'Pemantauan kesehatan lansia dan dokumentasi pemeriksaan secara terstruktur.', asset('images/posyandu-anak.jpg')],
                ] as $card)
                    <article class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-[0_8px_28px_rgba(15,118,110,.08)]">
                        <img src="{{ $card[3] }}" alt="{{ $card[0] }}" class="h-44 w-full object-cover">
                        <div class="p-5">
                            <p class="text-[9px] font-bold text-teal-700">{{ $card[1] }}</p>
                            <h3 class="mt-1 text-sm font-black">{{ $card[0] }}</h3>
                            <p class="mt-2 text-[10px] leading-5 text-slate-500">{{ $card[2] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="mx-auto max-w-6xl px-5 pb-16 sm:px-8">
            <div class="rounded-xl bg-slate-50 px-6 py-10 sm:px-10">
                <h2 class="text-2xl font-black tracking-tight">Fitur Lengkap yang Memudahkan<br>Keluarga Anda</h2>
                <div class="mt-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ([
                        ['Kartu Keluarga & Pendaftaran Anggota', 'Kelola profil keluarga, KK, dan identitas anggota secara aman.'],
                        ['Jadwal Pemeriksaan Posyandu', 'Lihat jadwal kegiatan dan pemeriksaan kesehatan di posyandu.'],
                        ['Riwayat & Laporan Medis', 'Akses riwayat pemeriksaan anggota keluarga kapan saja.'],
                        ['Sekatan Keamanan dan Wilayah', 'Hak akses dilindungi sesuai peran pengguna dalam layanan.'],
                        ['Materi Edukasi Kesehatan', 'Dapatkan edukasi gizi, tumbuh kembang, serta pola hidup sehat.'],
                        ['Pemantauan Kesehatan Keluarga', 'Pantau kondisi balita, bumil, lansia, dan hasil tindak lanjut.'],
                    ] as $feature)
                        <article class="rounded-lg border border-slate-100 bg-white p-5 shadow-sm">
                            <span class="grid h-8 w-8 place-items-center rounded-md bg-teal-50 text-sm text-teal-700">✓</span>
                            <h3 class="mt-3 text-xs font-black">{{ $feature[0] }}</h3>
                            <p class="mt-2 text-[10px] leading-5 text-slate-500">{{ $feature[1] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-6xl px-5 pb-16 sm:px-8">
            <div class="mx-auto max-w-xl text-center">
                <p class="text-[9px] font-bold uppercase tracking-[0.18em] text-teal-700">AKSES MUDAH TANPA RIBET</p>
                <h2 class="mt-2 text-2xl font-black tracking-tight">Cara Menggunakan Portal SIPANDU</h2>
                <p class="mt-2 text-[10px] text-slate-500">Mulai dari pendaftaran keluarga hingga memantau hasil pemeriksaan.</p>
            </div>
            <div class="mt-7 grid gap-4 md:grid-cols-4">
                @foreach ([
                    ['1', 'Daftar Akun', 'Hubungi kader untuk mendaftarkan keluarga dan menerima akses awal.'],
                    ['2', 'Masuk Ke Akun', 'Masuk menggunakan email atau nomor KK serta kata sandi.'],
                    ['3', 'Isi & Cek Data', 'Perbarui data keluarga dan periksa riwayat pemeriksaan.'],
                    ['4', 'Pantau Sehat', 'Ikuti jadwal posyandu dan tindak lanjut yang diberikan tenaga kesehatan.'],
                ] as $step)
                    <article class="rounded-lg border border-slate-100 bg-white p-5">
                        <span class="grid h-8 w-8 place-items-center rounded-md bg-teal-700 text-xs font-black text-white">{{ $step[0] }}</span>
                        <h3 class="mt-4 text-xs font-black">{{ $step[1] }}</h3>
                        <p class="mt-2 text-[10px] leading-5 text-slate-500">{{ $step[2] }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <section id="informasi" class="mx-auto max-w-6xl px-5 pb-16 sm:px-8">
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.18em] text-teal-700">EDUKASI DAN INFORMASI KESEHATAN</p>
                    <h2 class="mt-2 text-2xl font-black tracking-tight">Edukasi &amp; Informasi Kesehatan Warga</h2>
                    <p class="mt-2 text-[10px] text-slate-500">Informasi kesehatan terpercaya untuk keluarga dan masyarakat.</p>
                </div>
                <div class="hidden gap-2 sm:flex">
                    <span class="rounded-full bg-teal-700 px-3 py-1.5 text-[9px] font-bold text-white">Populer</span>
                    <span class="rounded-full border border-slate-200 px-3 py-1.5 text-[9px] text-slate-500">Gizi</span>
                    <span class="rounded-full border border-slate-200 px-3 py-1.5 text-[9px] text-slate-500">Posyandu</span>
                </div>
            </div>
            <div class="mt-7 grid gap-5 md:grid-cols-[1.4fr_1fr]">
                <article class="relative min-h-[220px] overflow-hidden rounded-xl bg-teal-800 p-7 text-white">
                    <div class="relative z-[1] max-w-sm">
                        <p class="text-[9px] text-teal-100">Edukasi Kesehatan Keluarga</p>
                        <h3 class="mt-3 text-xl font-black">Tingkatkan Pengetahuan Kesehatan Keluarga<br>Bersama Posyandu</h3>
                        <p class="mt-3 text-[10px] leading-5 text-teal-50/75">Pelajari pola gizi, imunisasi, tanda bahaya, dan jadwal pemeriksaan yang sesuai kebutuhan keluarga.</p>
                        <a href="{{ route('login') }}" class="mt-5 inline-flex rounded-md bg-white px-4 py-2 text-[10px] font-bold text-teal-800">Baca Edukasi</a>
                    </div>
                </article>
                <article class="relative min-h-[220px] overflow-hidden rounded-xl bg-teal-800 p-7 text-white">
                    <p class="text-[9px] text-teal-100">Mari Mulai Dari Keluarga</p>
                    <h3 class="mt-3 max-w-sm text-xl font-black">Mulai Pantau Kesehatan<br>Seluruh Anggota<br>Keluarga Sekarang</h3>
                    <p class="mt-3 max-w-sm text-[10px] leading-5 text-teal-50/75">Terhubung dengan kader dan tenaga kesehatan secara lebih cepat.</p>
                    <div class="mt-5 flex flex-wrap gap-2">
                        <a href="{{ route('login') }}" class="rounded-md bg-white px-4 py-2 text-[10px] font-bold text-teal-800">Masuk ke Akun</a>
                        <a href="{{ route('register') }}" class="rounded-md border border-white/20 px-4 py-2 text-[10px] font-bold text-white">Daftar Kader/Keluarga</a>
                    </div>
                </article>
            </div>
        </section>
    </main>

    <footer class="bg-[#065f46] text-slate-300">
        <div class="mx-auto grid max-w-6xl gap-8 px-5 py-10 sm:px-8 md:grid-cols-[1.5fr_1fr_1fr_1.2fr]">
            <div>
                <x-sipandu-brand subtitle="Pemantauan Posyandu" light />
                <p class="mt-4 max-w-xs text-[9px] leading-5 text-slate-400">Platform digital untuk mendukung pelayanan kesehatan keluarga dan pemantauan kegiatan Posyandu.</p>
            </div>
            <div><h3 class="text-[10px] font-bold text-white">LAYANAN PUBLIK</h3><div class="mt-3 space-y-2 text-[9px]"><p>Pemeriksaan Kesehatan</p><p>Jadwal Posyandu</p><p>Edukasi Keluarga</p></div></div>
            <div><h3 class="text-[10px] font-bold text-white">INFORMASI</h3><div class="mt-3 space-y-2 text-[9px]"><p>Tentang SIPANDU</p><p>Layanan Posyandu</p><p>Kontak Dinas</p></div></div>
            <div><h3 class="text-[10px] font-bold text-white">KONTAK &amp; BANTUAN</h3><div class="mt-3 space-y-2 text-[9px]"><p>Dinas Kesehatan Kabupaten</p><p>Helpdesk SIPANDU</p><p>Hubungi Kader Posyandu</p></div></div>
        </div>
        <div class="border-t border-white/10">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-5 py-4 text-[8px] text-slate-500 sm:px-8">
                <span>© 2026 SIPANDU. Semua hak dilindungi.</span>
                <span>Kebijakan Privasi&nbsp;&nbsp; Syarat &amp; Ketentuan</span>
            </div>
        </div>
    </footer>
</body>
</html>
