<?php
/**
 * Created by PhpStorm.
 * User: mahdi
 * Date: 12/4/18
 * Time: 1:47 PM
 */

namespace Cafesource\Helper;

class Money
{
    /**
     * Convert amount to toman
     *
     * @param $amount
     *
     * @return float
     */
    public static function toman( $amount )
    {
        return round($amount / 10);
    }

    /**
     * Convert amount to rial
     *
     * @param $amount
     *
     * @return float
     */
    public static function rial( $amount )
    {
        return round($amount * 10);
    }
}