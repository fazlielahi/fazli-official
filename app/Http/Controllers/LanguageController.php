<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

    class LanguageController extends Controller
    {

    public function switch(string $lang, Request $request): RedirectResponse
    {
        // 1) validate & store
        if (! in_array($lang, ['en', 'ar'])) {
            $lang = config('app.locale');
        }
        Session::put('locale', $lang);
        App::setLocale($lang);

        // 2) grab the “referer” (last page URL)
        $previousUrl = url()->previous(); // e.g. https://example.com/en/erp?foo=bar
        $parts      = parse_url($previousUrl);

        // 3) break path into segments
        $path     = $parts['path'] ?? '/';
        $segments = explode('/', trim($path, '/')); // ['en','erp']

        // 4) if first segment is a locale, replace it; otherwise, prefix it
        if (isset($segments[0]) && in_array($segments[0], ['ar','en'])) {
            $segments[0] = $lang;
        } else {
            array_unshift($segments, $lang);
        }

        // 5) rebuild URL (with any query string)
        $newPath = '/'.implode('/', $segments);
        if (! empty($parts['query'])) {
            $newPath .= '?'.$parts['query'];
        }

        // 6) redirect back “in the new lang”
        return redirect($newPath);
    }

    
}