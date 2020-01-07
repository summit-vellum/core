<?php

namespace Vellum\Actions;

use Illuminate\Support\Facades\Route;
use Vellum\Actions\BaseAction;
use Vellum\Contracts\Actionable;

class DeleteAction extends BaseAction implements Actionable
{
    public function icon()
    {
        return view('vellum::icons.icon')->with(['icon' => 'trash'])->render();
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
                'd-inline-block',
                'text-red-400',
                'hover:text-red-500',
            ],
            'button' => [
                'bg-red-500',
                'rounded',
                'px-4',
                'py-2',
                'text-white',
                'hover:bg-red-700',
                'font-semibold',
                'shadow',
                'inline-flex',
                'items-center mr-2',
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
        return 'Delete';
    }

    public function permission()
    {
        return 'delete';
    }
}
