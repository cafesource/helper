<?php

use Larabase\Cms\Helper\Field;

if(!function_exists('selected')){
    function selected($name, $value){
        return Field::selected($name, $value);
    }
}

if(!function_exists('checked')){
    function checked($name, $value){
        return Field::checked($name, $value);
    }
}
