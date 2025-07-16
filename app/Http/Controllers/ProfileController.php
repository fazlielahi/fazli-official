<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;         //Fir handling http request
use Illuminate\Support\Facades\Hash; //For hashing password
use Illuminate\Support\Facades\App; 
use App\Models\User;                        //The user model
use App\Models\Blog;                        //The user model
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
     public function showPublicProfile(Request $request)
        {
            auth()->check();
            $user = User::find($request->session()->get('user_id'));

            if (!$user) {
                return redirect()->back()->with('error', 'Session expired.');
            }
            $categories = \App\Models\Category::all();
            $selectedCategory = $request->input('category_id');
            $blogs = \App\Models\Blog::where('created_by', $user->id)
                ->where('status', 'published');
            if ($selectedCategory) {
                $blogs = $blogs->where('category_id', $selectedCategory);
            }
            $blogs = $blogs->get();
            $clickedUser = null;
            return view('site.published_blogs', compact('blogs', 'user', 'clickedUser', 'categories', 'selectedCategory'));
        }

        public function adminProfile(Request $request)
        {
            auth()->check();
            $user = User::find($request->session()->get('user_id'));

            if (!$user) {
                return redirect()->back()->with('error', 'Session expired.');
            }
            
            $blogs = Blog::where('created_by', $user->id)->where('status', 'published')->get();

            return view('admin.profile-super_admin', compact('blogs', 'user')); 
        }

        public function editProfile(Request $request)
        {
            $user = User::find($request->session()->get('user_id'));
            $locale = App::getLocale(); 

            return view('site.edit-profile', compact('user')); 
        }

        public function updateProfile(Request $request)
        {
            $user = User::find($request->session()->get('user_id'));
            $data = $request->validate([
                'name' => 'nullable|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],[
                'photo.mimes' => 'Photo must be of type: jpg, png, jpeg, gif.',
                'photo.max' => 'Photo must not be larger than 2MB.',
            ]);

            if($request->hasFile('photo'))
            {
                //delete the old image if it exists
                if ($user->photo && file_exists(public_path('images/' . $user->photo))) {
                    unlink(public_path('images/' . $user->photo));
                }

               $photoName = time() . '.' . $request->file('photo')->getClientOriginalExtension();
               $request->file('photo')->move(public_path('images'), $photoName);
               $data['photo'] = $photoName;
            }
            
            $user->update($data);
            if($user->type == 'super_admin')
            {
                return redirect()->route('localized.admin.profile', ['lang' => app()->getLocale()])->with('success', 'Profile updated successfully.');
            }else
            {
                return redirect()->route('localized.profile', ['lang' => app()->getLocale()])->with('success', 'Profile updated successfully.');
            }
        }

        public function userProfile($lang, $id)
        {
            // Set locale based on URL parameter
            app()->setLocale($lang);
            
            // Find the user or return 404
            $clickedUser = \App\User::findOrFail($id);
            // info($lang);
            // Get all blogs by this user, ordered by newest first
            $blogs = \App\Blog::where('created_by', $id)
                            ->where('status', 'published')
                            ->orderBy('created_at', 'desc')
                            ->get();
        
            $latestBlogs = \App\Blog::where('created_by', $id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get(); // For latest 10
            

            // Return the view with user and their blogs
            return view('sections.published_blogs', compact('clickedUser', 'blogs', 'latestBlogs'));
        }
}
