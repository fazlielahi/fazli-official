<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class ApplySiteSettings
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (Schema::hasTable('site_settings')) {
                Config::set('session.lifetime', SiteSetting::getSessionLifetimeMinutes());
                Config::set('session.expire_on_close', SiteSetting::getSessionExpireOnClose());
            }
        } catch (\Throwable) {
            // Ignore during install or when the database is unavailable.
        }

        return $next($request);
    }
}
