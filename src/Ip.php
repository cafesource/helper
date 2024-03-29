<?php


namespace Cafesource\Helper;


class Ip
{
    /**
     * @return float|string
     */
    public static function ip()
    {
        return Client::ip();
    }

    /**
     * Get user's IP address
     *
     * @param bool   $canGetLocalIp
     * @param string $defaultIp
     *
     * @return string
     *
     * e.g. '157.240.1.35' (US) - '197.234.219.43' (BJ) - '5.135.32.116' (FR) => For debug | @todo: remove debug value
     */
    public static function get( $canGetLocalIp = true, $defaultIp = '157.240.1.35' )
    {
        $ip = '';

        $serverVarKeys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ];

        foreach ( $serverVarKeys as $key ) {
            if ( array_key_exists($key, $_SERVER) === true ) {
                foreach ( explode(',', $_SERVER[ $key ]) as $item ) {
                    if (
                        self::isValid($item) &&
                        substr($item, 0, 4) != '127.' &&
                        $item != '::1' &&
                        $item != '' &&
                        !in_array($item, ['255.255.255.0', '255.255.255.255'])
                    ) {
                        $ip = $item;
                        break;
                    }
                }
            }
        }

        if ( $canGetLocalIp && empty($ip) ) {
            foreach ( $serverVarKeys as $key ) {
                if ( array_key_exists($key, $_SERVER) === true ) {
                    foreach ( explode(',', $_SERVER[ $key ]) as $item ) {
                        if ( self::isValid($item) && $item != '' ) {
                            $ip = $item;
                            break;
                        }
                    }
                }
            }
        }

        return ($ip) ? $ip : $defaultIp;
    }

    /**
     * Check IP address version
     *
     * @param string $ip
     *
     * @return int - 4/6
     */
    public static function version( $ip )
    {
        return strpos($ip, ":") === false ? 4 : 6;
    }

    /**
     * Validate an IP address
     *
     * @param string $ip
     *
     * @return boolean - true/false
     */
    public static function isValid( $ip ) : bool
    {
        if ( filter_var($ip, FILTER_VALIDATE_IP) )
            return true;

        return false;
    }

    /**
     * Validate an IPv4 IP address
     *
     * @param string $ip
     *
     * @return boolean - true/false
     */
    public static function isValidIPv4( $ip ) : bool
    {
        if ( filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) )
            return true;

        return false;
    }

    /**
     * Validate an IPv4 IP address
     *
     * @param string $ip
     *
     * @return boolean - true/false
     */
    public static function isValidIPv4RegEx( $ip ) : bool
    {
        return preg_match('/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/', $ip);
    }

    /**
     * Validate an IPv4 IP address
     * excluding private range addresses
     *
     * @param string $ip
     *
     * @return boolean - true/false
     */
    public static function isValidIPv4NoPriv( $ip ) : bool
    {
        if ( filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE) )
            return true;

        return false;
    }

    /**
     * Validate an IPv6 IP address
     *
     * @param string $ip
     *
     * @return boolean - true/false
     */
    public static function isValidIPv6( $ip ) : bool
    {
        if ( filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) )
            return true;

        return false;

    }

    /**
     * Validate an IPv6 IP address
     * excluding private range addresses
     *
     * @param string $ip
     *
     * @return boolean - true/false
     */
    public static function isValidIPv6NoPriv( $ip ) : bool
    {
        if ( filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE) )
            return true;

        return false;

    }

    /**
     * Convert ip address to ip number
     *
     * @param $ip
     *
     * @return float|int
     */
    public static function ipToNumber( $ip )
    {
        if ( trim($ip) == '' )
            return 0;

        $tmp = preg_split("#\.#", $ip);

        return ($tmp[ 3 ] + $tmp[ 2 ] * 256 + $tmp[ 1 ] * 256 * 256 + $tmp[ 0 ] * 256 * 256 * 256);
    }
}