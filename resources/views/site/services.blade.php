@extends('site.layout')
@section('body_class', 'page-services')
@section('title', __('lang.Services page meta title'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{{ __('lang.Services page meta description') }}" />
    <meta name="keywords" content="{{ __('lang.Services page meta keywords') }}" />

    <meta property="og:title" content="{{ __('lang.Services page meta title') }}" />
    <meta property="og:description" content="{{ __('lang.Services page meta description') }}" />
    <meta property="og:image" content="https://thefazli.com/images/tfc-services-page-preview.png" />
    <meta property="og:url" content="https://thefazli.com/{{ $locale }}/services" />
    <meta property="og:type" content="website" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@fazlielahi" />
    <meta name="twitter:title" content="{{ __('lang.Services page meta title') }}" />
    <meta name="twitter:description" content="{{ __('lang.Services page meta description') }}" />
    <meta name="twitter:image" content="https://thefazli.com/images/tfc-services-page-preview.png" />

    <meta name="author" content="TFC - The Fazli Community" />
    <meta name="robots" content="index, follow, max-image-preview:large">

    <link rel="canonical" href="https://thefazli.com/{{ $locale }}/services" />
@endsection

@section('structured_data')
    @php
        $servicesPageUrl = 'https://thefazli.com/' . $locale . '/services';
        $serviceListElements = [];

        foreach ($services as $index => $service) {
            $serviceListElements[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'item' => [
                    '@type' => 'Service',
                    'name' => __('lang.' . $service['title']),
                    'url' => $service['contact_url'],
                    'provider' => [
                        '@type' => 'Organization',
                        'name' => 'TFC - The Fazli Community',
                    ],
                ],
            ];
        }
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
                'name' => __('lang.Services'),
                'item' => $servicesPageUrl,
            ],
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => __('lang.Services page meta title'),
        'description' => __('lang.Services page meta description'),
        'url' => $servicesPageUrl,
        'isPartOf' => [
            '@type' => 'WebSite',
            'name' => 'TFC - The Fazli Community',
            'url' => 'https://thefazli.com/' . $locale,
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'name' => __('lang.Services'),
        'itemListElement' => $serviceListElements,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endsection

@section('head')
    <link rel="preload" href="{{ asset('assets/css/module-css/services.css') }}" as="style" />
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/services.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/services-page.css') }}" />
@endsection

@section('content')
    <section class="blogs-one">
        <div class="container">
            <div class="section-title text-center sec-title-animation animation-style1" id="services-section">
                <div class="section-title__tagline-box">
                    <div class="section-title__tagline-shape"></div>
                    <span class="section-title__tagline">{{ __('lang.Services') }}</span>
                </div>
                <h1 class="section-title__title {{ $locale == 'en' ? 'title-animation' : '' }}">{{ __('lang.More Than Web') }} <br>{{ __('lang.One Place,') }}
                    <span class="solution">{{ __('lang.Many Solutions.') }} <img src="{{ asset('assets/images/shapes/section-title-shape-1.png') }}" alt="" role="presentation" aria-hidden="true"></span>
                </h1>
            </div>
            <div class="services-container">
                @foreach ($services as $service)
                    <div class="item services-card">
                        <a class="blogs-one__single service-card-home services-card__surface" href="{{ $service['contact_url'] }}">
                            <div class="blogs-one__img-box">
                                <div class="blogs-one__img">
                                    <img src="{{ asset('assets/images/resources/' . $service['image']) }}" alt="{{ __('lang.' . $service['title']) }} | TFC - The Fazli Community">
                                </div>
                            </div>
                            <div class="blogs-one__content">
                                <h2 class="blogs-one__title">{{ __('lang.' . $service['title']) }}</h2>
                                <div class="blogs-one__ratting-and-heart-box">
                                    <div class="blogs-one__ratting-box">
                                        <ul class="blogs-one__ratting list-unstyled">
                                            <li><span class="icon-star"></span></li>
                                            <li><span class="icon-star"></span></li>
                                            <li><span class="icon-star"></span></li>
                                            <li><span class="icon-star"></span></li>
                                            <li><span class="icon-star"></span></li>
                                        </ul>
                                        <p class="blogs-one__ratting-text">{{ __('lang.' . $service['reviews']) }}</p>
                                    </div>
                                    <div class="blogs-one__heart" aria-hidden="true">
                                        <span class="icon-heart"></span>
                                    </div>
                                </div>
                                <div class="blogs-one__btn-and-doller-box">
                                    <div class="blogs-one__btn-box">
                                        <span class="blogs-one__btn thm-btn">
                                            <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('js/menu.js') }}" defer></script>
    @if ($locale === 'en')
        <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/js/gsap/gsap.js') }}"></script>
        <script src="{{ asset('assets/js/gsap/ScrollTrigger.js') }}"></script>
        <script src="{{ asset('assets/js/gsap/SplitText.js') }}"></script>
        <script src="{{ asset('js/services-page.js') }}"></script>
    @endif
@endsection
