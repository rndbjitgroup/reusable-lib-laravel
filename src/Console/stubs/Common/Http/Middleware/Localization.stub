<?php

namespace App\Http\Middleware;

use App\Enums\CmnEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->hasHeader('lang') ? $request->header('lang') : CmnEnum::DEFAULT_LANG;
        app()->setLocale($lang);
        return $next($request);
    }
}
