<!DOCTYPE html>
@php
    $locale = app()->getLocale();
    $pageDir = in_array($locale, ['ar', 'ur'], true) ? 'rtl' : 'ltr';
    $isToolsHubPage = request()->routeIs('localized.home', 'localized.tools', 'localized.services', 'localized.contact');
    $isAboutPage = request()->routeIs('localized.about-tfc');
    $skipJqueryUi = $isToolsHubPage || $isAboutPage;
@endphp
<html lang="{{ $locale }}" dir="{{ $pageDir }}">

<head>
    <title>@yield('title', __('lang.DEFAULT_TITLE'))</title>
    <link rel="icon" href="{{ asset('images/favicon-tfc-the-fazli-community.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta')

    @foreach (localizedHreflangUrls() as $hreflang => $url)
        <link rel="alternate" hreflang="{{ $hreflang }}" href="{{ $url }}" />
    @endforeach

    <link rel="stylesheet" href="{{ asset('styles/app.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/theme.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    @if($locale == 'ar')
        <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('styles/rtl.css') }}">
    @endif
    
    @if($locale == 'ur')
        <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;700&family=Noto+Sans+Arabic:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('styles/rtl.css') }}">
    @endif

    <!-- responsive css -->
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-header.css')}}">
    @unless($skipJqueryUi)
        <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-login-register.css')}}">
    @endunless

    @unless($skipJqueryUi)
    <!-- jquery ui -->
    <link rel="stylesheet" href="{{ asset('lib/jquery-ui.css')}}">
    <script src="{{ asset('lib/jquery-3.6.0.js')}}"></script>
    <script src="{{ asset('lib/jquery-ui.js')}}"></script>
    @endunless

    @yield('head')

    <link rel="stylesheet" href="{{ asset('styles/scrollbars.css') }}">

    @yield('structured_data')

</head>

@php
    $bodyClass = trim((string) $__env->yieldContent('body_class'));
    $isCvPage = str_starts_with($bodyClass, 'page-cv');
@endphp
<body onresize="add_collapse()" id="body" class="{{ $bodyClass }}"{{ $isCvPage ? ' data-theme-lock=dark' : '' }}>
    @include("site.inc.header")
    @include("site.inc.cv")

    <!--Start Preloader-->
    <!-- <div class="loader js-preloader">
        <div></div>
        <div></div>
        <div></div>
    </div> -->
    <!--End Preloader-->

    @yield('content')

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top">
        <span class="scroll-to-top__wrapper">
            <span class="scroll-to-top__inner"></span>
        </span>
        <span class="scroll-to-top__text">{{ __('lang.Go Back Top') }}</span>
    </a>

    @include("site.inc.footer")   

    @yield('script')

    <div id="comment-success-message" style="display:none; position:fixed; top:30px; left:50%; transform:translateX(-50%); z-index:9999; background:#1da370; color:#fff; padding:12px 32px; border-radius:8px; font-size:1.1rem; box-shadow:0 2px 8px #0002;">
        {{ __('lang.Comment added successfully!') }}
    </div>

    @guest
        <link rel="stylesheet" href="{{ asset('styles/auth-hint.css') }}">
        <div id="auth-required-overlay" class="auth-required-overlay" hidden aria-hidden="true">
            <div class="auth-required-overlay__backdrop" data-auth-dismiss aria-hidden="true"></div>
            <div id="auth-required-toast" class="auth-required-toast" role="alertdialog" aria-modal="true" aria-labelledby="auth-required-title" aria-live="polite">
                <h2 id="auth-required-title" class="auth-required-toast__title">{{ __('lang.AUTH_REQUIRED_TITLE') }}</h2>
                <p class="auth-required-toast__text">{{ __('lang.AUTH_REQUIRED_FOR_FEATURE') }}</p>
                <div class="auth-required-toast__actions">
                    <a href="{{ loginUrlWithNext() }}" class="auth-required-toast__login" data-auth-login>{{ __('lang.Login') }}</a>
                    <button type="button" class="auth-required-toast__dismiss" data-auth-dismiss>{{ __('lang.Close') }}</button>
                </div>
            </div>
        </div>
        <script>
            window.TFC_AUTH_HINT = {
                loginUrl: @json(loginUrlWithNext())
            };
        </script>
        <script src="{{ asset('js/auth-hint.js') }}"></script>
    @endguest

    <script src="{{ asset('js/theme.js') }}"></script>
    @unless($isToolsHubPage)
        <script src="{{ asset('js/like.js') }}"></script>
        <script src="{{ asset('js/comment.js') }}"></script>
        <script src="{{ asset('js/share-blog.js') }}"></script>
        @unless($isAboutPage)
            <script src="{{ asset('js/confetti.js') }}"></script>
        @endunless
    @endunless
</body>
</html>