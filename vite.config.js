import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/xetaravel.css',
                'resources/js/xetaravel.js',
                'resources/js/highlight.js',
                'resources/js/jarallax.js',
                'resources/js/waypoints.js',
                'resources/js/parallax.js',
                'resources/js/particles.js',
                'resources/js/typed.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        chunkSizeWarningLimit: 1000
    }
});
