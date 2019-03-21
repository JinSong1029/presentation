<?php

namespace App\Http\Middleware;

use Closure;

class IeFix
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('P3P', 'CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
        if(getenv('APP_MODE') != 'dashboard') {
            $response->header('CacheControl', 'no-cache');
            $response->header('Expires', 'no-cache');
            $response->header('Pragma', 'no-cache');
            $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }
        return $response;
    }
}
