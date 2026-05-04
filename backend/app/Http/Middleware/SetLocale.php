<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->header('Accept-Language', 'fr');
        App::setLocale(in_array($locale, ['fr', 'en', 'ar']) ? $locale : 'fr');
        return $next($request);
    }
}
