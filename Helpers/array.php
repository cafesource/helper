<?php

use Larabase\Helper\Arr;

if(!function_exists('isJson')){
    function isJson($string){
        return Arr::isJson($string);
    }
}

if(!function_exists('isSerialize')){
    function isSerialize($string){
        return Arr::isSerialize($string);
    }
}
