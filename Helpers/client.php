<?php

use Larabase\Helper\Client;

if(!function_exists('ip')){
    function ip(){
        return Client::ip();
    }
}
