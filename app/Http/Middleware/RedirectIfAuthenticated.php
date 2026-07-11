<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     * 
     * Redirect authenticated users away from login/register pages
     * to their appropriate dashboard based on user type.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is authenticated, redirect them away from login/register pages
        if (Auth::check()) {
            $user = Auth::user();
            $locale = app()->getLocale() ?: 'en';

            $next = sanitizeAuthNextUrl($request->query('next'));
            if ($next) {
                return redirect()->to($next);
            }

            if ($user->type === 'admin') {
                return redirect()->route('localized.profile', ['lang' => $locale]);
            }

            return redirect()->route('localized.admin.dashboard', ['lang' => $locale]);
        }

        // User is not authenticated, allow them to access login/register pages
        return $next($request);
    }
}
