<?php

namespace App\Exceptions;

class BadRequestException extends AppException
{
    /**
     * 
     */
    public function getMessageDefault()
    {
        return __('messages.http.bad_request');
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
        return config('exceptions.http.bad_request.code');
    }

    /**
     * 
     */
    public function getStatusCodeDefault()
    {
        return config('exceptions.http.bad_request.status_code');
    }
}