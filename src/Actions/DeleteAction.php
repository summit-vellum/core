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
            ],
        ]);
    }

    public function attributes($data = [])
    {
    	$type = 'DELETE';
    	$action = 'disable';
        return [
            'data-toggle' => 'modal',
            'data-target' => '#deleteResourceDialog',
            'data-ajax-modal' => '{"items":{"title":"Are you sure you want to '.$action.' this item?","author":"","header":"Disable","dismiss":"Cancel and go back","continue":"Continue and '.$action.'","subtext":""},"params":{"url":"'.$this->link($data->id, $data).'","type":"'.$type.'"}}'
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

    public function withDialog()
    {
    	return true;
    }
}
