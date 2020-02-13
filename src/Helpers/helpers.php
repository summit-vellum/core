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

    //for when the method is called in controller
    if (isset($trace[1]['class'])) {
        return view()->first($blades, $data);
    }

    //for when the method is called in blades
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

function check_cross_auth()
{

    if (auth()->user()) {
        $currentToken = auth()->user()->cross_token;
        $sessionToken = session()->get('cross_token');

        if ($currentToken == $sessionToken) {
            return true;
        }
    }

    return false;
}

function addScript($section, $url, $attributes = array(), $secure = null)
{
	$scriptKey = sha1($url);

    $GLOBALS['scriptHelper'][$section]['script'][$scriptKey] = array(
        'url' => $url,
        'attributes' => $attributes,
        'secure' => $secure,
    );
}

function addStyle($section, $url, $attributes = array(), $secure = null)
{
	$scriptKey = sha1($url);

    $GLOBALS['cssHelper'][$section]['style'][$scriptKey] = array(
        'url' => $url,
        'attributes' => $attributes,
        'secure' => $secure,
    );
}

function script($section)
{
	 if (isset($GLOBALS['scriptHelper'][$section]['script'])) {
        foreach ($GLOBALS['scriptHelper'][$section]['script'] as $script) {
            echo Html::script($script['url'], $script['attributes'], $script['secure']);
        }
    }
}

function style($section)
{
	if (isset($GLOBALS['cssHelper'][$section]['style'])) {
		 foreach ($GLOBALS['cssHelper'][$section]['style'] as $style) {
            echo Html::style($style['url'], $style['attributes'], $style['secure']);
        }
	}
}
