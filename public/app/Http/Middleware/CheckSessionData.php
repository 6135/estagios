<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\Authentication;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //check if session roles and user roles match, if so, continue, else, update session roles
        if(Authentication::check()){
            try{
                $user = Authentication::getUser();
                if(!$user->ativo){
                    $request->session()->flush();
                    return redirect('login');
                }
            } catch (\Exception $e){
                Log::error($e->getMessage());
                $request->session()->flush();
                return redirect('login');
            }

            session()->forget('user');
            session()->put('user', $user);
            $roles = $user->papeis->toArray();
            $session_roles = session()->get('roles')->toArray();
            if($roles != $session_roles){
                session()->put('roles', $user->papeis);
            }
        }
        return $next($request);

    }
}
