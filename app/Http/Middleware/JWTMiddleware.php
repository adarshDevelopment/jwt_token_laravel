<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Facades\JWTAuth;
// use JWTAuth;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (empty($token)) {
            return response()->json(["message" => "Invalid Token. please send token", 'success' => false], Response::HTTP_FORBIDDEN);
        }
        try {
            $user = JWTAuth::parseToken($token)->authenticate();
            return response()->json(['custom_msg' => 'returning from jwtMiddleware', 'success' => true, 'msg' => $user], 200);
            // return $next($request);
        } catch (JWTException $e) {
            return response()->json(['message' => $e->getMessage(), 'success' => false, 'custom_msg' => 'Exception caught'], Response::HTTP_FORBIDDEN);
        }

        // $token = $request->bearerToken();

        /*
        try {
            // $user = JWTAuth::authenticate($request->bearerToken(), $request->getPassword());
            // parsing token 
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                return response()->json(['success' => false, 'message' => 'Invalid Tokenz'], Response::HTTP_UNAUTHORIZED);
            } else if ($e instanceof Tymon\JwtAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'message' => 'Token is expired'], Response::HTTP_UNAUTHORIZED);
            } else {
                return response()->json(['success' => false, 'message' => 'Authorzie Token not found'], Response::HTTP_UNAUTHORIZED);
            }
        }
            */


        // return $next($request);
    }
}
