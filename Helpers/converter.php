<?php

use Larabase\Helper\Converter;

if(!function_exists('toEnglish')){
    function toEnglish($string){
        return Converter::toEnglish($string);
    }
}

if(!function_exists('toPersian')){
    function toPersian($string){
        return Converter::toPersian($string);
    }
}

if(!function_exists('toArabic')){
    function toArabic($string){
        return Converter::toArabic($string);
    }
}
