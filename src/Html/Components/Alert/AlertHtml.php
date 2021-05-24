<?php

namespace Cafesource\Helper\Html\Components\Alert;

use Cafesource\Helper\Html\HtmlMaker;

class AlertHtml extends HtmlMaker
{
    /**
     * @param $title
     * @param $class
     *
     * @return string
     */
    public function title( $title, $class ) : string
    {
        return "<div class='{$class}'>{$title}</div>";
    }

    /**
     * @param      $content
     * @param null $class
     * @param null $wrap
     *
     * @return string
     */
    public function content( $content, $class = null, $wrap = null ) : string
    {
        $class = $this->classes($class ?? []);
        $wrap  = $this->classes($wrap ?? []);

        return "<div class='{$wrap}'><div class='{$class}'>{$content}</div></div>";
    }

    /**
     * @param $alert
     * @param $items
     *
     * @return string
     */
    public function buttons( $alert, $items ) : string
    {
        $output = "<div class='{$alert->getClass('buttons.class', ['alert-buttons'])}'>";
        foreach ( $items as $button )
            $output .= $this->button($alert, $button);

        $output .= '</div>';

        return $output;
    }

    /**
     * @param $alert
     * @param $button
     *
     * @return string
     */
    public function button( $alert, $button ) : string
    {
        $output = "<a{$alert->getAttributes(null, [
            'href'  => $button[ "url" ],
            'class' => $alert->getClass(null, $button[ "class" ]),
        ])}>";

        if ( isset($button[ 'icon' ]) )
            $output .= "<i class='{$alert->getClass(null, $button[ "icon" ])}'></i>";

        if ( isset($button[ 'text' ]) )
            $output .= "<span>{$button[ 'text' ]}</span>";

        $output .= '</a>';

        return $output;
    }
}