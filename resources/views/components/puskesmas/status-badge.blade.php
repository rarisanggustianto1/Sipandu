@props(['status'])

@php
    /*
    | Badge status pengaduan.
    |
    | Kunci WAJIB sinkron dengan enum pada tabel `pengaduan`
    | dan dengan PengaduanController::STATUS.
    */
    $meta = [
        'baru' => ['label' => 'Baru', 'class' => 'bg-amber-100 text-amber-800'],
        'diproses' => ['label' => 'Diproses', 'class' => 'bg-blue-100 text-blue-800'],
        'selesai' => ['label' => 'Selesai', 'class' => 'bg-emerald-100 text-emerald-800'],
    ];

    $current = $meta[$status] ?? ['label' => ucfirst((string) $status), 'class' => 'bg-gray-100 text-gray-700'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-block rounded px-2 py-1 text-xs font-medium ' . $current['class']]) }}>
    {{ $current['label'] }}
</span>