<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', __('lang.DEFAULT_TITLE'))</title>
    <link rel="icon" href="{{ asset('images/favicon-tfc-the-fazli-community.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    @yield('meta')

    <link rel="stylesheet" href="{{ asset('styles/app.css') }}">
    
    @php $locale = app()->getLocale(); @endphp
    
    @if($locale == 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('styles/rtl.css') }}">
    @endif

    <!-- responsive css -->
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-header.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-profile.css')}}">

    <!-- jquery ui -->
    <link rel="stylesheet" href="{{ asset('lib/jquery-ui.css')}}">
    
    <link rel="stylesheet" href="{{ asset('styles/theme.css') }}">
    <script src="{{ asset('lib/jquery-3.6.0.js')}}"></script>
    <script src="{{ asset('lib/jquery-ui.js')}}"></script>

    @yield('head')

    <style>
        .container{
            margin-top: 35px;
        }

        .profile-sidebar{
            margin-top: 35px;
        }

        .category-dropdown.dropdown .col-md-4{
            margin: 0 !important;
        }

        .blogs-section{
            width: 100%;
            margin-top: 20px;
        }

        .dropdown-col{
            margin: 0;
        }

        .ScrollSmoother-content {
            background-color: #f2f4f7;
            padding-top: 20px
        }
        /* Sidebar navigation styles */
        .sidebar-nav-item {
            margin: 4px;
            border-radius: 6px;
            transition: all 0.3s ease;
            cursor: pointer;
            color: #fff !important;
            text-decoration: none;
            border: 1px solid f5f5f5;
        }
        .sidebar-nav-item:hover {
            background-color: #f5f5f5;   
            color: #333 !important;
        }
        .sidebar-nav-item.active {
            background-color: #21cf8c;
            color: #000;
            padding: 5px 15px;
        }

        .new-blog-btn {
            background-color: #21cf8c;
            color: #000;
            padding: 12px 15px;
        }

        .sidebar-nav-item span {
            font-weight: 500;
        }
        .col-md-2 {
            width: 17.666667% !important;
        }
        .col-md-10 {
            width: 81.333333% !important;
            justify-content: flex-start !important;
        }
        .action {
            position: absolute;
            right: 7px;
            top: 7px;
        }
        .blog-card {
            padding-right: 0;
            margin-left: 6px;
        }
        .modal-backdrop {
            z-index: 1040 !important;
        }
        .modal {
            z-index: 1050 !important;
        }
        .blog-boxes {
            flex-direction: row !important;
        }
        .news-card-items .news-image {
            height: 229px;
        }
        .news-card-items .news-image {
            max-height: 180px !important;
        }
        @media  screen and (max-width: 600px) {
            .blog-boxes {
                flex-direction: column !important;
            }
            .blog-card {
                width: 100% !important;
            }
        }
        .end-0 {
            right: -10px !important;
        }
        .top-0 {
            top: 10px !important;
        }
        .blog-two__img {
            height: 191px !important;
        }
        .action {
            z-index: 5;
        }
        .swal2-dark {
            background-color: #1e1e1e !important;
            border: 1px solid #444444 !important;
        }
        .swal2-title-dark {
            color: #ffffff !important;
        }
        .swal2-content-dark {
            color: #cccccc !important;
        }
        .swal2-confirm-dark {
            background-color: #d33 !important;
            border-color: #d33 !important;
        }
        .swal2-cancel-dark {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
        }
        .swal2-popup {
            background-color: #1e1e1e !important;
            color: #ffffff !important;
        }
        .swal2-title {
            color: #ffffff !important;
        }
        .swal2-html-container {
            color: #cccccc !important;
        }
        .swal2-icon {
            border-color: #ffa500 !important;
        }
        .swal2-icon.swal2-warning {
            border-color: #ffa500 !important;
            color: #ffa500 !important;
        }
        .cke_notifications_area {
            display: none !important;
        }

        .profile-sidebar .badge{
            top: 0;
            right: -10px;
            color: #fff !important;
        }
    </style>
</head>

<body onresize="add_collapse()" id="body">
    @include("site.inc.header")
    @include("site.inc.cv")
    <!--Start Preloader-->
    <div class="loader js-preloader">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <!--End Preloader-->
    @php
        use App\Models\User;
        use App\Models\Blog;
        $user = session()->has('user_id') ? \App\Models\User::find(session('user_id')) : null;
        $rejectedCount = 0;
        if ($user) {
            $rejectedCount = \App\Models\Blog::where('status', 'rejected')->where('created_by', $user->id)->count();
        }
        if(isset($blogs) && $user){
            $toastCount = $blogs->where('status', 'rejected')->where('created_by', $user->id)->count();
        }else{
            $toastCount = 0;
        }
    @endphp
    @if($toastCount > 0)
        <div aria-live="polite" aria-atomic="true" class="position-relative">
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                <div class="toast align-items-center text-bg-danger border-0" id="rejectedToast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <span> {{ __('lang.You have X rejected posts.', ['count' => $toastCount, 'plural' => $toastCount > 1 ? 's' : '']) }}</span>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($rejectedCount > 0)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var toastEl = document.getElementById('rejectedToast');
                if (toastEl) {
                    var toast = new bootstrap.Toast(toastEl, { delay: 7000 });
                    toast.show();
                }
            });
        </script>
    @endif
    <!-- News Section Start -->
    <div class="container">
        <div class="d-flex mb-md-0 profile-header" style="justify-content: space-between !important;">
            @php
                if(isset($clickedUser) && $clickedUser && $clickedUser->id) {
                    $profile_photo = $clickedUser->photo ?? 'default.png';
                    $profile_name = $clickedUser->name ?? 'Unknown';
                    $profile_since = $clickedUser->created_at ? $clickedUser->created_at->format('d/m/Y') : '';
                } else if($user && $user->id) {
                    $profile_photo = $user->photo ?? 'default.png';
                    $profile_name = $user->name ?? 'Unknown';
                    $profile_since = $user->created_at ? $user->created_at->format('d/m/Y') : '';
                } else {
                    $profile_photo = 'default.png';
                    $profile_name = 'Unknown';
                    $profile_since = '';
                }
            @endphp
            <div style="display: flex; align-items: center;" class="profile-photo-box">
                <img 
                    src="{{ $profile_photo ? asset('images/' . $profile_photo) : asset('default.png') }}"
                    alt="{{ e($profile_name ?? 'User profile picture') }}"
                    class="rounded-circle mx-2" style="width: 80px; height: 80px; object-fit: cover;">
                <div>
                    <h2 class="fw-semibold text-light">{{ $profile_name }}</h2>
                    <div class="member-since">
                        <p class="mb-0 mx-1 text-muted" style="font-size: 14px;">{{ __('lang.Member Since') }}</p> <p> <strong>{{ $profile_since }}</strong></p>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-md-row gap-2 profile-header-button">
                @if(isset($clickedUser) && $clickedUser && $clickedUser->id)
                    <a href="{{ route('localized.blogs', ['lang' => app()->getLocale()])}}" class="btn sidebar-nav-item btn-outline-secondary text-dark px-4 py-2 rounded-pill d-flex align-items-center">
                        <i class="fa-solid fa-arrow-left mx-1"></i> {{ __('lang.Back') }}
                    </a>
                @elseif($user && $user->type == 'admin')
                    <a href="{{ route('localized.profile-edit', ['lang' => app()->getLocale()])}}" class="btn sidebar-nav-item btn-outline-secondary text-dark px-2 py-2 rounded-pill d-flex align-items-center">
                        <i class="fa-solid fa-user-pen mx-1"></i> {{ __('lang.Edit Profile') }}
                    </a>
                    <a href="{{ route('localized.blog-create', ['lang' => app()->getLocale()]) }}"
                        class="sidebar-nav-item px-2 py-2 rounded-pill d-flex align-items-center new-blog-btn">
                        <i class="fa-solid fa-plus mx-1"></i> {{ __('lang.New Post') }}
                    </a>
                @elseif($user && $user->type == 'super_admin')
                    <a href="{{ route('localized.admin.dashboard', ['lang' => app()->getLocale()]) }}"
                        class="btn sidebar-nav-item btn-outline-secondary text-dark px-2 py-2 rounded-pill d-flex align-items-center">
                        <i class="fa-solid fa-user-pen mx-1"></i> {{ __('lang.Dashboard') }}
                    </a>
                    <a href="{{ route('localized.profile', ['lang' => app()->getLocale()]) }}"
                        class="sidebar-nav-item active  px-2 py-2 rounded-pill d-flex align-items-center">
                        <i class="fa-solid fa-file-lines mx-1"></i> {{ __('lang.My Blogs') }}
                    </a>
                @else
                    <a href="{{ route('localized.blogs', ['lang' => app()->getLocale()])}}" class="btn sidebar-nav-item btn-outline-secondary text-dark px-2 py-2 rounded-pill d-flex align-items-center">
                        <i class="fa-solid fa-arrow-left mx-1"></i> {{ __('lang.Back') }}
                    </a>
                @endif
            </div>
        </div>
        <div class="row g-4 blog-boxes" style="justify-content: space-between !important;">
            @if($user && $user->type == 'admin')
                @if(isset($clickedUser))
                    <style>
                        .blogs-section{
                            margin-top: 90px;
                        }
                    </style>
                @endif
                @if(!isset($clickedUser) || (isset($clickedUser) && isset($user) && $clickedUser->id == $user->id))
                    <div class="col-12 profile-sidebar">
                        <div class="sidebar-nav">
                            {{-- Published Blogs --}}
                            <a href="{{ route('localized.profile', ['lang' => app()->getLocale()]) }}"
                                class="sidebar-nav-item {{ request()->routeIs('localized.profile') ? 'active' : '' }}">
                                <i class="fa-solid fa-file-lines"></i> {{ __('lang.Published') }}
                            </a>
                            {{-- Draft Blogs --}}
                            <a href="{{ route('localized.profile-draft-blogs', ['lang' => app()->getLocale()]) }}"
                                class="sidebar-nav-item {{ request()->routeIs('localized.profile-draft-blogs') ? 'active' : '' }}">
                                <i class="fa-solid fa-pen-to-square"></i> {{ __('lang.Draft') }}
                            </a>
                            {{-- Review Requests --}}
                            <a href="{{ route('localized.profile-request-blogs', ['lang' => app()->getLocale()]) }}"
                                class="sidebar-nav-item {{ request()->routeIs('localized.profile-request-blogs') ? 'active' : '' }}">
                                <i class="fa-solid fa-magnifying-glass"></i> {{ __('lang.Requested') }}
                            </a>
                            {{-- Rejected Blogs --}}
                            <div class="position-relative" style="display: inline-block;">
                                <a href="{{ route('localized.profile-rejected-blogs', ['lang' => app()->getLocale()]) }}"
                                    class="sidebar-nav-item {{ request()->routeIs('localized.profile-rejected-blogs') ? 'active' : '' }}">
                                    <i class="fa-solid fa-xmark-circle text-danger"></i> {{ __('lang.Rejected') }}
                                </a>
                                @if(isset($rejectedCount) && $rejectedCount > 0)
                                    <span class="badge bg-danger position-absolute translate-middle-y" style="z-index:1; font-size: 0.75rem;">{{ $rejectedCount }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col dropdown-col">
                    @if(!empty($categories) && count($categories))
                        <div class="row mb-4 category-dropdown">
                            <div class="col-md-4">
                                <form method="GET" action="">
                                    <div class="input-group">
                                        <select name="category_id" class="form-control" onchange="this.form.submit()">
                                            <option value="">{{ __('lang.All Categories') }}</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ (isset($selectedCategory) && $selectedCategory == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary d-none" type="submit">{{ __('lang.Filter') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
        @yield('content')
    </div>
    <a href="#" data-target="html" class="scroll-to-target scroll-to-top">
        <span class="scroll-to-top__wrapper"><span class="scroll-to-top__inner"></span></span>
        <span class="scroll-to-top__text"> {{ __('lang.Go Back Top') }}</span>
    </a>
    @yield('script')
    <div id="comment-success-message" style="display:none; position:fixed; top:30px; left:50%; transform:translateX(-50%); z-index:9999; background:#1da370; color:#fff; padding:12px 32px; border-radius:8px; font-size:1.1rem; box-shadow:0 2px 8px #0002;">
        {{ __('lang.Comment added successfully!') }}
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/theme.js') }}"></script>
    <script src="{{ asset('js/like.js') }}"></script>
    <script src="{{ asset('js/comment.js') }}"></script>
    <script src="{{ asset('js/share-blog.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(blogId) {
            Swal.fire({
                title: '{{ __('lang.Delete Blog Post?') }}',
                text: '{{ __('lang.This action cannot be undone.') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '{{ __('lang.Delete') }}',
                cancelButtonText: '{{ __('lang.Cancel') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + blogId).submit();
                }
            });
        }
    </script>
</body>
</html>