<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Show the dashboard to the loged in users only
     */

    public function index(Request $request)
    {
        // Check if the user is logged in: either session or cookie has 'user_id'
        if (!$request->session()->has('user_id') && !$request->cookie('user_id')) {
            return redirect()->route('localized.login', ['lang' => app()->getLocale()]);
        }
        
        // auth()->user();
        auth()->check();
        $user = User::find($request->session()->get('user_id'));

        return view('admin.dashboard', ['user' => $user]);

    }
}
