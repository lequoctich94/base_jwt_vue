<?php

namespace App\Exceptions;

class NotFoundException extends AppException
{
    /**
     * 
     */
    public function getMessageDefault()
    {
        return __('messages.http.not_found');
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
        return config('exceptions.http.not_found.code');
    }

    /**
     * 
     */
    public function getStatusCodeDefault()
    {
        return config('exceptions.http.not_found.status_code');
    }
}