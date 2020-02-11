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

            return template('icons.icon')->with(['icon' => 'unlock'])->render() . $editedBy . ' currently editing this article.';
        }

        return template('vellum::icons.icon')->with(['icon' => 'trash'])->render();
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
                'btn-unlock',
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
                'btn-unlock',
            ],
        ]);
    }

    public function attributes($data = [])
    {
        return [
            'data-toggle' => 'modal',
            'data-target' => '#deleteResourceDialog',
            'data-ajax-modal' => '{"items":{"title":"Are you sure you want to disable this item?","author":"","header":"Disable","dismiss":"Cancel and go back","continue":"Continue and disable","subtext":""},"params":{"url":"'.$this->link($data->id, $data).'","type":"DELETE"}}'
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

    public function withDialog()
    {
    	return true;
    }
}
