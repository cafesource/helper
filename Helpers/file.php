<?php

use Larabase\Helper\File;

if(!function_exists('byteFormat')){
    function byteFormat( $bytes, $precision = 2, $lang = 'fa' ){
        return File::byteFormat( $bytes, $precision, $lang );
    }
}
