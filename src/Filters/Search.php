<?php

namespace Vellum\Filters;

use Illuminate\Database\Eloquent\Builder;
use Vellum\Contracts\Resource;
use Vellum\Filters\Filter;
use Illuminate\Support\Str;

class Search extends Filter
{

	protected $searchFields;

	public function __construct(Resource $resource)
	{
		$this->searchFields = isset($resource->attributes['searchable']) ? collect($resource->attributes['searchable']) : [];
	}

	protected function applyFilter(Builder $builder)
	{
		$firstField = $this->searchFields->shift();

		$module = request()->segment(1);
    	$module = Str::slug($module, '_');

    	if ($module == 'history') {
    		$builder->whereTitleLike(request($this->filterName()));
    	} else {
    		$builder->where(function($builder) use($firstField){
				$builder->where($firstField, 'like', "%".request($this->filterName())."%");

				$this->searchFields->map(function($field) use($builder) {
		            $builder->orWhere($field, 'like', "%".request($this->filterName())."%");
		        });
			});
    	}

		return $builder;
	}


}
