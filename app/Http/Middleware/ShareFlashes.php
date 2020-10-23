<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShareFlashes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Inertia::share('flash', function () {
            return [
                'success' => \Session::get('success'),
                'error' => \Session::get('error'),
            ];
        });

        return $next($request);
    }
}
