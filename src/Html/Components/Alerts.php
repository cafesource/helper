<?php

namespace Cafesource\Helper\Html\Components;

use Cafesource\Helper\Html\Components\Alert\Manager;

/**
 * Class Alerts
 * @method static bool has()
 * @method static mixed get(string $name)
 * @method static mixed all()
 * @method static Manager group($name, callable $callback)
 * @method static Alert add($name, callable $callback)
 */
class Alerts
{
    /**
     * The alert manager with singleton
     *
     * @var mixed $manager
     */
    protected static $manager = null;

    /**
     * @return Manager
     */
    public static function manager() : Manager
    {
        if ( is_null(self::$manager) )
            self::$manager = new Manager();

        return self::$manager;
    }

    /**
     * @param $method
     * @param $params
     *
     * @return false|mixed
     */
    public function __call( $method, $params )
    {
        return self::manager()->$method(...$params);
    }

    /**
     * @param $method
     * @param $params
     *
     * @return false|mixed
     */
    public static function __callStatic( $method, $params )
    {
        return self::manager()->$method(...$params);
    }
}
