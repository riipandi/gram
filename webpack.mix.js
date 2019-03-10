const mix = require('laravel-mix');

require('laravel-mix-tailwind');
require('laravel-mix-purgecss');

mix.copy('resources/img/', 'public/img/')
    .js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css')
    .tailwind()
    .purgeCss();

if (mix.inProduction()) {
    mix.version();
}