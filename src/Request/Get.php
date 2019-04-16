<?php

namespace CafeSource\Request;

class Get {

    public static function all()
    {
        return $_GET;
    }

    public static function get($key)
    {
        return $_GET[$key];
    }

    public static function set($key, $value)
    {
        $_GET[$key] = $value;
    }

    public static function has($key)
    {
        if (isset($_GET[$key]))
            return true;

        return false;
    }

    public static function remove($key)
    {
        unset($_GET[$key]);
    }

}