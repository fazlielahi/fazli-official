<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // 1) apply session‐stored locale
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        // 2) override if URL contains a valid {lang}
        $uriLang = $request->route('lang');
        if (in_array($uriLang, ['en', 'ar'])) {
            App::setLocale($uriLang);
            Session::put('locale', $uriLang);
        }

        return $next($request);
    }
}