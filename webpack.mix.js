// webpack.mix.js
const mix = require('laravel-mix');

mix.react('resources/js/components/app.jsx', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .sourceMaps();
