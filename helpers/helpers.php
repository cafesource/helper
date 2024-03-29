<?php

use Cafesource\Helper\Field;

if ( !function_exists('selected') ) {
    /**
     * @param $name
     * @param $value
     *
     * @return string|null
     */
    function selected( $name, $value )
    {
        return Field::selected($name, $value);
    }
}

if ( !function_exists('checked') ) {
    /**
     * @param $name
     * @param $value
     *
     * @return string|null
     */
    function checked( $name, $value )
    {
        return Field::checked($name, $value);
    }
}