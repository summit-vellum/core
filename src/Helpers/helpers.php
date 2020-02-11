<?php

function template($blade, $data = [], $module = '')
{
    $blades = [];

    if ($module) {
        $blades[] = $module.'::'.$blade;
    }

    $blades[] = 'vellum::'.$blade;
    $blades[] = $blade;

    $trace = debug_backtrace();

    if (isset($trace[1]['class'])) {
        return view()->first($blades, $data);
    }

    return view()->first($blades, $data)->name();
}

function non_breaking($string)
{
    return html_entity_decode(str_replace(' ', '&nbsp;', $string));
}

function selected($attributes, $value, $currentValue)
{
    return old($attributes['id'], $value) == $currentValue ? 'selected' : '';
}

/**
 * Converts an array of attributes to an html attribute string.
 *
 * @param array $attributes
 *
 * @return string
 */
function arrayToHtmlAttributes(array $attributes = array())
{
    $attributeString = '';
    if (count($attributes) > 0) {
        foreach ($attributes as $key => $value) {
            $attributeString .= " ".$key."='".$value."'";
        }
    }
    return $attributeString;
}

function check_cross_auth() {

    if (auth()->user()) {
        $currentToken = auth()->user()->cross_token;
        $sessionToken = session()->get('cross_token');

        if ($currentToken == $sessionToken) {
            return true;
        }
    }

    return false;
}
