<?php

namespace App\Core\Authentications\SSO;

interface SSOInterface
{
    public function register($info);

    public function login($info);

    public function me();
}