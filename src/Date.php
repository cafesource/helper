<?php

namespace Cafesource\Helper;

class Date
{
    /**
     * Calculates days count between two dates
     *
     * @param $firstDate
     * @param $lastDate
     *
     * @return int
     */
    public static function daysBetweenDate( $firstDate, $lastDate )
    {
        $diff = $firstDate - $lastDate;
        return ceil($diff / (60 * 60 * 24));
    }
}
