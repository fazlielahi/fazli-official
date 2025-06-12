<!DOCTYPE html>
<html lang="en">

<head>
   
    <title>@yield('title', __('lang.DEFAULT_TITLE'))</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" >

    @yield('meta')

    <link rel="stylesheet" href="{{ asset('styles/app.css') }}">

    @if($locale == 'ar')
        <link rel="stylesheet" href="{{ asset('styles/rtl.css') }}">
    @endif

    <!-- jquery ui -->
    <link rel="stylesheet" href="lib/jquery-ui.css">
    <script src="lib/jquery-3.6.0.js"></script>
    <script src="lib/jquery-ui.js"></script>

    @yield('head')


</head>

<body onresize="add_collapse()" id="body" >

    @include("site.inc.header")
    @include("site.inc.cv")

    @yield('content')

    {{-- Loading Overlay --}}
    <div id="page-loader">
    <div class="loader-content">
        {{-- Animated SVG Graphic --}}
        <svg class="loader-graphic" viewBox="0 0 100 100" aria-hidden="true">
        <circle cx="50" cy="50" r="30" stroke="rgba(24,163,110,0.3)" stroke-width="8" fill="none"/>
        <circle cx="50" cy="50" r="30" stroke="rgb(24,163,110)" stroke-width="8" fill="none"
            stroke-dasharray="47 188" stroke-linecap="round"/>
        </svg>

        {{-- Spinner Fallback --}}
        <div class="spinner"></div>

        {{-- Loading Text + Pulsing Dots --}}
        <p>fazli.web<span class="dots">...</span></p>
    </div>
    </div>

@yield('script')
</body>
</html>


    @include("site.inc.footer")   

    @yield('script')

    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>