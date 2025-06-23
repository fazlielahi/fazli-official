@extends('site.layout')

@section('title', __('lang.Blogs'))

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
<!-- Font Awesome CDN for version 6 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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
    <!--Page Header Start-->
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url('{{ asset('assets/images/shapes/page-header-bg-shape.png') }}');"></div>
        <div class="page-header__shape-4">
            <img src="{{ asset('assets/images/shapes/page-header-shape-4.png') }}" alt="">
        </div>
        <div class="page-header__shape-5">
            <img src="{{ asset('assets/images/shapes/page-header-shape-5.png') }}" alt="">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <div class="page-header__img">
                    <img src="{{ asset('assets/images/resources/page-header-img-1.png') }}" alt="">
                    <div class="page-header__shape-1">
                        <img src="{{ asset('assets/images/shapes/page-header-shape-1.png') }}" alt="">
                    </div>
                    <div class="page-header__shape-2">
                        <img src="{{ asset('assets/images/shapes/page-header-shape-2.png') }}" alt="">
                    </div>
                    <div class="page-header__shape-3">
                        <img src="{{ asset('assets/images/shapes/page-header-shape-3.png') }}" alt="">
                    </div>
                </div>
                <h2>{{ __('lang.Blogs Corner') }}</h2>
                <div class="thm-breadcrumb__box">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="{{ url('/') }}">{{ __('lang.Home') }}</a></li>
                        <li><span>//</span></li>
                        <li>{{ __('lang.Blofs') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--Page Header End-->

    <!--Blogs Grid Start-->
    <section class="blog-grid">
        <div class="blog-row">
            <div class="left-sidebar">
                <div class="blog-grid__left">
                    <div class="blog-grid__sidebar">
                        <div class="blog-grid__categories blog-grid__single">
                            <div class="blog-grid__title-box">
                                <h3 class="blog-grid__title">{{ __('lang.Categories') }}</h3>
                                <div class="blog-grid__title-shape-1">
                                    <img src="{{ asset('assets/images/shapes/blog-grid-title-shape-1.png') }}" alt="">
                                </div>
                            </div>
                            <ul class="list-unstyled blog-grid__list-item">
                                <li>
                                    <div class="blog-grid__list-check"></div>
                                    <p class="blog-grid__list-text">{{ __('lang.Accounting & Finance (12)') }}</p>
                                </li>
                                <li>
                                    <div class="blog-grid__list-check"></div>
                                    <p class="blog-grid__list-text">{{ __('lang.Programming & Tech (25)') }}</p>
                                </li>
                                <li>
                                    <div class="blog-grid__list-check"></div>
                                    <p class="blog-grid__list-text">{{ __('lang.Art & Design (59)') }}</p>
                                </li>
                                <li>
                                    <div class="blog-grid__list-check"></div>
                                    <p class="blog-grid__list-text">{{ __('lang.Health & Fitness (24)') }}</p>
                                </li>
                                <li>
                                    <div class="blog-grid__list-check"></div>
                                    <p class="blog-grid__list-text">{{ __('lang.Sales & Marketing (40)') }}</p>
                                </li>
                                <li>
                                    <div class="blog-grid__list-check"></div>
                                    <p class="blog-grid__list-text">{{ __('lang.User Research (40)') }}</p>
                                </li>
                                <li>
                                    <div class="blog-grid__list-check"></div>
                                    <p class="blog-grid__list-text">{{ __('lang.Business Development (30)') }}</p>
                                </li>
                            </ul>
                        </div>
                        <div class="blog-grid__discount blog-grid__single">
                            <div class="blog-grid__discount-shape-bg" style="background-image: url('{{ asset('assets/images/shapes/blog-grid-discount-shape-bg.png') }}');"></div>
                            <h4 class="blog-grid__discount-title">{{ __('lang.20% Discount') }}</h4>
                            <p class="blog-grid__discount-text">{{ __('lang.is simply dummy text of the printing') }} <br> {{ __('lang.and typesetting industry') }}</p>
                            <div class="blog-grid__discount-img">
                                <img src="{{ asset('assets/images/resources/blog-grid-discount-img-1.png') }}" alt="">
                            </div>
                            <div class="blog-grid__discount-coupon">
                                <p>{{ __('lang.Use Coupon') }}</p>
                                <h5>#FuStudy56</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="blogs-section">
                <!--Blog Two Single Start -->
                <div class="wow fadeInLeft blog-card" data-wow-delay="100ms">
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
                            <h4 class="blog-two__title"><a href="blog-details.html">How to Succeed in Online Learning: Tips for Students</a></h4>
                            <p class="blog-two__text">The discusses the advantages of using LMS for upskilling employees, managing compliance training,</p>
                        </div>
                        <div class="blog-two__meta-box comment-sec">
                            <ul class="blog-two__meta list-unstyled">
                                <li>
                                    <a href="#" class="like-toggle"><i class="fa-regular fa-heart" aria-hidden="true" style="color: #1da370; margin: 0 2px; font-size: small"></i> Like</a>
                                </li>
                                <li>
                                    <a href="blog-details.html">
                                        <span class="icon-comments"></span>Comments
                                    </a>
                                </li>
                                <li>
                                    <a href="blog-details.html"><span class="icon-clock"></span>Read!</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Blog Grid End-->
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.like-toggle').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    var icon = link.querySelector('i');
                    if (icon.classList.contains('fa-regular')) {
                        icon.classList.remove('fa-regular');
                        icon.classList.add('fa-solid');
                    } else {
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                    }
                });
            });
        });
    </script>
@endsection
