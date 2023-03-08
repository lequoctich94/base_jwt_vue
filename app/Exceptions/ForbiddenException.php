<?php

namespace App\Exceptions;

class ForbiddenException extends AppException
{
    /**
     * 
     */
    public function getMessageDefault()
    {
        return __('messages.http.forbidden');
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
        return config('exceptions.http.forbidden.code');
    }

    /**
     * 
     */
    public function getStatusCodeDefault()
    {
        return config('exceptions.http.forbidden.status_code');
    }
}