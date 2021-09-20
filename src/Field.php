<?php

namespace Cafesource\Helper;

class Field
{
    /**
     * Selected
     * add attribute selected
     *
     * @param $name
     * @param $value
     *
     * @return string|null
     */
    public static function selected( $name, $value )
    {
        if ( $name == $value )
            return 'selected';

        return null;
    }

    /**
     * Checked
     * add attribute checkbox
     *
     * @param $name
     * @param $value
     *
     * @return string|null
     */
    public static function checked( $name, $value )
    {
        if ( $name == $value )
            return 'checked';

        return null;
    }
}
