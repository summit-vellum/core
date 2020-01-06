<?php

namespace Vellum\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Vellum\Contracts\Resource;


class EagerLoad
{
	
	protected $eagerLoadFields = [];

	public function __construct(Resource $resource)
	{
		if(in_array('relation', $resource->attributes)) {

		$this->eagerLoadFields = collect($resource->attributes['relation'])->map(
			function($relation) {
				$hasOne = explode('.', $relation);
				if(count($hasOne) > 1) {
					return $hasOne[0];
				}
			})->filter(function($relation){
				return $relation;
			})->values()->toArray();
		}
	}

	public function handle($request, Closure $next)
	{
		if(count($this->eagerLoadFields) === 0){
			return $next($request);
		}

		$builder = $next($request);

		return $builder->with($this->eagerLoadFields);
	}

}
