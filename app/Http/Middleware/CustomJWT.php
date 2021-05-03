<?php
/**
 * Author: sai
 * Date: 2020/12/26
 * Time: 15:16
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\UnauthorizedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class CustomJWT
{
    public function bearerToken($request)
    {
        $header = $request->header('Authorization', '');

        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }

        return $header;
    }

    public function getTokenForRequest($request)
    {
        $token = $this->bearerToken($request);
        return $token ?:$request->input('token', '');
    }

    public function handle($request, Closure $next)
    {
        if (!$token = ($this->getTokenForRequest($request))) {
            throw new UnauthorizedException('Unauthorized');
        }
        dd(JWTAuth::parseToken());


//        if ($request->user = JWTAuth::parseToken()->authenticate()) {

        return $next($request);
    }
}