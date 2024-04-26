<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateJWT
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasHeader('Authorization')) {
            return response()->json(['message' => 'Token not provided'], 401);
        }
        
        $token = $request->header('Authorization');
        
        if (strpos($token, 'Bearer ') !== 0) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $token = substr($token, 7);
        
        if (count(explode('.', $token)) !== 3) {
            return response()->json(['message' => 'Token structure invalid'], 401);
        }
        
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'User not found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['message' => 'Invalid token: ' . $e->getMessage()], 401);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['message' => 'JWT Exception: ' . $e->getMessage()], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }

        return $next($request);
    }
}
