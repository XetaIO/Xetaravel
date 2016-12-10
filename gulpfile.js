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

//elixir.config.sourcemaps = false;

elixir((mix) => {
    mix
        .sass('app.scss')
        .sass([
            'bootstrap/bootstrap.scss'
        ], 'public/css/bootstrap.min.css')
        .sass([
            'font-awesome/font-awesome.scss'
        ], 'public/css/font-awesome.min.css')
        .scripts([
            'jquery-3.1.1.min.js',
            'jquery.easing.1.3.min.js',
            'tether.min.js',
            'bootstrap.min.js',
            'particles.min.js',
            'prism.min.js',
            'scrollup.min.js',
            'sidebar-1.0.0.min.js'
        ], 'public/js/lib.js')
        .scripts([
            'prettify.js',
        ], 'public/js/prettify.min.js')
        .scripts([
             'app.js'
        ], 'public/js/app.js')
        .typescript('ts.ts');
});
