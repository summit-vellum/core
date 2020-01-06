<?php

namespace Vellum\Actions;


class BaseAction
{

    public function getAttributes($data)
    {
        if(count($this->attributes($data)) === 0) {
            return null;
        }
        
        return arrayToHtmlAttributes($this->attributes($data));
    }

    public function getStyles($style = 'normal')
    {
        return implode(' ', $this->styles()[$style]);
    }


}