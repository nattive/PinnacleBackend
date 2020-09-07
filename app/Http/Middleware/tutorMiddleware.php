<?php

namespace App\Http\Middleware;

use Closure;

class tutorMiddleware
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
        if (count(\auth()->user->tutor) <= 0) {
            return response()->json('You are not a tutor', 401);
        }
        return $next($request);
    }
}
