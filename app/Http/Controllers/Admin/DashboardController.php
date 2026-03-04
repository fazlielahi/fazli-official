<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard to logged in users only
     * 
     * Now using Laravel Auth - middleware handles authentication check
     */

    public function index(Request $request)
    {
        // Get the authenticated user using Laravel Auth
        // No need for manual session checks - middleware handles authentication
        $user = Auth::user();

        return view('admin.dashboard', ['user' => $user]);
    }
}
