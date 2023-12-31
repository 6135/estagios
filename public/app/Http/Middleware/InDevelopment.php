<?php

namespace App\Http\Middleware;

use Closure;

class InDevelopment
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
        if(session()->get('login') != 'diogogl' || session()->get('login') != 'estagiodocente') {
            return redirect('indevelopment');
        }

        return $next($request);
    }
}
