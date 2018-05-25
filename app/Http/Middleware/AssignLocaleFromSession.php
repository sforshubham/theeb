<?php

namespace App\Http\Middleware;

use Closure;
use App;

class AssignLocaleFromSession
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
        $locale = $request->cookie('locale');
        if (is_null($locale)) {
            App::setLocale('ar');
        } else {
            App::setLocale($locale);
        }
        return $next($request);
    }
}
