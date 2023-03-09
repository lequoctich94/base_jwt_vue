<?php

namespace App\Core\Authentications;

class Authenticate extends Handler implements AuthenticateInterface
{
    /**
     * Register core
     * 
     * @param array $argm
     * @return mixed
     * 
     */
    public function register($argm)
    {
        $this->make($argm);
        return $this->getAuthenticate()->register($this->info_data);
    }

    /**
     * Login core
     * 
     * @param array $argm
     * @return mixed
     * 
     */
    public function login($argm)
    {
        //set các thông số bên App\Core\Authentications\Handler
        $this->make($argm);
        //gọi qua handle
        return $this->getAuthenticate()->login($this->info_data);
    }

    /**
     * @param array $argm
     * @return Staff $Staff
     * 
     */
    public function me($argm = [])
    {
        $this->make($argm);
        return $this->getAuthenticate()->me();
    }

    /**
     * Change password core
     * 
     * @param array $argm
     * @return mixed
     * 
     */
    public function changePassword($argm)
    {
        $this->make($argm);
        return $this->getAuthenticate()->changePassword($this->info_data);
    }
    
    /**
     * Logout core
     * 
     * @param string $guard
     * @return mixed
     * 
     */
    public function logout($guard = null)
    {
        return auth($guard)->logout();
    }
}