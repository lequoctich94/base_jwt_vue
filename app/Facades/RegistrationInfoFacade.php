<?php

namespace App\Facades;

use App\Core\RegistrationInfo\RegistrationInfoInterface;
use Illuminate\Support\Facades\Facade;

class RegistrationInfoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RegistrationInfoInterface::class;
    }
}