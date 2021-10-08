<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;


class TokenAuthMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
            return $next($request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'status'    => false,
                'msg'       => "Token is expired"
            ], 400);
            // do whatever you want to do if a token is expired

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'status'    => false,
                'msg'       => "Token is invalid"
            ], 401);
            // do whatever you want to do if a token is invalid

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'status'    => false,
                'msg'       => "Token is not present"
            ], 401);
            // do whatever you want to do if a token is not present
        }
    }
}
