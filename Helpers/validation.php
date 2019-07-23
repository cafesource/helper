<?php

use Larabase\Cms\Helper\Validation;

if(!function_exists('email')){
    function email($email){
        return Validation::email($email);
    }
}

if(!function_exists('mobile')){
    function mobile($number){
        return Validation::email($number);
    }
}

if(!function_exists('nationalCode')){
    function nationalCode($nationalCode){
        return Validation::nationalCode($nationalCode);
    }
}
