<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait LogTrait
{
    /**
     * Log position throw error
     */
    public function log($file, $fnc, $line)
    {
        Log::error("File: $file Function: $fnc Line: $line");
    }
}