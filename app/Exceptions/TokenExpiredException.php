<?php

namespace App\Exceptions;

class TokenExpiredException extends AppException
{
    /**
     * 
     */
    public function getMessageDefault()
    {
        return __('messages.http.token_expired');
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
        return config('exceptions.http.token_expired.code');
    }

    /**
     * 
     */
    public function getStatusCodeDefault()
    {
        return config('exceptions.http.token_expired.status_code');
    }
}