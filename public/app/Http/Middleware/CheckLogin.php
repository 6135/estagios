<?php

namespace App\Http\Middleware;
use App\Http\Controllers\Auth\Authentication;
use Illuminate\Support\Facades\Log;

use Closure;

class CheckLogin
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
        $response  = $next($request);
        if(!Authentication::check()) {
            abort(403);
        }
        return $response;
    }
}
