const mix = require('laravel-mix');

mix//.sass('resources/assets/sass/xetaravel.scss', 'public/css/xetaravel.min.css')
    //.sass('resources/assets/sass/admin/xetaravel.admin.scss', 'public/css/xetaravel.admin.min.css')
    .postCss("resources/assets/css/xetaravel.css", "public/css/xetaravel.min.css", [
        require("tailwindcss"),
    ])
    .version();
