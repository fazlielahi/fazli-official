@php
    $activeMenu = $activeMenu ?? match (true) {
        request()->routeIs('localized.bulk-mail.senders') => 'senders',
        request()->routeIs('localized.bulk-mail.contacts') => 'contacts',
        request()->routeIs('localized.bulk-mail.templates') => 'templates',
        request()->routeIs('localized.bulk-mail.campaigns') => 'campaigns',
        default => 'dashboard',
    };

    $locale = app()->getLocale();
    $dashboardUrl = route('localized.bulk-mail.index', ['lang' => $locale]);
    $sendersUrl = route('localized.bulk-mail.senders', ['lang' => $locale]);
    $contactsUrl = route('localized.bulk-mail.contacts', ['lang' => $locale]);
    $templatesUrl = route('localized.bulk-mail.templates', ['lang' => $locale]);
    $campaignsUrl = route('localized.bulk-mail.campaigns', ['lang' => $locale]);
    $toolsUrl = route('localized.tools', ['lang' => $locale]);
@endphp

<aside class="cv-side-menu" aria-label="{{ __('lang.Bulk Email Sender') }}">
    <a class="cv-side-menu__item{{ $activeMenu === 'dashboard' ? ' is-active' : '' }}"
       href="{{ $dashboardUrl }}"
       @if($activeMenu === 'dashboard') aria-current="page" @endif>
        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'home'])</span>
        <span class="cv-side-menu__label">{{ __('lang.Dashboard') }}</span>
    </a>

    <a class="cv-side-menu__item{{ $activeMenu === 'senders' ? ' is-active' : '' }}"
       href="{{ $sendersUrl }}"
       @if($activeMenu === 'senders') aria-current="page" @endif>
        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'envelope'])</span>
        <span class="cv-side-menu__label">{{ __('lang.Bulk mail nav senders') }}</span>
    </a>

    <a class="cv-side-menu__item{{ $activeMenu === 'contacts' ? ' is-active' : '' }}"
       href="{{ $contactsUrl }}"
       @if($activeMenu === 'contacts') aria-current="page" @endif>
        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'user-plus'])</span>
        <span class="cv-side-menu__label">{{ __('lang.Bulk mail nav contacts') }}</span>
    </a>

    <a class="cv-side-menu__item{{ $activeMenu === 'templates' ? ' is-active' : '' }}"
       href="{{ $templatesUrl }}"
       @if($activeMenu === 'templates') aria-current="page" @endif>
        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'document'])</span>
        <span class="cv-side-menu__label">{{ __('lang.Bulk mail nav templates') }}</span>
    </a>

    <a class="cv-side-menu__item{{ $activeMenu === 'campaigns' ? ' is-active' : '' }}"
       href="{{ $campaignsUrl }}"
       @if($activeMenu === 'campaigns') aria-current="page" @endif>
        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'share'])</span>
        <span class="cv-side-menu__label">{{ __('lang.Bulk mail nav campaigns') }}</span>
    </a>

    <a class="cv-side-menu__item{{ $activeMenu === 'tools' ? ' is-active' : '' }}"
       href="{{ $toolsUrl }}"
       @if($activeMenu === 'tools') aria-current="page" @endif>
        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'grid'])</span>
        <span class="cv-side-menu__label">{{ __('lang.All Tools') }}</span>
    </a>
</aside>
