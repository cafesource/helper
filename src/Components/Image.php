<?php

namespace Cafesource\Helper\Components;

class Image extends File
{
    public function __construct( $path )
    {
        parent::__construct($path);
    }

    /**
     * @return mixed
     */
    public function resize()
    {
        $img = $this->intervention()->make($this->get('path'))
            ->resize($this->width, $this->height)
            ->save($this->saveTo);

        return $img->response();
    }

    /**
     * @return mixed
     */
    public function crop()
    {
        $img = $this->intervention()->make($this->get('path'))
            ->crop($this->width, $this->height, $this->topLeft, $this->corner)
            ->save($this->saveTo);

        return $img->response();
    }

    /**
     * @param int $topLeft
     * @param int $corner
     *
     * @return $this
     */
    public function position( int $topLeft = 0, int $corner = 0 ) : Image
    {
        $this->topLeft = $topLeft;
        $this->corner = $corner;
        return $this;
    }

    /**
     * @param $path
     *
     * @return $this
     */
    public function watermark( $path ) : Image
    {
        $this->watermark = $path;
        return $this;
    }

    /**
     * @param $path
     *
     * @return $this
     */
    public function saveTo( $path ) : Image
    {
        $this->saveTo = $path;
        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function width( $value ) : Image
    {
        $this->width = $value;
        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function height( $value ) : Image
    {
        $this->height = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        $size = $this->getImageSize();
        return $size[ 0 ];
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        $size = $this->getImageSize();
        return $size[ 1 ];
    }

    /**
     * Get image size
     * width - height - bit - mimes
     *
     * @return array|false
     */
    public function getImageSize()
    {
        return getimagesize($this->get('path'));
    }
}