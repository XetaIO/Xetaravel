const mix = require('laravel-mix');

mix.sass('resources/assets/sass/xetaravel.scss', 'public/css/xetaravel.min.css')
    .sass('resources/assets/sass/admin/xetaravel.admin.scss', 'public/css/xetaravel.admin.min.css')
    .sass('resources/assets/sass/bootstrap/bootstrap.scss', 'public/css/bootstrap.min.css')
    .sass('resources/assets/sass/jasny-bootstrap/jasny-bootstrap.scss', 'public/css/bootstrap.plugins.min.css')
    .sass('resources/assets/sass/font-awesome/font-awesome.scss', 'public/css/font-awesome.min.css')
    .sass('resources/assets/sass/editor-md/editormd.scss', 'public/css/editor-md.custom.min.css')
    .version();
