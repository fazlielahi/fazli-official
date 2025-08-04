@extends('site.layout')
@section('title', 'Web Development & Digital Services | TFC - The Fazli Community')

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Explore expert services in web development, branding, SEO, digital marketing, WordPress, content writing, and more to grow your business." />
    
    <meta name="keywords" content="web development, web design, digital marketing, SEO, WordPress development, ecommerce, branding, UI UX design, content writing, landing page, PHP development, email marketing, Google Ads, mobile responsive design, domain hosting, website security, website maintenance" />


    <meta property="og:title" content="TFC - The Fazli Community – Tech Resources, Web Services & Learning Hub" />
    <meta property="og:description"   content="Empowering learners, professionals & businesses with web design, digital marketing, SEO training, and free career tools." />

    <meta property="og:image"         content="https://thefazli.com/images/tfc-services-page-preview.png" />
    <meta property="og:url"           content="https://thefazli.com/{{$locale}}/services" />
    <meta property="og:type"          content="website" />


    <meta name="twitter:card"         content="summary_large_image" />
    <meta name="twitter:site"         content="@fazlielahi" />
    <meta name="twitter:title" content="Web Development & Digital Services – The Fazli Community" />
    <meta name="twitter:description" content="Explore our professional web design, branding, e-commerce, and digital marketing services to grow your online presence." />
    <meta name="twitter:image"        content="https://thefazli.com/images/tfc-services-page-preview.png" />

    <meta name="author" content="TFC - The Fazli Community" />
    <meta name="robots" content="index, follow" />
    
    <link rel="canonical" href="https://thefazli.com/{{$locale}}/services" />
    
@endsection

<style>
    .about-btn{
        display: none;
    }

    
    .footer{
            position: unset !important;
        }
</style>

@section('head')
    <meta name="description" content="fistudy HTML 5 Template " />

    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/contact.css') }}">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom-animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-all.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jarallax.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/odometer.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/css/module-css/slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/footer.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/sliding-text.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/category.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/about.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/courses.css') }}" />
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
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/services.css') }}" />

    <!-- template styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />

    <style>
        .blog-image-container{
            width: 30% !important;
        }

        .page-header .container{
            justify-content: space-around;
            align-items: center;
        }
    </style>
@endsection

@section('content')

    <!--Page Header Start-->
    <section class="page-header">
    <div class="breadcrumb-wrapper bg-cover">
                <div class="container">
                    <div class="page-heading">
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ __('lang.One Place,') }}
                        <span class="solution">{{ __('lang.Many Solutions.') }}    </h1>
                        <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                            <li>
                                <a href="{{ route('localized.home', ['lang' => app()->getLocale()])}}">
                                    {{ __('lang.Home')}}
                                </a>
                            </li>
                            <li>
                                @if(app()->getLocale() === 'ar')
                                    <i class="fas fa-chevron-left"></i>
                                @else
                                    <i class="fas fa-chevron-right"></i>
                                @endif
                            </li>
                            <li>
                                {{ __('lang.Services')}}
                            </li>
                        </ul>
                    </div>
                    <div class="blog-image-container services-main-image">
                        <img src="{{ asset('images/contact-image.png') }}" width="100%" alt="TFC - The Fazli Community logo in Contact Page"/>
                    </div>
                </div>
            </div>
    </section>
    <!--Page Header End-->

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
                    <div class="owl-theme services-container">
                        <!--blogs One Single Start-->
                        <div class="items services-card">
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
                                            <a href="#" class="blogs-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--blogs One Single End-->

                        <!--blogs One Single Start-->
                        <div class="item services-card">
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
                                            <a href="#" class="blogs-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--blogs One Single End-->

                        <!--blogs One Single Start-->
                        <div class="item services-card">
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
                                            <a href="#" class="blogs-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--blogs One Single End-->

                        <!--blogs One Single Start-->
                        <div class="item services-card">
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
                                            <a href="#" class="blogs-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--blogs One Single End-->

                        <!--blogs One Single Start-->
                        <div class="item services-card">
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
                                            <a href="#" class="blogs-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--blogs One Single End-->

                        <!--blogs One Single Start-->
                        <div class="item services-card">
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
                                            <a href="#" class="blogs-one__btn thm-btn">
                                                <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--blogs One Single End-->

                        <!--blogs One Single Start-->
                        <div class="item services-card">
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
                                            <a href="#" class="blogs-one__btn thm-btn">
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

@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
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
    <script src="{{ asset('assets/js/gsap/gsap.js') }}"></script>
    <script src="{{ asset('assets/js/gsap/ScrollTrigger.js') }}"></script>
    <script src="{{ asset('assets/js/gsap/SplitText.js') }}"></script>
    <!-- template js -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection