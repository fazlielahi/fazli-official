<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ThrottleLogin extends ThrottleRequests
{
    /**
     * Handle an incoming request.
     * 
     * Custom throttle middleware for login that redirects back to login page
     * with a user-friendly error message instead of showing 429 error page.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  int  $maxAttempts
     * @param  int  $decayMinutes
     * @param  string  $prefix
     */
    public function handle($request, Closure $next, $maxAttempts = 5, $decayMinutes = 1, $prefix = '')
    {
        try {
            // Use parent's handle method which does the rate limiting
            return parent::handle($request, $next, $maxAttempts, $decayMinutes, $prefix);
        } catch (HttpException $e) {
            // Catch HTTP exceptions (including 429 Too Many Requests)
            if ($e->getStatusCode() === 429) {
                // Redirect back to login with user-friendly error message
                $locale = app()->getLocale() ?: 'en';
                $seconds = $e->getHeaders()['Retry-After'] ?? 60;
                
                return redirect()
                    ->route('localized.login', ['lang' => $locale])
                    ->withErrors([
                        'email' => "Too many login attempts. Please try again in {$seconds} seconds."
                    ])
                    ->with('throttle_seconds', $seconds) // Pass seconds for countdown
                    ->withInput($request->only('email'));
            }
            
            // Re-throw if it's not a 429 error
            throw $e;
        }
    }
}
