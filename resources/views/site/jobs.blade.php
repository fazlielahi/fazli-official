@extends('site.layout')

@section('title', __('lang.Jobs'))

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
    
    <!-- Theme styles -->
    <link rel="stylesheet" href="{{ asset('styles/theme.css') }}" />

    
    <!-- responsive design -->
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-blog.css') }}" />

    <style>
       
    </style>

@endsection

@section('content')

    <!--Page Header Start-->
    <section class="page-header">
    <div class="breadcrumb-wrapper bg-cover">
                <div class="container">
                    <div class="page-heading">
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ __('lang.Comming Soon!') }}</h1>
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
                                {{ __('lang.Jobs')}}
                            </li>
                        </ul>
                    </div>
                    <div class="blog-image-container">
                        <img src="" width="100%"/>
                    </div>
                </div>
            </div>
    </section>
    <!--Page Header End-->

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

            // Emoji Picker Functionality for Jobs
            $('.emoji-toggle-btn').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var $panel = $(this).siblings('.emoji-panel');
                $('.emoji-panel').not($panel).hide();
                $panel.toggle();
            });

            // Close emoji panel when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.emoji-picker-container').length) {
                    $('.emoji-panel').hide();
                }
            });

            // Insert emoji into textarea
            $('.emoji-btn').on('click', function(e) {
                e.preventDefault();
                var emoji = $(this).data('emoji');
                var $textarea = $(this).closest('.mb-3').find('textarea');
                var cursorPos = $textarea[0].selectionStart;
                var textBefore = $textarea.val().substring(0, cursorPos);
                var textAfter = $textarea.val().substring(cursorPos);
                
                $textarea.val(textBefore + emoji + textAfter);
                
                // Set cursor position after the inserted emoji
                var newCursorPos = cursorPos + emoji.length;
                $textarea[0].setSelectionRange(newCursorPos, newCursorPos);
                $textarea.focus();
                
                // Hide the emoji panel
                $('.emoji-panel').hide();
            });

            // Emoji button hover effects
            $('.emoji-btn').on('mouseenter', function() {
                $(this).css({
                    'transform': 'scale(1.2)',
                    'transition': 'transform 0.2s ease'
                });
            }).on('mouseleave', function() {
                $(this).css({
                    'transform': 'scale(1)',
                    'transition': 'transform 0.2s ease'
                });
            });

            // Offcanvas for Categories
            const toggleBtn = document.querySelector('.categories-toggle-btn');
            const offcanvasSidebar = document.querySelector('.offcanvas-sidebar');
            const offcanvasOverlay = document.querySelector('.offcanvas-overlay');
            const offcanvasClose = document.querySelector('.offcanvas-close');

            function openOffcanvas() {
                offcanvasSidebar.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
            function closeOffcanvas() {
                offcanvasSidebar.classList.remove('active');
                document.body.style.overflow = '';
            }

            if (toggleBtn && offcanvasSidebar) {
                toggleBtn.addEventListener('click', openOffcanvas);
            }
            if (offcanvasOverlay) {
                offcanvasOverlay.addEventListener('click', closeOffcanvas);
            }
            if (offcanvasClose) {
                offcanvasClose.addEventListener('click', closeOffcanvas);
            }
        });
    </script>

    <style>
        .emoji-toggle-btn:hover {
            background-color: rgba(255,255,255,0.1) !important;
            transform: scale(1.1);
        }
        
        .emoji-btn {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: all 0.2s ease;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .emoji-btn:hover {
            background-color: #f0f0f0;
            transform: scale(1.2);
        }
        
        .emoji-panel {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95) !important;
        }
        
        .comment-btn-inside:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(29, 163, 112, 0.4) !important;
        }
        
        @media (max-width: 768px) {
            .emoji-panel {
                min-width: 200px !important;
            }
            .emoji-grid {
                grid-template-columns: repeat(5, 1fr) !important;
                gap: 6px !important;
            }
            .emoji-btn {
                width: 25px;
                height: 25px;
                font-size: 16px;
            }
            .comment-btn-inside {
                padding: 6px 12px !important;
                font-size: 12px !important;
            }
        }

        @media (max-width: 700px) {
            .modal.comment-modal,
            .modal.comment-modal .modal-dialog,
            .modal.comment-modal .modal-content {
                overflow-y: auto !important;
                overflow-x: visible !important;
            }
            .modal.comment-modal .modal-content {
                display: block !important;
            }
            .modal.comment-modal .row.g-0 {
                flex-direction: column !important;
            }
            .modal.comment-modal .col-12 {
                border-right: none !important;
                margin: 0 !important;
                z-index: 100 !important;
            }
            .modal.comment-modal .col-12:last-child {
                border-bottom: none;
            }
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
    </style>
@endsection
