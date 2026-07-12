@extends('site.layout')

@section('body_class', 'page-about page-blogs')
@section('title', __('lang.About page meta title'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{{ __('lang.About page meta description') }}" />
    <meta name="keywords" content="{{ __('lang.About page meta keywords') }}" />

    <meta property="og:title" content="{{ __('lang.About page meta title') }}" />
    <meta property="og:description" content="{{ __('lang.About page meta description') }}" />
    <meta property="og:image" content="https://thefazli.com/images/tfc-about-page-preview.png" />
    <meta property="og:url" content="https://thefazli.com/{{ $locale }}/about-tfc" />
    <meta property="og:type" content="website" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@fazlielahi" />
    <meta name="twitter:title" content="{{ __('lang.About page meta title') }}" />
    <meta name="twitter:description" content="{{ __('lang.About page meta description') }}" />
    <meta name="twitter:image" content="https://thefazli.com/images/tfc-about-page-preview.png" />

    <meta name="author" content="{{ __('lang.MADE_BY') }}" />
    <meta name="robots" content="index, follow, max-image-preview:large">

    <link rel="canonical" href="https://thefazli.com/{{ $locale }}/about-tfc" />
@endsection

@section('structured_data')
    @php
        $aboutPageUrl = 'https://thefazli.com/' . $locale . '/about-tfc';
        $portfolioListElements = [];

        foreach ($portfolioItems as $index => $project) {
            $portfolioListElements[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'item' => [
                    '@type' => 'WebSite',
                    'name' => __('lang.' . $project['title_key']),
                    'url' => $project['url'],
                    'description' => __('lang.' . $project['desc_key']),
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
                'name' => __('lang.Home'),
                'item' => 'https://thefazli.com/' . $locale,
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => __('lang.About TFC'),
                'item' => $aboutPageUrl,
            ],
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'AboutPage',
        'name' => __('lang.About page meta title'),
        'description' => __('lang.About page meta description'),
        'url' => $aboutPageUrl,
        'isPartOf' => [
            '@type' => 'WebSite',
            'name' => __('lang.MADE_BY'),
            'url' => 'https://thefazli.com/' . $locale,
        ],
        'about' => [
            '@type' => 'Organization',
            'name' => __('lang.MADE_BY'),
            'url' => 'https://thefazli.com/' . $locale,
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'name' => __('lang.Portfolio'),
        'itemListElement' => $portfolioListElements,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @include('site.partials.schema-faq')
@endsection

@section('head')
    <link rel="preload" href="{{ asset('assets/css/module-css/banner.css') }}" as="style" />
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom-animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/odometer.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/css/module-css/banner.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/about.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/services.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/why-choose.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/blog.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/testimonial.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/faq.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-blog.css') }}" />
    <link rel="stylesheet" href="{{ asset('cv/css/cv-templates.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />
    <link rel="stylesheet" href="{{ asset('styles/blogs.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/blogs-comment-modal.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/about-page.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
@endsection


@section('content')
    @php
        $isRtl = in_array($locale, ['ar', 'ur'], true);
        $slideAnim = $isRtl ? 'slideInRight' : 'slideInLeft';
    @endphp

    <div class="page-wrapper">
        <main>
            <!-- Banner One Start -->
            <section class="banner-one">
                <div class="container main-banner-container">
                    <div class="row main-banner">
                        <div class="col-xl-6">
                            <div class="banner-one__left">
                                <div class="banner-one__title-box">
                                    <div class="banner-one__title-box-shape">
                                        <img src="{{ asset('assets/images/shapes/banner-one-title-box-shape-1.png') }}" alt="" aria-hidden="true">
                                    </div>
                                    <h1 class="banner-one__title">
                                        <span class="banner-one__title-clr-1">{{ __('lang.Your Vision') }}</span><br>
                                        <span class="banner-one__title-clr-2">{!! __('lang.Our Code') !!}</span> <br>
                                        <span class="slogan-3">{{ __('lang.Lets Build Something Great') }} </span>
                                    </h1>
                                </div>
                                <p class="banner-one__text">
                                    {{ __('lang.I bring ideas to life through') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="banner-one__right">
                                <div class="banner-one__img-box">
                                    <div class="banner-one__img">
                                        <img src="{{ asset('assets/images/banner-two-img-1.png') }}" alt="Fazli Elahi standing confidently in a TFC logo shirt, representing The Fazli Community">
                                        <div class="banner-one__img-shape-box rotate-me">
                                            <div class="banner-one__img-shape-1">
                                                <div class="banner-one__img-shape-2"></div>
                                            </div>
                                            <div class="banner-one__shape-1">
                                                <img src="{{ asset('assets/images/shapes/banner-one-shape-1.png') }}" alt="" aria-hidden="true">
                                            </div>
                                            <div class="banner-one__shape-2 rotate-me"></div>
                                            <div class="banner-one__shape-3">
                                                <img src="{{ asset('assets/images/shapes/banner-one-shape-3.png') }}" alt="" aria-hidden="true">
                                            </div>
                                        </div>
                                        <div class="banner-one__udemy-review">
                                            <!-- TFC LinkedIn Logo -->
                                             <a href="https://www.linkedin.com/company/thefazli/" target="_blank">
                                                <div class="banner-one__udemy-review-img">
                                                    <img src="{{ asset('images/linkedin-profile-photo.jpg') }}" alt="TFC's LinkedIn profile photo">
                                                </div>
                                                <div class="banner-one__udemy-review-logo">
                                                    <img src="{{ asset('images/linked-91x38.png') }}" height="100%" alt="LinkedIn logo">
                                                </div>
                                                <div class="banner-one__udemy-review-client-info">
                                                    <p class="banner-one__udemy-review-client-name">TFC | </p>
                                                    <div class="banner-one__udemy-review-star">
                                                        <span class="icon-star"></span>
                                                        <span class="icon-star"></span>
                                                        <span class="icon-star"></span>
                                                        <span class="icon-star"></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="banner-one__student-trained">
                                            <div class="banner-one__student-trained-shape-1 rotate-me">
                                                <img src="{{ asset('assets/images/shapes/banner-one-student-trained-shape-1.png') }}" alt="" aria-hidden="true">
                                            </div>
                                            <ul class="list-unstyled banner-one__student-trained-list">
                                                <li>
                                                    <div class="banner-one__student-trained-img">
                                                        <img src="{{ asset('images/client1.jpg') }}" alt="Photo of a satisfied client - Samad Khan">
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="banner-one__student-trained-img">
                                                        <img src="{{ asset('images/client2.jpg') }}" alt="Photo of a satisfied client - Majid Khan">
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="banner-one__student-trained-count-box">
                                                <div class="banner-one__student-trained-count-box-inner count-box">
                                                    <p class="count-text" data-stop="100" data-speed="3000">00</p>
                                                    <span>+</span>
                                                </div>
                                                <p class="banner-one__student-trained-text" >{{ __('lang.Happy Clients') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="banner-one__category-search-box">
                                <div class="banner-one__tags">
                                    <a href="#about-section">{{ __('lang.About') }}</a>
                                    <a href="#services-section">{{ __('lang.Services') }}</a>
                                    <a href="#cv-templates-section">{{ __('lang.Create Cv') }}</a>
                                    <a href="#why-choose-me">{{ __('lang.Why Us?') }}</a>
                                    <a href="#portfolio-sec">{{ __('lang.Portfolio') }}</a>
                                    <a href="#blog-section-home">{{ __('lang.Blogs') }}</a>
                                    <a href="#faq">{{ __('lang.FAQs') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--Banner One End -->

            <!-- About One Start -->
            <section class="about-one about-ltr-lock" id="about-section" dir="ltr">
                <div class="about-one__shape-1">
                    <img src="{{ asset('assets/images/shapes/about-one-shape-1.png') }}" alt="" aria-hidden="true">
                </div>
                <div class="about-one__shape-2">
                    <img src="{{ asset('assets/images/shapes/about-one-shape-2.png') }}" alt="" aria-hidden="true">
                </div>
                <div class="container">
                    <div class="row about-one__row">
                        <div class="col-xl-6 wow slideInLeft" data-wow-delay="100ms" data-wow-duration="2500ms">
                            <div class="about-one__left">
                                <div class="about-one__left-shape-1 rotate-me"></div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="about-one__img-box">
                                            <div class="about-one__img">
                                                <img src="{{ asset('assets/images/resources/tfc.jpg') }}" alt="TFC - The Fazli Community logo in About section">
                                            </div>
                                        </div>
                                        <div class="about-one__awards-box">
                                            <div class="about-one__awards-count-box">
                                                <h3 class="odometer" data-count="100">00</h3>
                                                <span>+</span>
                                            </div>
                                            <p>{{ __('lang.Happy Clients') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="about-one__experience-box">
                                            <div class="about-one__experience-box-inner">
                                                <div class="about-one__experience-icon">
                                                    <img src="{{ asset('assets/images/icon/about-one-experience-icon.png') }}" alt="Experience icon in the About TFC section">
                                                </div>
                                                <div class="about-one__experience-count-box">
                                                    <div class="about-one__experience-count">
                                                        <h3 class="odometer" data-count="5">00</h3>
                                                        <span>+</span>
                                                        <p>{{ __('lang.Years') }}</p>
                                                    </div>
                                                    <p>{{ __('lang.of experience') }}</p>
                                                </div>
                                            </div>
                                            <div class="about-one__experience-box-shape"></div>
                                        </div>
                                        <div class="about-one__img-box-2">
                                            <div class="about-one__img-2">
                                                <img src="{{ asset('assets/images/resources/fazli-elahi-about.jpeg') }}" alt="Fazli Elahi, founder of TFC - The Fazli Community">
                                            </div>
                                            <div class="about-one__img-shape-1 float-bob-y">
                                                <img src="{{ asset('assets/images/shapes/about-one-img-shape-1.png') }}" alt="" aria-hidden="true" role="presentation">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="about-one__right">
                                <div class="section-title text-start sec-title-animation animation-style2">
                                    <div class="section-title__tagline-box">
                                        <div class="section-title__tagline-shape"></div>
                                        <span class="section-title__tagline">{{ __('lang.About Us') }}</span>
                                    </div>
                                    <h2 class="section-title__title {{ $locale == 'en' ? 'title-animation' : '' }}">
                                        <div class="im">
                                        <span class="about-brand-prefix">{{ __('lang.TFC brand prefix') }}</span>
                                            <span class="about-brand-name">{{ __('lang.The Fazli Community') }}</span>
                                        </div>
                                       
                                        <span>{!! __('lang.Helping You Grow') !!} <img src="{{ asset('assets/images/shapes/section-title-shape-1.png') }}" alt="" role="presentation" aria-hidden="true"></span>
                                    </h2>
                                </div>
                                <p class="about-one__text">{{ __('lang.I bring ideas to life through') }}</p>
                                <ul class="about-one__mission-and-vision list-unstyled">
                                    <li>
                                        <div class="about-one__icon-and-title">
                                            <div class="about-one__icon">
                                                <img src="{{ asset('assets/images/icon/mission-icon.png') }}" alt="" role="presentation" aria-hidden="true">
                                            </div>
                                            <h3>{{ __('lang.Our Mission') }}:</h3>
                                        </div>
                                        <p class="about-one__mission-and-vision-text">{{ __('lang.Our mission is to provide helpful tools, valuable resources, and reliable tech services that empower individuals and businesses to learn, grow, and succeed online') }}</p>
                                    </li>
                                    <li>
                                        <div class="about-one__icon-and-title">
                                            <div class="about-one__icon">
                                                <img src="{{ asset('assets/images/icon/vision-icon.png') }}" alt="" role="presentation" aria-hidden="true">
                                            </div>
                                            <h3>{{ __('lang.Our Vision') }}</h3>
                                        </div>
                                        <p class="about-one__mission-and-vision-text">{{ __('lang.To become a leading digital hub where learners, professionals, and businesses connect, grow, and thrive through innovative tech solutions and community-driven support.') }}</p>
                                    </li>
                                </ul>
                                <div class="about-one__btn-and-live-class">
                                    <div class="about-one__btn-box">
                                        <a href="{{ route('localized.contact', ['lang' => app()->getLocale()]) }}" class="about-one__btn thm-btn">
                                            <span class="icon-angles-right"></span>{{ __('lang.About get in touch') }}
                                        </a>
                                    </div>
                                    <h3 class="about-one__live-class">{{ __('lang.Available') }}
                                        <img src="{{ asset('assets/images/shapes/live-class-shape-1.png') }}" alt="" role="presentation" aria-hidden="true">
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- About One End -->

            <!-- Services One Start -->
            <section class="blogs-one" >
                <div class="container">
                    <div class="section-title text-center sec-title-animation animation-style1" id="services-section">
                        <div class="section-title__tagline-box">
                            <div class="section-title__tagline-shape"></div>
                            <span class="section-title__tagline" >{{ __('lang.Services') }}</span>
                        </div>
                        <h2 class="section-title__title {{ $locale == 'en' ? 'title-animation' : '' }}">{{ __('lang.More Than Web') }} <br>{{ __('lang.One Place,') }}
                            <span class="solution">{{ __('lang.Many Solutions.') }} <img src="{{ asset('assets/images/shapes/section-title-shape-1.png') }}" alt="" role="presentation" aria-hidden="true"></span></h2>
                    </div>
                    <div class="blogs-one__carousel owl-theme owl-carousel">
                        @include('site.partials.about-services-carousel')
                    </div>
                </div>
            </section>
            <!-- Services One End -->

            @include('site.partials.about-cv-templates-section')

            <!-- Why Choose One Start -->
            <section class="why-choose-one about-ltr-lock" id="why-choose-me" dir="ltr">
                <div class="why-choose-one__shape-6 float-bob-x">
                    <img src="{{ asset('assets/images/shapes/why-choose-one-shape-6.png') }}" alt="" role="presentation" aria-hidden="true">
                </div>
                <div class="why-choose-one__shape-7 float-bob-y">
                    <img src="{{ asset('assets/images/shapes/why-choose-one-shape-7.png') }}" alt="" role="presentation" aria-hidden="true">
                </div>
                <div class="container">
                    <div class="row why-choose-us">
                        <div class="col-xl-6">
                            <div class="why-choose-one__left wow slideInLeft" data-wow-delay="100ms" data-wow-duration="2500ms">
                                <div class="why-choose-one__img-box">
                                    <div class="why-choose-one__img">
                                    <img src="{{ asset('assets/images/resources/tfc-team-why-choose-us.jpg') }}" alt="TFC team group photo at LEAP 2025 event with Autosoft company team">
                                    </div>
                                    <div class="why-choose-one__img-2">
                                    <img src="{{ asset('assets/images/resources/tfc-lab-why-choose-us.jpg') }}" alt="TFC lab and workspace showcasing our tech environment">
                                    </div>
                                    <div class="why-choose-one__shape-1 float-bob-y">
                                        <img src="{{ asset('assets/images/shapes/why-choose-one-shape-1.png') }}" alt="" role="presentation" aria-hidden="true">
                                    </div>
                                    <div class="why-choose-one__shape-2 float-bob-x">
                                        <img src="{{ asset('assets/images/shapes/why-choose-one-shape-2.png') }}" alt="" role="presentation" aria-hidden="true">
                                    </div>
                                    <div class="why-choose-one__shape-3 float-bob-y">
                                        <img src="{{ asset('assets/images/shapes/why-choose-one-shape-3.png') }}" alt="" role="presentation" aria-hidden="true">
                                    </div>
                                    <div class="why-choose-one__shape-4">
                                        <img src="{{ asset('assets/images/shapes/why-choose-one-shape-4.png') }}" alt="" role="presentation" aria-hidden="true">
                                    </div>
                                    <div class="why-choose-one__shape-5 img-bounce">
                                        <img src="{{ asset('assets/images/shapes/why-choose-one-shape-5.png') }}" alt="" role="presentation" aria-hidden="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="why-choose-one__right">
                                <div class="section-title text-start sec-title-animation animation-style2">
                                    <div class="section-title__tagline-box">
                                        <div class="section-title__tagline-shape"></div>
                                        <span class="section-title__tagline">{{ __('lang.Why Choose Us') }}</span>
                                    </div>
                                    <h2 class="section-title__title {{ $locale == 'en' ? 'title-animation' : '' }}">{{ __('lang.Why Clients Choose Us:') }}
                                        <span>{!! __('lang.And Stay With Us.') !!} <img src="{{ asset('assets/images/shapes/section-title-shape-1.png') }}" alt="" role="presentation" aria-hidden="true"></span>
                                    </h2>
                                </div>
                                <p class="why-choose-one__text">{{ __('lang.Because we care about your success. With the right mix of skills, dedication, and creativity, we turn your ideas into results — efficiently and professionally.') }}</p>
                                <div class="why-choose-one__points-box">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <ul class="why-choose-one__points-list list-unstyled">
                                                <li>
                                                    <div class="why-choose-one__points-icon-inner">
                                                        <div class="why-choose-one__points-icon">
                                                            <img src="{{ asset('assets/images/icon/why-choose-one-icon-1.png') }}" alt="" role="presentation" aria-hidden="true">
                                                        </div>
                                                    </div>
                                                    <div class="why-choose-one__points-content">
                                                        <h3>{{ __('lang.On-Time Delivery') }}</h3>
                                                        <p>{{ __('lang.We respect deadlines and always aim to deliver before them.') }}</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="why-choose-one__points-icon-inner">
                                                        <div class="why-choose-one__points-icon">
                                                            <img src="{{ asset('assets/images/icon/why-choose-one-icon-2.png') }}" alt="" role="presentation" aria-hidden="true">
                                                        </div>
                                                    </div>
                                                    <div class="why-choose-one__points-content">
                                                        <h3>{{ __('lang.Client-Centered Approach') }}</h3>
                                                        <p>{{ __('lang.Your goals come first. Every solution is tailored to meet your exact needs.') }}</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <ul class="why-choose-one__points-list list-unstyled">
                                                <li>
                                                    <div class="why-choose-one__points-icon-inner">
                                                        <div class="why-choose-one__points-icon">
                                                            <img src="{{ asset('assets/images/icon/why-choose-one-icon-3.png') }}" alt="" role="presentation" aria-hidden="true">
                                                        </div>
                                                    </div>
                                                    <div class="why-choose-one__points-content">
                                                        <h3>{{ __('lang.All-in-One Skillset') }}</h3>
                                                        <p>{{ __('lang.From web development to creative support — everything in one place.') }}</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="why-choose-one__points-icon-inner">
                                                        <div class="why-choose-one__points-icon">
                                                            <img src="{{ asset('assets/images/icon/why-choose-one-icon-4.png') }}" alt="" role="presentation" aria-hidden="true">
                                                        </div>
                                                    </div>
                                                    <div class="why-choose-one__points-content">
                                                        <h3>{{ __('lang.Clean & Scalable Code') }}</h3>
                                                        <p>{{ __('lang.We build smart, efficient, and future-ready solutions — no shortcuts.') }}</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="why-choose-one__btn-and-client-box">
                                    <div class="why-choose-one__btn-box">
                                        <a href="{{ route('localized.contact', ['lang' => app()->getLocale()]) }}" class="why-choose-one__btn thm-btn">
                                            <span class="icon-angles-right"></span>{{ __('lang.About get in touch') }}
                                        </a>
                                    </div>
                                    <div class="why-choose-one__client-box">
                                        <ul class="why-choose-one__client-img-list list-unstyled">
                                            <li>
                                                <img src="{{ asset('assets/images/resources/why-choose-one-client-img-1.jpg') }}" alt="Amer Hamza, client of The Fazli Community">
                                            </li>
                                            <li>
                                            <img src="{{ asset('assets/images/resources/why-choose-one-client-img-2.jpg') }}" alt="Engr. Adzsar K. Saraka, client of The Fazli Community">
                                            </li>
                                            <li>
                                            <img src="{{ asset('assets/images/resources/why-choose-one-client-img-3.jpg') }}" alt="Gulalai Khan, client of The Fazli Community">
                                            </li>
                                        </ul>
                                        <div class="why-choose-one__client-content">
                                            <div class="why-choose-one__count-box">
                                                <h3 class="odometer" data-count="10">00</h3>
                                                <span>+</span>
                                            </div>
                                            <p>{{ __('lang.we have Professional Engineers') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Why Choose One End -->

            @include('site.partials.about-testimonial-section', [
                'testimonialDefaultImage' => asset('images/default.svg'),
            ])

        @include('site.partials.about-portfolio')
 

        @include('site.partials.about-blogs-preview')


        @include('site.partials.about-faq-section')



        </main>
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.js') }}"></script>
    <script src="{{ asset('assets/js/odometer.min.js') }}"></script>
    @if ($locale === 'en')
        <script src="{{ asset('assets/js/gsap/gsap.js') }}"></script>
        <script src="{{ asset('assets/js/gsap/ScrollTrigger.js') }}"></script>
        <script src="{{ asset('assets/js/gsap/SplitText.js') }}"></script>
    @endif
    <script src="{{ asset('js/about-page.js') }}"></script>
    <script src="{{ asset('js/menu.js') }}" defer></script>
@endsection