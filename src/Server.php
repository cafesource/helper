<?php

namespace Cafesource\Helper;

class Server
{
    /**
     * @return false|string
     */
    public static function php()
    {
        return phpversion();
    }
}