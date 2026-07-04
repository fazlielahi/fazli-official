<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            'name' => 'required|string|max:120',
            'email' => 'required|email',
            'subject' => 'required|string|max:180',
            'message' => 'required|string|max:5000',
        ]);

        $recipient = config('mail.contact_to') ?: config('mail.from.address');

        try {
            Mail::send('emails.contact-message', ['contact' => $validated], function ($message) use ($validated, $recipient) {
                $message->to($recipient)
                    ->replyTo($validated['email'], $validated['name'])
                    ->subject('Contact form: ' . $validated['subject']);
            });
        } catch (\Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', __('lang.Contact message could not be sent'));
        }

        return back()->with('success', __('lang.Contact message sent successfully'));
    }
}
