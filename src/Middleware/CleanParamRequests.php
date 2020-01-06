<?php

namespace Vellum\Middleware;

use Closure;

class CleanParamRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if($request->has(['_token', '_method'])){
            unset($request['_token']);
            unset($request['_method']);
        }

        return $next($request);
    }
}
