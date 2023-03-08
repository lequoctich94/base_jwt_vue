<?php

namespace App\Core\Authentications;

interface AuthenticateInterface
{
    public function register($argm);

    public function login($argm);

    public function logout($argm);

    public function me($argm);
}