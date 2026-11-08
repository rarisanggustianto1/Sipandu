@props([
    'subtitle' => null,
    'light' => false,
])

<a href="{{ route('home') }}" {{ $attributes->merge(['class' => 'inline-flex shrink-0 items-center gap-2.5 no-underline']) }} style="display: inline-flex; flex-shrink: 0; align-items: center; gap: 10px; color: {{ $light ? '#ffffff' : '#115e59' }}; text-decoration: none;">
    <img
        src="{{ asset('images/sipandu-logo.png') }}"
        alt="Logo SIPANDU"
        class="h-11 w-11 rounded-xl object-contain"
        style="width: 44px; height: 44px; background: #ffffff; border-radius: 12px; object-fit: contain;"
    >
    <span class="flex min-w-0 flex-col" style="display: flex; flex-direction: column;">
        <span class="text-base font-black leading-tight tracking-wide" style="font-size: 16px; font-weight: 900; line-height: 1.15; letter-spacing: 0.04em;">SIPANDU</span>
        @if ($subtitle)
            <span class="max-w-52 truncate text-[11px] font-medium leading-tight {{ $light ? 'text-teal-50' : 'text-slate-500' }}" style="max-width: 13rem; overflow: hidden; text-overflow: ellipsis; font-size: 11px; font-weight: 500; line-height: 1.25; color: {{ $light ? '#f0fdfa' : '#64748b' }};">{{ $subtitle }}</span>
        @else
            <span class="text-[10px] font-medium leading-tight {{ $light ? 'text-teal-50' : 'text-slate-500' }}" style="font-size: 10px; font-weight: 500; line-height: 1.25; color: {{ $light ? '#f0fdfa' : '#64748b' }};">Pemantauan Posyandu</span>
        @endif
    </span>
</a>
