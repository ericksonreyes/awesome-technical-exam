<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

/**
 * Class PreFlightResponse
 * @package App\Http\Middleware
 */
class PreFlightResponse
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->getMethod() === 'OPTIONS') {
            return response('');
        }
        return $next($request);
    }

}