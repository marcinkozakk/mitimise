<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Request;

class Language
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('locale') && array_key_exists(session()->get('locale'), Config::get('app.availableLanguages'))) {
            App::setLocale(session()->get('locale'));
        }
        else {
            $userLangs = preg_split('/,|;/', $request->server('HTTP_ACCEPT_LANGUAGE'));

            foreach ($userLangs as $lang) {
                if(array_key_exists($lang, Config::get('app.availableLanguages'))) {
                    App::setLocale($lang);
                    session()->put('locale', $lang);
                    break;
                }
            }
            App::setLocale(Config::get('app.fallback_locale'));
        }
        return $next($request);
    }
}