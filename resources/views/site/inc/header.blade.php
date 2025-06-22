<div class="main-header">

    <div class="logo">
        fazli.web
    </div>

    <div class="menu" id="menu">
        <a href="{{ route('localized.home', ['lang' => app()->getLocale()]) }}" class="{{ request()->routeIs('localized.home') ? 'active' : '' }}">{{ __('lang.Home') }}</a>

        <a href="{{ route('localized.about', ['lang' => app()->getLocale()]) }}" class="{{ request()->routeIs('localized.about') ? 'active' : '' }}">{{ __('lang.About') }}</a>
        <!-- <div class="dropdown">
            <a href="#" class="dropdown-toggle {{ request()->is('about*') ? 'active' : '' }}">
                About <i class="fa-solid fa-chevron-down"></i>
            </a>
            <div class="dropdown-menu">
                <a href="{{ url('about/experience') }}" class="{{ request()->is('about/experience*') ? 'active' : '' }}">Experience</a>
                <a href="{{ url('about/skills') }}" class="{{ request()->is('about/skills*') ? 'active' : '' }}">Skills</a>
            </div>
        </div> -->
        <a href="{{ route('localized.contact', ['lang' => app()->getLocale()]) }}" class="{{ request()->routeIs('localized.contact') ? 'active' : '' }}"> {{ __('lang.Contact') }} </a>
        
        @if ($locale === 'en')
            <a href="{{ route('lang.switch', 'ar') }}" class="language-icon">
            <i class="fas fa-globe mx-2"></i>
            العربية
            </a>
        @else
            <a href="{{ route('lang.switch', 'en') }}" class="language-icon" style="">
            <i class="fas fa-globe mx-2"></i>
            English
            </a>
        @endif
    </div>         
    
    <i class="fa-solid fa-bars bars-icon"
    data-bs-toggle="collapse" href="#menu" aria-expanded="false" 
    aria-controls="menu"></i>

</div>
@php $locale = app()->getLocale(); @endphp