<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class SecureSuperUserMiddleware
{

    // Blocked IP addresses and networks
    public $restrictedIps = [];
    public $restrictedNetworks = ['10.5.0', '10.16.0'];


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
	// Changed to false to allow working from different networks: Gui
        $blocked = false;

        if (in_array($request->ip(), $this->restrictedIps)) {
            $blocked = false;
        }

        foreach ($this->restrictedNetworks as $restrictedNetwork) {
            if (Str::contains($request->ip(), $restrictedNetwork)) {
                $blocked = false;
            }
        }
	// Changed to allow working from different IPs: Gui
        if($blocked) {
           return response()->json(['message' => "You are not allowed to access this site.", 'ipAddress' => $request->ip()]);
        }

        return $next($request);
    }
}
