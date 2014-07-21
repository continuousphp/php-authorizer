<?php
/**
 * @author Matt Berg, 2014
 */

namespace Berg\Authorizer;

use Illuminate\Support\Facades\Log;

class LaravelLogger implements LoggerInterface {
    public function logError($error)
    {
        Log::error($error);
    }
}