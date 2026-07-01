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
use App\Models\CvTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        return view('site.index');
    }
}
