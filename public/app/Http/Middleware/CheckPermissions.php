<?php

namespace App\Http\Middleware;

use App\Models\PapelUtilizador;
use App\Models\Utilizador;
use App\Role;
use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckPermissions
{
    /**
     * Handle an incoming request. Checks if user has permission to access the page, accepts multiple roles as arguments by permission level
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        //get user object from session
        try{
            $user = Utilizador::find($request->session()->get('user')->email);
        }   catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect('login');
        }
        //get users active role from session
        $role = $request->session()->get('activeRole');

        //check if role is in the list of accepted roles
        if(in_array($role, $roles) && $user->hasRole($role)) {
            //if role is in the list of accepted roles, verify if the user still has that role
            return $next($request);
        } else {
            //if role is not in the list of accepted roles, return the response
            return json_encode(['success' => false, 'message' => __('messages.permission.error'), 'redirect' => route('home')]);
        }
        
    }
}
