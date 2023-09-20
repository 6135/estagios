<?php

namespace App\Http\Middleware;

use App\Models\AccessLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;
class LogAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $al = new AccessLog([
            'ipaddr' => $request->ip(),
            'status' => 'pending',
            'acao' => $request->method() . " route: " . (Route::current() ?? 'unknown'),
            'detalhes' => $request->path(),
            'data' => now(),
            'utilizador_email' => session()->has('user') ? session()->get('user')->email : null
        ]);
        $al->save();
        $response = $next($request);
        $status = "Unknown";
        if(method_exists($response, 'status'))
            $status = $response->status();
        $content = 'Unknown';
        if(method_exists($response, 'content'))
            $content = $response->content();
        $al->routeAccess(
            status: $status,
            acao: $request->method() . " route: " . (optional(Route::current())->getActionName() ?? 'unknown'),
            detalhes: $request->path() . ' '. $status . " " . $content
        );
        return $response;
    }
}
