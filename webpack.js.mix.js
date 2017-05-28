const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | WebPack Configuration
 |--------------------------------------------------------------------------
 */
mix.webpackConfig({
    node: {
        console: true
    }
});

mix.js([
        'resources/assets/js/xetaravel.admin.js',
        'resources/assets/js/console.js'
    ], 'public/js/xetaravel.admin.min.js')
    .js([
        'resources/assets/js/xetaravel.js',
        'resources/assets/js/console.js'
    ], 'public/js/xetaravel.min.js')
    .version();
