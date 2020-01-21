<?php

namespace Vellum\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Vellum\Contracts\Resource;
// use Illuminate\Support\Facades\View;

class ShortcodeComposer
{

    protected $shortcodes = [];

    public function __construct(?Resource $resource)
    {
        if(!$resource) return null;

       	$this->shortcodes = app(Pipeline::class)
       		->send([])
       		->through(config('shortcodes'))
       		->thenReturn();
    }


    public function compose(View $view)
    {
        $view->with('shortcodes', $this->shortcodes);
    }
}
