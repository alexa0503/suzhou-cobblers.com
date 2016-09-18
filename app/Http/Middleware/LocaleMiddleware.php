<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Cookie;

class LocaleMiddleware
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
        if( !$request->hasCookie('locale')){
            $locale = 'en';
        }
        if( null == Session::get('locale.language') )
            Session::set('locale.language', $locale);
        App::setLocale($locale);
        return $next($request);
    }
}
