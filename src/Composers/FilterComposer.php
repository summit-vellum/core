<?php

namespace Vellum\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Vellum\Contracts\Resource;
// use Illuminate\Support\Facades\View;

class FilterComposer
{

    protected $filters = [];

    public function __construct(?Resource $resource)
    {
        if(!$resource) return null;

        foreach($resource->getFilterFields() as $filter) {
            $class = new $filter;
            $className = $class->options();
            $key = 'select_'.$class->key();
            $options = Cache::remember($key, 60, function() use($className){
                return (new $className)->all()->pluck('name', 'id')->toArray();
            });
            $this->filters[$class->key()] = $options;
        }
    }


    public function compose(View $view)
    {
        $view->with('filters', $this->filters);
    }
}
