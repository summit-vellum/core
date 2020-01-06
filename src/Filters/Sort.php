<?php

namespace Vellum\Filters;

use Illuminate\Database\Eloquent\Builder;
use Vellum\Filters\Filter;

class Sort extends Filter
{
	protected function applyFilter(Builder $builder)
	{
		return $builder->orderBy(
			request($this->sortFieldName()), 
			request($this->filterName())
		);
	}

	protected function sortFieldName()
	{
		return 'sort_field';
	}


}
