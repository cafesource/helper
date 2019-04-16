<?php


namespace CafeSource\Helper\Session;


class Session {

    public static function get($key)
    {
        return $_SESSION[$key];
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function has($key)
    {
        if (isset($_SESSION[$key]))
            return true;

        return false;
    }

    public static function remove($key)
    {
        unset($_SESSION[$key]);
    } 
    
}