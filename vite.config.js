import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/xetaravel.css', 'resources/js/xetaravel.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
