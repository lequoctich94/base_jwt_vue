<?php

namespace App\Exceptions;

class InternalErrorException extends AppException
{
    /**
     * 
     */
    public function getMessageDefault()
    {
        return __('messages.http.internal_server_error');
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
        return config('exceptions.http.internal_server_error.code');
    }

    /**
     * 
     */
    public function getStatusCodeDefault()
    {
        return config('exceptions.http.internal_server_error.status_code');
    }
}