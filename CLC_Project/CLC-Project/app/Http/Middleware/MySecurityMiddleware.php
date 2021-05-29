<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\Utility\MyLogger;
use App\Services\Business\functions;

class MySecurityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        $path = $request->path();
        $logger = new MyLogger();
        $functions = new functions();

        $logger->info("Entering MySecurityMiddleware::handle() with path: " . $path, null);
        
        $secureCheck = true;
        
        if($request->is('/') || $request->is('login') || $request->is('userrest') ||  $request->is('userrest/*') ||
            $request->is('jobrest') || $request->is('jobrest/*') || $request->is('loginProcess') || $request->is('register'))
        {
            $secureCheck = false;
        }
        
        $logger->info($secureCheck ? "SecurityMiddleware::handle()...needs security" : "SecurityMiddleware::handle()
             no security required", null);
                
        if($secureCheck && $functions->getUser() == false)
        {
            $logger->info("Leaving SecurityMiddleware::handle() performing a redirect to login", null);
            exit;
            return redirect('/login');
        }
        return $next($request);
    }
}
