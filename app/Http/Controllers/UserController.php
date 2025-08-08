<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;         //Fir handling http request
use Illuminate\Support\Facades\Hash; //For hashing password
use Illuminate\Support\Facades\App; 
use App\Models\User;                        //The user model
use App\Models\Blog;                        //The user model
use Illuminate\Support\Facades\Cookie;


class UserController extends Controller
{
       /**
     * Show the user registration form 
     */

     public function showRegisterForm()
     {
         return view('admin.register'); 
     }

     /**
      * registeraton form submission
      */

      public function register(Request $request)
      {
        // dd($request);
        $request-> validate([

            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'type' => 'nullable|in:admin,super_admin',
            'photo' => 'nullable|mimes:jpg,png,jpeg,gif|max:2028',
        ],
        [
            // Custom messages
            'name.required' => 'Please enter your name.',
            'name.max' => 'Name cannot be longer than 255 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'You must enter a password.',
            'password.min' => 'Password must be at least 6 characters long.',
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
            $user->photo = 'images/default.png';
        }

        // Flash the success message to the session
        //session()->flash('success', 'Account created successfully. Please log in now.');

        // save the user to the database
        $user->save();

        // after registraion redirecting to login page
        return redirect()->route('localized.login', ['lang' => app()->getlocale()])->with('success', 'Account created successfully. Please log in now.');

      }
      

     /**
      * show the user login form
      */
     public function showLoginForm()
     {
        return view('admin.login'); 
     }

   /**
      * login form submission
      */

      public function login(Request $request)
      {
        // dd($request);
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'nullable',
        ],
        [
            'email.required' => 'Please Enter Your Email Address',
            'email.email' => 'Please Enter a Valid Email Address',
            'password.required' => 'Please Enter Your Password',
        ]);

        $user = User::where('email', $request->email)->first();

        if($user)
        {
            if(Hash::check($request->password, $user->password))
            {
                // store user id in session to mark user as logedin
                $request->session()->put('user_id', $user->id);

                //check if remember me is checked
                if($request->has('remember'))
                {
                    // Create an encrypted cookie with user_id that lasts for one month (43200 minutes = 30 days)
                    cookie::queue('user_id', $user->id, 43200);
                }

                // Redirect based on user type/status
                if ($user->type === 'admin') {
                    return redirect()->route('localized.profile', ['lang' => app()->getLocale()]);
                } else {
                    return redirect()->route('localized.admin.dashboard', ['lang' => app()->getLocale()]);
                }

            }else {
                // Incorrect password
                return back()->withErrors(['password' => 'Incorrect password.']);
            }

        }else{

            //no user found with that email
            return back()->withErrors(['email' => 'No account found with this email']);

        }
      }

        /**
       * log the user out (destroye session)
       */

       public function logout(Request $request)
       {
            // remove the user_id from session
            $request->session()->forget('user_id');

            Cookie::queue(Cookie::forget('user_id'));

            return redirect()->route('localized.login', ['lang' => app()->getLocale()])->with('success', 'You are now logged out.');
       }

}
