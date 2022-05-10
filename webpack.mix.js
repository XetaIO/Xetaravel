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
require('./webpack.sass.mix.js');
require('./webpack.js.mix.js');

mix.scripts([
        'resources/assets/js/libs/jquery.min.js',
        'resources/assets/js/libs/jquery.easing.min.js',
        'resources/assets/js/libs/tether.min.js',
        'resources/assets/js/libs/bootstrap.min.js',
        'resources/assets/js/libs/jasny-bootstrap.min.js',
        'resources/assets/js/libs/particles.min.js',
        'resources/assets/js/libs/prism.min.js',
        'resources/assets/js/libs/scrollup.min.js',
        'resources/assets/js/libs/raphael.min.js',
        'resources/assets/js/libs/morris.min.js',
        'resources/assets/js/libs/jquery-jvectormap.min.js',
        'resources/assets/js/libs/jquery-jvectormap-world-merc-en.min.js',
    ], 'public/js/lib.min.js')
    .scripts([
        'resources/assets/js/highlight/highlight.js',
    ], 'public/js/highlight.min.js')
    .scripts([
        'resources/assets/js/typed/typed.min.js',
        'resources/assets/js/parallax/parallax.min.js',
        'resources/assets/js/parallax/jarallax.min.js',
    ], 'public/js/home.min.js')
    .scripts([
        'resources/assets/js/waypoints/noframework.waypoints.min.js',
    ], 'public/js/noframework.waypoints.min.js')
    .copyDirectory('resources/assets/files', 'public/files')
    .copyDirectory('resources/assets/music', 'public/music')
    .copyDirectory('resources/assets/images', 'public/images')
    .copyDirectory('resources/assets/fonts', 'public/fonts')
    .copyDirectory('resources/assets/editor-md', 'public/editor-md')
    .version();
