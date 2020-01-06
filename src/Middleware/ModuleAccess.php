<?php

namespace Vellum\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ModuleAccess
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
        if(!Auth::check()) {
            return $next($request);
        }


        $module = $request->segment(1);
        
        if($module === 'modal') {
            $module = $request->segment(2);
        }

        if(!Auth::user()->modules()->contains($module)) {
            abort(403);
        }

        return $next($request);
    }
}
