const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// Others
mix
    .postCss("resources/assets/css/xetaravel.css", "public/css/xetaravel.min.css", [
        require("tailwindcss"),
    ])
    .sass('resources/assets/sass/xetaravel.scss', 'public/css/xetaravel.libs.min.css')
    .js([
        'resources/assets/js/xetaravel.admin.js',
    ], 'public/js/xetaravel.admin.min.js')
    .js([
        'resources/assets/js/xetaravel.js',
    ], 'public/js/xetaravel.min.js')
    .vue()
    .version();
