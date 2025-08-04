<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', __('lang.DEFAULT_TITLE'))</title>
    <link rel="icon" href="{{ asset('images/favicon-tfc-the-fazli-community.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta')

    <link rel="stylesheet" href="{{ asset('styles/app.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/theme.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    @php $locale = app()->getLocale(); @endphp
    
    @if($locale == 'ar')
        <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('styles/rtl.css') }}">
    @endif

    <!-- responsive css -->
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-header.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-login-register.css')}}">

    <!-- jquery ui -->
    <link rel="stylesheet" href="{{ asset('lib/jquery-ui.css')}}">
    <script src="{{ asset('lib/jquery-3.6.0.js')}}"></script>
    <script src="{{ asset('lib/jquery-ui.js')}}"></script>

    @yield('head')

    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://thefazli.com/{{$locale}}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Services",
      "item": "https://thefazli.com/{{$locale}}/services"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Contact",
      "item": "https://thefazli.com/{{$locale}}/contact"
    },
    {
      "@type": "ListItem",
      "position": 4,
      "name": "Blogs",
      "item": "https://thefazli.com/{{$locale}}/Blogs"
    },
    {
      "@type": "ListItem",
      "position": 5,
      "name": "{{ isset($blog) ? '/' . $blog->title : '' }}",
      "item": "https://thefazli.com/{{$locale}}{{ isset($blog) ? '/' . $blog->slug : '' }}"
    }
  ]
}
</script>


<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "{{ __('lang.faq_what_services') }}",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "{{ __('lang.faq_what_services_ans') }}"
      }
    },
    {
      "@type": "Question",
      "name": "{{ __('lang.faq_why_seo_important') }}",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "{{ __('lang.faq_why_seo_important_ans') }}"
      }
    },
    {
      "@type": "Question",
      "name": "{{ __('lang.faq_responsive_websites') }}",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "{{ __('lang.faq_responsive_websites_ans') }}"
      }
    },
    {
      "@type": "Question",
      "name": "{{ __('lang.faq_website_time') }}",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "{{ __('lang.faq_website_time_ans') }}"
      }
    },
    {
      "@type": "Question",
      "name": "{{ __('lang.faq_manage_content') }}",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "{{ __('lang.faq_manage_content_ans') }}"
      }
    },
    {
      "@type": "Question",
      "name": "{{ __('lang.faq_maintenance') }}",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "{{ __('lang.faq_maintenance_ans') }}"
      }
    }
  ]
}
</script>


</head>

<body onresize="add_collapse()" id="body">
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

    <script src="{{ asset('js/theme.js') }}"></script>
    <script src="{{ asset('js/like.js') }}"></script>
    <script src="{{ asset('js/comment.js') }}"></script>
    <script src="{{ asset('js/share-blog.js') }}"></script>
</body>
</html>