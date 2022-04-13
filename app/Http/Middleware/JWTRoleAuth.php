<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWTRoleAuth
{
    public function handle($request, Closure $next, $role = null)
    {
        try {
        //Resolve token role
        $token_role = JWTAuth::parseToken()->getClaim('role');
        } catch (JWTException $e) {
        /**
         *Token parsing failed, indicating that there are no available tokens in the request.
        *In order to be used globally (requests that do not require a token can also be passed), let the request continue here.
        *Because the responsibility of this middleware is only to verify the role in the token.
        */
            return $next($request);
        }

        //Judge the token role.
        if ($token_role != $role) {
            throw new UnauthorizedHttpException('jwt-auth', 'User role error');
        }

     return $next($request);
    }
}
