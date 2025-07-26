<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        if (Subscriber::where('email', $request->email)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are already subscribed with this email.'
            ]);
        }

        Subscriber::create([
            'email' => $request->email
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Thank you for subscribing!'
        ]);
    }


}