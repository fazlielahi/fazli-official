<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    private const QUOTE_SERVICES = [
        'web-design-development' => 'Web Design & Development',
        'corporate-identity' => 'Corporate Identity',
        'digital-marketing' => 'Digital Marketing',
        'ecommerce-development' => 'Ecommerce Development',
        'social-media-marketing' => 'Social Media Marketing',
        'wordpress-development' => 'WordPress Development',
        'seo-training' => 'SEO Training',
    ];

    public function index(Request $request)
    {
        $locale = App::getLocale();
        $quoteSubject = null;
        $quoteMessage = null;
        $selectedService = null;

        $serviceSlug = $request->query('service');
        if (is_string($serviceSlug) && isset(self::QUOTE_SERVICES[$serviceSlug])) {
            $serviceName = __('lang.' . self::QUOTE_SERVICES[$serviceSlug]);
            $selectedService = $serviceSlug;
            $quoteSubject = __('lang.Quote request subject', ['service' => $serviceName]);
            $quoteMessage = __('lang.Quote request message', ['service' => $serviceName]);
        }

        return view('site.contact', compact('locale', 'quoteSubject', 'quoteMessage', 'selectedService'));
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
