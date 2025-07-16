<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Local CSS files -->
    <link rel="stylesheet" href="{{ asset('assets/admin/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/jquery-jvectormap-2.0.3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/summernote.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">

    <!-- External CDN CSS (Simple Line Icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">



        <style>

            body{
                direction: ltr;
            }
            
            .image-wrapper {
                position: relative;
                display: inline-block;
                margin: 5px;
            }

            .preview-img {
                width: 100px;
                height: 100px;
                object-fit: cover;
                border-radius: 4px;
                border: 1px solid #ccc;
            }

            .remove-btn {
                position: absolute;
                top: 0;
                right: 5px;
                background: #fff;
                color: red;
                font-weight: bold;
                font-size: 18px;
                border-radius: 50%;
                padding: 0 6px;
                cursor: pointer;
            }

            .action{
                position: absolute;
                right: 7px;
                top: 7px;
            }

            .page-loader-wrapper{
                
                background: #080808e3 !important;
            }

            .page-loader-wrapper p {
                color: var(--font-white);
                font-size: 35px !important;
                font-weight: bold !important;
            }

            .user-account .user-photo {
                height: 50px !important;
            }

            .cke_notifications_area{
                display: none !important;
            }

    </style>
</head>
<body data-theme="light" class="font-nunito">
   
       <div id="wrapper" class="theme-cyan">

            <!-- Page Loader -->
            <div class="page-loader-wrapper">
                <div class="loader">
                    <div class="m-t-30"><img src="{{ asset('images/thefazli.com.png') }}" width="258" alt="thefazli.com"></div>
                    <p>{{ __('lang.Please wait...') }}</p>
                </div>
            </div>

            <!-- Top navbar div start -->
            <nav class="navbar navbar-fixed-top">
                <div class="container-fluid">
                    <div class="navbar-brand">
                        <button type="button" class="btn-toggle-offcanvas"><i class="fa fa-bars"></i></button>
                        <button type="button" class="btn-toggle-fullwidth"><i class="fa fa-bars"></i></button>
                        <a href="{{route('localized.home', ['lang' => app()->getlocale()] )}}">{{ __('lang.thefazli.com') }}</a> 
                    </div>
                    
                    <div class="navbar-right">
                        <form id="navbar-search" class="navbar-form search-form">
                            <input value="" class="form-control" placeholder="{{ __('lang.Search here...') }}" type="text">
                            <button type="button" class="btn btn-default"><i class="icon-magnifier"></i></button>
                        </form>                
                    </div>
                </div>
            </nav>

            <!-- main left menu -->
            <div id="left-sidebar" class="sidebar">
                <button type="button" class="btn-toggle-offcanvas"><i class="fa fa-arrow-left"></i></button>
                <div class="sidebar-scroll">
                    <div class="user-account">
                    <img src="{{ asset('images/' . ($user->photo ?? 'default.png')) }}" class="rounded-circle user-photo" alt="Profile Picture">
                        <div class="dropdown">
                            <span>{{ __('lang.Welcome') }},</span>
                            <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{ $user->name }}</strong></a>
                            <ul class="dropdown-menu dropdown-menu-right account">
                                <li><a href="{{route('localized.admin.profile', ['lang' => app()->getLocale()])}}" ><i class="icon-user"></i>{{ __('lang.My Profile') }}</a></li>
                                <li class="divider"></li>
                                <li><a href="{{route('localized.logout', ['lang' => app()->getLocale()])}}"><i class="icon-power"></i>{{ __('lang.Logout') }}</a></li>
                            </ul>
                        </div>
                        <hr>
                    
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu">{{ __('lang.Menu') }}</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#setting"><i class="icon-settings"></i></a></li>
                        @php 
                        // Get current locale
                        $locale = App::getLocale();
                        @endphp  
                        <li class="nav-item"><a href="{{ route('lang.switch', $locale === 'en' ? 'ar' : 'en') }}" class="nav-link"><i class="fa fa-language"></i></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#question"><i class="icon-question"></i></a></li>                
                    </ul>
                        
                    <!-- Tab panes -->
                    <div class="tab-content padding-0">
                        <div class="tab-pane active" id="menu">
                            <nav id="left-sidebar-nav" class="sidebar-nav">
                                <ul id="main-menu" class="metismenu li_animation_delay">
                                    <li>
                                        <a href="{{route('localized.admin.dashboard', ['lang' => app()->getLocale()])}}"><i class="fa fa-dashboard"></i><span>{{ __('lang.Dashboard') }}</span></a>
                                    </li>
                                    <li>
                                        <a href="{{route('localized.blogs', ['lang' => app()->getLocale()])}}"><i class="icon-speedometer"></i> &nbsp; <span>{{ __('lang.Website') }}</span></a>
                                    </li>
                                    <li>
                                        <a href="{{ route('localized.admin.categories.index', ['lang' => app()->getLocale()]) }}" ><i class="fas fa-folder"></i><span>{{ __('lang.Categories') }}</span></a>
                                    </li>
                                    <li class="active mb-3">
                                        <a href="#App" class="has-arrow"><i class="fa fa-th-large"></i><span>{{ __('lang.Blogs') }}</span></a>
                                        <ul>
                                            <li><a href="{{route('localized.admin.blog', ['lang' => app()->getLocale()])}}">{{ __('lang.Published Blogs') }}</a></li>
                                                <li><a href="{{ route('localized.admin.request-blogs', ['lang' => app()->getLocale()])}}#request-section">{{ __('lang.Request') }}</a></li>
                                                <li><a href="{{ route('localized.admin.request-blogs', ['lang' => app()->getLocale()])}}#draft-section">{{ __('lang.Draft') }}</a></li>
                                          
                                            <li><a href="{{ route('localized.admin.blog-create', ['lang' => app()->getLocale()])}}">{{ __('lang.Create Blog') }}</a></li>
                                        </ul>
                                    </li>                                
                                </ul>
                            </nav>
                        </div>
                    
                        <div class="tab-pane" id="setting">
                            <h6>{{ __('lang.Choose Skin') }}</h6>
                            <ul class="choose-skin list-unstyled">
                                <li data-theme="purple"><div class="purple"></div></li>
                                <li data-theme="blue"><div class="blue"></div></li>
                                <li data-theme="cyan" class="active"><div class="cyan"></div></li>
                                <li data-theme="green"><div class="green"></div></li>
                                <li data-theme="orange"><div class="orange"></div></li>
                                <li data-theme="blush"><div class="blush"></div></li>
                                <li data-theme="red"><div class="red"></div></li>
                            </ul>

                            <ul class="list-unstyled font_setting mt-3">
                                <li>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="font" value="font-nunito" checked="">
                                        <span class="custom-control-label">{{ __('lang.Nunito Google Font') }}</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="font" value="font-ubuntu">
                                        <span class="custom-control-label">{{ __('lang.Ubuntu Font') }}</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="font" value="font-raleway">
                                        <span class="custom-control-label">{{ __('lang.Raleway Google Font') }}</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="font" value="font-IBMplex">
                                        <span class="custom-control-label">{{ __('lang.IBM Plex Google Font') }}</span>
                                    </label>
                                </li>
                            </ul>

                            <ul class="list-unstyled mt-3">
                                <li class="d-flex align-items-center mb-2">
                                    <label class="toggle-switch theme-switch">
                                        <input type="checkbox">
                                        <span class="toggle-switch-slider"></span>
                                    </label>
                                    <span class="ml-3">{{ __('lang.Enable Dark Mode!') }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <label class="toggle-switch theme-rtl">
                                        <input type="checkbox">
                                        <span class="toggle-switch-slider"></span>
                                    </label>
                                    <span class="ml-3">{{ __('lang.Enable RTL Mode!') }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <label class="toggle-switch theme-high-contrast">
                                        <input type="checkbox">
                                        <span class="toggle-switch-slider"></span>
                                    </label>
                                    <span class="ml-3">{{ __('lang.Enable High Contrast Mode!') }}</span>
                                </li>
                            </ul>                    
                        </div>
                        <div class="tab-pane" id="question">
                            <form>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-magnifier"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="{{ __('lang.Search...') }}">
                                </div>
                            </form>
                            <ul class="list-unstyled question">
                                <li class="menu-heading">{{ __('lang.HOW-TO') }}</li>                 
                                <li class="menu-button mt-3">
                                    <a href="#" class="btn btn-primary btn-block">{{ __('lang.Documentation') }}</a>
                                </li>
                            </ul>
                        </div>    
                    </div>          
                </div>
            </div>
            
            @yield('content')   
 
        </div>
        
    <!-- Javascript -->
   <script src="{{ asset('assets/admin/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/admin/vendorscripts.bundle.js') }}"></script>

    <script src="{{ asset('assets/admin/apexcharts.bundle.js') }}"></script>
    <script src="{{ asset('assets/admin/jvectormap.bundle.js') }}"></script> <!-- JVectorMap Plugin Js -->
    <script src="{{ asset('assets/admin/knob.bundle.js') }}"></script> <!-- Jquery Knob -->

    <!-- Page JS files -->
    <script src="{{ asset('assets/admin/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/admin/summernote.js') }}"></script>
    <script src="{{ asset('assets/admin/blog.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>
</html>
