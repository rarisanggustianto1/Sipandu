<style>
    form :is(
        input:not([type="checkbox"], [type="radio"], [type="hidden"], [type="submit"], [type="reset"], [type="button"], [type="image"]),
        select,
        textarea
    ) {
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        background-color: #f8fafc;
        color: #1e293b;
    }

    form :is(
        input:not([type="checkbox"], [type="radio"], [type="hidden"], [type="submit"], [type="reset"], [type="button"], [type="image"]),
        select,
        textarea
    ):focus {
        border-color: #0f766e;
        outline: 3px solid rgb(15 118 110 / 16%);
        outline-offset: 1px;
    }

    body {
        padding-left: 18rem !important;
    }

    .dinas-sidebar {
        position: fixed;
        z-index: 40;
        inset: 0 auto 0 0;
        display: flex;
        width: 18rem;
        flex-direction: column;
        padding: 18px 14px;
        background: #ffffff;
        border-right: 1px solid #e2e8f0;
        box-shadow: 2px 0 12px rgba(15, 23, 42, .05);
    }

    .dinas-sidebar nav {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 6px;
        margin-top: 28px;
    }

    .dinas-sidebar nav a {
        display: block;
        padding: 11px 12px;
        border-radius: 10px;
        color: #475569;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: background .15s, color .15s;
    }

    .dinas-sidebar nav a:hover,
    .dinas-sidebar nav a[aria-current="page"] {
        background: #f0fdfa;
        color: #0f766e;
    }

    .dinas-sidebar-footer {
        padding-top: 14px;
        border-top: 1px solid #e2e8f0;
    }

    @media (max-width: 768px) {
        body {
            padding-left: 0 !important;
        }

        .dinas-sidebar {
            position: relative;
            width: 100%;
            min-height: auto;
            padding: 12px 16px;
            border-right: 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .dinas-sidebar nav {
            margin-top: 12px;
        }
    }
</style>

<aside class="dinas-sidebar">
    <x-sipandu-brand subtitle="Dinas Kesehatan" />

    <nav aria-label="Navigasi Dinas Kesehatan">
        <a href="{{ route('dinas.dashboard') }}" @if (request()->routeIs('dinas.dashboard')) aria-current="page" @endif>
            Dashboard
        </a>
        <a href="{{ route('dinas.puskesmas.index') }}" @if (request()->routeIs('dinas.puskesmas.*')) aria-current="page" @endif>
            Puskesmas
        </a>
        <a href="{{ route('dinas.edukasi.index') }}" @if (request()->routeIs('dinas.edukasi.*')) aria-current="page" @endif>
            Edukasi
        </a>
        <a href="{{ route('dinas.laporan.index') }}" @if (request()->routeIs('dinas.laporan.*')) aria-current="page" @endif>
            Laporan Wilayah
        </a>
    </nav>

    <div class="dinas-sidebar-footer">
        <p style="overflow:hidden;margin:0 0 10px;color:#334155;font-size:13px;font-weight:700;text-overflow:ellipsis;white-space:nowrap;">
            {{ auth()->user()->name }}
        </p>
        @include('dinas.partials.logout')
    </div>
</aside>
