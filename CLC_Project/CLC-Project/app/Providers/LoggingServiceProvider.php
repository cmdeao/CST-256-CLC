<?php

namespace App\Providers;

use App\Services\Utility\MyLogger2;
use Illuminate\Support\ServiceProvider;

class LoggingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Services\Utility\ILoggerService', function ($app){
           return new MyLogger2(); 
        });
    }
}
