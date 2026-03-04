@extends('site.layout')

@section('title', __('lang.Reset Password'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        .footer{
            display: none !important;
        }
    </style>
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

</style>

<div class="login-form">
    <h2>{{ __('lang.Reset Password') }}</h2>

    @if (session('status'))
        <div style="color: rgb(29, 89, 179); padding: 10px; background-color: rgba(29, 89, 179, 0.1); border-radius: 5px; margin-bottom: 15px;">
            <p style="margin: 0;"><strong>{{ session('status') }}</strong></p>
        </div>
    @endif

    {{-- Display validation errors --}}
    @if ($errors->any())
        <div style="color: rgb(160, 40, 50); padding: 10px; background-color: rgba(160, 40, 50, 0.1); border-radius: 5px; margin-bottom: 15px;">
            @foreach ($errors->all() as $error)
                <p style="margin: 0;"><strong>{{ $error }}</strong></p>
            @endforeach
        </div>
    @endif

    <form method="post" action="{{ route('localized.password.update', ['lang' => app()->getLocale()]) }}">
        @csrf

        {{-- Hidden token field --}}
        {{-- Ensure token is properly escaped for HTML but not double-encoded --}}
        <input type="hidden" name="token" value="{{ $token ?? '' }}">

        <div class="form-group mt-3">
            <label for="email">{{ __('lang.Email') }}</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $email ?? old('email') }}" placeholder="{{ __('lang.Enter Your Email') }}" required autofocus>
            @error('email')
                <p style="color: rgb(160, 40, 50);">{{ $message }}</p>
                <style>
                    #email {
                        border-color: rgb(160, 40, 50) !important;
                    }
                </style>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="password">{{ __('lang.Password') }}</label>
            <div style="position: relative;">
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    placeholder="{{ __('lang.Enter Your New Password') }}"
                    style="padding-right: 40px;"
                    required
                >
                <button
                    type="button"
                    id="togglePassword"
                    style="
                    position: absolute;
                    right: 10px;
                    top: 50%;
                    transform: translateY(-50%);
                    border: none;
                    background: none;
                    cursor: pointer;
                    padding: 0;
                    font-size: 16px;
                    "
                    aria-label="Show password"
                >
                    👁️
                </button>
            </div>
            @error('password')
                <p style="color: rgb(160, 40, 50);">{{ $message }}</p>
                <style>
                    #password {
                        border-color: rgb(160, 40, 50) !important;
                    }
                </style>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="password_confirmation">{{ __('lang.Confirm Password') }}</label>
            <div style="position: relative;">
                <input
                    type="password"
                    class="form-control"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="{{ __('lang.Confirm Your New Password') }}"
                    style="padding-right: 40px;"
                    required
                >
                <button
                    type="button"
                    id="togglePasswordConfirmation"
                    style="
                    position: absolute;
                    right: 10px;
                    top: 50%;
                    transform: translateY(-50%);
                    border: none;
                    background: none;
                    cursor: pointer;
                    padding: 0;
                    font-size: 16px;
                    "
                    aria-label="Show password"
                >
                    👁️
                </button>
            </div>
            @error('password_confirmation')
                <p style="color: rgb(160, 40, 50);">{{ $message }}</p>
                <style>
                    #password_confirmation {
                        border-color: rgb(160, 40, 50) !important;
                    }
                </style>
            @enderror
        </div>

        <div class="d-flex" style="align-items: center; justify-content: space-between; margin-top: 20px;">
            <button type="submit" id="submitButton" class="btn text-light btn-sm" style="background: #21cf8c; color:rgb(13, 14, 13) !important;">
                {{ __('lang.Reset Password') }}
            </button>
            <a style="color:rgb(20, 57, 82); font-size: small;" href="{{ route('localized.login', ['lang' => app()->getLocale()]) }}">
                {{ __('lang.Back to Login') }}
            </a>
        </div>
    </form>
</div>

<script>
    // Password visibility toggle
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    }

    // Password confirmation visibility toggle
    const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
    const passwordConfirmationInput = document.querySelector('#password_confirmation');

    if (togglePasswordConfirmation && passwordConfirmationInput) {
        togglePasswordConfirmation.addEventListener('click', function () {
            const type = passwordConfirmationInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmationInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    }

    // Add loading state to submit button
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitButton = document.getElementById('submitButton');
        
        if (form && submitButton) {
            form.addEventListener('submit', function() {
                submitButton.disabled = true;
                submitButton.style.opacity = '0.6';
                submitButton.style.cursor = 'not-allowed';
                submitButton.textContent = '{{ __("lang.Resetting...") }}';
            });
        }
    });
</script>

@endsection



