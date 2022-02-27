<?php


namespace App\Http\Middleware;

use Closure;

/**
 * Class PreventCachingMiddleware
 * @package App\Http\Middleware
 */
class PreventCachingMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('Cache-Control', 'no-cache, must-revalidate');
        return $response;
    }

}