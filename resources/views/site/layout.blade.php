<!DOCTYPE html>
<html lang="en">

<head>
   
    <title>@yield('title', __('lang.DEFAULT_TITLE'))</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" >
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta')

    <link rel="stylesheet" href="{{ asset('styles/app.css') }}">
    
    @php $locale = app()->getLocale(); @endphp
    
    @if($locale == 'ar')
        <link rel="stylesheet" href="{{ asset('styles/rtl.css') }}">
    @endif

    <!-- jquery ui -->
    <link rel="stylesheet" href="{{ asset('lib/jquery-ui.css')}}">
    <script src="{{ asset('lib/jquery-3.6.0.js')}}"></script>
    <script src="{{ asset('lib/jquery-ui.js')}}"></script>

    @yield('head')


</head>

<body onresize="add_collapse()" id="body" >

    @include("site.inc.header")
    @include("site.inc.cv")

    <!--Start Preloader-->
    <div class="loader js-preloader">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!--End Preloader-->
    @yield('content')

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top">
        <span class="scroll-to-top__wrapper"><span class="scroll-to-top__inner"></span></span>
        <span class="scroll-to-top__text"> Go Back Top</span>
    </a>

    @include("site.inc.footer")   

    @yield('script')

    <div id="comment-success-message" style="display:none; position:fixed; top:30px; left:50%; transform:translateX(-50%); z-index:9999; background:#1da370; color:#fff; padding:12px 32px; border-radius:8px; font-size:1.1rem; box-shadow:0 2px 8px #0002;">
        {{ __('lang.Comment added successfully!') }}
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/like.js') }}"></script>
    <script src="{{ asset('js/comment.js') }}"></script>
    <script src="{{ asset('js/share-blog.js') }}"></script>

</body>
</html>