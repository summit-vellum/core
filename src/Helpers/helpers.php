<?php

function template($blade, $data, $module)
{
    return view()->first([
        $module.'::'.$blade,
        'vellum::'.$blade,
        $blade
        ], $data
    );
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
