<?php

namespace Vellum\Actions;

class BaseAction
{

    protected $isLockIcon = false;
    protected $user;

    public function getAttributes($data)
    {
        if (count($this->attributes($data)) === 0) {
            return null;
        }

        return arrayToHtmlAttributes($this->attributes($data));
    }

    public function getStyles($style = 'normal')
    {
        return implode(' ', $this->styles()[$style]);
    }

    public function isLock($data, $module)
    {
        if (in_array($module, config('resource_lock'))) {

            $resource = $data->resourceLock;
            $this->isLockIcon = ($resource) ? true : false;
            $this->user = $resource;

        }
    }

    public function renderWithDialog()
    {
    	return $this->withDialog();
    }
}
