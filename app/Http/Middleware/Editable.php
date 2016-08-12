<?php

namespace App\Http\Middleware;

use Closure;

class Editable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $club_id)
    {
        return $next($request);
    }
}
