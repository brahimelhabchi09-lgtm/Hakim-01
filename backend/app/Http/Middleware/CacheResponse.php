<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    public function handle(Request $request, Closure $next, int $minutes = 60): Response
    {
        $response = $next($request);
        $response->setSharedMaxAge($minutes * 60);
        return $response;
    }
}
