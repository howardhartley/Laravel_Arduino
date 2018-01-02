var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss')


        .styles([


            'libs/bootstrap/css/bootstrap.css',
            'libs/font-awesome.css',
            'libs/sb-admin.css',
            'libs/styles.css'





        ], './public/css/libs.css')


        .scripts([


            'libs/jquery/jquery.js',
            'libs/popper/popper.min.js',
            'libs/bootstrap/js/bootstrap.js',
            'libs/jquery-easing/jquery.easing.min.js',
            // 'libs/sb-admin.min.js',
            'libs/scripts.js'



        ], './public/js/libs.js')









});
