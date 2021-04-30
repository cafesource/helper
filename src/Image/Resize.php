<?php

namespace Cafesource\Helper\Image;


class Resize extends Image implements ImageInterface
{
    protected $file = null;

    protected function file()
    {
        return $this->file;
    }

    public function image( $file )
    {
        $this->file = $file;

        return $this;
    }
}