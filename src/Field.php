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
    public static function selected( $name, $value ) : ?string
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
    public static function checked( $name, $value ) : ?string
    {
        if ( $name == $value )
            return 'checked';

        return null;
    }
}
