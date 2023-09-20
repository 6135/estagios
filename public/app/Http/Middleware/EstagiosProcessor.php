<?php

namespace App\Http\Middleware;

use Closure;
use http\Env\Request;
use Session;
use Illuminate\Support\Facades\Log;
use Config;

class EstagiosProcessor
{
    public function __construct()
    {
        //$request->session()->put('profile','empresa');
        //Session(['profile','empresa']);
        //Session::save();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //$request->session()->put('profile','docente');
        //Session(['profile','docente']);
        //Session::save();

        $this->handleGlobalVars($request);

        return $next($request);
    }

    public function handleGlobalVars($request) {
        //session(['debug' => config('estagios.debug')]);
        //$request->session()->put('debug',config('estagios.debug'));

        //session(['debug' => true]);

        if(config('estagios.debug')) {
            Session::put('debug',true);
            Log::debug('debug true');
        } else {
            Session::put('debug',false);
            Log::debug('debug false');
        }

        //Session::put('debug',true);
        Session::save();
    }
}
