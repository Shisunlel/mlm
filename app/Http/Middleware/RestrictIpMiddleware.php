<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestrictIpMiddleware
{
    // Allowed IP
    public $ip = ['192.168.4.115', '127.0.0.1'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!in_array($request->ip(), $this->ip)) {
            abort(503);
        }
        return $next($request);
    }
}
