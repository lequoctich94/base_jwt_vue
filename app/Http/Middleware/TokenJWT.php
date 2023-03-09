<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as JWTTokenExpired;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as JWTTokenInvalid;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException as JWTTokenBlacklisted;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Exceptions\TokenNotFoundException;
use App\Exceptions\TokenExpiredException;
use App\Exceptions\TokenInvalidException;
use App\Exceptions\TokenBlacklistedException;

class TokenJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if(empty($request->bearerToken())) {
                throw new TokenNotFoundException();
            }
            //so sánh token
            if (!JWTAuth::parseToken()->authenticate()) {
                throw new TokenNotFoundException();
            }
            return $next($request);
        } catch (JWTTokenExpired $e) {
            throw new TokenExpiredException();
        } catch (JWTTokenInvalid $e) {
            throw new TokenInvalidException();
        } catch (JWTTokenBlacklisted $e) {
            throw new TokenBlacklistedException();
        } catch (JWTException $e) {
            throw new TokenInvalidException($e);
        }
    }
}
