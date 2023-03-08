<?php

namespace App\Core\Authentications\SSO\ServiceExample;

use App\Core\Authentications\SSO\SSO;

class Authenticate extends SSO
{
    /**
     * authentication SSO info
     */
    protected function serviceVerify($info)
    {
        return;
    }

    /**
     * get socaial network type authentication SSO
     */
    protected function getSocialNetworkType()
    {
        return;
    }

    /**
     * get socaial network id from authentication SSO reponese
     */
    protected function getSocialNetworkID($response)
    {
        //
    }
}