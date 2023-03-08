<?php

namespace App\Exceptions;

class TokenBlacklistedException extends AppException
{
    /**
     * 
     */
    public function getMessageDefault()
    {
        return __('messages.http.token_blacklisted');
    }

    /**
     * 
     */
    public function getDataDefault()
    {
        return null;
    }


    /**
     * 
     */
    public function getCodeDefault()
    {
        return config('exceptions.http.token_blacklisted.code');
    }

    /**
     * 
     */
    public function getStatusCodeDefault()
    {
        return config('exceptions.http.token_blacklisted.status_code');
    }
}