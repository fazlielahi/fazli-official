<!DOCTYPE html>
<html lang="en">

<head>
   
    <title>@yield('title', __('lang.DEFAULT_TITLE'))</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" >

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

</body>
</html>