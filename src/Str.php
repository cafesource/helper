<?php
namespace Cafesource\Helper;

class Str
{
    /**
     * String slugger
     *
     * @param string $string
     * @param string $separator
     *
     * @return string
     */
    public static function slug( string $string, string $separator = '-' ) : string
    {
        $flip   = $separator == '-' ? '_' : '-';
        $string = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $string);

        # Replace @ with the word 'at'
        $string = str_replace('@', $separator . 'at' . $separator, $string);

        # Remove all characters that are not the separator, letters, numbers, or whitespace.
        $string = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', '', mb_strtolower($string));

        # Replace all separator characters and whitespace by a single separator
        $string = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $string);

        # Trim
        return trim($string, $separator);
    }

    /**
     * Generate random string
     *
     * @param int $length
     *
     * @return string
     */
    public static function random( int $length ) : string
    {
        $randomString = '';
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        for ( $i = 0; $i < $length; $i++ ) {
            $index        = rand(0, strlen($characters) - 1);
            $randomString .= $characters[ $index ];
        }

        return $randomString;
    }

    /**
     * @param $string
     *
     * @return bool
     */
    function isJson( $string ) : bool
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

?>
