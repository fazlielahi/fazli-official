<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;

class BlogController extends Controller
{
    // show all blogs for admin
    public function showBlog(Request $request)
    {
        // Check if the user is logged in: either session or cookie has 'user_id'
        if (!$request->session()->has('user_id') && !$request->cookie('user_id')) {
            return redirect()->route('localized.login', ['lang' => app()->getLocale()]);
        }

        $user = User::find($request->session()->get('user_id'));
        $categories = \App\Models\Category::all();
        $selectedCategory = $request->input('category_id');

        if($user->type === 'super_admin')
        {
            $blogs = \App\Models\Blog::query();
            if ($selectedCategory) {
                $blogs = $blogs->where('category_id', $selectedCategory);
            }
            $blogs = $blogs->where('status', 'published')->get();
        }else{
            $blogs = \App\Models\Blog::where('created_by', $user->id)
             ->where('status', 'published');
            if ($selectedCategory) {
                $blogs = $blogs->where('category_id', $selectedCategory);
            }
            $blogs = $blogs->get();
        }
        return view('admin.blog', compact('blogs', 'user', 'categories', 'selectedCategory'));
    }


    public function approveBlog(Request $request, $lang, $id)
    {
        if (!$request->session()->has('user_id')) {
            return redirect()->route('localized.login', ['lang' => app()->getLocale()]);
        }

        $user = User::find($request->session()->get('user_id'));
        if($user->type !== 'super_admin') {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $blog = Blog::findOrFail($id);
        $blog->update([
            'status' => 'published',
            'approved_by' => $user->id,
            'approved_at' => now(),
            'approval_message' => $request->input('message')
        ]);

        return redirect()->route('localized.admin.request-blogs', ['lang' => app()->getLocale()])
            ->with('success', __('lang.Blog approved successfully!'));
    }

    public function rejectBlog(Request $request, $lang, $id)
    {
        if (!$request->session()->has('user_id')) {
            return redirect()->route('localized.login', ['lang' => app()->getLocale()]);
        }

        $user = User::find($request->session()->get('user_id'));
        if($user->type !== 'super_admin') {
            return redirect()->back()->with('error', 'Unauthorized');
        }

       

        $request->validate(['rejection_message' => 'required|string|max:500']);
        $blog = Blog::findOrFail($id);
        $blog->update([
            'status' => 'rejected',
            'rejected_by' => $user->id,
            'rejection_message' => $request->input('rejection_message')
        ]);

        return redirect()->route('localized.admin.request-blogs', ['lang' => app()->getLocale()])
            ->with('success', __('lang.Blog rejected successfully!'));
                    
    }


    //function requestBlogs
    public function requestBlogs(Request $request) {

        // Check if the user is logged in: either session or cookie has 'user_id'
        if (!$request->session()->has('user_id') && !$request->cookie('user_id')) {
            return redirect()->route('localized.login', ['lang' => app()->getLocale()]);
        }

        $user = User::find($request->session()->get('user_id'));
        $categories = \App\Models\Category::all();
        $selectedCategory = $request->input('category_id');

        $blogs = \App\Models\Blog::query()->whereIn('status', ['request', 'draft']);
        if ($selectedCategory) {
            $blogs = $blogs->where('category_id', $selectedCategory);
        }
        $blogs = $blogs->get();

            if($user->type === 'super_admin')
            {
                return view('admin.request-blog', compact('blogs', 'user', 'categories', 'selectedCategory'));
            }else{
                return view('site.request-blog', compact('blogs', 'user', 'categories', 'selectedCategory'));
            }
    } 

    public function draftBlogs(Request $request)
    {
        if (!$request->session()->has('user_id') && !$request->cookie('user_id')) {
            return redirect()->route('localized.login', ['lang' => app()->getLocale()]);
        }

        $user = User::find($request->session()->get('user_id'));
        $categories = \App\Models\Category::all();
        $selectedCategory = $request->input('category_id');
        $blogs = \App\Models\Blog::where('status', 'draft')->where('created_by', $user->id);
        if ($selectedCategory) {
            $blogs = $blogs->where('category_id', $selectedCategory);
        }
        $blogs = $blogs->get();
        return view('site.draft-blog', compact('blogs', 'user', 'categories', 'selectedCategory'));
    }   

    public function create(Request $request)
    {
        if (!$request->session()->has('user_id') && !$request->cookie('user_id')) {
            return redirect()->route('localized.login', ['lang' => app()->getLocale()]);
        }
        $user = User::find($request->session()->get('user_id'));
        $categories = \App\Models\Category::all();
        if($user->type === 'super_admin')
        {
            return view('admin.create-blog', compact('user', 'categories'));
        }else{
            return view('site.create-blog', compact('user', 'categories'));
        }
    }
    
    //form submission for new blog post

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'status' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2028',
            'thumb' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2028',
            'category_id' => 'required|exists:categories,id',
        ],
        [
            'title.required' => "Please write a title",
            'content.required' => "Please add some contents",
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpg, jpeg, png, gif.',
            'image.max' => 'The image must not be larger than 2MB.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
        ]);

          $imagePath = null;
          $thumbPath = null;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imagePath = $image->store('uploads', 'public');
        } else {
            $imagePath = 'blog-default.jpg';
        }

        if($request->hasFile('thumb')){
            $thumb = $request->file('thumb');
            $thumbPath = $thumb->store('uploads', 'public');
        } else {
            $thumbPath = 'blog-thumb-default.jpg';
        }
        
        // dd($request->session()->get('user_id'));

        Blog::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'status' => $request->input('status') ?? 'draft',
            'image' =>  $imagePath,
            'thumb' =>  $thumbPath,
            'created_by' => $request->session()->get('user_id'),
            'category_id' => $request->input('category_id'),
        ]);

        $user = User::find($request->session()->get('user_id'));
        // dd($user);
        if($user->type === 'super_admin')
        {
            if($request->status === 'draft' || $request->status === 'request')
            {
                return redirect()->route('localized.admin.request-blogs', ['lang' => app()->getLocale()]);
            }else{
                return redirect()->route('localized.admin.blog', ['lang' => app()->getLocale()]);
            }
        
        }else{

            if($request->status === 'request')
            {
                return redirect()->route('localized.profile-request-blogs', ['lang' => app()->getLocale()]);

            }else if($request->status === 'draft'){

                return redirect()->route('localized.profile-draft-blogs', ['lang' => app()->getLocale()]);
            }
        }
       
    }

    // Show form to edit an existing blog
    public function editBlog($locale, $id, Request $request)   
    {
        // Check if the user is logged in: either session or cookie has 'user_id'
        if (!$request->session()->has('user_id') && !$request->cookie('user_id')) {
            return redirect()->route('localized.login', ['lang' => app()->getLocale()]);
        }

        $blog = Blog::findOrFail($id);

        $user = User::find($request->session()->get('user_id'));
        $categories = \App\Models\Category::all();

        // check if user is allowed to edit this blog
        if($blog->type === 'super_admin' && $blog->created_by !== $user->id)
        {
            abort(403, 'Unauthorized action.');
        }

            if($user->type === 'super_admin')
            {
                return view('admin.edit-blog', compact('blog', 'user', 'categories'));
            }else{
                return view('site.edit-blog', compact('blog', 'user', 'categories'));
            }            
    }

    // for submission for update blog post
    public function update(Request $request, $locale, $id)
    {
        // dd($request);
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'status' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'thumb' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ],
        [
            'title.required' => "Please write a title",
            'content.required' => "Please add some contents",

            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpg, jpeg, png, gif.',
            'image.max' => 'The image must not be larger than 2MB.',
        ]);

        // info($id);

        $blog = Blog::findOrFail($id);

      // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image); // Delete the old image from storage
            }

            // Store the new image and update the blog post
            $image = $request->file('image');
            $imagePath = $image->store('uploads', 'public'); // Save the new image to the 'uploads' directory

            $blog->image = $imagePath; // Update the blog's image field with the new image path
        }

          // Check if a new thumb is uploaded
        if ($request->hasFile('thumb')) {
            
            if ($blog->thumb) {
                Storage::disk('public')->delete($blog->thumb); 
            }
           
            $thumb = $request->file('thumb');
            $thumbPath = $thumb->store('uploads', 'public'); 

            $blog->thumb = $thumbPath; 
        }       

        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'category_id' => $request->input('category_id'),
        ]);

        $user = User::find($request->session()->get('user_id'));

        if($user->type === 'super_admin')
        {
            if($request->status === 'published')            
            {
                return redirect()->route('localized.admin.blog', ['lang' => app()->getLocale()]);
            }else
            {
                return redirect()->route('localized.admin.request-blogs', ['lang' => app()->getLocale()]);
            }
        }else{
            if($request->status === 'published')    
            {
                return redirect()->route('localized.profile', ['lang' => app()->getLocale()]);

            }else if($request->status === 'draft') {

                return redirect()->route('localized.profile-draft-blogs', ['lang' => app()->getLocale()]);

            }else{
                return redirect()->route('localized.profile-request-blogs', ['lang' => app()->getLocale()]);
            }
        }
    }

    //delete the blog post
    public function delete(Request $request, $locale, $id)
    {

        //check if the user is allowed to delete this blog

        $blog = Blog::findOrFail($id);
        $user = User::find(session()->get('user_id'));  

        $blog->delete();

        $user = User::find($request->session()->get('user_id'));

        if($user->type === 'super_admin')
        {
            if($blog->status === 'published')
            {
               return redirect()->back();
            }else if($blog->status === 'draft') {
                return redirect()->back();
            }else{
                return redirect()->back();
            }
        }else{
            if($blog->status === 'published')
            {
                return redirect()->back();
            }else if($blog->status === 'draft') {
                return redirect()->back();
            }else if($blog->status === 'rejected') {
                return redirect()->back();
            }else{
                return redirect()->back();
            }
        }       
    }
}
