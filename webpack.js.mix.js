const mix = require('laravel-mix');

mix.js([
        'resources/assets/js/xetaravel.admin.js',
    ], 'public/js/xetaravel.admin.min.js').vue()
    .js([
        'resources/assets/js/xetaravel.js',
    ], 'public/js/xetaravel.min.js').vue()
    .sourceMaps()
    .version();
