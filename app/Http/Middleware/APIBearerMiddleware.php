<?php

namespace App\Http\Middleware;

use Closure;

class APIBearerMiddleware
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
        $api_token = $request->bearerToken();

        if (!$api_token) {
            return response([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = \App\User::where('api_token', $api_token)->first();
        if (!$user) {
            return response([
                'message' => 'Unauthorized'
            ], 401);
        }


        return $next($request);
    }
}
