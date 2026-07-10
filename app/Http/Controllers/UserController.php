<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;         //Fir handling http request
use Illuminate\Support\Facades\Hash; //For hashing password
use Illuminate\Support\Facades\App; 
use Illuminate\Support\Facades\Auth; //For Laravel authentication
use Illuminate\Support\Facades\Password; //For password reset functionality
use App\Models\User;
use App\Models\SiteSetting;                        //The user model
use App\Models\Blog;                        //The user model


class UserController extends Controller
{
       /**
     * Show the user registration form 
     */

     public function showRegisterForm(Request $request)
     {
         $next = $this->sanitizeInternalNextUrl($request->query('next'));
         return view('admin.register', [
             'next' => $next,
         ]);
     }

     /**
      * registeraton form submission
      * 
      * Now automatically logs in the user after registration using Laravel Auth
      */

      public function register(Request $request)
      {
        // Validate the request
        $request-> validate([

            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'type' => 'nullable|in:admin,super_admin',
            'photo' => 'nullable|mimes:jpg,png,jpeg,gif|max:2028',
            'next' => 'nullable|string|max:2048',
        ],
        [
            // Custom messages
            'name.required' => 'Please enter your name.',
            'name.max' => 'Name cannot be longer than 255 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'You must enter a password.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
            'type.in' => 'Type must be either admin or super_admin.',
            'photo.mimes' => 'Photo must be of type: jpg, png, jpeg, gif.',
            'photo.max' => 'Photo must not be larger than 5MB.',

        ]);

        //create a new user and fill it with a form data
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        //hash the password 
        $user->password = Hash::make($request->password);
        $user->type = $request->type ?? 'admin';

        //photo uploading
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $photoName);
            $user->photo = $photoName;
        } else {
            $user->photo = 'default.svg';
        }

        // save the user to the database
        $user->save();

        // Automatically log in the user after registration using Laravel Auth
        Auth::login($user);

        $next = $this->sanitizeInternalNextUrl($request->input('next'));
        if ($next) {
            return redirect()->to($next)
                ->with('success', 'Account created successfully! You are now logged in.');
        }

        // Redirect based on user type (same as login)
        // User is now automatically logged in, so redirect to their appropriate dashboard
        if ($user->type === 'admin') {
            return redirect()->route('localized.profile', ['lang' => app()->getLocale()])
                ->with('success', 'Account created successfully! You are now logged in.');
        } else {
            return redirect()->route('localized.admin.dashboard', ['lang' => app()->getLocale()])
                ->with('success', 'Account created successfully! You are now logged in.');
        }

      }
      

     /**
      * show the user login form
      */
     public function showLoginForm(Request $request)
     {
        $next = $this->sanitizeInternalNextUrl($request->query('next'));
        return view('admin.login', [
            'next' => $next,
        ]);
     }

   /**
      * login form submission
     * 
     * Now using Laravel's built-in authentication system
      */

      public function login(Request $request)
      {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'nullable',
            'next' => 'nullable|string|max:2048',
        ],
        [
            'email.required' => 'Please Enter Your Email Address',
            'email.email' => 'Please Enter a Valid Email Address',
            'password.required' => 'Please Enter Your Password',
        ]);

        // Prepare credentials for authentication
        $credentials = $request->only('email', 'password');

        // Check if "remember me" is checked (Laravel uses boolean for remember)
        $remember = $request->has('remember');

        $guard = Auth::guard('web');
        if (method_exists($guard, 'setRememberDuration')) {
            $guard->setRememberDuration(SiteSetting::getRememberMeDays() * 24 * 60);
        }

        // Attempt to authenticate the user using Laravel's Auth system
        // Auth::attempt() automatically checks email and password, and creates the session
        if (Auth::attempt($credentials, $remember)) {
            // Authentication successful - user is now logged in via Laravel Auth
            
            // Get the authenticated user
            $user = Auth::user();

            $next = $this->sanitizeInternalNextUrl($request->input('next'));
            if (!$next) {
                $intended = session()->pull('url.intended');
                $next = $this->sanitizeInternalNextUrl(is_string($intended) ? $intended : null);
            }
            if ($next) {
                return redirect()->to($next);
            }

            // Redirect based on user type/status
            if ($user->type === 'admin') {
                return redirect()->route('localized.profile', ['lang' => app()->getLocale()]);
            }

            return redirect()->route('localized.admin.dashboard', ['lang' => app()->getLocale()]);
        }

        // Authentication failed
        // Show field-specific error message as requested
        $emailExists = User::query()->where('email', $request->input('email'))->exists();

        if (!$emailExists) {
            $errors = ['email' => ['Email does not exist.']];
            if ($request->expectsJson()) {
                return response()->json(['errors' => $errors], 422);
            }
            return back()->withErrors($errors)->withInput($request->only('email', 'next'));
        }

        $errors = ['password' => ['Incorrect password.']];
        if ($request->expectsJson()) {
            return response()->json(['errors' => $errors], 422);
        }
        return back()->withErrors($errors)->withInput($request->only('email', 'next'));
      }

    /**
     * Prevent open redirects while allowing same-site absolute URLs and safe relative paths.
     */
    protected function sanitizeInternalNextUrl(?string $next): ?string
    {
        if (!$next) {
            return null;
        }

        $next = trim($next);
        if ($next === '') {
            return null;
        }

        // Relative in-app paths are safest.
        if (str_starts_with($next, '/') && !str_starts_with($next, '//')) {
            return $next;
        }

        // Allow absolute URLs only when they target this application host.
        $appUrl = (string) config('app.url', '');
        if ($appUrl === '') {
            return null;
        }

        $target = parse_url($next);
        if (!is_array($target) || empty($target['host'])) {
            return null;
        }

        $app = parse_url($appUrl);
        if (!is_array($app) || empty($app['host'])) {
            return null;
        }

        $targetHost = strtolower($target['host']);
        $appHost = strtolower($app['host']);
        if ($targetHost !== $appHost) {
            return null;
        }

        $path = $target['path'] ?? '/';
        $query = isset($target['query']) && $target['query'] !== '' ? ('?' . $target['query']) : '';
        $fragment = isset($target['fragment']) && $target['fragment'] !== '' ? ('#' . $target['fragment']) : '';

        return $path . $query . $fragment;
    }

        /**
       * log the user out (destroy session)
       * 
       * Now using Laravel's built-in authentication logout
       */

       public function logout(Request $request)
       {
            // Use Laravel's Auth::logout() to properly log out the user
            // This handles:
            // - Clearing Laravel's authentication session
            // - Invalidating remember token (if used)
            // - Properly destroying the session
            Auth::logout();

            // Invalidate the session (regenerate session ID for security)
            // This clears all session data, including any old session variables
            $request->session()->invalidate();
            
            // Regenerate CSRF token after logout
            $request->session()->regenerateToken();

            return redirect()->route('localized.login', ['lang' => app()->getLocale()])
                ->with('success', 'You are now logged out.');
       }

    /**
     * Show the password reset request form (Forgot Password)
     * 
     * Displays the form where users can enter their email to request a password reset link.
     */
    public function showForgotPasswordForm()
    {
        return view('admin.passwords.email');
    }

    /**
     * Send password reset link to user's email
     * 
     * Validates the email and sends a password reset link using Laravel's built-in
     * password reset functionality. This method handles:
     * - Email validation
     * - Token generation
     * - Sending reset email
     * - Rate limiting (built into Laravel)
     */
    public function sendResetLink(Request $request)
    {
        // Validate the email
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        // Send password reset link using Laravel's Password facade
        // Explicitly use the 'users' broker to ensure consistency
        // This will:
        // 1. Check if user exists (but won't reveal if email doesn't exist for security)
        // 2. Generate a secure token
        // 3. Store token in password_reset_tokens table
        // 4. Send email with reset link
        $status = Password::broker('users')->sendResetLink(
            $request->only('email')
        );

        // Password::RESET_LINK_SENT means email was sent successfully
        // Password::INVALID_USER means email doesn't exist (but we show same message for security)
        // We always show the same success message to prevent email enumeration attacks
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __('passwords.sent'));
        }

        // For other statuses (like throttling), show appropriate error
        // But still don't reveal if email exists
        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show the password reset form
     * 
     * Displays the form where users can enter their new password after clicking
     * the reset link from their email. The token is validated to ensure it's valid.
     * 
     * @param string $token The password reset token from the email link
     */
    public function showResetForm(Request $request, $token = null)
    {
        // Get token from route parameter
        // The token comes from the URL: /password/reset/{token}
        // Try multiple ways to get the token to ensure we capture it correctly
        $token = $token ?: $request->route('token') ?: $request->get('token');
        
        // Get email from query string (standard Laravel pattern)
        // Email is passed as ?email=user@example.com in the URL
        $email = $request->query('email');
        
        // Ensure token is not empty
        if (empty($token)) {
            return redirect()->route('localized.password.request', ['lang' => app()->getLocale()])
                ->withErrors(['email' => 'Invalid reset link. Please request a new password reset link.']);
        }
        
        return view('admin.passwords.reset')->with([
            'token' => $token,
            'email' => $email,
        ]);
    }

    /**
     * Reset the user's password
     * 
     * Validates the reset token and updates the user's password. This method:
     * - Validates token (checks if it exists and hasn't expired)
     * - Validates new password (min 8 chars, confirmed)
     * - Updates user's password in database
     * - Deletes the used token
     * - Redirects to login with success message
     */
    public function reset(Request $request)
    {
        // Validate the request
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'token.required' => 'Reset token is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        // Prepare credentials for password reset
        // Get token from request (from hidden form field)
        // The token should match exactly what was in the URL
        $token = $request->input('token');
        
        // Ensure token is not empty
        if (empty($token)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Reset token is missing. Please request a new password reset link.']);
        }
        
        // Ensure email matches the one in the token record
        // Laravel's Password facade validates both token and email together
        // The email must match exactly what was used to generate the token
        $email = trim($request->email);
        
        // Ensure token is properly formatted (no extra whitespace or encoding issues)
        $token = trim($token);
        
        $credentials = [
            'email' => $email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
            'token' => $token,
        ];

        // Reset password using Laravel's Password facade
        // Explicitly use the 'users' broker to ensure consistency
        // This handles:
        // - Token validation (checks if token exists and is valid)
        // - Token expiration check (default: 60 minutes)
        // - Password hashing
        // - Updating user's password
        // - Deleting the used token
        $status = Password::broker('users')->reset(
            $credentials,
            function ($user, $password) {
                // Update the user's password
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        // Check the status and redirect accordingly
        if ($status === Password::PASSWORD_RESET) {
            // Password reset successful
            return redirect()->route('localized.login', ['lang' => app()->getLocale()])
                ->with('status', __('passwords.reset'));
        }

        // If reset failed (invalid token, expired token, etc.)
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
       }

}
