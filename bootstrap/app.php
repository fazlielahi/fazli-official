<?php

use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register custom throttle middleware for login
        $middleware->alias([
            'throttle.login' => \App\Http\Middleware\ThrottleLogin::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('cv:purge-expired-trash')->daily();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
