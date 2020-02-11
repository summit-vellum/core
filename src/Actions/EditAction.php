<?php

namespace Vellum\Actions;

use Illuminate\Support\Facades\Route;
use Vellum\Actions\BaseAction;
use Vellum\Contracts\Actionable;

class EditAction extends BaseAction implements Actionable
{
    public function icon()
    {
        return template('icons.icon')->with(['icon' => 'edit'])->render();
    }

    public function link($id, $data = [])
    {
        $module = explode('.', Route::current()->getName())[0];
        $this->isLock($data, $module);
        $this->isAutosaved($data, $module);

        if ($this->isLockIcon) {
            return 'javascript:void(0)';
         }

        return route($module . '.edit', $id);
    }

    public function styles()
    {
        return collect([
            'normal' => [
                'mx-1',
                'd-inline-block',
                'hover:text-gray-500',
                ($this->isLockIcon) ? 'cursor-not-allowed text-gray-400' : 'text-teal-400',
                ($this->isLockIcon) ? 'cursor-not-allowed' : ''
            ],
            'button' => [
                'bg-blue-500',
                'rounded',
                'px-4',
                'py-2',
                'text-white',
                'hover:bg-blue-700',
                'font-semibold',
                'shadow',
                'inline-flex',
                'items-center mr-2',
                ($this->isLockIcon) ? 'cursor-not-allowed' : ''
            ],
        ]);
    }

    public function attributes()
    {
        return [
            //...
        ];
    }

    public function tooltip()
    {
        return null;
    }

    public function label()
    {
        return 'Edit';
    }

    public function permission()
    {
        return 'update';
    }

    public function withDialog()
    {
    	return false;
    }
}
