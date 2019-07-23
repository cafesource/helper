<?php
namespace Larabase\Helper;

class Str
{
    /**
     * String slugger
     * @param $sting
     * @param string $separator
     * @return string
     */
    public static function slug($sting, $separator = '-')
    {
        $flip = $separator == '-' ? '_' : '-';
        $sting = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $sting);
        # Replace @ with the word 'at'
        $sting = str_replace('@', $separator . 'at' . $separator, $sting);
        # Remove all characters that are not the separator, letters, numbers, or whitespace.
        $sting = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', '', mb_strtolower($sting));
        # Replace all separator characters and whitespace by a single separator
        $sting = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $sting);
        # Trim
        return trim($sting, $separator);
    }

    /**
     * Genrate random string
     * @param int $length
     * @return string
     */
    public static function randomString( $length )
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ( $i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}
 ?>
