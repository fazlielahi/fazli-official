@php
    $locale = app()->getLocale();
    $toolsNavActive = request()->routeIs('localized.tools')
        || request()->routeIs('localized.jobs')
        || request()->routeIs('localized.resume.gallery');
@endphp

<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
    <div class="container-fluid">
    <a href="{{ route('localized.home', ['lang' => app()->getLocale()]) }}" class="{{ request()->routeIs('localized.home') ? 'active' : '' }}">
            <img src="{{ asset('images/dark-tfc-header-logo.png') }}" alt="thefazli.com" class="main-logo logo-dark" alt="TFC - The Fazli Community Dark logo"/>
            <img src="{{ asset('images/light-tfc-header-logo.png') }}" alt="thefazli.com" class="main-logo logo-light"  alt="TFC - The Fazli Community Light logo"/>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        @include('cv.partials.svg-icon', ['name' => 'bars-3', 'class' => 'header-svg-icon header-bars'])
        </button>
        <div class="collapse navbar-collapse" id="navbarNav" aria-label="breadcrumb">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a href="#" style="background-color: #ffffff00 !important;" class="nav-link dropdown-toggle {{ $toolsNavActive ? 'active' : '' }}" id="toolsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @include('cv.partials.svg-icon', ['name' => 'grid', 'class' => 'header-svg-icon me-2']){{ __('lang.Tools') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="toolsDropdown">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('localized.tools') ? 'active' : '' }}" href="{{ route('localized.tools', ['lang' => app()->getLocale()]) }}">
                                @include('cv.partials.svg-icon', ['name' => 'grid', 'class' => 'header-svg-icon me-2']){{ __('lang.All Tools') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('localized.resume.gallery') ? 'active' : '' }}" href="{{ route('localized.resume.gallery', ['lang' => app()->getLocale()]) }}">
                                @include('cv.partials.svg-icon', ['name' => 'document', 'class' => 'header-svg-icon me-2']){{ __('lang.CV Create') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('localized.jobs') ? 'active' : '' }}" href="{{ route('localized.jobs', ['lang' => app()->getLocale()]) }}">
                                @include('cv.partials.svg-icon', ['name' => 'magnifying-glass', 'class' => 'header-svg-icon me-2']){{ __('lang.Explore Jobs') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('localized.services', ['lang' => app()->getLocale()]) }}" class="{{ request()->routeIs('localized.services') ? 'active' : '' }}">
                        @include('cv.partials.svg-icon', ['name' => 'user', 'class' => 'header-svg-icon me-2']){{ __('lang.Services') }}
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" style="background-color: #ffffff00 !important;" class="nav-link dropdown-toggle {{ request()->routeIs('localized.blogs') || request()->routeIs('localized.books') ? 'active' : '' }}" id="blogsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @include('cv.partials.svg-icon', ['name' => 'rss', 'class' => 'header-svg-icon me-2']){{ __('lang.Blogs') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="blogsDropdown">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('localized.blogs') ? 'active' : '' }}" href="{{ route('localized.blogs', ['lang' => app()->getLocale()]) }}">
                                @include('cv.partials.svg-icon', ['name' => 'rss', 'class' => 'header-svg-icon me-2']){{ __('lang.Blogs') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('localized.books') ? 'active' : '' }}" href="{{ route('localized.books', ['lang' => app()->getLocale()]) }}">
                                @include('cv.partials.svg-icon', ['name' => 'book-open', 'class' => 'header-svg-icon me-2']){{ __('lang.Books') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('localized.about-tfc', ['lang' => app()->getLocale()]) }}" class="{{ request()->routeIs('localized.about-tfc') ? 'active' : '' }}">
                        @include('cv.partials.svg-icon', ['name' => 'user-circle', 'class' => 'header-svg-icon me-2']){{ __('lang.About TFC') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('localized.contact', ['lang' => app()->getLocale()]) }}" class="{{ request()->routeIs('localized.contact') ? 'active' : '' }}">
                        @include('cv.partials.svg-icon', ['name' => 'envelope', 'class' => 'header-svg-icon me-2']){{ __('lang.Contact') }}
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" style="background-color: #ffffff00 !important;" class="nav-link dropdown-toggle language-icon header-lang-toggle" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="{{ __('lang.Language') }}">
                        @include('cv.partials.svg-icon', ['name' => 'globe', 'class' => 'header-svg-icon me-1'])
                        <span class="header-lang-label d-lg-none">
                            @if($locale === 'en')
                                {{ __('lang.English') }}
                            @elseif($locale === 'ar')
                                {{ __('lang.Arabic') }}
                            @elseif($locale === 'ur')
                                {{ __('lang.Urdu') }}
                            @endif
                        </span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                        <li>
                            <a class="dropdown-item {{ $locale === 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">
                                {{ __('lang.English') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ $locale === 'ar' ? 'active' : '' }}" href="{{ route('lang.switch', 'ar') }}">
                                {{ __('lang.Arabic') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ $locale === 'ur' ? 'active' : '' }}" href="{{ route('lang.switch', 'ur') }}">
                                {{ __('lang.Urdu') }}
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="header-button d-flex align-items-center">
            <div class="theme-toggle-container">
                <div class="theme-toggle" data-theme="light" title="{{ __('lang.Theme') }}">
                    @include('cv.partials.svg-icon', ['name' => 'sun', 'class' => 'header-svg-icon icon sun-icon'])
                    @include('cv.partials.svg-icon', ['name' => 'moon', 'class' => 'header-svg-icon icon moon-icon'])
                </div>
            </div>

            @php
                $user = auth()->check() ? auth()->user() : null;
            @endphp

            @if($user)
                @php
                    $displayName = trim((string) ($user->name ?? ''));
                    $firstName = $displayName !== '' ? preg_split('/\s+/', $displayName)[0] : 'User';
                @endphp
                <div class="dropdown ms-3">
                    <button class="btn dropdown-toggle d-flex align-items-center justify-content-between w-100"
                            style="color: #fff; justify-content: flex-end !important; margin-bottom: 2px"
                            type="button" id="userDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2">{{ $firstName }}</span>
                        <img
                            src="{{ userPhotoUrl($user) }}"
                            class="rounded-circle me-1"
                            width="30"
                            height="30"
                            style="object-fit: cover; border-radius: 50%; border: 1px solid rgb(173, 172, 172);"
                            alt="{{ e($displayName ?: 'User profile picture') }}"
                            onerror="this.onerror=null;this.src='{{ asset('images/default.svg') }}';">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" style="min-width: 200px;">
                        <li>
                            <a class="dropdown-item" href="{{ route('localized.profile', ['lang' => app()->getLocale()]) }}">
                                @include('cv.partials.svg-icon', ['name' => 'user-circle', 'class' => 'header-svg-icon me-2']){{ __('lang.My Profile') }}
                            </a>
                        </li>
                        @if($user->type === 'super_admin')
                            <li>
                                <a class="dropdown-item" href="{{ route('localized.admin.dashboard', ['lang' => app()->getLocale()]) }}">
                                    @include('cv.partials.svg-icon', ['name' => 'layers', 'class' => 'header-svg-icon me-2']){{ __('lang.Control Panel') }}
                                </a>
                            </li>
                        @endif
                        <li>
                            <a class="dropdown-item" href="{{ route('localized.resume.projects', ['lang' => app()->getLocale()]) }}">
                                @include('cv.partials.svg-icon', ['name' => 'document', 'class' => 'header-svg-icon me-2']){{ __('lang.My Resumes') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('localized.profile-published-blogs', ['lang' => app()->getLocale()]) }}">
                                @include('cv.partials.svg-icon', ['name' => 'rss', 'class' => 'header-svg-icon me-2']){{ __('lang.My Blogs') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('localized.tools', ['lang' => app()->getLocale()]) }}">
                                @include('cv.partials.svg-icon', ['name' => 'grid', 'class' => 'header-svg-icon me-2']){{ __('lang.All Tools') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('localized.blog-create', ['lang' => app()->getLocale()]) }}">
                                @include('cv.partials.svg-icon', ['name' => 'plus-circle', 'class' => 'header-svg-icon me-2']){{ __('lang.Create Blog') }}
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('localized.logout', ['lang' => app()->getLocale()]) }}">
                                @include('cv.partials.svg-icon', ['name' => 'arrow-right-on-rectangle', 'class' => 'header-svg-icon me-2']){{ __('lang.Logout') }}
                            </a>
                        </li>
                    </ul>
                </div>
            @else
                <div class="dropdown ms-2 header-auth-dropdown">
                    <button class="btn btn-sm login-btn dropdown-toggle d-flex align-items-center"
                            type="button"
                            id="authDropdown"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                        @include('cv.partials.svg-icon', ['name' => 'arrow-right', 'class' => 'header-svg-icon me-1']){{ __('lang.Login') }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="authDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ loginUrlWithNext() }}">
                                @include('cv.partials.svg-icon', ['name' => 'arrow-right', 'class' => 'header-svg-icon me-2']){{ __('lang.Login') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ registerUrlWithNext() }}">
                                @include('cv.partials.svg-icon', ['name' => 'user-plus', 'class' => 'header-svg-icon me-2']){{ __('lang.Sign Up') }}
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</nav>
