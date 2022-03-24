const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | WebPack Configuration
 |--------------------------------------------------------------------------
 */
mix.webpackConfig({
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
        'resources/assets/ts/Xetaravel.admin.ts'
    ], 'public/js/xetaravel.admin.min.js').vue()
    .js([
        'resources/assets/js/xetaravel.js',
        'resources/assets/ts/Xetaravel.ts'
    ], 'public/js/xetaravel.min.js').vue()
    .version();
