<?php


namespace Vellum\Repositories;


use Closure;

class IndexFields
{
    public function handle($request, Closure $next)
    {
        if(!$request) {
            return $next($request);
        }

        $fields = $next($request);

        return collect($fields)->filter(function($field){
            return $field->getAttribute('hideFromIndex') === null;
        })->keyBy(function($item){
            return $item->getAttribute('id');
        })->map(function($item){
            return $item->getAttributes();
        });
    }
}
