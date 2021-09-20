<?php

namespace Cafesource\Helper;

class Client
{
    /**
     * Get client ip
     *
     * @return array|false|string
     */
    public static function ip()
    {
        if ( getenv('HTTP_CLIENT_IP') )
            return getenv('HTTP_CLIENT_IP');

        if ( getenv('HTTP_X_FORWARDED_FOR') )
            return getenv('HTTP_X_FORWARDED_FOR');

        if ( getenv('HTTP_X_FORWARDED') )
            return getenv('HTTP_X_FORWARDED');

        if ( getenv('HTTP_FORWARDED_FOR') )
            return getenv('HTTP_FORWARDED_FOR');

        if ( getenv('HTTP_FORWARDED') )
            return getenv('HTTP_FORWARDED');

        if ( getenv('REMOTE_ADDR') )
            return getenv('REMOTE_ADDR');

        return 'UNKNOWN';
    }

    /**
     * System os and device
     *
     * @param null $key
     *
     * @return string|array
     */
    public static function system( $key = null )
    {
        $userAgent = $_SERVER[ 'HTTP_USER_AGENT' ];
        $platform  = "Unknown OS Platform";
        $os        = [
            '/windows phone 8/i'    => 'Windows Phone 8',
            '/windows phone os 7/i' => 'Windows Phone 7',
            '/windows nt 6.3/i'     => 'Windows 8.1',
            '/windows nt 6.2/i'     => 'Windows 8',
            '/windows nt 6.1/i'     => 'Windows 7',
            '/windows nt 6.0/i'     => 'Windows Vista',
            '/windows nt 5.2/i'     => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     => 'Windows XP',
            '/windows xp/i'         => 'Windows XP',
            '/windows nt 5.0/i'     => 'Windows 2000',
            '/windows me/i'         => 'Windows ME',
            '/win98/i'              => 'Windows 98',
            '/win95/i'              => 'Windows 95',
            '/win16/i'              => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i'        => 'Mac OS 9',
            '/ubuntu/i'             => 'Ubuntu',
            '/linux/i'              => 'Linux',
            '/iphone/i'             => 'iPhone',
            '/ipod/i'               => 'iPod',
            '/ipad/i'               => 'iPad',
            '/android/i'            => 'Android',
            '/blackberry/i'         => 'BlackBerry',
            '/webos/i'              => 'Mobile'
        ];

        $found  = false;
        $device = '';
        foreach ( $os as $regex => $value ) {
            if ( $found )
                break;

            else if ( preg_match($regex, $userAgent) ) {
                $platform = $value;
                $device   = !preg_match('/(windows|mac|linux|ubuntu)/i', $platform)
                    ? 'MOBILE' : (preg_match('/phone/i', $platform) ? 'MOBILE' : 'SYSTEM');
            }
        }

        $device = !$device ? 'SYSTEM' : $device;
        $system = [
            'os'     => $platform,
            'device' => $device
        ];

        return !is_null($key) ? $system[ $key ] : $system;
    }

    /**
     * The user browser
     *
     * @return array|string
     */
    public static function browser( $key = null )
    {
        $userAgent = $_SERVER[ 'HTTP_USER_AGENT' ];
        $browser   = 'Unknown';
        $version   = '?';

        // Next get the name of the useragent yes seperately and for good reason
        if ( preg_match('/MSIE/i', $userAgent) && !preg_match('/Opera/i', $userAgent) ) {
            $browser = 'Internet Explorer';
            $ub      = "MSIE";
        } elseif ( preg_match('/Firefox/i', $userAgent) ) {
            $browser = 'Mozilla Firefox';
            $ub      = "Firefox";
        } elseif ( preg_match('/OPR/i', $userAgent) ) {
            $browser = 'Opera';
            $ub      = "OPR";
        } elseif ( preg_match('/Chrome/i', $userAgent) && !preg_match('/Edge/i', $userAgent) ) {
            $browser = 'Google Chrome';
            $ub      = "Chrome";
        } elseif ( preg_match('/Safari/i', $userAgent) && !preg_match('/Edge/i', $userAgent) ) {
            $browser = 'Apple Safari';
            $ub      = "Safari";
        } elseif ( preg_match('/Netscape/i', $userAgent) ) {
            $browser = 'Netscape';
            $ub      = "Netscape";
        } elseif ( preg_match('/Edge/i', $userAgent) ) {
            $browser = 'Edge';
            $ub      = "Edge";
        } elseif ( preg_match('/Trident/i', $userAgent) ) {
            $browser = 'Internet Explorer';
            $ub      = "MSIE";
        }

        // finally get the correct version number
        $known   = ['Version', $ub, 'other'];
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if ( !preg_match_all($pattern, $userAgent, $matches) ) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches[ 'browser' ]);
        if ( !empty($matches[ 'version' ]) && $i >= 1 ) {
            $version = $matches[ 'version' ][ 0 ];
        }


        $info = [
            'name'    => $browser,
            'version' => $version
        ];

        return !is_null($key) ? $info[ $key ] : $info;
    }
}
