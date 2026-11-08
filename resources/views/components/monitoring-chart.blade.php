@props(['title', 'unit', 'metric', 'points'])

@php
    $values = collect($points)
        ->filter(fn (array $point): bool => is_numeric($point['values'][$metric] ?? null))
        ->values();
    $minimum = $values->isEmpty() ? 0 : (float) $values->min(fn (array $point): float => (float) $point['values'][$metric]);
    $maximum = $values->isEmpty() ? 0 : (float) $values->max(fn (array $point): float => (float) $point['values'][$metric]);
    $range = max($maximum - $minimum, 0.1);
    $coordinates = $values->map(function (array $point, int $index) use ($values, $minimum, $range, $metric): array {
        $x = $values->count() === 1 ? 200 : 32 + ($index * 336 / ($values->count() - 1));
        $y = 156 - (((float) $point['values'][$metric] - $minimum) / $range * 112);

        return [
            'x' => round($x, 1),
            'y' => round($y, 1),
            'value' => round((float) $point['values'][$metric], 1),
            'label' => $point['label'],
            'date' => $point['tanggal'],
        ];
    });
@endphp

<article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h3 class="font-bold text-slate-900">{{ $title }}</h3>
            <p class="mt-1 text-xs text-slate-500">Rata-rata per pertemuan ({{ $unit }})</p>
        </div>
        <span class="rounded-lg bg-teal-50 px-2.5 py-1 text-xs font-bold text-teal-800">{{ $values->count() }} titik</span>
    </div>

    @if ($values->isEmpty())
        <p class="mt-5 rounded-xl bg-slate-50 p-4 text-sm text-slate-500">Belum ada nilai untuk parameter ini.</p>
    @else
        <svg viewBox="0 0 400 205" role="img" aria-label="{{ $title }} per pertemuan" class="mt-4 h-52 w-full">
            <line x1="24" y1="156" x2="376" y2="156" stroke="#cbd5e1" stroke-width="1" />
            @if ($coordinates->count() > 1)
                <polyline points="{{ $coordinates->map(fn (array $point): string => $point['x'].','.$point['y'])->implode(' ') }}" fill="none" stroke="#0f766e" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            @endif
            @foreach ($coordinates as $index => $point)
                <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="5" fill="#0f766e" />
                <text x="{{ $point['x'] }}" y="180" text-anchor="middle" fill="#64748b" font-size="11">P{{ $index + 1 }}</text>
            @endforeach
        </svg>
        <div class="mt-3 space-y-2 border-t border-slate-100 pt-3">
            @foreach ($coordinates as $index => $point)
                <div class="flex items-center justify-between gap-3 text-xs">
                    <span class="min-w-0 truncate text-slate-600">P{{ $index + 1 }} · {{ $point['label'] }} · {{ $point['date'] }}</span>
                    <span class="shrink-0 font-bold text-slate-800">{{ number_format($point['value'], 1) }} {{ $unit }}</span>
                </div>
            @endforeach
        </div>
    @endif
</article>
