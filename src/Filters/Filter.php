<?php

namespace Vellum\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Closure;


abstract class Filter
{
	public function handle($request, Closure $next)
	{
		$builder = $next($request);

		return $this->applyFilter($builder);
	}

	protected function filterName()
	{
		return Str::snake(class_basename($this));
	}

	protected abstract function applyFilter(Builder $builder);
}
