<?php

namespace Cafesource\Helper;

class Converter
{
    /**
     * @var array numbers
     */
    const numbers = [
        'english' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        'persian' => ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'],
        'arabic'  => ['۰', '۱', '۲', '۳', '٤', '٥', '٦', '۷', '۸', '۹'],
    ];

    /**
     * Convert to english number
     *
     * @param string $string
     *
     * @return string
     */
    public static function toEnglish( string $string ) : string
    {
        $string = str_replace(static::numbers[ 'persian' ], static::numbers[ 'english' ], $string);
        return str_replace(static::numbers[ 'arabic' ], static::numbers[ 'english' ], $string);
    }

    /**
     * Convert to persian number
     *
     * @param string $string
     *
     * @return string
     */
    public static function toPersian( string $string ) : string
    {
        $string = str_replace(static::numbers[ 'english' ], static::numbers[ 'persian' ], $string);
        return str_replace(static::numbers[ 'arabic' ], static::numbers[ 'persian' ], $string);
    }

    /**
     * Convert to arabic number
     *
     * @param string $string
     *
     * @return string
     */
    public static function toArabic( string $string ) : string
    {
        $string = str_replace(static::numbers[ 'english' ], static::numbers[ 'arabic' ], $string);
        return str_replace(static::numbers[ 'persian' ], self::numbers[ 'arabic' ], $string);
    }
}
