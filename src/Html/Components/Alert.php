<?php

namespace Cafesource\Helper\Html\Components;

use Illuminate\Support\Arr;
use Cafesource\Helper\Html\Components\Alert\AlertHtml;

class Alert
{
    /**
     * The alert name or key
     *
     * @var string $name
     */
    protected string $name;

    /**
     * The alert data
     *
     * @var array $alert
     */
    protected array $alert = [];

    /**
     * @var AlertHtml $html
     */
    protected AlertHtml $html;

    public function __construct( $name )
    {
        $this->name = $name;
        $this->html = new AlertHtml();
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set( $name, $value )
    {
        $this->alert[ $name ] = $value;
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    public function __get( $name )
    {
        if ( array_key_exists($name, $this->alert) )
            return $this->alert[ $name ];

        return null;
    }

    /**
     * The alert name
     *
     * @return string
     */
    public function name() : string
    {
        return $this->name;
    }

    /**
     * @param      $key
     * @param null $default
     *
     * @return mixed
     */
    public function get( $key, $default = null )
    {
        return Arr::get($this->alert, $key, $default);
    }

    /**
     * @param       $title
     * @param array $class
     *
     * @return $this
     */
    public function title( $title, array $class = [] ) : Alert
    {
        $this->alert[ 'title' ][ 'string' ] = $title;

        if ( !is_null($class) )
            $this->alert[ 'title' ][ 'class' ] = $class;

        return $this;
    }

    /**
     * @param $messages
     *
     * @return $this
     */
    public function items( $messages ) : Alert
    {
        $this->alert[ 'items' ] = $messages;
        return $this;
    }

    /**
     * @param      $text
     * @param null $wrapper
     *
     * @return $this
     */
    public function text( $text, $wrapper = null ) : Alert
    {
        $this->alert[ 'text' ][ 'string' ] = $text;

        if ( !is_null($wrapper) )
            $this->alert[ 'text' ][ 'class' ] = $wrapper;

        return $this;
    }

    /**
     * @param $html
     *
     * @return $this
     */
    public function html( $html ) : Alert
    {
        $this->alert[ 'html' ] = $html;
        return $this;
    }

    /**
     * @param array $class
     *
     * @return $this
     */
    public function class( array $class ) : Alert
    {
        $classes                  = $this->get('classes', []);
        $this->alert[ 'classes' ] = array_merge($classes, $class);
        return $this;
    }

    /**
     * @param array $attrs
     *
     * @return $this
     */
    public function attributes( array $attrs ) : Alert
    {
        $attributes             = $this->get('attrs', []);
        $this->alert[ 'attrs' ] = array_merge($attributes, $attrs);
        return $this;
    }

    /**
     * @param $color
     *
     * @return $this
     */
    public function color( $color ) : Alert
    {
        return $this->class(['alert', "alert-$color"]);
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function size( $value ) : Alert
    {
        $this->alert[ 'size' ] = $value;
        return $this;
    }

    /**
     * @param       $button
     * @param array $class
     *
     * @return $this
     */
    public function button( $button, array $class = [] ) : Alert
    {
        return $this->buttons([$button], $class);
    }

    /**
     * @param       $items
     * @param array $class
     *
     * @return $this
     */
    public function buttons( $items, array $class = [] ) : Alert
    {
        $buttons = $this->alert[ 'buttons' ][ 'items' ] ?? [];
        $items   = array_merge($items, $buttons);

        $this->alert[ 'buttons' ][ 'items' ] = $items;

        if ( !is_null($class) )
            $this->alert[ 'buttons' ][ 'class' ] = $class;

        return $this;
    }

    /**
     * @param      $name
     * @param null $default
     *
     * @return string
     */
    public function getClass( $name = null, $default = null ) : string
    {
        $classes = !is_null($name) ? $this->get($name, []) : [];
        if ( !is_null($default) )
            $classes = array_merge($default, $classes);

        return $this->html->classes($classes);
    }

    /**
     * @param string|null  $name
     * @param string|array $default
     */
    public function getAttributes( string $name = null, $default = null ) : string
    {
        $attributes = !is_null($name) ? $this->get($name, []) : [];

        if ( !is_null($default) )
            $attributes = array_merge($default, $attributes);

        return $this->html->attributes($attributes);
    }

    /**
     * @return string|null
     */
    public function getContent() : ?string
    {
        if ( !is_null($this->get('html')) )
            return $this->get('html');

        $output = $this->get('text.string');
        if ( !is_null($this->get('items')) ) {
            $output .= "<ul><li>" . implode('</li><li>', $this->get('items', [])) . "</li></ul>";
        }
        return $output;
    }

    /**
     * Convert alert to html
     *
     * @return string
     */
    public function toHtml() : string
    {
        $output = "<div class='{$this->getClass('classes')}'>";

        # The alert title
        $output .= $this->html->title($this->get('title.string'), $this->getClass('title.class', ['alert-title']));

        # The alert content
        $output .= $this->html->content($this->getContent(), $this->get('text.class'), ['alert-content']);

        # The alert buttons
        if ( $this->get('buttons.items', false) )
            $output .= $this->html->buttons($this, $this->get('buttons.items', []));

        $output .= '</div>';

        return $output;
    }

    /**
     * The alert to array
     *
     * @return array
     */
    public function toArray() : array
    {
        return $this->alert();
    }

    /**
     * The alert info
     *
     * @return array
     */
    public function alert() : array
    {
        return $this->alert;
    }
}