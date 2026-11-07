import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        // Dengarkan di semua antarmuka (IPv4 + IPv6) supaya dev server
        // tetap bisa diakses lewat http://sipandu.test.
        // Tanpa ini, Vite hanya bind ke [::1]:5173 (IPv6) dan CSS gagal dimuat.
        host: true,
        port: 5173,
        cors: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
