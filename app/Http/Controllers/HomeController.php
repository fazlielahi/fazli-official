<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str; //to use its static method str::random() without typing the full namespace eachtime
use App\Models\Blog;
use App\Models\User;
use App\Models\Comment;
use App\Models\Likes;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function index()
    {
        $locale = App::getLocale();
        $blogs = \App\Models\Blog::where('status', 'published')->orderByDesc('id')->take(4)->get();
        return view('site.index', compact('locale', 'blogs'));
    }
}
