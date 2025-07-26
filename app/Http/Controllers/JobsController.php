<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function index()
    {
        $locale = App::getLocale();
        return view('site.jobs', compact('locale'));
    }
} 