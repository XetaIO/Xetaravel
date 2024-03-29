const mix = require('laravel-mix');
const TerserPlugin = require("terser-webpack-plugin");

class RemoveLicenseFilePlugin {
    apply(compiler) {
        compiler.hooks.emit.tap("RemoveLicenseFilePlugin", (compilation) => {
            // compilation has assets to output
            // console.log(compilation.assets);
            for (let name in compilation.assets) {
                if (name.endsWith("LICENSE.txt")) {
                    delete compilation.assets[name];
                }
            }
        });
    }
}


/*
 |--------------------------------------------------------------------------
 | Webpack Configuration
 |--------------------------------------------------------------------------
 */
mix.webpackConfig({
    plugins: [new RemoveLicenseFilePlugin()],
});

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
    .js([
        'resources/assets/js/xetaravel.admin.js',
    ], 'public/js/xetaravel.admin.min.js')
    .js([
        'resources/assets/js/xetaravel.js',
    ], 'public/js/xetaravel.min.js')
    .vue();

if (mix.inProduction() == false) {
    mix.browserSync({
        proxy: 'http://xetaravel.io',
        host: '192.168.56.56',
        port: 3000,
        open: false,
        watchOptions: {
            usePolling: true,
            interval: 500,
        }
    });
}

if (mix.inProduction()) {
    mix.version();
}