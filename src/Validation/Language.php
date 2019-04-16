<?php


namespace CafeSource\Helper\Validation;


class Language {

    public static function persian($string)
    {
        if (preg_match('/^[^\x{600}-\x{6FF}]+$/u', str_replace("\\\\","",$string)))
            return false;

        return true;
    }

    public static function english($string)
    {
        if (preg_match("/^[\w\d\s.,-]*$/", $string))
            return true;

        return false;
    }

}