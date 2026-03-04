@extends('site.layout')

@section('title', 'Founder - ' . __('lang.Fazli Elahi'))

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('lang.META_DESCRIPTION') }}"/>
    <meta name="keywords" content="{{ __('lang.META_KEYWORDS') }}"/>
    <meta name="author" content="{{ __('lang.AUTHOR_NAME') }}">

    <meta property="og:title" content="Fazli Elahi - Founder">
    <meta property="og:description" content="{{ __('lang.OG_DESCRIPTION') }}">
    <meta property="og:image" content="https://fazlielahi.rf.gd/images/portfolio-preview.jpg">
    <meta property="og:url" content="https://fazlielahi.rf.gd">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Fazli Elahi - Founder">
    <meta name="twitter:description" content="{{ __('lang.OG_DESCRIPTION') }}">
    <meta name="twitter:image" content="https://fazlielahi.rf.gd/images/portfolio-preview.jpg">
    <meta name="twitter:url" content="https://fazlielahi.rf.gd">
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" /> <!-- main heading css -->
    <link rel="stylesheet" href="{{ asset('styles/cv.css') }}" /> <!-- cv css -->
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/slider.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/founder-profile.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/certificate/cwa-lightbox.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel='stylesheet' href="{{ asset('lib/fontawesome-free-6.5.1-web/css/all.min.css') }}">
    <link href="{{ asset('lib/jqueryscripttop.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('lib/cards.css') }}"> <!--templates_sec -->
    <link rel="stylesheet" href="{{ asset('styles/template.css') }}">
    <style>
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .rotate-me {
            animation: rotate 20s linear infinite;
        }

        .img-container img{
            border: 1px solid lightgray;
        }

        .scroll-to-target.scroll-to-top{
            display: none;
        }

        body{
            overflow-x: hidden;
        }
        
        .login-btn, .register-btn{
            color: #fff;
        }

    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
     <!-- responsive design -->
     <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-about.css') }}" />
    
@endsection

@section('content')
    <div class="about-top" style="position:relative;">
        <!-- Animated Banner Background Shapes (from index) -->
        <div class="banner-one__img-shape-box rotate-me" style="position:absolute;top:50px;left:0;right:0;width:552px;height:552px;background:rgba(109,13,212,0.05);border-radius:50%;z-index:0;margin:auto;">
            <div class="banner-one__img-shape-1">
                <div class="banner-one__img-shape-2"></div>
            </div>
            <div class="banner-one__shape-1" style="position:absolute;top:51px;left:0px;">
                <img src="{{ asset('assets/images/shapes/banner-one-shape-1.png') }}" alt="">
            </div>
            <div class="banner-one__shape-2 rotate-me" style="position:absolute;top:120px;right:60px;"></div>
            <div class="banner-one__shape-3" style="position:absolute;top:30px;right:0;">
                <img src="{{ asset('assets/images/shapes/banner-one-shape-3.png') }}" alt="">
            </div>
        </div>
        <div class="main-heading">
            <h1>
                <span class="heading-row1">{{ __('lang.I_AM') }}</span>
                <span class="heading-row2">{{ __('lang.Fazli Elahi') }}</span>
            </h1>
            <h3>
                <span class="subtitle1" id="element"></span> {{ __('lang.WEB_DEVELOPER') }}
            </h3>
            <span class="organization" id='message'>{{ __('lang.OPEN_TO_OPPORTUNITIES') }}</span>
            <span class="cv-btn" id='cvbtn' onclick="openModal()">{{ __('lang.CHECK_CV') }}</span>
        </div>

        <!-- Image SLider -->
        <div class="photo-slider">
            <div id="slider">
                <div class="portfolio">
                    <img src="{{ asset('images/slider2.jpg') }}" alt="Portfolio image 1" /><br />
                    <div class="ombra"></div>
                </div>
                <div class="portfolio">
                    <img src="{{ asset('images/slider1.jpg') }}" alt="Portfolio image 2" /><br />
                    <div class="ombra"></div>
                </div>
                <div class="portfolio">
                    <img src="{{ asset('images/slider3.jpg') }}" alt="Portfolio image 3" /><br />
                    <div class="ombra"></div>
                </div>
                <div class="portfolio">
                    <img src="{{ asset('images/slider4.jpg') }}" alt="Portfolio image 4" /><br />
                    <div class="ombra"></div>
                </div>
                <div class="portfolio 2ndlast-photo">
                    <img src="{{ asset('images/slider5.jpg') }}" alt="Portfolio image 5" /><br />
                    <div class="ombra"></div>
                </div>
                <div class="portfolio last-photo">
                    <img src="{{ asset('images/blackhatmea24.jpg') }}" alt="Portfolio image 6" /><br />
                    <div class="ombra"></div>
                </div>
                <div id="navi"></div>
            </div>
        </div>
    </div>

    <!-- Social media boxes -->
    <div class="socialmedia-slider slider-card" id="social-slider">
        <button class="slider-nav-btn slider-nav-prev" id="slider-prev" aria-label="Previous">
            <i class="fas fa-arrow-left"></i>
        </button>
        <button class="slider-nav-btn slider-nav-next" id="slider-next" aria-label="Next">
            <i class="fas fa-arrow-right"></i>
        </button>
        <div class="marquee-slider__list">
            <div class="marquee-slider__list--item">
                <div class="social-profiles">
                    <div class="top linkedin">
                        <span>{{ __('lang.Linkedin') }}</span>
                        <img src="{{ asset('images/linkedin.png') }}" alt="" class="logo">
                    </div>
                    <div class="profile-photo">
                        <div class="photo">
                            <img src="{{ asset('images/linkedin-profile.jpg') }}" alt="LinkedIn profile">
                        </div>
                    </div>
                    <span class="username">{{ __('lang.Fazli Elahi') }}</span>
                    <span class="role">
                        {{ __('lang.FULL_STACK_AT') }}
                        <a href="https://tamakan.com.sa/" target="_blank">{{ __('lang.ORGANIZATION_NAME') }}</a>
                    </span>
                    <span class="profile-btn">
                        <a href="https://www.linkedin.com/in/fazlielahi/" target="_blank">{{ __('lang.VIEW_PROFILE') }}</a>
                    </span>
                </div>
            </div>
            <div class="marquee-slider__list--item">
                <div class="social-profiles">
                    <div class="top github">
                        <span>{{ __('lang.GitHub') }}</span>
                        <img src="{{ asset('images/github.png') }}" alt="" class="logo">
                    </div>
                    <div class="profile-photo">
                        <div class="photo">
                            <img src="{{ asset('images/github-profile.jpg') }}" alt="GitHub profile">
                        </div>
                    </div>
                    <span class="username">{{ __('lang.Fazli Elahi') }}</span>
                    <span class="role">
                        {{ __('lang.FULL_STACK_AT') }}
                        <a href="https://tamakan.com.sa/" target="_blank">{{ __('lang.ORGANIZATION_NAME') }}</a>
                    </span>
                    <span class="profile-btn">
                        <a href="https://github.com/fazlielahi" target="_blank">{{ __('lang.VIEW_PROFILE') }}</a>
                    </span>
                </div>
            </div>
            <div class="marquee-slider__list--item">
                <div class="social-profiles">
                    <div class="top whatsapp">
                        <span>{{ __('lang.Whatsapp') }}</span>
                        <img src="{{ asset('images/whatsapp.png') }}" alt="" class="logo">
                    </div>
                    <div class="profile-photo">
                        <div class="photo">
                            <img src="{{ asset('images/whatsapp-profile.png') }}" alt="WhatsApp profile">
                        </div>
                    </div>
                    <span class="username">{{ __('lang.Fazli Elahi') }}</span>
                    <span class="role">
                        {{ __('lang.FULL_STACK_AT') }}
                        <a href="https://tamakan.com.sa/" target="_blank">{{ __('lang.ORGANIZATION_NAME') }}</a>
                    </span>
                    <span class="profile-btn">
                        <a href="https://wa.me/+923415609801" target="_blank">{{ __('lang.VIEW_PROFILE') }}</a>
                    </span>
                </div>
            </div>
            <div class="marquee-slider__list--item">
                <div class="social-profiles">
                    <div class="top facebook">
                        <span>{{ __('lang.Facebook') }}</span>
                        <img src="{{ asset('images/facebook.png') }}" alt="" class="logo">
                    </div>
                    <div class="profile-photo">
                        <div class="photo">
                            <img src="{{ asset('images/facebook-profile.png') }}" alt="Facebook profile">
                        </div>
                    </div>
                    <span class="username">{{ __('lang.Fazli Elahi') }}</span>
                    <span class="role">
                        {{ __('lang.FULL_STACK_AT') }}
                        <a href="https://tamakan.com.sa/" target="_blank">{{ __('lang.ORGANIZATION_NAME') }}</a>
                    </span>
                    <span class="profile-btn">
                        <a href="https://www.facebook.com/fazlie.lahi.50/" target="_blank">{{ __('lang.VIEW_PROFILE') }}</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Experience Timeline Section -->
    <div class="experience-timeline">
        <h2 class="experience-timeline__title">
            Experience
            <button class="section-toggle-btn" id="experience-toggle" aria-label="Toggle Experience Section">
                <i class="fas fa-chevron-down"></i>
            </button>
        </h2>
        <div class="experience-timeline__content" id="experience-content">
        <ul class="experience-timeline__list">
            @forelse($experiences ?? [] as $experience)
                <li class="experience-timeline__item">
                    <div class="experience-timeline__company">
                        <div class="experience-timeline__icon">
                            @if($experience->company_logo)
                                <img src="{{ asset('storage/' . $experience->company_logo) }}" alt="{{ $experience->company_name }}">
                            @else
                                <i class="fas fa-building" style="font-size: 24px; color: #21cf8c;"></i>
                            @endif
                        </div>
                        <h3 class="experience-timeline__company-name">{{ $experience->company_name }}</h3>
                    </div>
                    <div class="experience-timeline__role">
                        <div class="experience-timeline__role-header">
                            <h4 class="experience-timeline__role-title">{{ $experience->role_title }}</h4>
                            @if($experience->is_current)
                                <div class="experience-timeline__status">
                                    <span class="experience-timeline__status-icon experience-timeline__status-icon--check">
                                        <i class="fas fa-check"></i>
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="experience-timeline__role-details">
                            <span>{{ $experience->start_date->format('M Y') }} - {{ $experience->is_current ? 'Present' : ($experience->end_date ? $experience->end_date->format('M Y') : 'Present') }}</span>
                            <span>({{ $experience->duration }})</span>
                            @if($experience->location)
                                <span>{{ $experience->location }}</span>
                            @endif
                            <span>{{ $experience->employment_type }}</span>
                        </div>
                        @if($experience->description || ($experience->responsibilities && count($experience->responsibilities) > 0))
                            <div class="experience-timeline__role-description">
                                @if($experience->description)
                                    <p style="margin-bottom: 12px; color: inherit;">{{ $experience->description }}</p>
                                @endif
                                @if($experience->responsibilities && count($experience->responsibilities) > 0)
                                    <ul class="experience-timeline__description-list">
                                        @foreach($experience->responsibilities as $responsibility)
                                            <li>{{ $responsibility }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endif
                        @if($experience->media_images && count($experience->media_images) > 0)
                            <!-- Experience Media Row -->
                            <div class="experience-timeline__media-section">
                                <div class="experience-timeline__media-container">
                                    <button class="experience-timeline__media-nav experience-timeline__media-nav--prev exp-media-nav-prev" aria-label="Previous">
                                        <i class="fas fa-arrow-left"></i>
                                    </button>
                                    <button class="experience-timeline__media-nav experience-timeline__media-nav--next exp-media-nav-next" aria-label="Next">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                    <div class="experience-timeline__media-scroll exp-media-scroll">
                                        <div class="experience-timeline__media-items">
                                            @foreach($experience->media_images as $index => $imagePath)
                                                @if($imagePath)
                                                    <div class="experience-timeline__media-item" data-image-src="{{ asset('storage/' . $imagePath) }}" data-image-desc="{{ $experience->company_name }} - Image {{ $index + 1 }}">
                                                        <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $experience->company_name }} - Image {{ $index + 1 }}">
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </li>
            @empty
                <li class="experience-timeline__item">
                    <div class="text-center" style="padding: 40px; color: #6b7280;">
                        <p>No experiences available yet.</p>
                    </div>
                </li>
            @endforelse
        </ul>
        </div>
    </div>

    <!-- Technical Skills Section -->
    <div class="skills-timeline">
        <h2 class="skills-timeline__title">
            {{ __('lang.TECHNICAL_SKILLS') }}
            <button class="section-toggle-btn" id="skills-toggle" aria-label="Toggle Skills Section">
                <i class="fas fa-chevron-down"></i>
            </button>
        </h2>
        <div class="skills-timeline__content collapsed" id="skills-content">
        <div class="skills-timeline__grid">
            <div class="skill-item" data-pamt='95' onclick="skills('html')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/html.png') }}" alt="HTML" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">HTML</h4>
                    <div class="skill-item__percentage">95%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='94' onclick="skills('css')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/css.png') }}" alt="CSS" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">CSS</h4>
                    <div class="skill-item__percentage">94%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='70' onclick="skills('js')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/js.png') }}" alt="JavaScript" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">JavaScript</h4>
                    <div class="skill-item__percentage">70%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='87' onclick="skills('bs')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/bs.png') }}" alt="Bootstrap" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">Bootstrap</h4>
                    <div class="skill-item__percentage">87%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='57' onclick="skills('jq')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/jq.png') }}" alt="JQuery" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">JQuery</h4>
                    <div class="skill-item__percentage">57%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='73' onclick="skills('jq ui')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/jq-ui.png') }}" alt="JQuery UI" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">JQuery UI</h4>
                    <div class="skill-item__percentage">73%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='81' onclick="skills('jq script')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/jq-script.png') }}" alt="JQuery Script" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">JQuery Script</h4>
                    <div class="skill-item__percentage">81%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='41' onclick="skills('react js')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/react-logo.png') }}" alt="React" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">React</h4>
                    <div class="skill-item__percentage">41%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='91' onclick="skills('php')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/php.png') }}" alt="PHP" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">PHP</h4>
                    <div class="skill-item__percentage">91%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='88' onclick="skills('mysql')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/mysql.png') }}" alt="MySQL" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">MySQL</h4>
                    <div class="skill-item__percentage">88%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='74' onclick="skills('oop')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/oop.png') }}" alt="OOP" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">OOP</h4>
                    <div class="skill-item__percentage">74%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='43' onclick="skills('lvl')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/lvl.png') }}" alt="Laravel" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">Laravel</h4>
                    <div class="skill-item__percentage">43%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='86' onclick="skills('wd')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/wd.png') }}" alt="WordPress" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">WordPress</h4>
                    <div class="skill-item__percentage">86%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='66' onclick="skills('api')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/api.png') }}" alt="API" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">API</h4>
                    <div class="skill-item__percentage">66%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='88' onclick="skills('ajax')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/ajax.png') }}" alt="AJAX" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">AJAX</h4>
                    <div class="skill-item__percentage">88%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='93' onclick="skills('json')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/json.png') }}" alt="JSON" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">JSON</h4>
                    <div class="skill-item__percentage">93%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='98' onclick="skills('word')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/word.png') }}" alt="MS Word" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">MS Word</h4>
                    <div class="skill-item__percentage">98%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='66' onclick="skills('excel')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/excel.png') }}" alt="MS Excel" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">MS Excel</h4>
                    <div class="skill-item__percentage">66%</div>
                </div>
            </div>
            <div class="skill-item" data-pamt='76' onclick="skills('pp')">
                <div class="skill-item__icon">
                    <img src="{{ asset('images/skills/pp.png') }}" alt="MS PowerPoint" />
                </div>
                <div class="skill-item__info">
                    <h4 class="skill-item__name">MS PowerPoint</h4>
                    <div class="skill-item__percentage">76%</div>
                </div>
            </div>
        </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('js/menu.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <!-- for scroll anim social media -->
    <script src="{{ asset('lib/scroll-anim/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('lib/scroll-anim/marqueeSlider.js') }}"></script>
    <script src="{{ asset('js/scroll-anim.js') }}"></script>
    <script defer src="{{ asset('lib/certificate/cwa-image-lightbox.js') }}"></script>
    <script defer src="{{ asset('lib/certificate/home-certificate.js') }}"></script>
    <!-- Type JS -->
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script>
        var typed = new Typed('#element', {
            strings: ['{{ __('lang.TYPED_FRONTEND') }}', '{{ __('lang.TYPED_BACKEND') }}', '{{ __('lang.TYPED_FULLSTACK') }} &nbsp'],
            typeSpeed: 50,
        });
    </script>
    <script>
        var typed = new Typed('#message', {
            strings: ['{{ __('lang.OPEN_TO_OPPORTUNITIES') }}'],
            typeSpeed: 50,
        });

         // Preloader
        $(window).on('load', function (event) {
            $('.js-preloader').delay(700).fadeOut(500);
        });

        // Expand/Collapse functionality
        $(document).ready(function() {
            // Experience section - expanded by default (no collapsed class)
            const experienceToggle = $('#experience-toggle');
            const experienceContent = $('#experience-content');
            
            // Skills section - collapsed by default (already has collapsed class in HTML)
            const skillsToggle = $('#skills-toggle');
            const skillsContent = $('#skills-content');
            
            // Set initial icon state for skills (rotated since it's collapsed)
            skillsToggle.addClass('collapsed');
            
            // Experience toggle handler (button and title)
            experienceToggle.on('click', function(e) {
                e.stopPropagation();
                experienceContent.toggleClass('collapsed');
                experienceToggle.toggleClass('collapsed');
            });
            
            $('.experience-timeline__title').on('click', function(e) {
                if (!$(e.target).closest('.section-toggle-btn').length) {
                    experienceContent.toggleClass('collapsed');
                    experienceToggle.toggleClass('collapsed');
                }
            });
            
            // Skills toggle handler (button and title)
            skillsToggle.on('click', function(e) {
                e.stopPropagation();
                skillsContent.toggleClass('collapsed');
                skillsToggle.toggleClass('collapsed');
            });
            
            $('.skills-timeline__title').on('click', function(e) {
                if (!$(e.target).closest('.section-toggle-btn').length) {
                    skillsContent.toggleClass('collapsed');
                    skillsToggle.toggleClass('collapsed');
                }
            });
        });

        // Experience Media Navigation - Handle multiple media sections
        $(document).ready(function() {
            const scrollAmount = 180; // Width of item + gap

            function initMediaSection(container) {
                const $container = $(container);
                const $mediaScroll = $container.find('.exp-media-scroll');
                const $prevBtn = $container.find('.exp-media-nav-prev');
                const $nextBtn = $container.find('.exp-media-nav-next');

                function checkButtons() {
                    if ($mediaScroll.length === 0) return;
                    
                    const scrollElement = $mediaScroll[0];
                    if (!scrollElement) return;
                    
                    const maxScroll = scrollElement.scrollWidth - scrollElement.clientWidth;
                    
                    // Show/hide buttons based on overflow
                    if (maxScroll <= 5) {
                        $prevBtn.addClass('hidden');
                        $nextBtn.addClass('hidden');
                    } else {
                        $prevBtn.removeClass('hidden');
                        $nextBtn.removeClass('hidden');
                    }
                    
                    // Update button states based on scroll position
                    if (scrollElement.scrollLeft <= 5) {
                        $prevBtn.addClass('disabled');
                    } else {
                        $prevBtn.removeClass('disabled');
                    }
                    
                    if (scrollElement.scrollLeft >= maxScroll - 5) {
                        $nextBtn.addClass('disabled');
                    } else {
                        $nextBtn.removeClass('disabled');
                    }
                }

                // Navigation buttons
                $prevBtn.off('click').on('click', function() {
                    if ($(this).hasClass('disabled') || $(this).hasClass('hidden')) return;
                    $mediaScroll.animate({
                        scrollLeft: '-=' + scrollAmount
                    }, 300, function() {
                        checkButtons();
                    });
                });

                $nextBtn.off('click').on('click', function() {
                    if ($(this).hasClass('disabled') || $(this).hasClass('hidden')) return;
                    $mediaScroll.animate({
                        scrollLeft: '+=' + scrollAmount
                    }, 300, function() {
                        checkButtons();
                    });
                });

                // Update button states on scroll
                $mediaScroll.off('scroll').on('scroll', function() {
                    checkButtons();
                });

                // Initial check
                setTimeout(checkButtons, 100);
            }

            // Initialize all media sections
            $('.experience-timeline__media-container').each(function() {
                initMediaSection(this);
            });
            
            // Check on window resize
            $(window).on('resize', function() {
                $('.experience-timeline__media-container').each(function() {
                    const $mediaScroll = $(this).find('.exp-media-scroll');
                    const $prevBtn = $(this).find('.exp-media-nav-prev');
                    const $nextBtn = $(this).find('.exp-media-nav-next');
                    
                    setTimeout(function() {
                        const scrollElement = $mediaScroll[0];
                        if (scrollElement) {
                            const maxScroll = scrollElement.scrollWidth - scrollElement.clientWidth;
                            if (maxScroll <= 5) {
                                $prevBtn.addClass('hidden');
                                $nextBtn.addClass('hidden');
                            } else {
                                $prevBtn.removeClass('hidden');
                                $nextBtn.removeClass('hidden');
                            }
                        }
                    }, 100);
                });
            });

            // Image Lightbox on click - wait for script to load
            function setupImageLightbox() {
                if (typeof imageLightbox === 'function') {
                    $('.experience-timeline__media-item').off('click.lightbox').on('click.lightbox', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        const mediaItems = $('.experience-timeline__media-item');
                        const arrImages = [];
                        
                        mediaItems.each(function() {
                            const src = $(this).data('image-src') || $(this).find('img').attr('src');
                            const desc = $(this).data('image-desc') || $(this).find('img').attr('alt') || '';
                            arrImages.push({
                                src: src,
                                desc: desc
                            });
                        });
                        
                        const clickedIndex = mediaItems.index($(this));
                        
                        if (arrImages.length > 0 && clickedIndex >= 0) {
                            imageLightbox(arrImages, clickedIndex);
                        }
                    });
                } else {
                    // Retry after a short delay if function not available
                    setTimeout(setupImageLightbox, 100);
                }
            }
            
            // Try to setup immediately, then retry if needed
            setupImageLightbox();
            setTimeout(setupImageLightbox, 500);
        });

    </script>
    
@endsection
