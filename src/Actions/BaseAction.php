<?php

namespace Vellum\Actions;

class BaseAction
{

    protected $isLocked = false;
    protected $isAutosavedLock = false;
    protected $user;
    protected $isResourceLocked;

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
            $this->isLocked = ($resource && $data->resourceLock->user->id != auth()->user()->id) ? true : false;
            $this->isResourceLocked = ($resource) ? true : false;
            $this->user = $resource;
        }
    }

    public function isAutosaved($data, $module)
    {
        if (in_array($module, config('autosave'))) {
            $resource = $data->autosaves;
            $this->isAutosavedLock = ($resource && $data->autosaves['user_id'] == auth()->user()->id) ? true : false;
        }
    }

    public function renderWithDialog()
    {
    	return $this->withDialog();
    }
}
