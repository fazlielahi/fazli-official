<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;         //Fir handling http request
use Illuminate\Support\Facades\Hash; //For hashing password
use Illuminate\Support\Facades\App; 
use Illuminate\Support\Facades\Auth; //For Laravel authentication
use App\Models\User;
use App\Models\Blog;
use App\Models\Likes;
use App\Models\UserCV;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
        public function overview(Request $request)
        {
            $user = Auth::user();

            $recentCvs = UserCV::where('user_id', $user->id)
                ->orderByDesc('updated_at')
                ->take(4)
                ->get(['id', 'title', 'template_slug', 'updated_at']);

            $blogCounts = [
                'published' => Blog::where('created_by', $user->id)->where('status', 'published')->count(),
                'draft' => Blog::where('created_by', $user->id)->where('status', 'draft')->count(),
                'request' => Blog::where('created_by', $user->id)->where('status', 'request')->count(),
                'rejected' => Blog::where('created_by', $user->id)->where('status', 'rejected')->count(),
            ];

            $isNewUser = $blogCounts['published'] === 0 && $recentCvs->isEmpty();

            return view('site.profile-overview', compact('user', 'recentCvs', 'blogCounts', 'isNewUser'));
        }

     public function showPublicProfile(Request $request)
        {
            $user = Auth::user();

            $categories = \App\Models\Category::all();
            $selectedCategory = $request->input('category_id');
            $categoryId = $selectedCategory ? (int) $selectedCategory : null;

            $blogs = $this->publishedBlogsQuery($user->id, $categoryId)
                ->paginate(12)
                ->withQueryString();

            $clickedUser = null;
            $likedBlogIds = $this->likedBlogIdsFromRequest($request);
            $search = '';

            return view('site.published_blogs', compact(
                'blogs',
                'user',
                'clickedUser',
                'categories',
                'selectedCategory',
                'likedBlogIds',
                'search'
            ));
        }

        public function adminProfile(Request $request)
        {
            // Get the authenticated user using Laravel Auth
            // Middleware ensures user is authenticated
            $user = Auth::user();
            
            $blogs = Blog::where('created_by', $user->id)->where('status', 'published')->get();

            return view('admin.profile-super_admin', compact('blogs', 'user')); 
        }

        public function editProfile(Request $request)
        {
            $locale = App::getLocale();

            return redirect()->route('localized.profile', [
                'lang' => $locale,
                'edit' => 'profile',
            ]);
        }

        public function updateProfile(Request $request)
        {
            $user = Auth::user();

            $validated = $request->validate([
                'name' => 'nullable|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_photo' => 'nullable|boolean',
            ], [
                'photo.mimes' => 'Photo must be of type: jpg, png, jpeg, gif.',
                'photo.max' => 'Photo must not be larger than 2MB.',
            ]);

            if ($request->boolean('remove_photo')) {
                if ($user->photo && file_exists(public_path('images/' . $user->photo))) {
                    @unlink(public_path('images/' . $user->photo));
                }
                $validated['photo'] = 'default.svg';
            } elseif ($request->hasFile('photo')) {
                if ($user->photo && file_exists(public_path('images/' . $user->photo))) {
                    @unlink(public_path('images/' . $user->photo));
                }

                $photoName = time() . '.' . $request->file('photo')->getClientOriginalExtension();
                $request->file('photo')->move(public_path('images'), $photoName);
                $validated['photo'] = $photoName;
            } else {
                unset($validated['photo']);
            }

            unset($validated['remove_photo']);

            $user->update($validated);

            return redirect()
                ->back()
                ->with('success', __('Profile updated successfully.'));
        }

        public function userProfile(Request $request, $lang, $id)
        {
            app()->setLocale($lang);

            $clickedUser = User::findOrFail($id);

            $blogs = $this->publishedBlogsQuery($clickedUser->id)
                ->paginate(12)
                ->withQueryString();

            $latestBlogs = Blog::where('created_by', $clickedUser->id)
                ->where('status', 'published')
                ->orderByDesc('created_at')
                ->take(10)
                ->get();

            $likedBlogIds = $this->likedBlogIdsFromRequest($request);
            $search = '';

            return view('site.published_blogs', compact(
                'clickedUser',
                'blogs',
                'latestBlogs',
                'likedBlogIds',
                'search'
            ));
        }

        private function publishedBlogsQuery(int $userId, ?int $categoryId = null)
        {
            $query = Blog::query()
                ->where('created_by', $userId)
                ->where('status', 'published')
                ->with([
                    'creater',
                    'category',
                    'comments' => fn ($commentQuery) => $commentQuery->latest(),
                ])
                ->withCount(['likes', 'comments'])
                ->orderByDesc('created_at');

            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }

            return $query;
        }

        private function likedBlogIdsFromRequest(Request $request): array
        {
            $visitorToken = $request->cookie('visiter_token');

            if (!$visitorToken) {
                return [];
            }

            return Likes::where('visiter_token', $visitorToken)->pluck('blog_id')->all();
        }
}
