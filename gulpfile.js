const elixir = require('laravel-elixir');


const elixirTypscript = require('elixir-typescript');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir.config.sourcemaps = false;

elixir((mix) => {
    mix
        .sass('xetaravel.scss')
        .sass([
            'bootstrap/bootstrap.scss'
        ], 'public/css/bootstrap.min.css')
        .sass([
            'jasny-bootstrap/jasny-bootstrap.scss'
        ], 'public/css/bootstrap.plugins.min.css')
        .sass([
            'font-awesome/font-awesome.scss'
        ], 'public/css/font-awesome.min.css')
        .scripts([
            'libs/jquery.min.js',
            'libs/jquery.easing.min.js',
            'libs/tether.min.js',
            'libs/bootstrap.min.js',
            'libs/jasny-bootstrap.min.js',
            'libs/particles.min.js',
            'libs/prism.min.js',
            'libs/scrollup.min.js',
            'libs/sidebar.min.js'
        ], 'public/js/lib.min.js')
        .scripts([
            'prettify.js',
        ], 'public/js/prettify.min.js')
        .scripts([
             'app.js'
        ], 'public/js/app.js')
        .typescript('ts.ts')
        .copy('resources/assets/music', 'public/music')
        .copy('resources/assets/images', 'public/images')
        .copy('resources/assets/fonts', 'public/fonts');
});
