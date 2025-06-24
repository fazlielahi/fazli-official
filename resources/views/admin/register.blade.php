@extends('site.layout')

@section('title', __('lang.Register'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
@endsection

@section('head')
    <!-- Preload critical CSS -->
    <link rel="preload" href="{{ asset('assets/css/style.css') }}" as="style" />
    <link rel="preload" href="{{ asset('assets/css/responsive.css') }}" as="style" />

    
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" /> <!-- main heading css -->
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet" />

    <!-- Third-party CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom-animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-all.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jarallax.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/odometer.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}" />

    <!-- Module CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/banner.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/footer.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/sliding-text.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/category.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/about.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/services.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/why-choose.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/live-class.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/video-one.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/blog.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/counter.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/team.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/newsletter.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/testimonial.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/contact.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/process.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/page-header.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/become-a-teacher.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/shop.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/faq.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/error.css') }}" />

    <!-- Template styles -->
    <link rel="stylesheet" href="{{ asset('styles/login-register.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />

@endsection


@section('content')

<style>
 
    .ScrollSmoother-content{
        padding: 46px 23px 10px 23px;
        width: 35%;
        margin: 97px auto;
        background: white;
        border: 1px solid #8080803b;
        border-radius: 10px;
    }
    
</style>

<div class="register">

    <h2>{{ __('lang.Register') }}</h2>

    <!-- Registration form -->
     <form method="POST" action="{{ route('localized.register', ['lang' => app()->getlocale()]) }}" enctype="multipart/form-data">
        @csrf 

        <div class="form-group mt-3">
            <label for="name">{{ __('lang.Name') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="{{ __('lang.Enter Your Name') }}" class="form-control">
            @error('name')
                <p style="color: rgb(160, 40, 50);"> {{ $message }}</p>
                <style>
                    #name{
                        border-color: rgb(160, 40, 50) !important;
                    }
                </style>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="email">{{ __('lang.Email') }}</label>
            <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="{{ __('lang.Enter Your Email') }}" class="form-control">
            @error('email')
                <p style="color: rgb(160, 40, 50);"> {{ $message }}</p>
                <style>
                    #email{
                        border-color: rgb(160, 40, 50) !important;
                    }
                </style>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="password">{{ __('lang.Password') }}</label>
            <input type="password" id="password" name="password" placeholder="{{ __('lang.Enter Your Password') }}" class="form-control">
            @error('password')
                <p style="color: rgb(160, 40, 50);"> {{ $message }}</p>
                <style>
                    #password{
                        border-color: rgb(160, 40, 50) !important;
                    }
                </style>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="photo">Photo (Optional)</label>
            <input type="file" id="photo" name="photo" class="form-control">
            @error('photo')
                <p style="color: rgb(160, 40, 50);"> {{ $message }}</p>
                <style>
                    #photo{
                        border-color: rgb(160, 40, 50) !important;
                    }
                </style>
            @enderror
        </div>

        <button type="submit" class="btn text-light btn-sm mt-3" style="background: #21cf8c; color:rgba(0, 0, 0, 0.87) !important;">{{ __('lang.Register') }}</button>

        <p class="mt-3">{{ __('lang.Already have an account?') }} <a href="{{ route('localized.login', ['lang' => app()->getlocale()]) }}" style="color: #21cf8c;">{{ __('lang.Login here.') }}</a></p> 

     </form>
</div>
@endsection

@section('script')
{{-- Core JS --}}
        <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

        {{-- Plugins --}}
        <script src="{{ asset('assets/js/jarallax.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.ajaxchimp.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.appear.min.js') }}"></script>
        <script src="{{ asset('assets/js/swiper.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('assets/js/odometer.min.js') }}"></script>
        <script src="{{ asset('assets/js/wNumb.min.js') }}"></script>
        <script src="{{ asset('assets/js/wow.js') }}"></script>
        <script src="{{ asset('assets/js/isotope.js') }}"></script>
        <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
        <script src="{{ asset('assets/js/marquee.min.js') }}"></script>
        <script src="{{ asset('assets/js/aos.js') }}"></script>

        {{-- GSAP --}}
        <script src="{{ asset('assets/js/gsap/gsap.js') }}"></script>
        <script src="{{ asset('assets/js/gsap/ScrollTrigger.js') }}"></script>
        <script src="{{ asset('assets/js/gsap/SplitText.js') }}"></script>

        {{-- Custom Template JS --}}
        <script src="{{ asset('assets/js/script.js') }}"></script>

        {{-- Heart Icon Toggle Script --}}
        <script>
            $(document).ready(function() {
                // Heart icon toggle functionality
                $('.blogs-one__heart a').on('click', function(e) {
                    e.preventDefault();
                    var $heartIcon = $(this).find('.icon-heart');
                    
                    // Toggle the active class
                    $heartIcon.toggleClass('active');
                    
                    // Optional: Add animation effect
                    if ($heartIcon.hasClass('active')) {
                        $heartIcon.addClass('heart-beat');
                        setTimeout(function() {
                            $heartIcon.removeClass('heart-beat');
                        }, 300);
                    }
                });
            });
        </script>


@endsection