<?php

namespace App\Exceptions;

class TokenInvalidException extends AppException
{
    /**
     * 
     */
    public function getMessageDefault()
    {
        return __('messages.http.token_invalid');
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
        return config('exceptions.http.token_invalid.code');
    }

    /**
     * 
     */
    public function getStatusCodeDefault()
    {
        return config('exceptions.http.token_invalid.status_code');
    }
}