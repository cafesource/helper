<?php

namespace Cafesource\Helper;

class Url
{
    /**
     *  Get the file size of any remote resource (using curl),
     *  either in bytes or - default - as human-readable formatted string.
     *
     * @param string  $url     Takes the remote object's URL.
     * @param boolean $useHead Whether to use HEAD requests. If false, uses GET.
     *
     * @return  string                 Returns human-readable formatted size
     *                                  or size in bytes (default: formatted).
     */
    public static function fileSize( string $url, bool $useHead = true )
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_NOBODY         => 1,
        ));
        if ( false !== $useHead ) {
            curl_setopt($ch, CURLOPT_NOBODY, 1);
        }
        curl_exec($ch);
        # content-length of download (in bytes), read from Content-Length: field
        $clen = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        curl_close($ch);
        # cannot retrieve file size, return "-1"
        if ( !$clen ) {
            return -1;
        }

        return $clen; // return size in bytes
    }

    /**
     * @param false $removeQueryString
     *
     * @return string
     */
    public static function current( bool $removeQueryString = false ) : string
    {
        $pageURL = 'http';
        if ( $_SERVER[ "HTTPS" ] == "on" ) {
            $pageURL .= "s";
        }
        $pageURL .= "://";

        if ( $_SERVER[ "SERVER_PORT" ] != "80" ) {
            $pageURL .= $_SERVER[ "SERVER_NAME" ] . ":" . $_SERVER[ "SERVER_PORT" ] . $_SERVER[ "REQUEST_URI" ];
        } else {
            $pageURL .= $_SERVER[ "SERVER_NAME" ] . $_SERVER[ "REQUEST_URI" ];
        }

        if ( !$removeQueryString && $_SERVER[ 'QUERY_STRING' ] ) {
            $pageURL .= '?' . $_SERVER[ 'QUERY_STRING' ];
        }

        return $pageURL;
    }
}
