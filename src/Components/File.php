<?php

namespace Cafesource\Helper\Components;

use Intervention\Image\ImageManager;

class File
{
    protected array $file = [];

    public function __construct( $path )
    {
        $info = pathinfo($path);
        $this->set('path', $path);
        $this->set('dirname', $info[ 'dirname' ] ?? null);
        $this->set('basename', $info[ 'basename' ] ?? null);
        $this->set('extension', $info[ 'extension' ] ?? null);
        $this->set('filename', $info[ 'filename' ] ?? null);

        if ( file_exists($path) && is_file($path) ) {
            $this->set('mime', finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path));
        }
    }

    public function __set( $name, $value )
    {
        $this->$name = $value;
    }

    public function __get( $name )
    {
        if ( isset($this->$name) )
            return $this->$name;

        return null;
    }

    public function info()
    {
        return $this->file;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return void
     */
    public function set( $key, $value )
    {
        $this->file[ $key ] = $value;
    }

    /**
     * @param      $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function get( $key, $default = null )
    {
        if ( array_key_exists($key, $this->file) )
            return $this->file[ $key ];

        return $default;
    }

    /**
     * @param $location
     *
     * @return $this
     */
    public function path( $location ) : File
    {
        return new self($location);
    }

    /**
     * @param $url
     *
     * @return $this
     */
    public function url( $url ) : File
    {
        $this->set('url', $url);
        return $this;
    }


    /**
     * @return bool
     */
    public function exists() : bool
    {
        if ( file_exists($this->get('path')) )
            return true;

        return false;
    }

    /**
     * @return false|mixed|string
     */
    public function getExtension()
    {
        return $this->get('extension');
    }

    /**
     * @param $lang
     * - Fa: بایت, کیلوبایت, مگابایت, گیگابایت, ترابایت
     * - En: B, KB, MB, GB, TB
     *
     * @return string|int|null
     */
    public function getSize( $lang = null )
    {
        $size = filesize($this->get('path'));

        if ( !is_null($lang) )
            return \Cafesource\Helper\File::byteFormat($size, 2, $lang);

        return $size;
    }

    /**
     * Remove file
     */
    public function remove()
    {
        unlink($this->file[ 'path' ]);
    }

    /**
     * File move the location
     *
     * @param $path
     */
    public function move( $path )
    {
        $this->rename($this->get('path'), $path);
    }

    /**
     * Rename file
     *
     * @param $oldName
     * @param $name
     */
    public function rename( $oldName, $name )
    {
        rename($oldName, $name);
    }

    /**
     * @param string[] $config
     *
     * @return ImageManager
     */
    public function intervention( array $config = ['driver' => 'gd'] ) : ImageManager
    {
        return new ImageManager($config);
    }
}