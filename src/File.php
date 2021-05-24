<?php

namespace Cafesource\Helper;

class File
{
    /**
     * @param        $bytes
     * @param int    $precision
     * @param string $lang
     *
     * @return string
     */
    public static function byteFormat( $bytes, int $precision = 2, string $lang = 'fa' ) : string
    {
        $units = [
            'fa' => ['بایت', 'کیلوبایت', 'مگابایت', 'گیگابایت', 'ترابایت'],
            'en' => ['B', 'KB', 'MB', 'GB', 'TB'],
        ];

        $i = 0;
        while ( $bytes > 1024 ) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, $precision) . ' ' . $units[ $lang ][ $i ];
    }
}
