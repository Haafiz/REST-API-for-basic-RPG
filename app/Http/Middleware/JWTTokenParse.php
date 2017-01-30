<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Facades\JWTAuth;

use Closure;

class JWTTokenParse {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (env('APP_ENV') === 'testing') {
            JWTAuth::setRequest($request);
        }
        
        return $next($request);
    }

}
