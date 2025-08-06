@extends('site.layout')

@section('title', __('lang.The Fazli Community – Tech Resources, Web Services & Learning Hub'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" 
          content="The Fazli Community (TFC) empowers learners, professionals, and businesses with web design, custom PHP development, digital marketing, SEO training, and free career tools. Join our tech community today!" />
    <meta name="keywords" content="web design, PHP development, custom PHP, digital marketing, SEO training, career tools, tech community, professional development, web development, online learning, business solutions" />

    <meta property="og:title" content="The Fazli Community – Tech Resources, Web Services & Learning Hub" />
    <meta property="og:description"   content="Empowering learners, professionals & businesses with web design, digital marketing, SEO training, and free career tools." />

    <meta property="og:image"         content="https://thefazli.com/images/tfc-website-preview.png" />
    <meta property="og:url"           content="https://thefazli.com/{{$locale}}" />
    <meta property="og:type"          content="website" />

    <meta name="twitter:card"         content="summary_large_image" />
    <meta name="twitter:site"         content="@fazlielahi" />
    <meta name="twitter:title"        content="The Fazli Community – Tech Resources & Learning Hub" />
    <meta name="twitter:description"  content="Empowering learners, professionals & businesses with web design, digital marketing, SEO training, and free career tools." />
    <meta name="twitter:image"        content="https://thefazli.com/images/tfc-website-preview.png" />

    <meta name="author" content="TFC - The Fazli Community" />
    <meta name="robots" content="index, follow" />
    
    <link rel="canonical" href="https://thefazli.com/{{$locale}}" />
    
@endsection

@section('head')
    <!-- Preload critical CSS -->
    <link rel="preload" href="{{ asset('assets/css/style.css') }}" as="style" />
    <link rel="preload" href="{{ asset('assets/css/responsive.css') }}" as="style" />

    <!-- Main styles -->
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
    <link 
      href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" 
      rel="stylesheet" 
    />

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

    <!-- Font Awesome CDN v6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

        <!-- responsive design -->
        <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-blog.css') }}" />
        
    <!-- responsive design -->
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-home.css') }}" />

    <!-- Template styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />

    <style>
        .blog-two .row{
            justify-content: center;
        }

        .footer{
            position: unset;
        }

        .fa-close-btn {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            color: #fff; /* white for dark theme */
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            line-height: 1;
            transition: color 0.2s;
        }
        body[data-theme="light"] .fa-close-btn {
            color: #222; /* dark for light theme */
        }
        .fa-close-btn:focus {
            outline: 2px solid #18835a;
        }

        .blog-two__title{
            margin-bottom: 20px !important;
        }

        .blog-two__content{
            padding-bottom: 1px !important;
        }
    </style>
@endsection


@section('content')

    <div class="page-wrapper">
        <main>
            <!-- Banner One Start -->
            <section class="banner-one" style="padding-top: 0px !important">            
                <div class="container main-banner-container">
                    <div class="row main-banner">
                        <div class="col-xl-6">
                            <div class="banner-one__left">
                                <div class="banner-one__title-box">
                                    <div class="banner-one__title-box-shape">
                                        <img src="{{ asset('assets/images/shapes/banner-one-title-box-shape-1.png') }}" alt="" aria-hidden="true">
                                    </div>
                                    <h2 class="banner-one__title">
                                        <span class="banner-one__title-clr-1">{{ __('lang.Your Vision') }}</span><br>
                                        <span class="banner-one__title-clr-2">{!! __('lang.Our Code') !!}</span> <br>
                                        <span class="slogan-3">{{ __('lang.Lets Build Something Great') }} </span>
                                    </h2>
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
                                            <div class="banner-one__udemy-review-img">
                                                <img src="{{ asset('images/linkedin-profile-photo.jpg') }}" alt="Fazli Elahi's LinkedIn profile photo">
                                            </div>
                                            <div class="banner-one__udemy-review-logo">
                                                <img src="{{ asset('images/linked-91x38.png') }}" height="100%" alt="LinkedIn logo">
                                            </div>
                                            <div class="banner-one__udemy-review-client-info">
                                                <p class="banner-one__udemy-review-client-name">Fazli Elahi | </p>
                                                <div class="banner-one__udemy-review-star">
                                                    <span class="icon-star"></span>
                                                    <span class="icon-star"></span>
                                                    <span class="icon-star"></span>
                                                    <span class="icon-star"></span>
                                                </div>
                                            </div>
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
                                    <a href="#why-choose-me">{{ __('lang.Why Us?') }}</a>
                                    <a href="#portfolio-sec">{{ __('lang.Portfolio') }}</a>
                                    <a href="#blog-section-home">{{ __('lang.Blogs') }}</a>
                                    <a href="#blog-section-home">{{ __('lang.FAQs') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--Banner One End -->

            <!-- About One Start -->
            <section class="about-one" id="about-section">
                <div class="about-one__shape-1">
                    <img src="{{ asset('assets/images/shapes/about-one-shape-1.png') }}" alt="" aria-hidden="true">
                </div>
                <div class="about-one__shape-2">
                    <img src="{{ asset('assets/images/shapes/about-one-shape-2.png') }}" alt="" aria-hidden="true">
                </div>
                <div class="container">
                    <div class="row about-rtl">
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
                                <div class="section-title text-left sec-title-animation animation-style2">
                                    <div class="section-title__tagline-box">
                                        <div class="section-title__tagline-shape"></div>
                                        <span class="section-title__tagline">{{ __('lang.About Us') }}</span>
                                    </div>
                                    <h2 class="section-title__title {{ $locale == 'en' ? 'title-animation' : '' }}">
                                        <div class="im">
                                        <span style="color:#fff">
                                            TFC -
                                            </span>
                                            <span style="margin: 0 8px;">The Fazli Community</span>
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
                                        <a href="{{ route('localized.about', ['lang' => app()->getLocale()]) }}" class="about-one__btn thm-btn">
                                            <span class="icon-angles-right"></span>{{ __('lang.Know More') }}
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
                        <!--blogs One Single Start-->
                        <div class="item">
                            <div class="blogs-one__single service-card-home">
                                <div class="blogs-one__img-box">
                                    <div class="blogs-one__img">
                                        <img src="{{ asset('assets/images/resources/web-development.jpg') }}" alt="Web development services by TFC - The Fazli Community">
                                    </div>
                                </div>
                                <div class="blogs-one__content">
                                 
                                    <h3 class="blogs-one__title">
                                        <a href="#">{{ __('lang.Web Design & Development') }}</a>
                                    </h3>
                                    <div class="blogs-one__ratting-and-heart-box">
                                        <div class="blogs-one__ratting-box">
                                            <ul class="blogs-one__ratting list-unstyled">
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                            </ul>
                                            <p class="blogs-one__ratting-text">{{ __('lang.32 Reviews') }}</p>
                                        </div>
                                        <div class="blogs-one__heart">
                                            <a href="#"><span class="icon-heart"></span></a>
                                        </div>
                                    </div>
                                    <div class="blogs-one__btn-and-doller-box">
                                        <div class="blogs-one__btn-box">
                                            <a href="{{ route('localized.contact', ['lang' => app()->getLocale()]) }}" class="blogs-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--blogs One Single End-->

                        <!--blogs One Single Start-->
                        <div class="item">
                            <div class="blogs-one__single service-card-home">
                                <div class="blogs-one__img-box">
                                    <div class="blogs-one__img">
                                        <img src="{{ asset('assets/images/resources/coorporate-identity.jpg') }}" alt="Corporate identity and branding services by TFC - The Fazli Community">
                                    </div>
                                </div>
                                <div class="blogs-one__content">
                                 
                                    <h3 class="blogs-one__title">
                                        <a href="#">{{ __('lang.Corporate Identity') }}</a>
                                    </h3>
                                    <div class="blogs-one__ratting-and-heart-box">
                                        <div class="blogs-one__ratting-box">
                                            <ul class="blogs-one__ratting list-unstyled">
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                            </ul>
                                            <p class="blogs-one__ratting-text">{{ __('lang.25 Reviews') }}</p>
                                        </div>
                                        <div class="blogs-one__heart">
                                            <a href="#"><span class="icon-heart"></span></a>
                                        </div>
                                    </div>
                                    <div class="blogs-one__btn-and-doller-box">
                                        <div class="blogs-one__btn-box">
                                            <a href="{{ route('localized.contact', ['lang' => app()->getLocale()]) }}" class="blogs-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--blogs One Single End-->

                        <!--blogs One Single Start-->
                        <div class="item">
                            <div class="blogs-one__single service-card-home">
                                <div class="blogs-one__img-box">
                                    <div class="blogs-one__img">
                                    <img src="{{ asset('assets/images/resources/digital-marketing.jpg') }}" alt="Digital marketing services by TFC - The Fazli Community">
                                    </div>
                                </div>
                                <div class="blogs-one__content">
                                 
                                    <h3 class="blogs-one__title">
                                        <a href="#">{{ __('lang.Digital Marketing') }}</a>
                                    </h3>
                                    <div class="blogs-one__ratting-and-heart-box">
                                        <div class="blogs-one__ratting-box">
                                            <ul class="blogs-one__ratting list-unstyled">
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                            </ul>
                                            <p class="blogs-one__ratting-text">{{ __('lang.30 Reviews') }}</p>
                                        </div>
                                        <div class="blogs-one__heart">
                                            <a href="#"><span class="icon-heart"></span></a>
                                        </div>
                                    </div>
                                    <div class="blogs-one__btn-and-doller-box">
                                        <div class="blogs-one__btn-box">
                                            <a href="{{ route('localized.contact', ['lang' => app()->getLocale()]) }}" class="blogs-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--blogs One Single End-->

                        <!--blogs One Single Start-->
                        <div class="item">
                            <div class="blogs-one__single service-card-home">
                                <div class="blogs-one__img-box">
                                    <div class="blogs-one__img">
                                    <img src="{{ asset('assets/images/resources/ecommerce.jpg') }}" alt="E-commerce development services by TFC - The Fazli Community">
                                    </div>
                                </div>
                                <div class="blogs-one__content">
                                 
                                    <h3 class="blogs-one__title">
                                        <a href="#">{{ __('lang.Ecommerce Development') }}</a>
                                    </h3>
                                    <div class="blogs-one__ratting-and-heart-box">
                                        <div class="blogs-one__ratting-box">
                                            <ul class="blogs-one__ratting list-unstyled">
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                            </ul>
                                            <p class="blogs-one__ratting-text">{{ __('lang.27 Reviews') }}</p>
                                        </div>
                                        <div class="blogs-one__heart">
                                            <a href="#"><span class="icon-heart"></span></a>
                                        </div>
                                    </div>
                                    <div class="blogs-one__btn-and-doller-box">
                                        <div class="blogs-one__btn-box">
                                            <a href="{{ route('localized.contact', ['lang' => app()->getLocale()]) }}" class="blogs-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--blogs One Single End-->

                        <!--blogs One Single Start-->
                        <div class="item">
                            <div class="blogs-one__single service-card-home">
                                <div class="blogs-one__img-box">
                                    <div class="blogs-one__img">
                                    <img src="{{ asset('assets/images/resources/social-media-marketing.jpg') }}" alt="Social media marketing services by TFC - The Fazli Community">
                                    </div>
                                </div>
                                <div class="blogs-one__content">
                                 
                                    <h3 class="blogs-one__title">
                                        <a href="#">{{ __('lang.Social Media Marketing') }}</a>
                                    </h3>
                                    <div class="blogs-one__ratting-and-heart-box">
                                        <div class="blogs-one__ratting-box">
                                            <ul class="blogs-one__ratting list-unstyled">
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                            </ul>
                                            <p class="blogs-one__ratting-text">{{ __('lang.24 Reviews') }}</p>
                                        </div>
                                        <div class="blogs-one__heart">
                                            <a href="#"><span class="icon-heart"></span></a>
                                        </div>
                                    </div>
                                    <div class="blogs-one__btn-and-doller-box">
                                        <div class="blogs-one__btn-box">
                                            <a href="{{ route('localized.contact', ['lang' => app()->getLocale()]) }}" class="blogs-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--blogs One Single End-->

                        <!--blogs One Single Start-->
                        <div class="item">
                            <div class="blogs-one__single service-card-home">
                                <div class="blogs-one__img-box">
                                    <div class="blogs-one__img">
                                    <img src="{{ asset('assets/images/resources/wordpress.jpg') }}" alt="WordPress development and services by TFC - The Fazli Community">
                                    </div>
                                </div>
                                <div class="blogs-one__content">
                                 
                                    <h3 class="blogs-one__title">
                                        <a href="#">{{ __('lang.WordPress Development') }}</a>
                                    </h3>
                                    <div class="blogs-one__ratting-and-heart-box">
                                        <div class="blogs-one__ratting-box">
                                            <ul class="blogs-one__ratting list-unstyled">
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                            </ul>
                                            <p class="blogs-one__ratting-text">{{ __('lang.22 Reviews') }}</p>
                                        </div>
                                        <div class="blogs-one__heart">
                                            <a href="#"><span class="icon-heart"></span></a>
                                        </div>
                                    </div>
                                    <div class="blogs-one__btn-and-doller-box">
                                        <div class="blogs-one__btn-box">
                                            <a href="{{ route('localized.contact', ['lang' => app()->getLocale()]) }}" class="blogs-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--blogs One Single End-->

                        <!--blogs One Single Start-->
                        <div class="item">
                            <div class="blogs-one__single service-card-home">
                                <div class="blogs-one__img-box">
                                    <div class="blogs-one__img">
                                    <img src="{{ asset('assets/images/resources/seo-training.jpg') }}" alt="SEO training course offered by TFC - The Fazli Community">
                                    </div>
                                </div>
                                <div class="blogs-one__content">
                                 
                                    <h3 class="blogs-one__title">
                                        <a href="#">{{ __('lang.SEO Training') }}</a>
                                    </h3>
                                    <div class="blogs-one__ratting-and-heart-box">
                                        <div class="blogs-one__ratting-box">
                                            <ul class="blogs-one__ratting list-unstyled">
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                            </ul>
                                            <p class="blogs-one__ratting-text">{{ __('lang.20 Reviews') }}</p>
                                        </div>
                                        <div class="blogs-one__heart">
                                            <a href="#"><span class="icon-heart"></span></a>
                                        </div>
                                    </div>
                                    <div class="blogs-one__btn-and-doller-box">
                                        <div class="blogs-one__btn-box">
                                            <a href="{{ route('localized.contact', ['lang' => app()->getLocale()]) }}" class="blogs-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--blogs One Single End-->
                    </div>
                </div>
            </section>
            <!-- Services One End -->

            <!-- Why Choose One Start -->
            <section class="why-choose-one" id="why-choose-me">
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
                                <div class="section-title text-left sec-title-animation animation-style2">
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
                                        <a href="{{ route('localized.about', ['lang' => app()->getLocale()]) }}" class="why-choose-one__btn thm-btn">
                                            <span class="icon-angles-right"></span>{{ __('lang.Know More') }}
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

                <!-- Testimonial One Start-->
                <section class="testimonial-one">
            <div class="testimonial-one__shape-1 float-bob-x">
                <img src="{{ asset('assets/images/shapes/testimonial-one-shape-1.png') }}" alt="" role="presentation" aria-hidden="true">
            </div>
            <div class="testimonial-one__shape-2">
                <img src="{{ asset('assets/images/shapes/testimonial-one-shape-2.png') }}" alt="" role="presentation" aria-hidden="true">
            </div>
            <div class="container">
                <div class="section-title text-left sec-title-animation animation-style2">
                    <div class="section-title__tagline-box">
                        <div class="section-title__tagline-shape"></div>
                        <span class="section-title__tagline">{{ __('lang.Testimonial') }}</span>
                    </div>
                    <h2 class="section-title__title">{{ __('lang.Explore Genuine Feedback') }} <br>
                        {!! __('lang.from Happy Clients') !!} 
                    </h2>
                </div>
                <div class="testimonial-one__inner">
                    <div class="testimonial-one__carousel owl-theme owl-carousel">
                        <!--Testimonial One Single Start-->
                        <div class="item">
                            <div class="testimonial-one__single">
                                <div class="testimonial-one__img-inner">
                                    <div class="testimonial-one__img">
                                    <img src="{{ asset('images/testimonial/majid-khan.jpg') }}" alt="Testimonial by Majid Khan, Architectural Designer" title="Majid Khan - Architectural Designer">
                                        <div class="testimonial-one__icon">
                                            <span class="icon-graduation-cap"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial-one__content">
                                    <div class="testimonial-one__client-info">
                                        <h3 class="testimonial-one__client-name">{{ __('lang.testimonial_majid_name') }}</h3>
                                        <p class="testimonial-one__client-sub-title">{{ __('lang.testimonial_majid_title') }}</p>
                                    </div>
                                    <p class="testimonial-one__text">{{ __('lang.testimonial_majid_text') }}</p>
                                    <div class="testimonial-one__ratting-and-social">
                                        <ul class="testimonial-one__ratting list-unstyled">
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                        </ul>
                                        <div class="testimonial-one__social">
                                            <a href="https://www.linkedin.com/in/mian-majid-khan-7a8b9c5d/"><span class="fab fa-linkedin-in"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Testimonial One Single End-->
                        <!--Testimonial One Single Start-->
                        <div class="item">
                            <div class="testimonial-one__single">
                                <div class="testimonial-one__img-inner">
                                    <div class="testimonial-one__img">
                                    <img src="{{ asset('images/testimonial/samad-khan.jpg') }}" alt="Testimonial by Samad Khan, Environmental Health & Safety (EHS) Supervisor" title="Samad Khan - EHS Supervisor">
                                        <div class="testimonial-one__icon">
                                            <span class="icon-graduation-cap"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial-one__content">
                                    <div class="testimonial-one__client-info">
                                        <h3 class="testimonial-one__client-name">{{ __('lang.testimonial_samad_name') }}</h3>
                                        <p class="testimonial-one__client-sub-title">{{ __('lang.testimonial_samad_title') }}</p>
                                    </div>
                                    <p class="testimonial-one__text">{{ __('lang.testimonial_samad_text') }}</p>
                                    <div class="testimonial-one__ratting-and-social">
                                        <ul class="testimonial-one__ratting list-unstyled">
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                        </ul>
                                        <div class="testimonial-one__social">
                                            <a href="https://www.linkedin.com/in/samad-khan-488a13232/"><span class="fab fa-linkedin-in"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Testimonial One Single End-->
                        <!--Testimonial One Single Start-->
                        <div class="item">
                            <div class="testimonial-one__single">
                                <div class="testimonial-one__img-inner">
                                    <div class="testimonial-one__img">
                                    <img src="{{ asset('images/testimonial/waleed-zafar.jpg') }}" alt="Testimonial by Waleed Zafar, Facade Quality Control Inspector" title="Waleed Zafar - Facade Quality Control Inspector">
                                        <div class="testimonial-one__icon">
                                            <span class="icon-graduation-cap"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial-one__content">
                                    <div class="testimonial-one__client-info">
                                        <h3 class="testimonial-one__client-name">{{ __('lang.testimonial_waleed_name') }}</h3>
                                        <p class="testimonial-one__client-sub-title">{{ __('lang.testimonial_waleed_title') }}</p>
                                    </div>
                                    <p class="testimonial-one__text">{{ __('lang.testimonial_waleed_text') }}</p>
                                    <div class="testimonial-one__ratting-and-social">
                                        <ul class="testimonial-one__ratting list-unstyled">
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                        </ul>
                                        <div class="testimonial-one__social">
                                            <a href="https://www.linkedin.com/in/samad-khan-488a13232/"><span class="fab fa-linkedin-in"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Testimonial One Single End-->
                        <!--Testimonial One Single Start-->
                        <div class="item">
                            <div class="testimonial-one__single">
                                <div class="testimonial-one__img-inner">
                                    <div class="testimonial-one__img">
                                    <img src="{{ asset('images/default.png') }}" alt="Default client image" title="Client image not available">
                                        <div class="testimonial-one__icon">
                                            <span class="icon-graduation-cap"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial-one__content">
                                    <div class="testimonial-one__client-info">
                                        <h3 class="testimonial-one__client-name">{{ __('lang.testimonial_hamza_name') }}</h3>
                                        <p class="testimonial-one__client-sub-title">{{ __('lang.testimonial_hamza_title') }}</p>
                                    </div>
                                    <p class="testimonial-one__text">{{ __('lang.testimonial_hamza_text') }}</p>
                                    <div class="testimonial-one__ratting-and-social">
                                        <ul class="testimonial-one__ratting list-unstyled">
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                            <li>
                                                <span class="icon-star"></span>
                                            </li>
                                        </ul>
                                        <div class="testimonial-one__social">
                                            <a href="https://www.linkedin.com/in/ameer-hamza-74648a366/"><span class="fab fa-linkedin-in"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Testimonial One Single End-->
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonial One End -->

         <!-- portfolio One Start -->
        <section class="blog-one">
            <div class="container">
                <div class="section-title text-center sec-title-animation animation-style1">
                    <div class="section-title__tagline-box">
                        <div class="section-title__tagline-shape"></div>
                        <span class="section-title__tagline" id="portfolio-sec">{{ __('lang.Portfolio') }}</span>
                    </div>
                    <h2 class="section-title__title {{ $locale == 'en' ? 'title-animation' : '' }}">{{ __('lang.From Concepts to Live Projects') }} <br>  {!! __('lang.See What I\'ve Built.') !!} </sapn> <img src="{{ asset('assets/images/shapes/section-title-shape-1.png') }}" alt="" role="presentation" aria-hidden="true"></h2>
                </div>
                <div class="blog-one__carousel owl-theme owl-carousel">
                    <!-- Blog One Single Start -->
                    <div class="item">
                        <div class="blog-one__single">
                            <div class="blog-one__img">
                            <img src="{{ asset('assets/images/project/1.jpg') }}" alt="PEC Engineering website project developed by TFC">
                            </div>
                            <div class="blog-one__content">
                                <ul class="blog-one__meta list-unstyled">
                                    <li>
                                        <a href="#"><span class="icon-calendar"></span>{{ __('lang.Apr 25, 2025') }}</a>
                                    </li>
                                    <li>
                                        <a href="#" class="mx-2"> <span class="icon-comment"></span> {{ __('lang.Completed!') }}</a>
                                    </li>
                                </ul>
                                <h3 class="blog-one__title"><a href="https://pec.com.sa">{{ __('lang.PEC Engineering Website') }}</a></h3>
                                <p class="blog-one__text">{{ __('lang.PEC Engineering Website desc') }}</p>
                                <div class="blog-one__btn-and-user-box">
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Blog One Single End -->
                    <!-- Blog One Single Start -->
                    <div class="item">
                        <div class="blog-one__single">
                            <div class="blog-one__img">
                            <img src="{{ asset('assets/images/project/2.jpg') }}" alt="Architecture portfolio website for mianmajid.arch designed by TFC">
                            </div>
                            <div class="blog-one__content">
                                <ul class="blog-one__meta list-unstyled">
                                    <li>
                                        <a href="#"><span class="icon-calendar"></span>{{ __('lang.Marvh 18, 2025') }}</a>
                                    </li>
                                    <li>
                                        <a href="#"><span class="icon-comment"></span>{{ __('lang.Ongoing!') }}</a>
                                    </li>
                                </ul>
                                <h3 class="blog-one__title"><a href="linkedin.com/in/fazlielahi">{{ __('lang.Architecture Portfolio – mianmajid.arch') }}</a></h3>
                                <p class="blog-one__text">{{ __('lang.Architecture Portfolio – mianmajid.arch desc') }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Blog One Single End -->
                    <!-- Blog One Single Start -->
                    <div class="item">
                        <div class="blog-one__single">
                            <div class="blog-one__img" >
                                <img src="{{ asset('assets/images/project/3.jpg') }}" alt="4Space Furniture website – Modern furniture and custom design project by TFC">
                            </div>
                            <div class="blog-one__content">
                                <ul class="blog-one__meta list-unstyled">
                                    <li>
                                        <a href="#"><span class="icon-calendar"></span>{{ __('lang.Jan 01, 2025') }}</a>
                                    </li>
                                    <li>
                                        <a href="#"><span class="icon-comment"></span>{{ __('lang.Completed!') }}</a>
                                    </li>
                                </ul>
                                <h3 class="blog-one__title"><a href="https://4space.com.sa/">
                                {{ __('lang.4Space Furniture Website – Modern Furniture & Custom Design') }}</a></h3>
                                <p class="blog-one__text">{{ __('lang.4Space Furniture Website – Modern Furniture & Custom Design desc') }}</p>
                                
                            </div>
                        </div>
                    </div>
                    <!-- Blog One Single End -->
                    <!-- Blog One Single Start -->
                    <div class="item">
                        <div class="blog-one__single">
                            <div class="blog-one__img">
                            <img src="{{ asset('assets/images/project/4.jpg') }}" alt="ERP system website project developed by TFC">
                            </div>
                            <div class="blog-one__content">
                                <ul class="blog-one__meta list-unstyled">
                                    <li>
                                        <a href="new.tamakantech.com"><span class="icon-calendar"></span>{{ __('lang.August 25, 2024') }}</a>
                                    </li>
                                    <li>
                                        <a href="blog-details.html"><span class="icon-comment"></span>{{ __('lang.Completed!') }}</a>
                                    </li>
                                </ul>
                                <h3 class="blog-one__title"><a href="blog-details.html">{{ __('lang.ERP System Website') }}</a></h3>
                                <p class="blog-one__text">{{ __('lang.ERP System Website desc') }}</p>
                                <div class="blog-one__btn-and-user-box">
                                    <div class="blog-one__btn-box">
                                        <a href="blog-details.html" class="thm-btn"><span
                                                class="icon-angles-right"></span>{{ __('lang.Read More') }}</a>
                                    </div>
                                    <div class="blog-one__user-box">
                                        <div class="blog-one__user-img">
                                            <img src="{{ asset('assets/images/blog/blog-one-user-img-1.jpg') }}" alt="">
                                        </div>
                                        <div class="blog-one__user-content">
                                            <h5 class="blog-one__user-name">{{ __('lang.Emily Dawson') }}</h5>
                                            <p class="blog-one__user-sub-title">{{ __('lang.Tech Specialist') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Blog One Single End -->

                </div>
            </div>
        </section>
        <!-- portfolio One End --> 

                <!--Blog section Start -->
                <section class="blog-two one-page-two-blog" id="blog-section-home">
            <div class="container">
                <div class="section-title-two text-center sec-title-animation animation-style1">
                   <div class="section-title__tagline-box">
                        <div class="section-title__tagline-shape"></div>
                        <span class="section-title__tagline">{{ __('lang.Blogs') }}</span>
                    </div>
                    <h2 class="section-title-two__title">{{ __('lang.Knowledge That Powers Growth -') }} <br> {{ __('lang.Our') }}
                        <span style="color: #fff">{{ __('lang.Blog Corner') }}</span>
                    </h2>
                </div>
                <div class="row">
                    <!--Blog Two Single Start -->
                    @if($blogs->count() > 0)
                @foreach($blogs->sortByDesc('id') as $blog)
                    <!--Blog Two Single Start -->
                    <div class="wow fadeInLeft blog-card-home" data-wow-delay="100ms">
                        <div class="blog-two__single">
                            <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id]) }}">
                                <div class="blog-two__img">
                                <img 
                                    src="{{ $blog->thumb && file_exists(public_path('storage/' . $blog->thumb)) ? asset('storage/' . $blog->thumb) : asset('images/blog-default.jpg') }}" 
                                    alt="{{ $blog->title ?? 'Blog post thumbnail' }}"
                                    >
                                </div>
                            </a>
                            <div class="blog-two__content">
                                <div class="blog-two__meta-box blog-profile">
                                    <div class="profile-container">
                                        <a href="{{ route('localized.user-profile', ['lang' => app()->getLocale(), $blog->creater->id]) }}" class="mb-0 text-muted">
                                        <img 
                                            src="{{ $blog->creater && $blog->creater->photo ? asset('images/' . $blog->creater->photo) : asset('images/default.png') }}" 
                                            alt="{{ $blog->creater ? $blog->creater->name . ' profile picture' : 'Default profile picture' }}" 
                                            width="100%" 
                                            class="profile-pic">
                                        </a>
                                        <div>
                                            <span class="username">
                                                <a href="{{ route('localized.user-profile', ['lang' => app()->getLocale(), $blog->creater->id]) }}">
                                                    {{ $blog->creater->name ?? __('lang.unknown') }}
                                                </a>
                                            </span>
                                            <span class="blog-time text-muted" style="font-size: 13px;">
                                                {{ $blog->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        
                                    </div>
                                </div>
                                <h4 class="blog-two__title">
                                    <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id]) }}">
                                        {{ Str::limit(html_entity_decode(strip_tags($blog->title)), 85) }}
                                    </a>
                                </h4>
                            </div>
                            <div class="blog-two__meta-box comment-sec d-none">
                                <ul class="blog-two__meta list-unstyled post-interactions">
                                    <li class="like-btn" data-url="{{ route('localized.blog.like', [app()->getLocale(), $blog->id]) }}">
                                        @if(App\Models\Likes::where('blog_id', $blog->id)->exists())
                                            <i class="heart-icon fa-solid fa-heart"></i>
                                        @else
                                            <i class="heart-icon fa-regular fa-heart"></i>
                                        @endif 
                                        <span class="like">{{ __('lang.Like') }} </span> <span class="like-count">{{ $blog->likes->count() }}</span>
                                    </li>
                                    <li>
                                        <a href="#" data-bs-toggle="modal" class="comment-a"  data-bs-target="#editModal{{ $blog->id }}" >
                                            <i class="far fa-comments mx-1"></i> <span class="comment">{{ __('lang.Comments') }}</span>
                                        </a>
                                    </li>
                                    <li data-bs-toggle="modal" class="share-btn" data-bs-target="#shareModalTest">
                                    <i class="far fa-share-square mx-1"></i><span class="share">{{ __('lang.Share') }} </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                   
                @endforeach
                @else
                <div class="col-12 text-center py-5">
                    <div class="no-blogs-message">
                        <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">{{ __('lang.No blogs uploaded yet') }} </h4>
                        <p class="text-muted">{{ __('lang.There are no blogs available in the selected category.') }}</p>
                    </div>
                </div>
                @endif
                <div class="text-center my-4">
                    <a href="{{ route('localized.blogs', ['lang' => app()->getLocale()]) }}" class="btn btn-outline-secondary mb-3">{{ __('lang.Read More') }}</a>
                </div>
                <div class="ads-section-mobile">                       
                </div>
                    <!--Blog Two Single End -->
                </div>
            </div>
        </section>
        <!--Blog Two End -->

        <!-- faqs -->

        <section id="faq" class="faq-section py-5">
    <div class="container">
        <h2 class="mb-4">{{ __('lang.faq_title') }}</h2>
        <div class="accordion" id="faqAccordion">

            <!-- Q1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                        {{ __('lang.faq_what_services') }}
                    </button>
                </h2>
                <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {{ __('lang.faq_what_services_ans') }}
                    </div>
                </div>
            </div>

            <!-- Q2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        {{ __('lang.faq_why_seo_important') }}
                    </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {{ __('lang.faq_why_seo_important_ans') }}
                    </div>
                </div>
            </div>

            <!-- Q3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        {{ __('lang.faq_responsive_websites') }}
                    </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {{ __('lang.faq_responsive_websites_ans') }}
                    </div>
                </div>
            </div>

            <!-- Q4 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                        {{ __('lang.faq_website_time') }}
                    </button>
                </h2>
                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {{ __('lang.faq_website_time_ans') }}
                    </div>
                </div>
            </div>

            <!-- Q5 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading5">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                        {{ __('lang.faq_manage_content') }}
                    </button>
                </h2>
                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {{ __('lang.faq_manage_content_ans') }}
                    </div>
                </div>
            </div>

            <!-- Q6 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading6">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                        {{ __('lang.faq_maintenance') }}
                    </button>
                </h2>
                <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {{ __('lang.faq_maintenance_ans') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>





        </main>
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
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection