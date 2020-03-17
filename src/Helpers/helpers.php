<?php
function isHTML($string){
   return preg_match("/<[^<]+>/", $string, $m) != 0;
}

function compressHTML($html)
{
    return trim(preg_replace('/\s+/', ' ', $html));
}

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

function seoUrl($string, $replaceStr)
{
    //Lower case everything
    $string = strtolower($string);

    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", '', $string);

    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", ' ', $string);

    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", $replaceStr, $string);

    return $string;
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

function commaAndOrSeperator($arr)
{
	$line = '';
	foreach($arr as $key => $item) {
        if ($key > 0 && $key != (count($arr) - 1)) {
            $line .= ', ';
        } else if($key != 0 && count($arr) > 1){
            $line .= ' or ';
        }

        $line .= $item;
	}

	return $line;
}
