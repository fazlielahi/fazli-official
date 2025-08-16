@extends('site.layout')
@section('title', 'Contact')


@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   
    <meta name="description" content="Contact TFC - The Fazli Community for expert support and personalized solutions in web development, branding, SEO, digital marketing, and more to help grow your business." />

    
    <meta name="keywords" content="contact, get in touch, customer support, inquiries, partnership, web development help, digital marketing assistance, branding consultation, website support, SEO questions, service requests" />

    <meta property="og:title" content="Contact TFC - The Fazli Community. We're Here to Support Your Growth" />
    <meta property="og:description" content="Reach out to TFC - The Fazli Community for expert support, collaboration, and inquiries. We’re here to help you succeed." />


    <meta property="og:image"         content="https://thefazli.com/images/tfc-contact-page-preview.png" />
    <meta property="og:url"           content="https://thefazli.com/{{$locale}}/contact" />
    <meta property="og:type"          content="website" />


    <meta name="twitter:card"         content="summary_large_image" />
    <meta name="twitter:site"         content="@fazlielahi" />
    <meta name="twitter:title" content="Contact TFC - The Fazli Community – We're Here to Support Your Growth" />
    <meta name="twitter:description" content="Get in touch with TFC - The Fazli Community team for inquiries, support, and partnership opportunities. We're here to help you grow." />
    <meta name="twitter:image"        content="https://thefazli.com/images/tfc-contact-page-preview.png" />

    <meta name="author" content="TFC - The Fazli Community" />
    <meta name="robots" content="index, follow, max-image-preview:large">
    
    <link rel="canonical" href="https://thefazli.com/{{$locale}}/contact" />
    
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
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ __('lang.We’d Love to Hear From You') }}</h1>
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
                                {{ __('lang.Contact')}}
                            </li>
                        </ul>
                    </div>
                    <div class="blog-image-container contact-image">
                        <img src="{{ asset('images/contact-image.png') }}" width="100%" alt="TFC - The Fazli Community logo in Contact Page"/>
                    </div>
                </div>
            </div>
    </section>
    <!--Page Header End-->

    <!--Contact Two Start-->
    <section class="contact-two">
        <div class="container">
            <ul class="row list-unstyled">
                <li class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="100ms">
                    <div class="contact-two__single">
                        <div class="contact-two__icon">
                            <img src="{{ asset('assets/images/icon/contact-two-icon-1.png') }}" alt="" role="presentation" aria-hidden="true">
                        </div>
                        <h3 class="contact-two__title">{{ __('lang.Address') }}</h3>
                        <p> Riyadh Riyadh,<br> Saudi Arabia</p>
                    </div>
                </li>
                <li class="col-xl-3 col-lg-6 col-md-6 wow fadeInLeft" data-wow-delay="200ms">
                    <div class="contact-two__single">
                        <div class="contact-two__icon">
                            <img src="{{ asset('assets/images/icon/contact-two-icon-2.png') }}" alt="" role="presentation" aria-hidden="true">
                        </div>
                        <h3 class="contact-two__title">{{ __('lang.Contact Number') }}</h3>
                        <p> <a href="wa.me:966592304816"><i class="fab fa-whatsapp"></i> +966592304816</a></p>
                        <p> <a href="tel:966592304816"><i class="fas fa-phone"></i> +966592304816</a></p>
                    </div>
                </li>
                <li class="col-xl-3 col-lg-6 col-md-6 wow fadeInRight" data-wow-delay="300ms">
                    <div class="contact-two__single">
                        <div class="contact-two__icon">
                            <img src="{{ asset('assets/images/icon/contact-two-icon-3.png') }}" alt="" role="presentation" aria-hidden="true">
                        </div>
                        <h3 class="contact-two__title">{{ __('lang.Email Address') }}</h3>
                        <p> <a href="info@domain.com">fazli@tamakan.com.sa</a></p>
                        <p> <a href="mailto:fazlielahi03060155124@gmail.com">fazlielahi03060155124@gmail.com</a></p>
                    </div>
                </li>
                <li class="col-xl-3 col-lg-6 col-md-6 wow fadeInRight" data-wow-delay="400ms">
                    <div class="contact-two__single">
                        <div class="contact-two__icon">
                            <img src="{{ asset('assets/images/icon/contact-two-icon-4.png') }}" alt="" role="presentation" aria-hidden="true">
                        </div>
                        <h3 class="contact-two__title">{{ __('lang.Working hours') }}</h3>
                        <p> 10:00 AM - 8:00 PM
                            <br> {{ __('lang.Monday - Saturday') }}</p>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!--Contact Two End-->

    <!--Contact Three Start-->
    <section class="contact-three">
        <div class="container">
            <div class="row contact-form">
                <div class="col-xl-6 col-lg-6">
                    <div class="contact-three__left">
                        <div class="contact-three__img">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d463878.29488595825!2d46.82252880000001!3d24.725191849999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2f03890d489399%3A0xba974d1c98e79fd5!2sRiyadh!5e0!3m2!1sen!2ssa!4v1753643396917!5m2!1sen!2ssa" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="contact-three__right">
                        <div class="section-title-two text-left sec-title-animation animation-style1">
                            <div class="section-title-two__tagline-box">
                                <span class="section-title-two__tagline">{{ __('lang.Get in Touch') }}</span>
                            </div>
                            <h2 class="section-title-two__title">{{ __('lang.I am Here to Help and Ready to Hear from You') }}</h2>
                        </div>
                        <form class="contact-form-validated contact-three__form" action="{{ asset('assets/inc/sendemail.php') }}"
                            method="post" novalidate="novalidate">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <h4 class="contact-three__input-title">{{ __('lang.Full Name') }}</h4>
                                    <div class="contact-three__input-box">
                                        <input type="text" name="name" placeholder="{{ __('lang.Jhon Doe Placeholder') }}" required="">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <h4 class="contact-three__input-title">{{ __('lang.Email Address') }} *</h4>
                                    <div class="contact-three__input-box">
                                        <input type="email" name="email" placeholder="{{ __('lang.Email Placeholder') }}" required="">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <h4 class="contact-three__input-title">{{ __('lang.Subject') }} *</h4>
                                    <div class="contact-three__input-box">
                                        <input type="text" name="Phone" placeholder="{{ __('lang.Write about your enquiry') }}" required="">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <h4 class="contact-three__input-title">{{ __('lang.Message') }} *</h4>
                                    <div class="contact-three__input-box text-message-box">
                                        <textarea name="message" placeholder="{{ __('lang.Write Your Message') }}"></textarea>
                                    </div>
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
    <!--Contact Three End-->
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