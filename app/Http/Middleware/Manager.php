<?php

namespace App\Http\Middleware;

use Closure;

class Manager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(\Auth::user()->role != 'manager' && \Auth::user()->role != 'landlord') {
            return redirect()->back()->withErrors(['You do not have permission.']);
        }
        return $next($request);
    }
}
