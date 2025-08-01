<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $locale = App::getLocale();
        return view('site.services', compact('locale'));
    }
}
