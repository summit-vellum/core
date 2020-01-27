<?php

namespace Vellum\Actions;

use Illuminate\Support\Facades\Route;
use Vellum\Actions\BaseAction;
use Vellum\Contracts\Actionable;

class DeleteAction extends BaseAction implements Actionable
{
    public function icon()
    {
        if ($this->isLockIcon) {

            $editedBy = (auth()->user()->id == $this->user['user_id']) ? 'You are ' : $this->user['name'] . ' is';

            return view('vellum::icons.icon')->with(['icon' => 'unlock'])->render() . $editedBy . ' currently editing this article.';
        }

        return view('vellum::icons.icon')->with(['icon' => 'trash'])->render();
    }

    public function link($id, $data = [])
    {
        $module = explode('.', Route::current()->getName())[0];

        $this->isLock($data, $module);

        if ($this->isLockIcon) {

            return route($module . '.unlock', $id);
        }

        return route($module . '.destroy', $id);
    }

    public function styles()
    {
        return collect([
            'normal' => [
                'mx-1',
                'pt-1',
                'flex',
                'whitespace-no-wrap',
                ($this->isLockIcon) ? 'hover:text-green-500' : 'hover:text-red-500',
                ($this->isLockIcon) ? 'text-green-400' : 'text-red-400',
                ($this->isLockIcon) ? 'btn-unlock' : 'btn-delete',
            ],
            'button' => [
                'rounded',
                'px-4',
                'py-2',
                'text-white',
                'font-semibold',
                'shadow',
                'inline-flex',
                'items-center mr-2',
                'whitespace-no-wrap',
                'icon-link',
                'd-inline-block',
                'mx-2',
                ($this->isLockIcon) ? 'hover:bg-green-700' : 'hover:bg-red-700',
                ($this->isLockIcon) ? 'bg-green-500' : 'bg-red-500',
                ($this->isLockIcon) ? 'btn-unlock' : 'btn-delete',
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
        if (!$this->isLockIcon) {
            return 'Delete';
        }
    }

    public function permission()
    {
        return 'delete';
    }
}
