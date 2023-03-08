<?php

namespace App\Core\Authentications\Internal\Def;

use App\Core\Authentications\Internal\Internal;
use App\Exceptions\UnauthorizedException;

class Authenticate extends Internal
{
    /**
     * Override register
     * 
     * @param array $info
     * @return      $token
     */
    public function register($info)
    {
        return null;
    }


    /**
     * Override login
     * 
     * @param array $info
     * @return      $token
     * 
     * @throws \App\Exceptions\UnauthorizedException
     */
    public function login($info)
    {
       //login hiện tại đang sài cái này
        if (! $token = auth($this->guard)->attempt($info)) {
            throw new UnauthorizedException();
        }
        return $token;
    }
}