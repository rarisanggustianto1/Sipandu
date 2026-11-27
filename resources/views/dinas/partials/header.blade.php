<style>
    body {
        font-family: "Instrument Sans", ui-sans-serif, system-ui, sans-serif !important;
        background: var(--sipandu-canvas, #f1f5f9) !important;
        color: var(--sipandu-heading, #0f172a) !important;
        font-size: 15px;
    }

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
        display: flex;
        height: 100dvh;
        overflow: hidden;
        padding-left: 18rem !important;
    }

    .dinas-sidebar {
        position: fixed;
        z-index: 40;
        inset: 0 auto 0 0;
        display: flex;
        width: 18rem;
        height: 100dvh;
        box-sizing: border-box;
        flex-direction: column;
        padding: 0;
        background: var(--sipandu-surface, #ffffff);
        border-right: 1px solid var(--sipandu-border, #e2e8f0);
        box-shadow: 2px 0 12px rgb(15 23 42 / 5%);
        overflow: hidden;
    }

    .dinas-sidebar-brand {
        display: flex;
        width: 100%;
        min-height: 4rem;
        align-items: center;
        justify-content: space-between;
        padding: 0 1.25rem;
        background: #14b8a6;
    }

    .dinas-sidebar-brand .dinas-sidebar-close {
        border-color: rgb(255 255 255 / 35%);
        background: transparent;
        color: #ffffff;
    }

    .dinas-sidebar nav {
        display: flex;
        flex: 1;
        min-height: 0;
        flex-direction: column;
        gap: 4px;
        margin-top: 0;
        padding: 1rem 0.75rem;
        overflow-y: auto;
        overscroll-behavior: contain;
    }

    .dinas-sidebar nav a {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        padding: 0.625rem 0.75rem;
        border-radius: 0.75rem;
        color: #475569;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: background .15s, color .15s;
    }

    .dinas-sidebar nav a:hover,
    .dinas-sidebar nav a[aria-current="page"] {
        background: var(--sipandu-primary-soft, #f0fdfa);
        color: var(--sipandu-primary, #0f766e);
    }

    .dinas-sidebar-footer {
        padding: 1rem 0.75rem;
        border-top: 1px solid var(--sipandu-border, #e2e8f0);
    }

    .dinas-sidebar-footer p {
        overflow: hidden;
        margin: 0 0 0.75rem;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dinas-sidebar-account {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        padding: 0.75rem;
        border: 1px solid transparent;
        border-radius: 0.75rem;
        background: #f8fafc;
        color: #334155;
        text-decoration: none;
        transition: background-color .15s, border-color .15s;
    }

    .dinas-sidebar-account:hover {
        border-color: #99f6e4;
        background: #f0fdfa;
    }

    .dinas-sidebar-account-avatar {
        display: grid;
        width: 2.25rem;
        height: 2.25rem;
        flex: 0 0 auto;
        place-items: center;
        border-radius: 9999px;
        background: #ccfbf1;
        color: #0f766e;
        font-weight: 700;
    }

    .dinas-sidebar-account-copy {
        min-width: 0;
        flex: 1;
    }

    .dinas-sidebar-account-name {
        display: block;
        overflow: hidden;
        color: #1e293b;
        font-size: 0.875rem;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dinas-sidebar-account-caption {
        display: block;
        color: #64748b;
        font-size: 0.75rem;
    }

    .dinas-sidebar-logout {
        width: 100%;
        padding: 0.625rem 0.75rem;
        border: 1px solid #fecdd3;
        border-radius: 0.75rem;
        background: #fff1f2;
        color: #be123c;
        font: inherit;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
    }

    .dinas-sidebar ~ main,
    .dinas-sidebar ~ .container {
        box-sizing: border-box;
        flex: 1 1 0%;
        height: 100dvh;
        margin-block: 0;
        min-height: 0;
        min-width: 0;
        overflow-y: auto;
        overscroll-behavior: contain;
    }

    .dinas-sidebar ~ main,
    .dinas-sidebar ~ .container {
        padding: 2rem clamp(1rem, 3vw, 2.5rem);
        font-size: 0.9375rem;
        line-height: 1.55;
    }

    .dinas-sidebar ~ main h1,
    .dinas-sidebar ~ main h2,
    .dinas-sidebar ~ .container h1,
    .dinas-sidebar ~ .container h2,
    .dinas-sidebar ~ main h3,
    .dinas-sidebar ~ .container h3,
    .dinas-sidebar ~ main h4,
    .dinas-sidebar ~ .container h4 {
        color: var(--sipandu-heading, #0f172a);
        font-weight: 700;
        line-height: 1.3;
    }

    .dinas-sidebar ~ main .dinas-page-header,
    .dinas-sidebar ~ .container .dinas-page-header {
        position: sticky;
        z-index: 10;
        top: 0;
        margin: -2rem calc(-1 * clamp(1rem, 3vw, 2.5rem)) 1.5rem;
        padding: 1.25rem clamp(1rem, 3vw, 2.5rem);
        border-bottom: 1px solid var(--sipandu-border, #e2e8f0);
        background: rgb(241 245 249 / 94%);
        backdrop-filter: blur(12px);
    }

    .dinas-sidebar ~ main .dinas-page-header .page-title,
    .dinas-sidebar ~ .container .dinas-page-header .page-title {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
    }

    .dinas-sidebar ~ main .report-detail-table th:nth-child(2),
    .dinas-sidebar ~ main .report-detail-table th:nth-child(3),
    .dinas-sidebar ~ main .report-detail-table th:nth-child(4),
    .dinas-sidebar ~ .container .report-detail-table th:nth-child(2),
    .dinas-sidebar ~ .container .report-detail-table th:nth-child(3),
    .dinas-sidebar ~ .container .report-detail-table th:nth-child(4) {
        text-align: center;
    }

    .dinas-sidebar ~ main .dinas-page-header .subtitle,
    .dinas-sidebar ~ .container .dinas-page-header .subtitle {
        margin: 0.25rem 0 0;
    }

    .dinas-sidebar ~ main > h1,
    .dinas-sidebar ~ main > h2,
    .dinas-sidebar ~ .container > h1,
    .dinas-sidebar ~ .container > h2,
    .dinas-sidebar ~ main .page-title,
    .dinas-sidebar ~ .container .page-title {
        margin-top: 0;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .dinas-sidebar ~ main h2,
    .dinas-sidebar ~ .container h2 {
        font-size: 1.25rem;
    }

    .dinas-sidebar ~ main h3,
    .dinas-sidebar ~ .container h3 {
        font-size: 1.125rem;
        font-weight: 700;
    }

    .dinas-sidebar ~ main .summary,
    .dinas-sidebar ~ .container .summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(14rem, 1fr));
        gap: 1rem;
    }

    .dinas-sidebar ~ main .summary-card,
    .dinas-sidebar ~ .container .summary-card {
        padding: 1.25rem;
    }

    .dinas-sidebar ~ main .summary-card h2,
    .dinas-sidebar ~ .container .summary-card h2 {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 800;
    }

    .dinas-sidebar ~ main .filters,
    .dinas-sidebar ~ .container .filters {
        grid-template-columns: repeat(auto-fit, minmax(12rem, 1fr));
        gap: 1rem;
    }

    .dinas-sidebar ~ main .card,
    .dinas-sidebar ~ .container .card {
        margin-bottom: 1.25rem;
        padding: 1.25rem;
    }

    .dinas-sidebar ~ main .section-title,
    .dinas-sidebar ~ .container .section-title {
        margin: 1.5rem 0 0.75rem;
        font-size: 1.25rem;
        font-weight: 700;
    }

    .dinas-sidebar ~ main .subtitle,
    .dinas-sidebar ~ main > p,
    .dinas-sidebar ~ .container .subtitle,
    .dinas-sidebar ~ .container > p {
        color: var(--sipandu-muted, #64748b);
    }

    .dinas-sidebar ~ main .card,
    .dinas-sidebar ~ main .summary-card,
    .dinas-sidebar ~ .container .card,
    .dinas-sidebar ~ .container .form-card,
    .dinas-sidebar ~ .container .menu-card,
    .dinas-sidebar ~ .container .summary-card,
    .dinas-sidebar ~ .container .stats .card {
        border: 1px solid var(--sipandu-border, #e2e8f0);
        border-radius: 1rem;
        background: var(--sipandu-surface, #ffffff);
        box-shadow: 0 1px 3px rgb(15 23 42 / 6%);
    }

    .dinas-sidebar ~ .container .stats .card,
    .dinas-sidebar ~ .container .summary-card {
        padding: 1.25rem;
    }

    .dinas-sidebar ~ .container .card .number,
    .dinas-sidebar ~ .container .summary-card h2 {
        color: var(--sipandu-primary, #0f766e);
    }

    .dinas-sidebar ~ main .table-wrapper,
    .dinas-sidebar ~ .container .table-wrapper {
        overflow-x: auto;
        border: 1px solid var(--sipandu-border, #e2e8f0);
        border-radius: 1rem;
        background: var(--sipandu-surface, #ffffff);
        box-shadow: 0 1px 3px rgb(15 23 42 / 6%);
    }

    .dinas-sidebar ~ main table,
    .dinas-sidebar ~ .container table {
        width: 100%;
        border-collapse: collapse;
        color: #334155;
    }

    .dinas-sidebar ~ main table.report-table,
    .dinas-sidebar ~ .container table.report-table {
        min-width: 62rem;
    }

    .dinas-sidebar ~ main table.report-detail-table,
    .dinas-sidebar ~ .container table.report-detail-table {
        table-layout: fixed;
    }

    .dinas-sidebar ~ main .report-detail-table td:first-child,
    .dinas-sidebar ~ .container .report-detail-table td:first-child {
        overflow-wrap: anywhere;
    }

    .dinas-sidebar ~ main .report-detail-table td:nth-child(2),
    .dinas-sidebar ~ main .report-detail-table td:nth-child(3),
    .dinas-sidebar ~ main .report-detail-table td:nth-child(4),
    .dinas-sidebar ~ .container .report-detail-table td:nth-child(2),
    .dinas-sidebar ~ .container .report-detail-table td:nth-child(3),
    .dinas-sidebar ~ .container .report-detail-table td:nth-child(4) {
        text-align: center;
        font-variant-numeric: tabular-nums;
    }

    .dinas-sidebar ~ main .report-detail-table td:last-child,
    .dinas-sidebar ~ .container .report-detail-table td:last-child {
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    .dinas-sidebar ~ main th,
    .dinas-sidebar ~ .container th {
        background: #f8fafc;
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .dinas-sidebar ~ main th,
    .dinas-sidebar ~ main td,
    .dinas-sidebar ~ .container th,
    .dinas-sidebar ~ .container td {
        border-bottom: 1px solid #e2e8f0;
        padding: 0.875rem 1rem;
        text-align: left;
        vertical-align: top;
    }

    .dinas-sidebar ~ main tbody tr:hover,
    .dinas-sidebar ~ .container tbody tr:hover {
        background: #f8fafc;
    }

    .dinas-sidebar ~ main .btn,
    .dinas-sidebar ~ .container .btn {
        display: inline-flex;
        min-height: 2.5rem;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.625rem 1rem;
        border: 1px solid #cbd5e1;
        border-radius: 0.75rem;
        background: #ffffff;
        color: #334155;
        font: inherit;
        font-size: 0.875rem;
        font-weight: 600;
        line-height: 1.25rem;
        text-decoration: none;
        cursor: pointer;
        transition: background-color .15s, border-color .15s, color .15s;
    }

    .dinas-sidebar ~ main .btn:hover,
    .dinas-sidebar ~ .container .btn:hover {
        background: #f8fafc;
    }

    .dinas-sidebar ~ main .btn-primary,
    .dinas-sidebar ~ main .btn:not(.btn-danger):not(.btn-edit):not(.btn-delete):not(.btn-secondary),
    .dinas-sidebar ~ .container .btn-primary,
    .dinas-sidebar ~ .container .btn:not(.btn-danger):not(.btn-edit):not(.btn-delete):not(.btn-secondary) {
        border-color: var(--sipandu-primary, #0f766e);
        background: var(--sipandu-primary, #0f766e);
        color: #ffffff;
    }

    .dinas-sidebar ~ main .btn-primary:hover,
    .dinas-sidebar ~ main .btn:not(.btn-danger):not(.btn-edit):not(.btn-delete):not(.btn-secondary):hover,
    .dinas-sidebar ~ .container .btn-primary:hover,
    .dinas-sidebar ~ .container .btn:not(.btn-danger):not(.btn-edit):not(.btn-delete):not(.btn-secondary):hover {
        border-color: var(--sipandu-primary-hover, #115e59);
        background: var(--sipandu-primary-hover, #115e59);
    }

    .dinas-sidebar ~ main .btn-secondary,
    .dinas-sidebar ~ .container .btn-secondary {
        border-color: #cbd5e1;
        background: #ffffff;
        color: #334155;
    }

    .dinas-sidebar ~ main .btn-danger,
    .dinas-sidebar ~ main .btn-delete,
    .dinas-sidebar ~ .container .btn-danger,
    .dinas-sidebar ~ .container .btn-delete {
        border-color: #fecdd3;
        background: #fff1f2;
        color: #be123c;
    }

    .dinas-sidebar ~ main .btn-edit,
    .dinas-sidebar ~ .container .btn-edit {
        border-color: #99f6e4;
        background: #f0fdfa;
        color: #0f766e;
    }

    .dinas-sidebar ~ main form :is(
        input:not([type="checkbox"], [type="radio"], [type="hidden"], [type="submit"], [type="reset"], [type="button"], [type="image"]),
        select,
        textarea
    ),
    .dinas-sidebar ~ .container form :is(
        input:not([type="checkbox"], [type="radio"], [type="hidden"], [type="submit"], [type="reset"], [type="button"], [type="image"]),
        select,
        textarea
    ) {
        border-color: #cbd5e1;
        border-radius: 0.75rem;
        background: #ffffff;
        color: #0f172a;
    }

    .dinas-sidebar ~ main label,
    .dinas-sidebar ~ .container label {
        color: #334155;
    }

    .dinas-sidebar ~ main .alert,
    .dinas-sidebar ~ main .success,
    .dinas-sidebar ~ main .info,
    .dinas-sidebar ~ .container .alert,
    .dinas-sidebar ~ .container .success,
    .dinas-sidebar ~ .container .info {
        border: 1px solid #99f6e4;
        border-radius: 0.75rem;
        background: #f0fdfa;
        color: #115e59;
    }

    .dinas-sidebar ~ main .error,
    .dinas-sidebar ~ .container .error {
        color: #be123c;
    }

    .dinas-sidebar ~ main .back,
    .dinas-sidebar ~ main a:not(.btn),
    .dinas-sidebar ~ .container a:not(.btn) {
        color: var(--sipandu-primary, #0f766e);
    }

    .dinas-sidebar ~ main .pagination,
    .dinas-sidebar ~ .container .pagination {
        margin-top: 1rem;
    }

    .dinas-sidebar-toggle,
    .dinas-sidebar-close,
    .dinas-sidebar-backdrop {
        display: none;
    }

    @media (max-width: 768px) {
        body {
            padding-left: 0 !important;
        }

        .dinas-sidebar {
            transform: translateX(-100%);
            transition: transform .2s ease;
        }

        .dinas-sidebar.is-open {
            transform: translateX(0);
        }

        .dinas-sidebar-toggle {
            position: fixed;
            z-index: 20;
            top: 12px;
            left: 12px;
            display: block;
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 0.75rem;
            background: #ffffff;
            color: #0f766e;
            font: inherit;
            font-weight: 600;
        }

        .dinas-sidebar-close {
            display: block;
        }

        .dinas-sidebar-backdrop.is-visible {
            position: fixed;
            z-index: 30;
            inset: 0;
            display: block;
            border: 0;
            background: rgb(15 23 42 / 50%);
        }

        .dinas-sidebar ~ main,
        .dinas-sidebar ~ .container {
            padding-top: 4rem;
        }

        .dinas-sidebar ~ main .dinas-page-header,
        .dinas-sidebar ~ .container .dinas-page-header {
            margin-top: -4rem;
            margin-right: -1rem;
            margin-left: -1rem;
            padding: 1rem 1rem 1rem 4rem;
        }
    }
</style>

<button type="button" class="dinas-sidebar-toggle" aria-controls="dinas-sidebar" aria-expanded="false">
    Menu
</button>
<button type="button" class="dinas-sidebar-backdrop" aria-label="Tutup menu navigasi" hidden></button>

<aside id="dinas-sidebar" class="dinas-sidebar">
    <div class="dinas-sidebar-brand">
        <x-sipandu-brand subtitle="Dinas Kesehatan" :light="true" />
        <button type="button" class="dinas-sidebar-close" aria-label="Tutup menu navigasi">Tutup</button>
    </div>

    <nav aria-label="Navigasi Dinas Kesehatan">
        <a href="{{ route('dinas.dashboard') }}" @if (request()->routeIs('dinas.dashboard')) aria-current="page" @endif>
            <x-puskesmas.icon name="grid" class="h-5 w-5 shrink-0" />
            <span>Dashboard</span>
        </a>
        <a href="{{ route('dinas.puskesmas.index') }}" @if (request()->routeIs('dinas.puskesmas.*')) aria-current="page" @endif>
            <x-puskesmas.icon name="building" class="h-5 w-5 shrink-0" />
            <span>Puskesmas</span>
        </a>
        <a href="{{ route('dinas.edukasi.index') }}" @if (request()->routeIs('dinas.edukasi.*')) aria-current="page" @endif>
            <x-puskesmas.icon name="book" class="h-5 w-5 shrink-0" />
            <span>Edukasi</span>
        </a>
        <a href="{{ route('dinas.laporan.index') }}" @if (request()->routeIs('dinas.laporan.*')) aria-current="page" @endif>
            <x-puskesmas.icon name="chart" class="h-5 w-5 shrink-0" />
            <span>Laporan Wilayah</span>
        </a>
    </nav>

    <div class="dinas-sidebar-footer">
        <a href="{{ route('profile') }}" class="dinas-sidebar-account" aria-label="Buka profil akun {{ auth()->user()->name }}">
            <span class="dinas-sidebar-account-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <span class="dinas-sidebar-account-copy">
                <span class="dinas-sidebar-account-name">{{ auth()->user()->name }}</span>
                <span class="dinas-sidebar-account-caption">Profil akun · Dinas Kesehatan</span>
            </span>
            <x-puskesmas.icon name="chevron" class="h-4 w-4 shrink-0 text-slate-400" />
        </a>
        @include('dinas.partials.logout')
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('dinas-sidebar');
        const toggle = document.querySelector('.dinas-sidebar-toggle');
        const closeButton = document.querySelector('.dinas-sidebar-close');
        const backdrop = document.querySelector('.dinas-sidebar-backdrop');

        if (!sidebar || !toggle || !closeButton || !backdrop) {
            return;
        }

        const closeSidebar = () => {
            sidebar.classList.remove('is-open');
            backdrop.classList.remove('is-visible');
            backdrop.hidden = true;
            toggle.setAttribute('aria-expanded', 'false');
        };

        toggle.addEventListener('click', () => {
            sidebar.classList.add('is-open');
            backdrop.hidden = false;
            backdrop.classList.add('is-visible');
            toggle.setAttribute('aria-expanded', 'true');
        });

        closeButton.addEventListener('click', closeSidebar);
        backdrop.addEventListener('click', closeSidebar);
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeSidebar();
            }
        });
    });
</script>
