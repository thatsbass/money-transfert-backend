<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Redis;

class CheckBlacklist
{
    public function handle($request, Closure $next)
    {
        $token = JWTAuth::getToken();

        if (Redis::get('blacklist:' . $token)) {
            return response()->json(['error' => 'Token is blacklisted'], 401);
        }

        return $next($request);
    }
}
