<?php

namespace App\Exceptions;

class UnauthorizedException extends AppException
{
    /**
     * 
     */
    public function getMessageDefault()
    {
        return __('messages.http.unauthorized');
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
        return config('exceptions.http.unauthorized.code');
    }

    /**
     * 
     */
    public function getStatusCodeDefault()
    {
        return config('exceptions.http.unauthorized.status_code');
    }
}