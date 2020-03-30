<?php

namespace Vellum\Filters;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;
use Vellum\Filters\Filter;
use Illuminate\Support\Str;

class Sort extends Filter
{
	protected function applyFilter(Builder $builder)
	{
		if (request($this->filterName()) != null) {
			$builder->orderBy(
				request($this->sortFieldName()),
				request($this->filterName())
			);
		} else {
			$module = request()->segment(1);
    		$module = Str::studly(Str::slug($module, '_'));
			$tableName = ($module) ? Str::snake(Str::plural($module)) : '';

			if (Schema::hasColumn($tableName, 'id')) {
				$builder->orderBy('id', 'desc');
			}
		}

		return $builder;
	}

	protected function sortFieldName()
	{
		return 'sort_field';
	}


}
