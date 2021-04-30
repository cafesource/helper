<?php

namespace Cafesource\Helper\Image;

abstract class Image
{
    protected $image = null;
    protected $path  = null;
    protected $url   = null;

    abstract protected function file();

    public function name()
    {

    }

    public function has( $path )
    {
        if ( file_exists($path) )
            return true;

        return false;
    }

    public function path( $url )
    {
        return public_path($url);
    }

    public function url( $url )
    {
        return asset($url);
    }

    public function extension( $name )
    {
        $explode = explode('.', $name);
        return end($explode);
    }

    public function size( $path, $format = 'kb' )
    {
        return filesize($path);
    }

}