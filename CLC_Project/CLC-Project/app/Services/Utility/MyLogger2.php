<?php
namespace App\Services\Utility;

use Illuminate\Support\Facades\Log;

class MyLogger2 implements ILoggerService
{   
    function debug($message, $data)
    {
        if(is_array($data))
        {
            Log::debug($message . print_r($data, true));
        }
        else
        {
            Log::debug($message . $data);
        }
    }
    
    function info($message, $data)
    {
        if(is_array($data))
        {
            Log::info($message . print_r($data, true));
        }
        else
        {
            Log::info($message . $data);
        }
    }
    
    function warning($message, $data)
    {
        if(is_array($data))
        {
            Log::warning($message . print_r($data, true));
        }
        else
        {
            Log::warning($message . $data);
        }
    }
    
    function error($message, $data)
    {
        if(is_array($data))
        {
            Log::error($message . print_r($data, true));
        }
        else
        {
            Log::error($message . $data);
        }
    }
}

