import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/xetaravel.css',
                'resources/css/flatpickr.css',
                'resources/css/flatpickr_dark.css',
                'resources/js/xetaravel.js',
                'resources/js/highlight.js',
                'resources/js/jarallax.js',
                'resources/js/waypoints.js',
                'resources/js/parallax.js',
                'resources/js/typed.js',
                'resources/js/chart.js',
                'resources/js/flatpickr.js',
                'resources/js/easymde.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        chunkSizeWarningLimit: 1000
    }
});
