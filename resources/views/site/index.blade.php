    @extends('site.layout')

@section('title', __('lang.PORTFOLIO_TITLE'))

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

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicons/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicons/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicons/favicon-16x16.png') }}" />
    <link rel="manifest" href="{{ asset('assets/images/favicons/site.webmanifest') }}" />

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
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />

@endsection

@section('content')

    <div class="page-wrapper">
        <main>
            <!-- Banner One Start -->
            <section class="banner-one" style="padding-top: 50px !important">
        
                
                <div class="container">
                    <div class="row main-banner">
                        <div class="col-xl-6">
                            <div class="banner-one__left">
                                <div class="banner-one__title-box">
                                    <div class="banner-one__title-box-shape">
                                        <img src="{{ asset('assets/images/shapes/banner-one-title-box-shape-1.png') }}" alt="">
                                    </div>
                                    <h2 class="banner-one__title">
                                        <span class="banner-one__title-clr-1">{{ __('lang.Your Vision') }}</span>, <br>
                                        <span class="banner-one__title-clr-2">{!! __('lang.My Code') !!}</span> <br>
                                        {{ __('lang.Lets Build Something Great') }} 
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
                                        <img src="{{ asset('assets/images/banner-two-img-1.png') }}" alt="">
                                        <div class="banner-one__img-shape-box rotate-me">
                                            <div class="banner-one__img-shape-1">
                                                <div class="banner-one__img-shape-2"></div>
                                            </div>
                                            <div class="banner-one__shape-1">
                                                <img src="{{ asset('assets/images/shapes/banner-one-shape-1.png') }}" alt="">
                                            </div>
                                            <div class="banner-one__shape-2 rotate-me"></div>
                                            <div class="banner-one__shape-3">
                                                <img src="{{ asset('assets/images/shapes/banner-one-shape-3.png') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="banner-one__udemy-review">
                                            <div class="banner-one__udemy-review-img">
                                                <img src="{{ asset('images/linkedin-profile-photo.jpg') }}" alt="">
                                            </div>
                                            <div class="banner-one__udemy-review-logo">
                                                <img src="{{ asset('images/linked-91x38.png') }}" height="100%" alt="">
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
                                                <img src="{{ asset('assets/images/shapes/banner-one-student-trained-shape-1.png') }}" alt="">
                                            </div>
                                            <ul class="list-unstyled banner-one__student-trained-list">
                                                <li>
                                                    <div class="banner-one__student-trained-img">
                                                        <img src="{{ asset('images/client1.jpg') }}" alt="">
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="banner-one__student-trained-img">
                                                        <img src="{{ asset('images/client2.jpg') }}" alt="">
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
                                    <a href="#why-choose-me">{{ __('lang.Why Me?') }}</a>
                                    <a href="#portfolio-sec">{{ __('lang.Portfolio') }}</a>
                                    <a href="#">{{ __('lang.Blogs') }}</a>
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
                    <img src="{{ asset('assets/images/shapes/about-one-shape-1.png') }}" alt="">
                </div>
                <div class="about-one__shape-2">
                    <img src="{{ asset('assets/images/shapes/about-one-shape-2.png') }}" alt="">
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
                                                <img src="{{ asset('assets/images/resources/about1.jpeg') }}" alt="">
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
                                                    <img src="{{ asset('assets/images/icon/about-one-experience-icon.png') }}" alt="">
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
                                                <img src="{{ asset('assets/images/resources/about2.jpeg') }}" alt="">
                                            </div>
                                            <div class="about-one__img-shape-1 float-bob-y">
                                                <img src="{{ asset('assets/images/shapes/about-one-img-shape-1.png') }}" alt="">
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
                                        <span class="section-title__tagline">{{ __('lang.About Me') }}</span>
                                    </div>
                                    <h2 class="section-title__title {{ $locale == 'en' ? 'title-animation' : '' }}">
                                        {{ __('lang.IM') }}:<span style="color:#fff !important"> {{ __('lang.Fazli Elahi') }}</span>
                                        <span>{!! __('lang.Full stack web developer') !!} <img src="{{ asset('assets/images/shapes/section-title-shape-1.png') }}" alt=""></span>
                                    </h2>
                                </div>
                                <p class="about-one__text">{{ __('lang.I bring ideas to life through') }}</p>
                                <ul class="about-one__mission-and-vision list-unstyled">
                                    <li>
                                        <div class="about-one__icon-and-title">
                                            <div class="about-one__icon">
                                                <img src="{{ asset('assets/images/icon/mission-icon.png') }}" alt="">
                                            </div>
                                            <h3>{{ __('lang.My Mission') }}:</h3>
                                        </div>
                                        <p class="about-one__mission-and-vision-text">{{ __('lang.My mission is to create meaningful, user-friendly web experiences that help individuals and businesses grow online.') }}</p>
                                    </li>
                                    <li>
                                        <div class="about-one__icon-and-title">
                                            <div class="about-one__icon">
                                                <img src="{{ asset('assets/images/icon/vision-icon.png') }}" alt="">
                                            </div>
                                            <h3>{{ __('lang.My Vision') }}</h3>
                                        </div>
                                        <p class="about-one__mission-and-vision-text">{{ __('lang.My vision is to become a trusted web developer known for building smart, scalable, and impactful digital solutions.') }}</p>
                                    </li>
                                </ul>
                                <div class="about-one__btn-and-live-class">
                                    <div class="about-one__btn-box">
                                        <a href="{{ route('localized.about', ['lang' => app()->getLocale()]) }}" class="about-one__btn thm-btn">
                                            <span class="icon-angles-right"></span>{{ __('lang.Know More') }}
                                        </a>
                                    </div>
                                    <h3 class="about-one__live-class">{{ __('lang.Available') }}
                                        <img src="{{ asset('assets/images/shapes/live-class-shape-1.png') }}" alt="">
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- About One End -->

            <!-- Services One Start -->
            <section class="courses-one" >
                <div class="container">
                    <div class="section-title text-center sec-title-animation animation-style1" id="services-section">
                        <div class="section-title__tagline-box">
                            <div class="section-title__tagline-shape"></div>
                            <span class="section-title__tagline" >{{ __('lang.Services') }}</span>
                        </div>
                        <h2 class="section-title__title {{ $locale == 'en' ? 'title-animation' : '' }}">{{ __('lang.More Than Web:') }} <br>{{ __('lang.One Place,') }}
                            <span class="solution">{{ __('lang.Many Solutions.') }} <img src="{{ asset('assets/images/shapes/section-title-shape-1.png') }}" alt=""></span></h2>
                    </div>
                    <div class="courses-one__carousel owl-theme owl-carousel">
                        <!--Courses One Single Start-->
                        <div class="item">
                            <div class="courses-one__single">
                                <div class="courses-one__img-box">
                                    <div class="courses-one__img">
                                        <img src="{{ asset('assets/images/resources/web-development.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="courses-one__content">
                                 
                                    <h3 class="courses-one__title">
                                        <a href="course-details.html">{{ __('lang.Web Design & Development') }}</a>
                                    </h3>
                                    <div class="courses-one__ratting-and-heart-box">
                                        <div class="courses-one__ratting-box">
                                            <ul class="courses-one__ratting list-unstyled">
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                            </ul>
                                            <p class="courses-one__ratting-text">{{ __('lang.32 Reviews') }}</p>
                                        </div>
                                        <div class="courses-one__heart">
                                            <a href="#"><span class="icon-heart"></span></a>
                                        </div>
                                    </div>
                                    <div class="courses-one__btn-and-doller-box">
                                        <div class="courses-one__btn-box">
                                            <a href="course-details.html" class="courses-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Courses One Single End-->

                        <!--Courses One Single Start-->
                        <div class="item">
                            <div class="courses-one__single">
                                <div class="courses-one__img-box">
                                    <div class="courses-one__img">
                                        <img src="{{ asset('assets/images/resources/coorporate-identity.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="courses-one__content">
                                 
                                    <h3 class="courses-one__title">
                                        <a href="course-details.html">{{ __('lang.Corporate Identity') }}</a>
                                    </h3>
                                    <div class="courses-one__ratting-and-heart-box">
                                        <div class="courses-one__ratting-box">
                                            <ul class="courses-one__ratting list-unstyled">
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                            </ul>
                                            <p class="courses-one__ratting-text">{{ __('lang.25 Reviews') }}</p>
                                        </div>
                                        <div class="courses-one__heart">
                                            <a href="#"><span class="icon-heart"></span></a>
                                        </div>
                                    </div>
                                    <div class="courses-one__btn-and-doller-box">
                                        <div class="courses-one__btn-box">
                                            <a href="course-details.html" class="courses-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Courses One Single End-->

                        <!--Courses One Single Start-->
                        <div class="item">
                            <div class="courses-one__single">
                                <div class="courses-one__img-box">
                                    <div class="courses-one__img">
                                        <img src="{{ asset('assets/images/resources/digital-marketing.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="courses-one__content">
                                 
                                    <h3 class="courses-one__title">
                                        <a href="course-details.html">{{ __('lang.Digital Marketing') }}</a>
                                    </h3>
                                    <div class="courses-one__ratting-and-heart-box">
                                        <div class="courses-one__ratting-box">
                                            <ul class="courses-one__ratting list-unstyled">
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                            </ul>
                                            <p class="courses-one__ratting-text">{{ __('lang.30 Reviews') }}</p>
                                        </div>
                                        <div class="courses-one__heart">
                                            <a href="#"><span class="icon-heart"></span></a>
                                        </div>
                                    </div>
                                    <div class="courses-one__btn-and-doller-box">
                                        <div class="courses-one__btn-box">
                                            <a href="course-details.html" class="courses-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Courses One Single End-->

                        <!--Courses One Single Start-->
                        <div class="item">
                            <div class="courses-one__single">
                                <div class="courses-one__img-box">
                                    <div class="courses-one__img">
                                        <img src="{{ asset('assets/images/resources/ecommerce.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="courses-one__content">
                                 
                                    <h3 class="courses-one__title">
                                        <a href="course-details.html">{{ __('lang.Ecommerce Development') }}</a>
                                    </h3>
                                    <div class="courses-one__ratting-and-heart-box">
                                        <div class="courses-one__ratting-box">
                                            <ul class="courses-one__ratting list-unstyled">
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                            </ul>
                                            <p class="courses-one__ratting-text">{{ __('lang.27 Reviews') }}</p>
                                        </div>
                                        <div class="courses-one__heart">
                                            <a href="#"><span class="icon-heart"></span></a>
                                        </div>
                                    </div>
                                    <div class="courses-one__btn-and-doller-box">
                                        <div class="courses-one__btn-box">
                                            <a href="course-details.html" class="courses-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Courses One Single End-->

                        <!--Courses One Single Start-->
                        <div class="item">
                            <div class="courses-one__single">
                                <div class="courses-one__img-box">
                                    <div class="courses-one__img">
                                        <img src="{{ asset('assets/images/resources/social-media-marketing.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="courses-one__content">
                                 
                                    <h3 class="courses-one__title">
                                        <a href="course-details.html">{{ __('lang.Social Media Marketing') }}</a>
                                    </h3>
                                    <div class="courses-one__ratting-and-heart-box">
                                        <div class="courses-one__ratting-box">
                                            <ul class="courses-one__ratting list-unstyled">
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                            </ul>
                                            <p class="courses-one__ratting-text">{{ __('lang.24 Reviews') }}</p>
                                        </div>
                                        <div class="courses-one__heart">
                                            <a href="#"><span class="icon-heart"></span></a>
                                        </div>
                                    </div>
                                    <div class="courses-one__btn-and-doller-box">
                                        <div class="courses-one__btn-box">
                                            <a href="course-details.html" class="courses-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Courses One Single End-->

                        <!--Courses One Single Start-->
                        <div class="item">
                            <div class="courses-one__single">
                                <div class="courses-one__img-box">
                                    <div class="courses-one__img">
                                        <img src="{{ asset('assets/images/resources/wordpress.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="courses-one__content">
                                 
                                    <h3 class="courses-one__title">
                                        <a href="course-details.html">{{ __('lang.WordPress Development') }}</a>
                                    </h3>
                                    <div class="courses-one__ratting-and-heart-box">
                                        <div class="courses-one__ratting-box">
                                            <ul class="courses-one__ratting list-unstyled">
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                            </ul>
                                            <p class="courses-one__ratting-text">{{ __('lang.22 Reviews') }}</p>
                                        </div>
                                        <div class="courses-one__heart">
                                            <a href="#"><span class="icon-heart"></span></a>
                                        </div>
                                    </div>
                                    <div class="courses-one__btn-and-doller-box">
                                        <div class="courses-one__btn-box">
                                            <a href="course-details.html" class="courses-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Courses One Single End-->

                        <!--Courses One Single Start-->
                        <div class="item">
                            <div class="courses-one__single">
                                <div class="courses-one__img-box">
                                    <div class="courses-one__img">
                                        <img src="{{ asset('assets/images/resources/seo-training.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="courses-one__content">
                                 
                                    <h3 class="courses-one__title">
                                        <a href="course-details.html">{{ __('lang.SEO Training') }}</a>
                                    </h3>
                                    <div class="courses-one__ratting-and-heart-box">
                                        <div class="courses-one__ratting-box">
                                            <ul class="courses-one__ratting list-unstyled">
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                                <li><span class="icon-star"></span></li>
                                            </ul>
                                            <p class="courses-one__ratting-text">{{ __('lang.20 Reviews') }}</p>
                                        </div>
                                        <div class="courses-one__heart">
                                            <a href="#"><span class="icon-heart"></span></a>
                                        </div>
                                    </div>
                                    <div class="courses-one__btn-and-doller-box">
                                        <div class="courses-one__btn-box">
                                            <a href="course-details.html" class="courses-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Courses One Single End-->
                    </div>
                </div>
            </section>
            <!-- Services One End -->

            <!-- Why Choose One Start -->
            <section class="why-choose-one" id="why-choose-me">
                <div class="why-choose-one__shape-6 float-bob-x">
                    <img src="{{ asset('assets/images/shapes/why-choose-one-shape-6.png') }}" alt="">
                </div>
                <div class="why-choose-one__shape-7 float-bob-y">
                    <img src="{{ asset('assets/images/shapes/why-choose-one-shape-7.png') }}" alt="">
                </div>
                <div class="container">
                    <div class="row why-choose-us">
                        <div class="col-xl-6">
                            <div class="why-choose-one__left wow slideInLeft" data-wow-delay="100ms" data-wow-duration="2500ms">
                                <div class="why-choose-one__img-box">
                                    <div class="why-choose-one__img">
                                        <img src="{{ asset('assets/images/resources/why-choose-one-img-1.jpg') }}" alt="">
                                    </div>
                                    <div class="why-choose-one__img-2">
                                        <img src="{{ asset('assets/images/resources/why-choose-one-img-2.jpg') }}" alt="">
                                    </div>
                                    <div class="why-choose-one__shape-1 float-bob-y">
                                        <img src="{{ asset('assets/images/shapes/why-choose-one-shape-1.png') }}" alt="">
                                    </div>
                                    <div class="why-choose-one__shape-2 float-bob-x">
                                        <img src="{{ asset('assets/images/shapes/why-choose-one-shape-2.png') }}" alt="">
                                    </div>
                                    <div class="why-choose-one__shape-3 float-bob-y">
                                        <img src="{{ asset('assets/images/shapes/why-choose-one-shape-3.png') }}" alt="">
                                    </div>
                                    <div class="why-choose-one__shape-4">
                                        <img src="{{ asset('assets/images/shapes/why-choose-one-shape-4.png') }}" alt="">
                                    </div>
                                    <div class="why-choose-one__shape-5 img-bounce">
                                        <img src="{{ asset('assets/images/shapes/why-choose-one-shape-5.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="why-choose-one__right">
                                <div class="section-title text-left sec-title-animation animation-style2">
                                    <div class="section-title__tagline-box">
                                        <div class="section-title__tagline-shape"></div>
                                        <span class="section-title__tagline">{{ __('lang.Why Choose Me') }}</span>
                                    </div>
                                    <h2 class="section-title__title {{ $locale == 'en' ? 'title-animation' : '' }}">{{ __('lang.Why Clients Choose Me:') }}
                                        <span>{!! __('lang.And Stay With Me.') !!} <img src="{{ asset('assets/images/shapes/section-title-shape-1.png') }}" alt=""></span>
                                    </h2>
                                </div>
                                <p class="why-choose-one__text">{{ __('lang.Because I care about your success. With the right mix of skills, dedication, and creativity, I turn your ideas into results — efficiently and professionally.') }}</p>
                                <div class="why-choose-one__points-box">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <ul class="why-choose-one__points-list list-unstyled">
                                                <li>
                                                    <div class="why-choose-one__points-icon-inner">
                                                        <div class="why-choose-one__points-icon">
                                                            <img src="{{ asset('assets/images/icon/why-choose-one-icon-1.png') }}" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="why-choose-one__points-content">
                                                        <h3>{{ __('lang.On-Time Delivery') }}</h3>
                                                        <p>{{ __('lang.I respect deadlines and always aim to deliver before them.') }}</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="why-choose-one__points-icon-inner">
                                                        <div class="why-choose-one__points-icon">
                                                            <img src="{{ asset('assets/images/icon/why-choose-one-icon-2.png') }}" alt="">
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
                                                            <img src="{{ asset('assets/images/icon/why-choose-one-icon-3.png') }}" alt="">
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
                                                            <img src="{{ asset('assets/images/icon/why-choose-one-icon-4.png') }}" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="why-choose-one__points-content">
                                                        <h3>{{ __('lang.Clean & Scalable Code') }}</h3>
                                                        <p>{{ __('lang.I build smart, efficient, and future-ready solutions — no shortcuts.') }}</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="why-choose-one__btn-and-client-box">
                                    <div class="why-choose-one__btn-box">
                                        <a href="/about" class="why-choose-one__btn thm-btn">
                                            <span class="icon-angles-right"></span>{{ __('lang.Know More') }}
                                        </a>
                                    </div>
                                    <div class="why-choose-one__client-box">
                                        <ul class="why-choose-one__client-img-list list-unstyled">
                                            <li><img src="{{ asset('assets/images/resources/why-choose-one-client-img-1.jpg') }}" alt=""></li>
                                            <li><img src="{{ asset('assets/images/resources/why-choose-one-client-img-2.jpg') }}" alt=""></li>
                                            <li><img src="{{ asset('assets/images/resources/why-choose-one-client-img-3.jpg') }}" alt=""></li>
                                        </ul>
                                        <div class="why-choose-one__client-content">
                                            <div class="why-choose-one__count-box">
                                                <h3 class="odometer" data-count="10">00</h3>
                                                <span>+</span>
                                            </div>
                                            <p>{{ __('lang.Ive Professional Engineers') }}</p>
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
                <img src="{{ asset('assets/images/shapes/testimonial-one-shape-1.png') }}" alt="">
            </div>
            <div class="testimonial-one__shape-2">
                <img src="{{ asset('assets/images/shapes/testimonial-one-shape-2.png') }}" alt="">
            </div>
            <div class="container">
                <div class="section-title text-left sec-title-animation animation-style2">
                    <div class="section-title__tagline-box">
                        <div class="section-title__tagline-shape"></div>
                        <span class="section-title__tagline">{{ __('lang.Testimonial') }}</span>
                    </div>
                    <h2 class="section-title__title title-animation">{{ __('lang.Explore Genuine Feedback') }} <br>
                        {!! __('lang.from Happy Clients') !!} <img src="{{ asset('assets/images/shapes/section-title-shape-1.png') }}" alt="">
                    </h2>
                </div>
                <div class="testimonial-one__inner">
                    <div class="testimonial-one__carousel owl-theme owl-carousel">
                        <!--Testimonial One Single Start-->
                        <div class="item">
                            <div class="testimonial-one__single">
                                <div class="testimonial-one__img-inner">
                                    <div class="testimonial-one__img">
                                        <img src="{{ asset('images/testimonial/testimonial-1-1.jpg') }}" alt="">
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
                                        <img src="{{ asset('images/testimonial/testimonial-1-2.jpg') }}" alt="">
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
                                        <img src="{{ asset('images/testimonial/testimonial-1-3.jpg') }}" alt="">
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
                    <h2 class="section-title__title {{ $locale == 'en' ? 'title-animation' : '' }}">{{ __('lang.From Concepts to Live Projects') }} <br> {{ __('lang.See What I\'ve Built.') }} <img src="{{ asset('assets/images/shapes/section-title-shape-1.png') }}" alt=""></h2>
                </div>
                <div class="blog-one__carousel owl-theme owl-carousel">
                    <!-- Blog One Single Start -->
                    <div class="item">
                        <div class="blog-one__single">
                            <div class="blog-one__img">
                                <img src="{{ asset('assets/images/project/1.jpg') }}" alt="">
                            </div>
                            <div class="blog-one__content">
                                <ul class="blog-one__meta list-unstyled">
                                    <li>
                                        <a href="#"><span class="icon-calendar"></span>Apr 25, 2025</a>
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
                                <img src="{{ asset('assets/images/project/2.jpg') }}" alt="">
                            </div>
                            <div class="blog-one__content">
                                <ul class="blog-one__meta list-unstyled">
                                    <li>
                                        <a href="#"><span class="icon-calendar"></span>Marvh 18, 2025</a>
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
                            <div class="blog-one__img">
                                <img src="{{ asset('assets/images/project/3.jpg') }}" alt="">
                            </div>
                            <div class="blog-one__content">
                                <ul class="blog-one__meta list-unstyled">
                                    <li>
                                        <a href="#"><span class="icon-calendar"></span>Jan 01, 2025</a>
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
                                <img src="{{ asset('assets/images/project/4.jpg') }}" alt="">
                            </div>
                            <div class="blog-one__content">
                                <ul class="blog-one__meta list-unstyled">
                                    <li>
                                        <a href="new.tamakantech.com"><span class="icon-calendar"></span>August 25, 2024</a>
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
                <section class="blog-two one-page-two-blog" id="blog">
            <div class="container">
                <div class="section-title-two text-center sec-title-animation animation-style1">
                   <div class="section-title__tagline-box">
                        <div class="section-title__tagline-shape"></div>
                        <span class="section-title__tagline">{{ __('lang.Blogs') }}</span>
                    </div>
                    <h2 class="section-title-two__title title-animation">Knowledge That Powers Growth - <br> My
                        <span style="color: #fff">Blog Corner</span>
                    </h2>
                </div>
                <div class="row">
                    <!--Blog Two Single Start -->
                    <div class="col-xl-4 col-lg-4 wow fadeInLeft" data-wow-delay="100ms">
                        <div class="blog-two__single">
                            <div class="blog-two__img">
                                <img src="{{ asset('assets/images/blog/blog-2-1.jpg') }}" alt="">
                                <div class="blog-two__date">
                                    <span class="icon-calendar"></span>
                                    <p>Nov 02, 2025</p>
                                </div>
                            </div>
                            <div class="blog-two__content">
                                <div class="blog-two__meta-box blog-profile">
                                <div class="profile-container">
                                        <img class="profile-pic" src="{{ asset('images/client1.jpg') }}" alt="Profile Picture">
                                        <span class="username">Fazli Elahi</span>
                                    </div>
                                </div>
                                <h4 class="blog-two__title"><a href="blog-details.html">How to Succeed in Online
                                        Learning: Tips for Students</a></h4>
                                <p class="blog-two__text">The discusses the advantages of using LMS for upskilling
                                    employees, managing compliance training,</p>
                            </div>
                                <div class="blog-two__meta-box comment-sec">
                                    <ul class="blog-two__meta list-unstyled">
                                        <li>
                                            <a href="blog-details.html"><span class="icon-tags"></span>Like</a>
                                        </li>
                                        <li>
                                            <a href="blog-details.html">
                                                <span
                                                    class="icon-comments">
                                                </span>Comments
                                            </a>
                                        </li>
                                        <li>
                                            <a href="blog-details.html"><span class="icon-clock"></span>Read!</a>
                                        </li>
                                    </ul>
                                </div>
                        </div>
                    </div>
                    <!--Blog Two Single End -->
                </div>
            </div>
        </section>
        <!--Blog Two End -->

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
                $('.courses-one__heart a').on('click', function(e) {
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