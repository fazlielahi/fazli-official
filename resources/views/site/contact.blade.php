@extends('site.layout')
@section('body_class', 'page-contact')
@section('title', __('lang.Contact page meta title'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{{ __('lang.Contact page meta description') }}" />
    <meta name="keywords" content="{{ __('lang.Contact page meta keywords') }}" />

    <meta property="og:title" content="{{ __('lang.Contact page meta title') }}" />
    <meta property="og:description" content="{{ __('lang.Contact page meta description') }}" />
    <meta property="og:image" content="https://thefazli.com/images/tfc-contact-page-preview.png" />
    <meta property="og:url" content="https://thefazli.com/{{ $locale }}/contact" />
    <meta property="og:type" content="website" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@fazlielahi" />
    <meta name="twitter:title" content="{{ __('lang.Contact page meta title') }}" />
    <meta name="twitter:description" content="{{ __('lang.Contact page meta description') }}" />
    <meta name="twitter:image" content="https://thefazli.com/images/tfc-contact-page-preview.png" />

    <meta name="author" content="TFC - The Fazli Community" />
    <meta name="robots" content="index, follow, max-image-preview:large">

    <link rel="canonical" href="https://thefazli.com/{{ $locale }}/contact" />
@endsection

@section('structured_data')
    @php
        $contactPageUrl = 'https://thefazli.com/' . $locale . '/contact';
    @endphp
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => 'https://thefazli.com/' . $locale,
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => __('lang.Contact'),
                'item' => $contactPageUrl,
            ],
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'ContactPage',
        'name' => __('lang.Contact page meta title'),
        'description' => __('lang.Contact page meta description'),
        'url' => $contactPageUrl,
        'mainEntity' => [
            '@type' => 'Organization',
            'name' => 'TFC - The Fazli Community',
            'url' => 'https://thefazli.com/' . $locale,
            'email' => 'info@thefazli.com',
            'telephone' => '+966592304816',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Riyadh',
                'addressCountry' => 'SA',
            ],
            'contactPoint' => [
                [
                    '@type' => 'ContactPoint',
                    'telephone' => '+966592304816',
                    'email' => 'info@thefazli.com',
                    'contactType' => 'customer service',
                    'availableLanguage' => ['en', 'ar', 'ur'],
                ],
            ],
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endsection

@section('head')
    <link rel="preload" href="{{ asset('assets/css/module-css/contact.css') }}" as="style" />
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-all.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/contact.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/contact-page.css') }}">
@endsection

@section('content')
    <main>
        <section class="contact-two">
            <div class="container">
                <ul class="row list-unstyled">
                    <li class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="100ms">
                        <div class="contact-two__single">
                            <div class="contact-two__icon">
                                <img src="{{ asset('assets/images/icon/contact-two-icon-1.png') }}" alt="" role="presentation" aria-hidden="true">
                            </div>
                            <h2 class="contact-two__title">{{ __('lang.Address') }}</h2>
                            <p>{{ __('lang.CONTACT_ADDRESS_VALUE') }}</p>
                        </div>
                    </li>
                    <li class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="200ms">
                        <div class="contact-two__single">
                            <div class="contact-two__icon">
                                <img src="{{ asset('assets/images/icon/contact-two-icon-2.png') }}" alt="" role="presentation" aria-hidden="true">
                            </div>
                            <h2 class="contact-two__title">{{ __('lang.Contact Number') }}</h2>
                            <p><a href="https://wa.me/966592304816"><i class="fab fa-whatsapp"></i> +966592304816</a></p>
                            <p><a href="tel:+966592304816"><i class="fas fa-phone"></i> +966592304816</a></p>
                        </div>
                    </li>
                    <li class="col-xl-3 col-lg-6 col-md-6 wow fadeInRight" data-wow-delay="300ms">
                        <div class="contact-two__single">
                            <div class="contact-two__icon">
                                <img src="{{ asset('assets/images/icon/contact-two-icon-3.png') }}" alt="" role="presentation" aria-hidden="true">
                            </div>
                            <h2 class="contact-two__title">{{ __('lang.Email Address') }}</h2>
                            <p><a href="mailto:info@thefazli.com">info@thefazli.com</a></p>
                            <p><a href="mailto:fazlielahi01@gmail.com">fazlielahi01@gmail.com</a></p>
                        </div>
                    </li>
                    <li class="col-xl-3 col-lg-6 col-md-6 wow fadeInRight" data-wow-delay="400ms">
                        <div class="contact-two__single">
                            <div class="contact-two__icon">
                                <img src="{{ asset('assets/images/icon/contact-two-icon-4.png') }}" alt="" role="presentation" aria-hidden="true">
                            </div>
                            <h2 class="contact-two__title">{{ __('lang.Working hours') }}</h2>
                            <p>10:00 AM - 8:00 PM<br>{{ __('lang.Monday - Saturday') }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        <section class="contact-three" id="contact-form">
            <div class="container">
                <div class="row contact-form">
                    <div class="col-xl-6 col-lg-6">
                        <div class="contact-three__left">
                            <div class="contact-three__img">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d463878.29488595825!2d46.82252880000001!3d24.725191849999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2f03890d489399%3A0xba974d1c98e79fd5!2sRiyadh!5e0!3m2!1sen!2ssa!4v1753643396917!5m2!1sen!2ssa" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="{{ __('lang.Address') }}"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="contact-three__right">
                            <div class="section-title-two text-left sec-title-animation animation-style1">
                                <div class="section-title-two__tagline-box">
                                    <span class="section-title-two__tagline">{{ __('lang.Get in Touch') }}</span>
                                </div>
                                <h1 class="section-title-two__title">{{ __('lang.We are Here to Help and Ready to Hear from You') }}</h1>
                            </div>
                            @if (session('success'))
                                <div class="contact-form-alert contact-form-alert--success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="contact-form-alert contact-form-alert--error" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="contact-form-alert contact-form-alert--error" role="alert">
                                    {{ __('lang.Please check the form and try again') }}
                                </div>
                            @endif

                            <form class="contact-three__form" action="{{ route('localized.contact.send', ['lang' => app()->getLocale()]) }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <h4 class="contact-three__input-title">{{ __('lang.Full Name') }}</h4>
                                        <div class="contact-three__input-box">
                                            <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('lang.Jhon Doe Placeholder') }}" required>
                                        </div>
                                        @error('name')
                                            <p class="contact-form-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <h4 class="contact-three__input-title">{{ __('lang.Email Address') }} *</h4>
                                        <div class="contact-three__input-box">
                                            <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('lang.Email Placeholder') }}" required>
                                        </div>
                                        @error('email')
                                            <p class="contact-form-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-xl-12">
                                        <h4 class="contact-three__input-title">{{ __('lang.Subject') }} *</h4>
                                        <div class="contact-three__input-box">
                                            <input type="text" name="subject" value="{{ old('subject', $quoteSubject ?? '') }}" placeholder="{{ __('lang.Write about your enquiry') }}" required>
                                        </div>
                                        @error('subject')
                                            <p class="contact-form-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-xl-12">
                                        <h4 class="contact-three__input-title">{{ __('lang.Message') }} *</h4>
                                        <div class="contact-three__input-box text-message-box">
                                            <textarea name="message" placeholder="{{ __('lang.Write Your Message') }}" required>{{ old('message', $quoteMessage ?? '') }}</textarea>
                                        </div>
                                        @error('message')
                                            <p class="contact-form-error">{{ $message }}</p>
                                        @enderror
                                        <div class="contact-three__btn-box">
                                            <button type="submit" class="thm-btn-two contact-three__btn"><span>{{ __('lang.Send') }} {{ __('lang.Message') }}</span><i class="icon-angles-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="result"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('script')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/wow.js') }}"></script>
    <script src="{{ asset('js/contact-page.js') }}"></script>
    <script src="{{ asset('js/menu.js') }}" defer></script>
@endsection
