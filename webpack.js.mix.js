const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | WebPack Configuration
 |--------------------------------------------------------------------------
 */
mix.webpackConfig({
    node: {
        console: true
    },
    resolve: {
        extensions: ['.ts']
    },
    module: {
        rules: [
            {
                test: /\.ts$/,
                loader: 'ts-loader'
            }
        ]
    }
});

mix.js([
        'resources/assets/js/xetaravel.admin.js',
    ], 'public/js/xetaravel.admin.min.js')
    .js([
        'resources/assets/js/xetaravel.js',
        'resources/assets/ts/Xetaravel.ts'
    ], 'public/js/xetaravel.min.js')
    .version();
