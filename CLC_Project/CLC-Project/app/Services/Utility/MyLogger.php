<?php
namespace App\Services\Utility;
use Illuminate\Support\Facades\Log;

class MyLogger implements ILogger
{
    static function getLogger()
    {
        
    }
    
    static function debug($message, $data)
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
    
    static function info($message, $data)
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
    
    static function warning($message, $data)
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
    
    static function error($message, $data)
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

