<?php

namespace App\Http\Controllers\BulkMail;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    public function index()
    {
        $locale = App::getLocale();

        return view('bulk-mail.dashboard', compact('locale'));
    }
}
