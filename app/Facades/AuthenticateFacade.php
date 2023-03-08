<?php

namespace App\Facades;

use App\Core\Authentications\AuthenticateInterface;
use Illuminate\Support\Facades\Facade;

class AuthenticateFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AuthenticateInterface::class;
    }
}