<!DOCTYPE html>
@php
    $locale = app()->getLocale();
    $pageDir = in_array($locale, ['ar', 'ur'], true) ? 'rtl' : 'ltr';
    $isRtl = $pageDir === 'rtl';
@endphp
<html lang="{{ $locale }}" dir="{{ $pageDir }}">

<head>
    <link rel="icon" href="{{ asset('images/favicon-tfc-the-fazli-community.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>@hasSection('title')@yield('title')@else TFC - The Fazli Community @endif</title>

    @yield('meta')

    <link rel="stylesheet" href="{{ asset('styles/app.css') }}">

    @if($locale == 'ar')
        <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('styles/rtl.css') }}">
    @endif

    @if($locale == 'ur')
        <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('styles/rtl.css') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-header.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-profile.css')}}">
    <link rel="stylesheet" href="{{ asset('lib/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{ asset('styles/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/profile-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/profile-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/profile-edit.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <script src="{{ asset('lib/jquery-3.6.0.js')}}"></script>
    <script src="{{ asset('lib/jquery-ui.js')}}"></script>

    @yield('head')

    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/scrollbars.css') }}">

    <style>
        .blogs-section {
            width: 100%;
        }

        .action {
            position: absolute;
            right: 7px;
            top: 7px;
            z-index: 5;
        }

        .blog-card {
            padding-right: 0;
            margin-left: 6px;
        }

        .modal-backdrop { z-index: 1040 !important; }
        .modal { z-index: 1050 !important; }

        .news-card-items .news-image {
            height: 229px;
            max-height: 180px !important;
        }

        body.page-user-profile:not(.page-blogs) .blog-two__img { height: 191px !important; }

        .end-0 { right: -10px !important; }
        .top-0 { top: 10px !important; }

        .cke_notifications_area { display: none !important; }

        @media screen and (max-width: 600px) {
            .blog-card { width: 100% !important; }
        }
    </style>

    @if($isRtl)
        <link rel="stylesheet" href="{{ asset('styles/profile-rtl.css') }}">
    @endif
</head>

@php
    $profileBodyClass = trim('page-user-profile ' . (string) $__env->yieldContent('body_class'));
@endphp
<body onresize="add_collapse()" id="body" class="{{ $profileBodyClass }}">
    @include("site.inc.header")
    @include("site.inc.cv")

    <div class="loader js-preloader">
        <div></div><div></div><div></div>
    </div>

    @php
        use App\Models\Blog;
        $user = auth()->check() ? auth()->user() : null;
        $rejectedCount = 0;
        if ($user) {
            $rejectedCount = Blog::where('status', 'rejected')->where('created_by', $user->id)->count();
        }
        if (isset($blogs) && $user) {
            $toastCount = $blogs->where('status', 'rejected')->where('created_by', $user->id)->count();
        } else {
            $toastCount = 0;
        }

        $showProfileShell = $user
            && in_array($user->type, ['admin', 'super_admin'], true)
            && (!isset($clickedUser) || (isset($clickedUser) && $clickedUser->id == $user->id));

        if (isset($clickedUser) && $clickedUser && $clickedUser->id) {
            $profileUser = $clickedUser;
            $profile_name = $clickedUser->name ?? 'Unknown';
            $profile_since = $clickedUser->created_at ? $clickedUser->created_at->format('d/m/Y') : '';
        } elseif ($user && $user->id) {
            $profileUser = $user;
            $profile_name = $user->name ?? 'Unknown';
            $profile_since = $user->created_at ? $user->created_at->format('d/m/Y') : '';
        } else {
            $profileUser = null;
            $profile_name = 'Unknown';
            $profile_since = '';
        }

        $profilePhotoSrc = userPhotoUrl($profileUser);
        $defaultPhotoSrc = asset('images/default.svg');
    @endphp

    @if($toastCount > 0)
        <div aria-live="polite" aria-atomic="true">
            <div class="profile-toast-container">
                <div class="toast profile-toast profile-toast--danger border-0" id="rejectedToast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="profile-toast__inner">
                        <div class="toast-body profile-toast__body">
                            <span>{{ __('lang.You have X rejected posts.', ['count' => $toastCount, 'plural' => $toastCount > 1 ? 's' : '']) }}</span>
                        </div>
                        <button type="button" class="profile-toast__close" data-bs-dismiss="toast" aria-label="{{ __('lang.Close') }}">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($rejectedCount > 0)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var toastEl = document.getElementById('rejectedToast');
                if (toastEl && typeof bootstrap !== 'undefined') {
                    new bootstrap.Toast(toastEl, { delay: 7000 }).show();
                }
            });
        </script>
    @endif

    <div class="profile-page-wrap {{ $showProfileShell ? '' : 'profile-page-wrap--public' }}">
        @if($showProfileShell)
            <button type="button" class="profile-sidebar-toggle" id="profileSidebarToggle" aria-expanded="false" aria-controls="profileSidebar">
                <i class="fa-solid fa-bars"></i> {{ __('lang.Menu') }}
            </button>

            <div class="profile-shell">
                @include('site.partials.profile-sidebar')

                <div class="profile-shell__main">
                    @php
                        $showHeaderCategoryFilter = !empty($categories) && count($categories)
                            && !request()->routeIs('localized.blog-create', 'localized.admin.blog.edit');
                    @endphp
                    @if(View::hasSection('page_title') || $showHeaderCategoryFilter || View::hasSection('page_header_actions'))
                        <div class="profile-page-header">
                            @hasSection('page_title')
                                <h1 class="profile-page-title">@yield('page_title')</h1>
                            @endif

                            @if($showHeaderCategoryFilter || View::hasSection('page_header_actions'))
                                <div class="profile-page-header__tools">
                                    @if($showHeaderCategoryFilter)
                                        <div class="profile-category-bar{{ !empty($selectedCategory) ? ' is-filtered' : '' }}">
                                            <form method="GET" action="" class="profile-category-form">
                                                <div class="profile-category-select-wrap">
                                                    <i class="fa-solid fa-layer-group profile-category-select-wrap__icon" aria-hidden="true"></i>
                                                    <select
                                                        name="category_id"
                                                        class="profile-category-select"
                                                        aria-label="{{ __('lang.All Categories') }}"
                                                        onchange="this.form.submit()"
                                                    >
                                                        <option value="">{{ __('lang.All Categories') }}</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ (isset($selectedCategory) && $selectedCategory == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <i class="fa-solid fa-chevron-down profile-category-select-wrap__caret" aria-hidden="true"></i>
                                                </div>
                                            </form>
                                        </div>
                                    @endif

                                    @hasSection('page_header_actions')
                                        <div class="profile-page-header__actions">
                                            @yield('page_header_actions')
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="profile-shell__body">
                        @yield('content')
                    </div>
                </div>
            </div>
        @else
            <div class="profile-public-header">
                <div class="profile-public-header__user">
                    <img src="{{ $profilePhotoSrc }}" alt="{{ e($profile_name) }}" class="profile-public-header__avatar" onerror="this.onerror=null;this.src='{{ $defaultPhotoSrc }}';">
                    <div>
                        <h2 class="profile-public-header__name">{{ $profile_name }}</h2>
                        <p class="profile-public-header__since">{{ __('lang.Member Since') }} {{ $profile_since }}</p>
                    </div>
                </div>
                <div class="profile-main-toolbar__actions">
                    @if(isset($clickedUser) && $clickedUser && $clickedUser->id)
                        <a href="{{ route('localized.blogs', ['lang' => app()->getLocale()]) }}" class="profile-action-btn">
                            <i class="fa-solid fa-arrow-left"></i> {{ __('lang.Back') }}
                        </a>
                    @elseif($user && $user->type === 'super_admin')
                        <a href="{{ route('localized.admin.dashboard', ['lang' => app()->getLocale()]) }}" class="profile-action-btn">
                            <i class="fa-solid fa-gauge-high"></i> {{ __('lang.Dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('localized.blogs', ['lang' => app()->getLocale()]) }}" class="profile-action-btn">
                            <i class="fa-solid fa-arrow-left"></i> {{ __('lang.Back') }}
                        </a>
                    @endif
                </div>
            </div>

            @if(isset($clickedUser))
                <style>.blogs-section { margin-top: 0; }</style>
            @endif

            @yield('content')
        @endif
    </div>

    @if($showProfileShell)
        @include('site.partials.profile-edit-modal')
    @endif

    @if($showProfileShell && session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: @json(session('success')),
                        showConfirmButton: false,
                        timer: 3500,
                        timerProgressBar: true,
                    });
                }
            });
        </script>
    @endif

    @yield('script')

    <div id="comment-success-message" class="profile-flash profile-flash--success" role="status" aria-live="polite">
        {{ __('lang.Comment added successfully!') }}
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/theme.js') }}"></script>
    <script src="{{ asset('js/like.js') }}"></script>
    <script src="{{ asset('js/comment.js') }}"></script>
    <script src="{{ asset('js/share-blog.js') }}"></script>
    @if($showProfileShell)
        <script src="{{ asset('js/profile-edit.js') }}"></script>
        <script src="{{ asset('js/profile-sidebar.js') }}"></script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(blogId) {
            Swal.fire({
                title: '{{ __('lang.Delete Blog Post?') }}',
                text: '{{ __('lang.This action cannot be undone.') }}',
                icon: 'warning',
                showCancelButton: true,
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
