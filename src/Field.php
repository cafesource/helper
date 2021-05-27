<?php

namespace Cafesource\Helper;

/**
 * Class Field
 *
 * @package Larabase\Cms\Helper
 */
class Field
{
    /**
     * Selected
     * add attribute selected
     *
     * @param string $name
     * @param string $value
     *
     * @return string|null
     */
    public static function selected( string $name, string $value )
    {
        if ( $name == $value )
            return 'selected';

        return null;
    }

    /**
     * Checked
     * add attribute checkbox
     *
     * @param string $name
     * @param string $value
     *
     * @return string|null
     */
    public static function checked( string $name, string $value )
    {
        if ( $name == $value )
            return 'checked';

        return null;
    }
}
