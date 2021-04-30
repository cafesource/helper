<?php

namespace Cafesource\Helper;

class File
{
    public static function byteFormat( $bytes, $precision = 2, $lang = 'fa' )
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
