@props([
    'label',
    'value' => null,
    'unit' => null,
    'date' => null,
])

<article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $label }}</p>
    <p class="mt-2 text-2xl font-black tracking-tight text-slate-900">
        @if ($value !== null && $value !== '')
            {{ $value }} <span class="text-sm font-semibold text-slate-500">{{ $unit }}</span>
        @else
            <span class="text-base font-semibold text-slate-400">Belum tercatat</span>
        @endif
    </p>
    @if ($date)
        <p class="mt-1 text-xs text-slate-500">{{ $date }}</p>
    @endif
</article>
