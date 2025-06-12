<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $locale = App::getLocale();

        return view('site.contact', compact('locale'));
    }

    public function sendEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        Mail::send([], [], function ($message) use ($validated) {
            $message->to('fazlielahi03060155124@gmail.com')
                ->subject($validated['subject'])
                ->setBody("
                    Email: {$validated['email']}<br>
                    Phone: {$validated['phone']}<br>
                    Message: {$validated['message']}
                ", 'text/html');
        });

        return back()->with('success', 'Message sent successfully!');
    }
}
