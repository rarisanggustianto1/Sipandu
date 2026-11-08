import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

/**
 * Sidebar navigation for authenticated SIPANDU roles.
 *
 * 1. Buka/tutup sidebar untuk layar kecil (mobile).
 * 2. Ingat folder mana yang terbuka/b tertutup (localStorage),
 *    dengan pengecualian: folder yang memuat halaman aktif selalu terbuka.
 */
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebar-backdrop');

    /* ---------- 1. Sidebar mobile ---------- */
    if (sidebar) {
        const openSidebar = () => {
            sidebar.classList.remove('-translate-x-full');
            backdrop?.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        };

        const closeSidebar = () => {
            sidebar.classList.add('-translate-x-full');
            backdrop?.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        };

        document.querySelectorAll('[data-sidebar-open]').forEach((el) =>
            el.addEventListener('click', openSidebar)
        );

        document.querySelectorAll('[data-sidebar-close]').forEach((el) =>
            el.addEventListener('click', closeSidebar)
        );

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeSidebar();
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) closeSidebar();
        });
    }

    /* ---------- 2. Folder: ingat status buka/tutup ---------- */
    const STORE_KEY = 'sipandu.sidebar.folders';
    const groups = Array.from(document.querySelectorAll('[data-nav-group]'));

    if (!groups.length) return;

    const readStore = () => {
        try {
            return JSON.parse(localStorage.getItem(STORE_KEY) || '{}');
        } catch {
            return {};
        }
    };

    const writeStore = (state) => {
        try {
            localStorage.setItem(STORE_KEY, JSON.stringify(state));
        } catch {
            /* penyimpanan tidak tersedia (mis. private mode) - abaikan */
        }
    };

    // Pulihkan status tersimpan, kecuali folder yang berisi halaman aktif.
    const stored = readStore();
    groups.forEach((group) => {
        const key = group.dataset.navGroup;
        const hasActiveItem = group.querySelector('[aria-current="page"]');

        if (hasActiveItem) {
            group.open = true;
            return;
        }

        if (typeof stored[key] === 'boolean') {
            group.open = stored[key];
        }
    });

    // Simpan setiap kali pengguna mengubah status folder.
    groups.forEach((group) => {
        group.addEventListener('toggle', () => {
            stored[group.dataset.navGroup] = group.open;
            writeStore(stored);
        });
    });
});