<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate;

class ApiAuthentication extends Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if ($this->auth->guard('api')->check()) {
            $this->auth->shouldUse('api');
        }
        else
        {
            return response('401 Unauthenticated', 401);
        }
        return $next($request);
    }
}
