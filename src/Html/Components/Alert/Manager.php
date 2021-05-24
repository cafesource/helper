<?php

namespace Cafesource\Helper\Html\Components\Alert;

use Cafesource\Helper\Html\Components\Alert;

class Manager
{
    /**
     * @var mixed|null $name
     */
    protected $name;

    /**
     * @var array $alerts
     */
    protected array $alerts = [];

    public function __construct( $name = null )
    {
        $this->name = $name;
    }

    /**
     * Make the group alert
     *
     * @param $name
     * @param $callback
     *
     * @return Manager
     */
    public function group( $name, $callback ) : Manager
    {
        if ( !isset($this->alerts[ $name ]) )
            $this->alerts[ $name ] = new self($name);

        call_user_func($callback, $this->alerts[ $name ]);

        return $this;
    }

    /**
     * Add a alert
     *
     * @param $name
     * @param $callback
     *
     * @return Alert
     */
    public function add( $name, $callback ) : Alert
    {
        $this->alerts[ $name ] = new Alert($name);
        call_user_func($callback, $this->alerts[ $name ]);

        return $this->alerts[ $name ];
    }

    /**
     * Check the alerts of this place
     *
     * @param string|null $name
     *
     * @return bool
     */
    public function has( string $name = null ) : bool
    {
        if ( is_null($name) )
            return count($this->alerts) > 0;

        return array_key_exists($name, $this->alerts);
    }

    /**
     * The alert location
     *
     * @param string|null $name
     *
     * @return mixed
     */
    public function get( string $name = null )
    {
        if ( is_null($name) )
            return $this->alerts;

        if ( $this->has($name) )
            return $this->alerts[ $name ];

        return [];
    }

    /**
     * The alerts
     *
     * @return array
     */
    public function all() : array
    {
        return $this->alerts;
    }

    /**
     * Remove the alert with name from location
     *
     * @param $key
     */
    public function remove( $key )
    {
        unset($this->alerts[ $key ]);
    }

    /**
     * Remove all alert in location
     */
    public function removeAll()
    {
        $this->alerts = [];
    }

    /**
     * @return string
     */
    public function toHtml() : string
    {
        $html = '<div class="alerts">';
        foreach ( $this->all() as $alert )
            $html .= $alert->toHtml();

        $html .= '</div>';
        return $html;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        $items = [];
        foreach ( $this->all() as $alert )
            $items[ $alert->name() ] = $alert->all();

        return $items;
    }
}
