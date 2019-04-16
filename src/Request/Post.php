<?php

namespace CafeSource;

class Post {

    public static function get($key)
    {
        return $_POST[$key];
    }

    public static function set($key, $value)
    {
        $_POST[$key] = $value;
    }

    public static function has($key)
    {
        if (isset($_POST[$key]))
            return true;

        return false;
    }

    public static function remove($key)
    {
        unset($_POST[$key]);
    }

}