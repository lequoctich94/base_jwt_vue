<?php

use App\Exceptions\InternalErrorException;
use Illuminate\Support\Facades\Log;

if (!function_exists('throwErr')) {
    function throwErr($e)
    {
        $class_exceptions = config('exceptions.register');
        $class_exception = get_class($e);

        Log::error('Request ip:'.request()->ip().' Trace id:'.(request()->trace_id ?? 0).' Message: '.$e->getMessage().' |File: '.$e->getFile().' |Line:'.$e->getLine());

        if (!in_array($class_exception, $class_exceptions)) {
            throw new InternalErrorException();
        } else {
            $mess_cus = $e->getMessage()['message'] ?? null;
            if ($mess_cus) {
                throw new $class_exception($mess_cus);
            }
            throw new $class_exception();
        }
    }
}