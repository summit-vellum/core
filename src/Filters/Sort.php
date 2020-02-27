<?php

namespace Vellum\Filters;

use Illuminate\Database\Eloquent\Builder;
use Vellum\Filters\Filter;

class Sort extends Filter
{
	protected function applyFilter(Builder $builder)
	{
		if (request($this->filterName()) != null) {
			$builder->orderBy(
				request($this->sortFieldName()),
				request($this->filterName())
			);
		}

		return $builder;
	}

	protected function sortFieldName()
	{
		return 'sort_field';
	}


}
