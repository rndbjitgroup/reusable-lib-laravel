<?php

namespace App\Http\Middleware;

use App\Enums\CmnEnum;
use Closure;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->hasHeader('lang') ? $request->header('lang') : CmnEnum::DEFAULT_LANG;
        app()->setLocale($lang);
        return $next($request);
    }
}
