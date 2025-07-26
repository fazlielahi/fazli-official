<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
    <a href="{{ route('localized.home', ['lang' => app()->getLocale()]) }}" class="{{ request()->routeIs('localized.home') ? 'active' : '' }}">
            <img src="{{ asset('images/tfc-header-logo.png') }}" alt="thefazli.com" class="main-logo"/>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <!-- fallback icon if the above is invisible -->
        <i class="fas fa-bars header-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('localized.home', ['lang' => app()->getLocale()]) }}" class="{{ request()->routeIs('localized.home') ? 'active' : '' }}">
                        <i class="fas fa-home me-2"></i>{{ __('lang.Home') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('localized.about', ['lang' => app()->getLocale()]) }}" class="{{ request()->routeIs('localized.about') ? 'active' : '' }}">
                        <i class="fas fa-user me-2"></i>{{ __('lang.About') }}
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" style="background-color: #ffffff00 !important;" class="nav-link dropdown-toggle {{ request()->routeIs('localized.blogs') || request()->routeIs('localized.books') ? 'active' : '' }}" id="blogsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-blog me-2"></i>{{ __('lang.Blogs') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="blogsDropdown">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('localized.blogs') ? 'active' : '' }}" href="{{ route('localized.blogs', ['lang' => app()->getLocale()]) }}">
                                <i class="fas fa-blog me-2"></i>{{ __('lang.Blogs') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('localized.books') ? 'active' : '' }}" href="{{ route('localized.books', ['lang' => app()->getLocale()]) }}">
                                <i class="fas fa-book me-2"></i>{{ __('lang.Books') }}
                            </a>
                        </li>      
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" style="background-color: #ffffff00 !important; " class="nav-link dropdown-toggle {{ request()->routeIs('localized.jobs') || request()->routeIs('localized.cv-create') ? 'active' : '' }}" id="jobsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-briefcase me-2"></i>{{ __('lang.Jobs') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="jobsDropdown">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('localized.jobs') ? 'active' : '' }}" href="{{ route('localized.jobs', ['lang' => app()->getLocale()]) }}">
                                <i class="fas fa-search me-2"></i>{{ __('lang.Explore Jobs') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('localized.cv-create') ? 'active' : '' }}" href="{{ route('localized.cv-create', ['lang' => app()->getLocale()]) }}">
                                <i class="fas fa-file-alt me-2"></i>{{ __('lang.CV Create') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('localized.contact', ['lang' => app()->getLocale()]) }}" class="{{ request()->routeIs('localized.contact') ? 'active' : '' }}">
                        <i class="fas fa-envelope me-2"></i>{{ __('lang.Contact') }}
                    </a>
                </li>
                <li class="nav-item">
                    @if ($locale === 'en')
                        <a href="{{ route('lang.switch', 'ar') }}" class="language-icon">
                            <i class="fas fa-globe"></i>
                            {{ __('lang.Arabic') }}
                        </a>
                    @else
                        <a href="{{ route('lang.switch', 'en') }}" class="language-icon">
                            <i class="fas fa-globe"></i>
                            {{ __('lang.English') }}
                        </a>
                    @endif
                </li>
            </ul>
        </div>
        <div class="header-button d-flex align-items-center">
            <!-- Theme Toggle -->
            <div class="theme-toggle-container">
                <span class="theme-toggle-label d-none d-md-inline">{{ __('lang.Theme') }}</span>
                <div class="theme-toggle" data-theme="dark">
                    <i class="fas fa-sun icon sun-icon"></i>
                    <i class="fas fa-moon icon moon-icon"></i>
                </div>
            </div>
            
            @php 
                $user = session()->has('user_id') ? \App\Models\User::find(session('user_id')) : null;
            @endphp

            @if($user)
                <div class="dropdown ms-3">
                    <button class="btn dropdown-toggle d-flex align-items-center justify-content-between w-100" 
                            style="background-color:rgb(0, 0, 0);min-width: 159px !important; color: #fff; justify-content: flex-end !important; margin-bottom: 2px"
                            type="button" id="userDropdown" 
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2">{{ $user->name }}</span>
                        <img src="{{ $user->photo ? asset('images/' . $user->photo) : asset('images/default.png') }}"
                             class="rounded-circle me-1" width="30" height="30" 
                             style="object-fit: cover; border-radius: 50%; border: 1px solid rgb(173, 172, 172);">
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('localized.profile', ['lang' => app()->getLocale()]) }}">
                                <i class="fas fa-user-circle me-2"></i>{{ __('lang.My Profile') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('localized.blog-create', ['lang' => app()->getLocale()]) }}">
                                <i class="fas fa-plus-circle me-2"></i>{{ __('lang.Create Blog') }}
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('localized.logout', ['lang' => app()->getLocale()]) }}">
                                <i class="fas fa-sign-out-alt me-2"></i>{{ __('lang.Logout') }}
                            </a>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('localized.register', ['lang' => app()->getLocale()]) }}" class="btn btn-sm bg-red-2 register-btn">
                    <i class="fas fa-user-plus mx-1"></i>{{ __('lang.Sign Up') }}
                </a>
                <a href="{{ route('localized.login', ['lang' => app()->getLocale()]) }}" class="btn btn-sm bg-red-2 login-btn">
                    <i class="fas fa-sign-in-alt mx-1"></i>{{ __('lang.Login') }}
                </a>
            @endif
        </div>
    </div>
</nav>

@php $locale = app()->getLocale(); @endphp