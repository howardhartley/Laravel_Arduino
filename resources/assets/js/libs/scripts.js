$(document).ready(function(){

    $('#load-screen').delay(700).fadeOut(600, function(){
        $(this).remove();

    });

    new WOW().init();

});