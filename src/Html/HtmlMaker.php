<?php

namespace Cafesource\Helper\Html;

abstract class HtmlMaker
{
    public function __construct()
    {
    }

    /**
     * @param array $items
     *
     * @return string
     */
    public function classes( array $items ) : string
    {
        return implode(' ', $items);
    }

    /**
     * @param array $items
     *
     * @return string
     */
    public function attributes( array $items ) : string
    {
        $output = '';
        foreach ( $items as $key => $value )
            $output .= " {$key}='{$value}'";

        return $output;
    }
}