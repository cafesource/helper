<?php

use Larabase\Helper\Str;

if(!function_exists('slug')){
    function slug($sting, $separator = '-'){
        return Str::slug($sting, $separator);
    }
}

if(!function_exists('randomString')){
    function randomString($length){
        return Str::randomString($length);
    }
}
