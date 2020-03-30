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
    protected $js = [];
    protected $css = [];
    protected $renderAsHtml = [];
    protected $label = [];
    protected $isFiltered = false;

    public function __construct(?Resource $resource)
    {
        if(!$resource) return null;
        $isFiltered = false;

        foreach ($resource->getFilterFields() as $filter) {
            $class = new $filter;
            $className = $class->options();
            $this->js[] = $class->js();
            $this->css[] = $class->css();
            $this->label[$class->key()] = $class->label();

            if (!$this->isFiltered && request($class->key()) != '') {
            	$this->isFiltered = true;
            }

            if ($class->html() != '') {
            	$this->filters[$class->key()] = $class->html();
            	$this->renderAsHtml[$class->key()] = true;
            } else {
            	$this->renderAsHtml[$class->key()] = false;
            	if (!is_array($className) && class_exists($className)) {
	            	$key = 'select_'.$class->key();
		            $options = Cache::remember($key, 1, function() use($className){
		                return (new $className)->all()->pluck('name', 'id')->toArray();
		            });
	            	$this->filters[$class->key()] = $options;
	            } else {
	            	$this->filters[$class->key()] = $className;;
	            }
            }
        }
    }

    public function compose(View $view)
    {
        $view->with('filters', $this->filters)
        	->with('filtersJs', $this->js)
        	->with('filtersCss', $this->css)
        	->with('filtersLabel', $this->label)
        	->with('renderAsHtml', $this->renderAsHtml)
        	->with('isFiltered', $this->isFiltered);
    }
}
