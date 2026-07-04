<?php

use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'throttle.login' => \App\Http\Middleware\ThrottleLogin::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);

        $middleware->redirectGuestsTo(function (Request $request) {
            $locale = app()->getLocale() ?: 'en';

            return route('localized.login', [
                'lang' => $locale,
                'next' => $request->fullUrl(),
            ]);
        });

        $middleware->web(prepend: [
            \App\Http\Middleware\ApplySiteSettings::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('cv:purge-expired-trash')->daily();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
