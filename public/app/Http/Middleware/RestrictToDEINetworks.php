<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class RestrictToDEINetworks
{
    // Blocked IP addresses and networks
    public $restrictedIps = [];
    public $restrictedNetworks = ['10.15', '10.16'];


    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissionType = '')
    {
	
        $blocked = true;

        if($permissionType=='funcionariosOuComLogin') {
            $this->restrictedNetworks[] = '10.5.';

            //dd($this->restrictedNetworks);

            if(session()->get('login') != '') {
                $blocked = false;
                //dd("blocked");
            }
        }

        if (in_array($request->ip(), $this->restrictedIps)) {
            $blocked = false;
        }

        foreach ($this->restrictedNetworks as $restrictedNetwork) {
            if (Str::contains($request->ip(), $restrictedNetwork)) {
                $blocked = false;
            }
        }

        if ($blocked) {
       		return response()->json(['message' => "You are not allowed to access this site.", 'ipAddress' => $request->ip()]);
        }

        return $next($request);
    }
}
