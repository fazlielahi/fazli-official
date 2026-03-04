<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Models\Experience;

class FounderProfileController extends Controller
{
    public function index()
    {
        $locale = App::getLocale();
        $experiences = Experience::active()->ordered()->get();

        return view('site.founder-profile', compact('locale', 'experiences'));
    }
}
