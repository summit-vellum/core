<?php

namespace Vellum\Actions;

use Illuminate\Support\Facades\Route;
use Vellum\Actions\BaseAction;
use Vellum\Contracts\Actionable;

class DeleteAction extends BaseAction implements Actionable
{
    public function icon()
    {
        return template('vellum::icons.icon')->with(['icon' => 'trash'])->render();
    }

    public function link($id, $data = [])
    {
        $module = explode('.', Route::current()->getName())[0];
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
                'btn-unlock',
            ],
        ]);
    }

    public function attributes($data = [])
    {
        return [];
    }

    public function tooltip()
    {
        return null;
    }

    public function label()
    {
        return 'Delete';
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
