const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
// js
mix.combine(['resources/js/jquery.min.js', 'resources/js/jquery.validate.js', 'resources/js/popper.min.js', 'resources/js/bootstrap.min.js',
    'resources/js/bootstrap-select.min.js', 'resources/js/sweetAlert2.min.js', 'resources/js/moment.min.js', 'resources/js/daterangepicker.min.js',
    'resources/js/intlTelInput.js', 'resources/js/intlTelUtils.js', 'resources/js/app.js'], 'public/js/public.js');
// sass
mix.sass('resources/sass/app.scss', 'public/css');
// plugins css
mix.styles(['resources/css/bootstrap.min.css', 'resources/css/bootstrap-select.min.css',
    'resources/css/intlTelInput.css', 'resources/css/boxicons.min.css', 'resources/css/daterangepicker.css'], 'public/css/public.css');
