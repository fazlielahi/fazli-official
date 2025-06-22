@extends('site.layout')

@section('title', __('lang.PORTFOLIO_TITLE'))

@section('meta')

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('lang.META_DESCRIPTION') }}"/>
    <meta name="keywords" content="{{ __('lang.META_KEYWORDS') }}"/>
    <meta name="author" content="{{ __('lang.AUTHOR_NAME') }}">


    <meta property="og:title" content="Fazli Elahi Portfolio">
    <meta property="og:description" content="{{ __('lang.OG_DESCRIPTION') }}">
    <meta property="og:image" content="https://fazlielahi.rf.gd/images/portfolio-preview.jpg">
    <meta property="og:url" content="https://fazlielahi.rf.gd">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Fazli Elahi Portfolio">
    <meta name="twitter:description" content="{{ __('lang.OG_DESCRIPTION') }}">
    <meta name="twitter:image" content="https://fazlielahi.rf.gd/images/portfolio-preview.jpg">
    <meta name="twitter:url" content="https://fazlielahi.rf.gd">

@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" /> <!-- main heading css -->
    <link rel="stylesheet" href="{{ asset('styles/cv.css') }}" /> <!-- cv css -->
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/slider.css') }}">
    <link rel='stylesheet' href="{{ asset('lib/bootstrap.min.css') }}">
    <link rel='stylesheet' href="{{ asset('lib/fontawesome-free-6.5.1-web/css/all.min.css') }}">
    <link href="{{ asset('lib/jqueryscripttop.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('lib/experience-card.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/cards.css') }}"> <!--templates_sec -->
    <link rel="stylesheet" href="{{ asset('styles/template.css') }}">
@endsection

@section('content')
    <div class="about-top">

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
        <div class="marquee-slider__list">
            <!-- Linkedin -->
            <div class="marquee-slider__list--item">

                <div class="social-profiles">

                    <div class="top linkedin"> <span> {{ __('lang.Linkedin') }} </span>
                        <img src="{{ asset('images/linkedin.png') }}" alt="" class="logo">
                    </div>

                    <div class="profile-photo">
                        <div class="photo">
                            <img src="{{ asset('images/linkedin-profile.jpg') }}" />
                        </div>
                    </div>

                    <span class="username"> {{ __('lang.Fazli Elahi') }} </span>

                    <span class="role">
                        {{ __('lang.FULL_STACK_AT') }}
                        <a href="https://tamakan.com.sa/" target="_blank">
                            {{ __('lang.ORGANIZATION_NAME') }}
                        </a>
                    </span>

                    <span class="profile-btn">
                        <a href="https://www.linkedin.com/in/fazlielahi/" target="_blank">{{ __('lang.VIEW_PROFILE') }}</a>
                    </span>

                </div>

            </div>

            <!-- Git hub -->
            <div class="marquee-slider__list--item">

                <div class="social-profiles">

                    <div class="top github"> <span> {{ __('lang.GitHub') }} </span>
                        <img src="{{ asset('images/github.png') }}" alt="" class="logo">
                    </div>

                    <div class="profile-photo">
                        <div class="photo">
                            <img src="{{ asset('images/github-profile.jpg') }}" />
                        </div>
                    </div>

                    <span class="username"> {{ __('lang.Fazli Elahi') }} </span>
                    <span class="role">
                        {{ __('lang.FULL_STACK_AT') }}
                        <a href="https://tamakan.com.sa/" target="_blank">
                            {{ __('lang.ORGANIZATION_NAME') }}
                        </a>
                    </span>

                    <span class="profile-btn">
                        <a href="https://github.com/fazlielahi" target="_blank">{{ __('lang.VIEW_PROFILE') }}</a>
                    </span>

                </div>

            </div>
            <!-- Whatsapp -->
            <div class="marquee-slider__list--item">

                <div class="social-profiles">

                    <div class="top whatsapp"> <span> {{ __('lang.Whatsapp') }} </span>
                        <img src="{{ asset('images/whatsapp.png') }}" alt="" class="logo">
                    </div>

                    <div class="profile-photo">
                        <div class="photo">
                            <img src="{{ asset('images/whatsapp-profile.png') }}" />
                        </div>
                    </div>

                    <span class="username"> {{ __('lang.Fazli Elahi') }} </span>

                    <span class="role">
                        {{ __('lang.FULL_STACK_AT') }}
                        <a href="https://tamakan.com.sa/" target="_blank">
                            {{ __('lang.ORGANIZATION_NAME') }}
                        </a>
                    </span>

                    <span class="profile-btn">
                        <a href="https://wa.me/+923415609801" target="_blank">{{ __('lang.VIEW_PROFILE') }}</a>
                    </span>

                </div>

            </div>
    

            <!-- Facebook -->
            <div class="marquee-slider__list--item">

                <div class="social-profiles">

                    <div class="top facebook"> <span> {{ __('lang.Facebook') }} </span>
                        <img src="{{ asset('images/facebook.png') }}" alt="" class="logo">
                    </div>

                    <div class="profile-photo">
                        <div class="photo">
                            <img src="{{ asset('images/facebook-profile.png') }}" />
                        </div>
                    </div>

                    <span class="username"> {{ __('lang.Fazli Elahi') }} </span>
                    <span class="role">
                        {{ __('lang.FULL_STACK_AT') }}
                        <a href="https://tamakan.com.sa/" target="_blank">
                            {{ __('lang.ORGANIZATION_NAME') }}
                        </a>
                    </span>

                    <span class="profile-btn">
                        <a href="https://www.facebook.com/fazlie.lahi.50/" target="_blank">{{ __('lang.VIEW_PROFILE') }}</a>
                    </span>

                </div>

            </div>
        </div>
    </div>


    <!--Skills and graph-->
    <div class="container-fluid skills_sec">

        <div class="skills_boxes">

            <h3 class="skills-heading">{{ __('lang.TECHNICAL_SKILLS') }}</h3>

            <div class="skill" data-pamt='95' onclick="skills('html')">
                <div class="icon" title="HTML">
                    <img src="{{ asset('images/skills/html.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_HTML') }} </p>
            </div>


            <div class="skill" data-pamt='94' title="Cascading style sheet" onclick="skills('css')">
                <div class="icon">
                    <img src="{{ asset('images/skills/css.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_CSS') }} </p>
            </div>

            <div class="skill" data-pamt='70' title="Javascript" onclick="skills('js')">
                <div class="icon">
                    <img src="{{ asset('images/skills/js.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_JS') }} </p>
            </div>

            <div class="skill" data-pamt='87' title="Bootstrap" onclick="skills('bs')">
                <div class="icon">
                    <img src="{{ asset('images/skills/bs.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_BOOTSTRAP') }} </p>
            </div>

            <div class="skill" data-pamt='57' title="JQuery" onclick="skills('jq')">
                <div class="icon">
                    <img src="{{ asset('images/skills/jq.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_JQUERY') }} </p>
            </div>

            <div class="skill" data-pamt='73' title="JQuery UI" onclick="skills('jq ui')">
                <div class="icon">
                    <img src="{{ asset('images/skills/jq-ui.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_JQUERY_UI') }} </p>
            </div>

            <div class="skill" data-pamt='81' title="JQery script" onclick="skills('jq script')">
                <div class="icon">
                    <img src="{{ asset('images/skills/jq-script.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_JQUERY_SCRIPT') }} </p>
            </div>
            

            <div class="skill" data-pamt='41' title="JQery script" onclick="skills('react js')">
                <div class="icon">
                    <img src="{{ asset('images/skills/react-logo.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_REACT') }} </p>
            </div>

            <div class="skill" data-pamt='91' title="PHP" onclick="skills('php')">
                <div class="icon">
                    <img src="{{ asset('images/skills/php.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_PHP') }} </p>
            </div>

            <div class="skill" data-pamt='88' title="MYSQL" onclick="skills('mysql')">
                <div class="icon">
                    <img src="{{ asset('images/skills/mysql.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_MYSQL') }} </p>
            </div>

            <div class="skill" data-pamt='74' title="Object Oriented Programming" onclick="skills('oop')">
                <div class="icon">
                    <img src="{{ asset('images/skills/oop.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_OOP') }} </p>
            </div>

            <div class="skill" data-pamt='43' title="Laravel" onclick="skills('lvl')">
                <div class="icon">
                    <img src="{{ asset('images/skills/lvl.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_LARAVEL') }} </p>
            </div>

            <div class="skill" data-pamt='86' title="Wordpress" onclick="skills('wd')">
                <div class="icon">
                    <img src="{{ asset('images/skills/wd.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_WORDPRESS') }} </p>
            </div>

            <div class="skill" data-pamt='66' onclick="skills('api')">
                <div class="icon">
                    <img src="{{ asset('images/skills/api.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_API') }} </p>
            </div>

            <div class="skill" data-pamt='88' title="AJAX" onclick="skills('ajax')">
                <div class="icon">
                    <img src="{{ asset('images/skills/ajax.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_AJAX') }} </p>
            </div>

            <div class="skill" data-pamt='93' title="Javascript Object notation" onclick="skills('json')">
                <div class="icon">
                    <img src="{{ asset('images/skills/json.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_JSON') }} </p>
            </div>

            <div class="skill" data-pamt='98' title="Microsoft Word" onclick="skills('word')">
                <div class="icon">
                    <img src="{{ asset('images/skills/word.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_MS_WORD') }} </p>
            </div>

            <div class="skill" data-pamt='66' title="Microsoft Excel" onclick="skills('excel')">
                <div class="icon">
                    <img src="{{ asset('images/skills/excel.png') }}" />
                </div>
                <p> {{ __('lang.SKILL_MS_EXCEL') }} </p>
            </div>
            <a href="index.php">
                <div class="skill" data-pamt='76' title="Microsoft Powerpoint" onclick="skills('pp')">
                    <div class="icon">
                        <img src="{{ asset('images/skills/pp.png') }}" />
                    </div>
                    <p> {{ __('lang.SKILL_MS_PP') }} </p>
                </div>
            </a>
        </div>

        <div class="skill_graph">

            <div class="canvas_elemts">
                <canvas id="skills_graph" width="170" height="170">
                </canvas>
            </div>

            <div id="skill_title"> </div>

        </div>

    </div>

    <!-- Experience section-->

    <div class="container-fluid experience">

        <h3 class="section-heading">{{ __('lang.PROFESSIONAL_EXPERIENCE') }}</h3>

        <div class="row active-with-click">
            <!--Masia soft-->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <article class="material-card Pink">
                    <h2 class="heading">
                        <span class="company-name"> MASIA Soft </span>
                        <label>
                            {{ __('lang.PHP_DEVELOPER') }}
                        </label>
                    </h2>
                    <div class="mc-content">
                        <div class="img-container">
                            <img class="img-responsive" src="{{ asset('images/exp/masia-soft.jpg') }}">
                        </div>
                        <div class="mc-description">
                            {{ __('lang.MASIA_DESCRIPTION') }}
                            <a href="https://tamakan.com.sa/">
                                {{ __('lang.ORGANIZATION_NAME') }}
                            </a>

                        </div>
                    </div>
                    <a class="mc-btn-action">
                        <i class="fa fa-bars"></i>
                    </a>
                    <div class="mc-footer">
                        <label>
                            {{ __('lang.CURRENT_POSITION') }}
                        </label>
                    </div>
                </article>
            </div>
          
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('js/menu.js') }}"></script>
    <script src="{{ asset('lib/bootstrap-5.3.2-dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    <!-- for scroll anim social media -->
    <script src="{{ asset('lib/scroll-anim/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('lib/scroll-anim/marqueeSlider.js') }}"></script>
    <script src="{{ asset('js/scroll-anim.js') }}"></script>

    <!--Skills graph-->
    <script type="text/javascript" src="{{ asset('js/skillsgraph.js') }}"></script>

    <!-- Experience cards js -->
    <script src="{{ asset('lib/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery.material-cards.min.js') }}"></script>
    <script src="{{ asset('js/experience-cards.js') }}"></script>

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
    </script>
@endsection
    