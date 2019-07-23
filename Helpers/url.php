<?php

use Larabase\Cms\Helper\Url;

if(!function_exists('fileSize')){
    function fileSize($url, $useHead = true){
        return Url::fileSize($url, $useHead);
    }
}

if(!function_exists('current')){
    function current($removeQueryString = false){
        return Url::current($removeQueryString);
    }
}
