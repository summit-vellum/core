<?php

namespace Vellum\Actions;

use Illuminate\Support\Facades\Route;
use Vellum\Actions\BaseAction;
use Vellum\Contracts\Actionable;

class DeleteAction extends BaseAction implements Actionable
{
	public $dialog_details;
	public $with_dialog;

	public function __construct($dialogDetails = [], $withDialog = false)
	{
		/**
		 * array structure of dialogDetails
		 *
			 $dialogDetails = [
	    		'header' => 'header text in here',
	    		'valueDisplayedIn' => [
	    			'title' => 'field you want to be show in title bar',
	    			'subTxt' => 'field you want to be show in subTxt bar'
	    		],
	    		'dismiss' => 'white button text in here',
	    		'continue' => 'red button text in here'
	    	];
		 */
		$this->dialog_details = $dialogDetails;
		$this->with_dialog = $withDialog;
	}

    public function icon()
    {
        return template('vellum::icons.icon')->with(['icon' => 'trash'])->render();
    }

    public function link($id, $data = [])
    {
        $module = explode('.', Route::current()->getName())[0];
        $this->isLock($data, $module);
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
                (!$this->with_dialog) ? 'btn-delete' : '',
                ($this->isLockIcon) ? 'hide cursor-not-allowed text-gray-400' : 'text-teal-400'
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
                (!$this->with_dialog) ? 'btn-delete' : '',
                ($this->isLockIcon) ? 'hide cursor-not-allowed' : ''
            ],
        ]);
    }

    public function attributes($data = [])
    {
    	$type = 'DELETE';
    	$dataAttr = $data->getAttributes();
    	$attributes = [];

    	if ($this->with_dialog && isset($this->dialog_details) && !empty($this->dialog_details)) {
    		$title = isset($this->dialog_details['valueDisplayedIn']['title']) &&
    				 isset($dataAttr[$this->dialog_details['valueDisplayedIn']['title']]) ? $dataAttr[$this->dialog_details['valueDisplayedIn']['title']] : '';
	    	$subText = isset($this->dialog_details['valueDisplayedIn']['subText']) &&
	    			   isset($dataAttr[$this->dialog_details['valueDisplayedIn']['subText']]) ? $dataAttr[$this->dialog_details['valueDisplayedIn']['subText']] : '';

	        $attributes = [
	            'data-toggle' => 'modal',
	            'data-target' => '#deleteResourceDialog',
	            'data-ajax-modal' => '{"items":{"title":"'.$title.'","header":"'.$this->dialog_details['header'].'","dismiss":"'.$this->dialog_details['dismiss'].'","continue":"'.$this->dialog_details['continue'].'","subtext":"'.$subText.'"},"params":{"url":"'.$this->link($data->id, $data).'","type":"'.$type.'"}}'
	        ];
    	}


    	return $attributes;
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
    	return $this->with_dialog;
    }
}
