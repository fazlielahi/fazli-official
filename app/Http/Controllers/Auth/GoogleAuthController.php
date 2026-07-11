<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(Request $request)
    {
        $next = sanitizeAuthNextUrl($request->query('next'));
        if ($next) {
            $request->session()->put('auth.next', $next);
        } else {
            $request->session()->forget('auth.next');
        }

        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        // If session state is unreliable in local/dev, stateless prevents "Invalid state" errors.
        $googleUser = Socialite::driver('google')->stateless()->user();

        $googleId = $googleUser->getId();
        $email = $googleUser->getEmail();
        if (!$googleId && !$email) {
            return redirect()->route('localized.login', ['lang' => app()->getLocale()])
                ->withErrors(['email' => 'Google login did not return an identifier (id/email).']);
        }

        $user = null;
        if ($googleId) {
            $user = User::query()->where('google_id', $googleId)->first();
        }

        if (!$user && $email) {
            // Backward-compatible: link existing local account by email (first login only)
            $user = User::query()->where('email', $email)->first();
        }

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName() ?: ($googleUser->getNickname() ?: 'Google User'),
                'email' => $email,
                'google_id' => $googleId,
                // Random password so password login is not accidentally enabled
                'password' => bcrypt(Str::random(40)),
                // In this app, "admin" users go to profile dashboard
                'type' => 'admin',
                'photo' => $googleUser->getAvatar() ?: 'default.svg',
            ]);
        } elseif ($googleId && empty($user->google_id)) {
            // Link google_id to an existing account found by email
            $user->google_id = $googleId;
            $user->save();
        }

        Auth::login($user, true);

        $next = sanitizeAuthNextUrl(request()->session()->pull('auth.next'));
        if ($next) {
            return redirect()->to($next);
        }

        if ($user->type === 'admin') {
            return redirect()->route('localized.profile', ['lang' => app()->getLocale()]);
        }

        return redirect()->route('localized.admin.dashboard', ['lang' => app()->getLocale()]);
    }
}

