<?php

namespace Vellum\Actions;

class BaseAction
{

    protected $isLockIcon = false;
    protected $isAutosaved = false;
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
            $this->isLockIcon = ($resource && $data->resourceLock->user->id != auth()->user()->id) ? true : false;
            $this->user = $resource;

        }
    }

    public function isAutosaved($data, $module)
    {
        if (in_array($module, config('autosave'))) {
            $resource = $data->autosave;
            $this->isAutosavedLock = ($resource) ? true : false;
        }
    }

    public function renderWithDialog()
    {
    	return $this->withDialog();
    }
}
