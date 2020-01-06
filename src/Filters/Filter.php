<?php

namespace Vellum\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Closure;


abstract class Filter
{
	public function handle($request, Closure $next)
	{
		if(
			!request()->has($this->filterName()) || 
			empty(request($this->filterName())) ||
			request($this->filterName()) === 0

		){
			return $next($request);
		}

		$builder = $next($request);

		return $this->applyFilter($builder);
	}

	protected function filterName()
	{
		return Str::snake(class_basename($this));
	}

	protected abstract function applyFilter(Builder $builder);
}
