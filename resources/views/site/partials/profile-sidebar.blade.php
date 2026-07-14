@php
    $locale = app()->getLocale();
    $navUser = auth()->user();
    $sidebarPhotoSrc = userPhotoUrl($navUser);
    $roleLabel = $navUser->type === 'super_admin'
        ? __('lang.Super Admin')
        : __('lang.Author');
@endphp

<aside class="profile-shell__sidebar" id="profileSidebar" aria-label="{{ __('lang.My Dashboard') }}">
    <div class="profile-shell__user">
        <button
            type="button"
            class="profile-shell__edit"
            data-open-profile-edit
            title="{{ __('lang.Edit Profile') }}"
            aria-label="{{ __('lang.Edit Profile') }}"
        >
            <i class="fa-solid fa-pen"></i>
        </button>
        <img
            src="{{ $sidebarPhotoSrc }}"
            alt="{{ e($navUser->name ?? 'User profile picture') }}"
            class="profile-shell__avatar"
            onerror="this.onerror=null;this.src='{{ asset('images/default.svg') }}';">
        <h2 class="profile-shell__name">{{ $navUser->name }}</h2>
        <p class="profile-shell__meta">{{ __('lang.Member Since') }} {{ optional($navUser->created_at)->format('d/m/Y') }}</p>
        <span class="profile-shell__role">{{ $roleLabel }}</span>
    </div>

    <nav class="profile-shell__nav">
        <span class="profile-nav__label">{{ __('lang.Overview') }}</span>
        <a href="{{ route('localized.profile', ['lang' => $locale]) }}"
           class="profile-nav__link {{ request()->routeIs('localized.profile') ? 'is-active' : '' }}">
            <i class="fa-solid fa-gauge-high"></i>
            <span>{{ __('lang.My Dashboard') }}</span>
        </a>

        <span class="profile-nav__label">{{ __('lang.Tools') }}</span>
        <a href="{{ route('localized.resume.projects', ['lang' => $locale]) }}"
           class="profile-nav__link {{ request()->routeIs('localized.resume.projects', 'localized.resume.trash') ? 'is-active' : '' }}">
            <i class="fa-solid fa-file-lines"></i>
            <span>{{ __('lang.My Resumes') }}</span>
        </a>
        <a href="{{ route('localized.tools', ['lang' => $locale]) }}"
           class="profile-nav__link {{ request()->routeIs('localized.tools') ? 'is-active' : '' }}">
            <i class="fa-solid fa-toolbox"></i>
            <span>{{ __('lang.All Tools') }}</span>
        </a>
        <a href="{{ route('localized.bulk-mail.index', ['lang' => $locale]) }}"
           class="profile-nav__link {{ request()->routeIs('localized.bulk-mail.*') ? 'is-active' : '' }}">
            <i class="fa-solid fa-envelope"></i>
            <span>{{ __('lang.Bulk Email Sender') }}</span>
        </a>

        <span class="profile-nav__label">{{ __('lang.Content') }}</span>
        <a href="{{ route('localized.profile-published-blogs', ['lang' => $locale]) }}"
           class="profile-nav__link {{ request()->routeIs('localized.profile-published-blogs') ? 'is-active' : '' }}">
            <i class="fa-solid fa-newspaper"></i>
            <span>{{ __('lang.Published') }}</span>
        </a>
        <a href="{{ route('localized.profile-draft-blogs', ['lang' => $locale]) }}"
           class="profile-nav__link {{ request()->routeIs('localized.profile-draft-blogs') ? 'is-active' : '' }}">
            <i class="fa-solid fa-pen-to-square"></i>
            <span>{{ __('lang.Draft') }}</span>
        </a>
        <a href="{{ route('localized.profile-request-blogs', ['lang' => $locale]) }}"
           class="profile-nav__link {{ request()->routeIs('localized.profile-request-blogs') ? 'is-active' : '' }}">
            <i class="fa-solid fa-magnifying-glass"></i>
            <span>{{ __('lang.Requested') }}</span>
        </a>
        <a href="{{ route('localized.profile-rejected-blogs', ['lang' => $locale]) }}"
           class="profile-nav__link {{ request()->routeIs('localized.profile-rejected-blogs') ? 'is-active' : '' }}">
            <i class="fa-solid fa-circle-xmark"></i>
            <span>{{ __('lang.Rejected') }}</span>
            @if(!empty($rejectedCount) && $rejectedCount > 0)
                <span class="profile-nav__badge">{{ $rejectedCount }}</span>
            @endif
        </a>

        <span class="profile-nav__label">{{ __('lang.Account') }}</span>
        <button type="button" class="profile-nav__link" data-open-profile-edit>
            <i class="fa-solid fa-user-pen"></i>
            <span>{{ __('lang.Edit Profile') }}</span>
        </button>
        @if($navUser->type === 'super_admin')
            <a href="{{ route('localized.admin.dashboard', ['lang' => $locale]) }}"
               class="profile-nav__link {{ request()->routeIs('localized.admin.dashboard') ? 'is-active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i>
                <span>{{ __('lang.Dashboard') }}</span>
            </a>
        @endif
        <a href="{{ route('localized.blog-create', ['lang' => $locale, 'return' => url()->full()]) }}"
           class="profile-nav__link {{ request()->routeIs('localized.blog-create') ? 'is-active' : '' }}">
            <i class="fa-solid fa-plus"></i>
            <span>{{ __('lang.New Post') }}</span>
        </a>
    </nav>
</aside>
