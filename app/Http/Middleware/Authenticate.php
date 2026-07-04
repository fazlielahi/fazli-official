<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $locale = app()->getLocale();

        return route('localized.login', [
            'lang' => $locale,
            'next' => $request->fullUrl(),
        ]);
    }

    /**
     * Handle unauthenticated users with a friendly message instead of a bare error.
     */
    protected function unauthenticated($request, array $guards): never
    {
        $message = __('lang.AUTH_REQUIRED_FOR_FEATURE');

        if ($request->expectsJson()) {
            throw new AuthenticationException($message, $guards);
        }

        session()->flash('auth_required', $message);

        throw new AuthenticationException(
            $message,
            $guards,
            $this->redirectTo($request)
        );
    }
}

