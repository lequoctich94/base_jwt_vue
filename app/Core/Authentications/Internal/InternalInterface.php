<?php

namespace App\Core\Authentications\Internal;

interface InternalInterface
{
    public function register($info);

    public function login($info);

    public function me();
}