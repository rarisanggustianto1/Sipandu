@props([
    'label',
    'value' => null,
    'unit' => null,
])

<div class="rounded-xl bg-slate-50 p-3">
    <dt class="text-xs font-medium text-slate-500">{{ $label }}</dt>
    <dd class="mt-1 break-words text-sm font-bold text-slate-900">
        @if ($value !== null && $value !== '')
            {{ $value }} {{ $unit }}
        @else
            <span class="font-medium text-slate-400">Belum tercatat</span>
        @endif
    </dd>
</div>
