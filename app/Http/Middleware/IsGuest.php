<?php

namespace App\Http\Middleware;

use Closure;

class IsGuest
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
        if (!auth()->check()) {
            return $next($request);
        }

        if (auth()->user() && auth()->user()->roles == 'ADMIN') {
            return redirect()->route('admin-dashboard');
        } else {
            return $next($request);
        }
    }
}
