/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






let mix = require('laravel-mix');

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/assets'),
            fonts: path.resolve(__dirname, './resources/assets/fonts'),
        }
    },
});

mix.sass('resources/assets/styles/app.scss', 'public/css/site.css')
    .copyDirectory('resources/assets/img', 'public/images')
    .js('resources/assets/js/frontend.js', 'public/js/main.js')
    .version();


mix.sass('resources/assets/sass/backend.scss', 'public/css/backend.css')
    .js(['resources/assets/js/backend.js','resources/assets/js/dragdrop.js'], 'public/js/backend.js')
    .version();