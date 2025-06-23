<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();
        return view('site.courses', compact('locale'));
    }

    public function courseDetails()
    {
        $locale = app()->getLocale();
        return view('site.course-details', compact('locale'));
    }
}
