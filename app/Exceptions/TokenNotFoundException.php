<?php

namespace App\Exceptions;

class TokenNotFoundException extends AppException
{
    /**
     * 
     */
    public function getMessageDefault()
    {
        return __('messages.http.token_not_found');
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
        return config('exceptions.http.token_not_found.code');
    }

    /**
     * 
     */
    public function getStatusCodeDefault()
    {
        return config('exceptions.http.token_not_found.status_code');
    }
}