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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

// Admin
mix.less('resources/_admin/less/bootstrap.less', 'public/_admin/css')
    .less('resources/_admin/less/admin.less', 'public/_admin/css')
    .less('node_modules/admin-lte/build/less/skins/_all-skins.less', 'public/_admin/css')
    .sass('resources/_admin/scss/app.scss', 'public/_admin/css')
    .js([
        'node_modules/admin-lte/build/js/Layout.js',
        'node_modules/admin-lte/build/js/BoxWidget.js',
        'node_modules/admin-lte/build/js/PushMenu.js',
        'node_modules/admin-lte/build/js/Tree.js',
        'node_modules/admin-lte/build/js/ControlSidebar.js',
    ], 'public/_admin/js/admin.js')
    .copyDirectory('node_modules/admin-lte/plugins', 'public/vendor')
    .copyDirectory('node_modules/admin-lte/bower_components', 'public/vendor')
    .copy('node_modules/admin-lte/dist/js/demo.js', 'public/_admin/js')
    .copyDirectory('node_modules/admin-lte/dist/img', 'public/_admin/images/dashboard');