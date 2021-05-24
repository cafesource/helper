<?php

namespace Cafesource\Helper;

class Validation
{
    /**
     * Checking username character
     *
     * @param $username
     *
     * @return bool
     */
    public function username( $username ) : bool
    {
        # for english chars + numbers only
        if ( preg_match('/^[a-zA-Z0-9]{5,}$/', $username) )
            return true;

        return false;
    }

    /**
     * Email validation
     *
     * @param string $email
     *
     * @return bool
     */
    public static function email( $email ) : bool
    {
        if ( preg_match('/^([0-9a-zA-Z\w])@([a-zA-Z]{3,5}).([a-zA-Z]{2,4})/', $email) )
            return true;

        return false;
    }

    /**
     * Mobile validation
     *
     * @param int|string $number
     *
     * @return bool
     */
    public static function mobile( $number ) : bool
    {
        if ( preg_match('/^(?:09|\+?63)(?:\d(:?-)?){9,10}$/', $number) )
            return true;

        return false;
    }

    /**
     * National code validation
     *
     * @param $nationalCode
     *
     * @return bool
     */
    public static function nationalCode( $nationalCode ) : bool
    {
        if ( !preg_match('/^[0-9]{10}$/', $nationalCode) )
            return false;

        for ( $i = 0; $i < 10; $i++ ) {
            if ( preg_match('/^' . $i . '{10}$/', $nationalCode) )
                return false;
        }

        for ( $i = 0, $sum = 0; $i < 9; $i++ ) {
            $sum += ((10 - $i) * intval(substr($nationalCode, $i, 1)));
        }

        $ret    = $sum % 11;
        $parity = intval(substr($nationalCode, 9, 1));
        if ( ($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity) ) {
            return true;
        }
        return false;
    }

    /**
     * @param $tel
     *
     * @return bool
     */
    public function tel( $tel ) : bool
    {
        if ( is_numeric($tel) )
            return true;

        return false;
    }

    /**
     * @param $code
     *
     * @return bool
     */
    public function zipCode( $code ) : bool
    {
        if ( is_numeric($code) && strlen($code) == 10 )
            return true;

        return false;
    }
}