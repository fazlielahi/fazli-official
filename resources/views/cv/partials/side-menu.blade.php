@php
    $activeMenu = $activeMenu ?? 'create';
    $locale = app()->getLocale();
    $galleryUrl = route('localized.cv.gallery', ['lang' => $locale]);
    $homeUrl = route('localized.home', ['lang' => $locale]);
    $projectsUrl = route('localized.cv.projects', ['lang' => $locale]);
    $trashUrl = route('localized.cv.trash', ['lang' => $locale]);
@endphp

<aside class="cv-side-menu" aria-label="Quick menu">
    @if ($activeMenu === 'create')
        <a class="cv-side-menu__item is-active" href="#" aria-current="page">
            <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'plus'])</span>
            <span class="cv-side-menu__label">Create</span>
        </a>
    @else
        <a class="cv-side-menu__item" href="{{ $galleryUrl }}">
            <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'plus'])</span>
            <span class="cv-side-menu__label">Create</span>
        </a>
    @endif

    <a class="cv-side-menu__item{{ $activeMenu === 'home' ? ' is-active' : '' }}" href="{{ $homeUrl }}" @if($activeMenu === 'home') aria-current="page" @endif>
        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'home'])</span>
        <span class="cv-side-menu__label">Home</span>
    </a>

    <a class="cv-side-menu__item{{ $activeMenu === 'projects' ? ' is-active' : '' }}" href="{{ $projectsUrl }}" @if($activeMenu === 'projects') aria-current="page" @endif @guest data-requires-auth data-auth-next="{{ $projectsUrl }}" @endguest>
        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'folder'])</span>
        <span class="cv-side-menu__label">Projects</span>
    </a>

    <a class="cv-side-menu__item{{ $activeMenu === 'templates' ? ' is-active' : '' }}" href="{{ $galleryUrl }}" @if($activeMenu === 'templates') aria-current="page" @endif>
        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'layers'])</span>
        <span class="cv-side-menu__label">Templates</span>
    </a>

    @auth
        <a class="cv-side-menu__item{{ $activeMenu === 'trash' ? ' is-active' : '' }}" href="{{ $trashUrl }}" @if($activeMenu === 'trash') aria-current="page" @endif>
            <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'trash'])</span>
            <span class="cv-side-menu__label">Trash</span>
        </a>
    @endauth
</aside>
