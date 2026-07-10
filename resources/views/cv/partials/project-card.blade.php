@php
    $lang = app()->getLocale();
    $openHref = route('localized.resume.builder', ['lang' => $lang, 'slug' => $cv->template_slug]) . '?cv_id=' . $cv->id;
    $title = $cv->title ?? 'Untitled resume';
    $at = $cv->updated_at;
@endphp
<article class="cv-project-card" data-cv-id="{{ $cv->id }}" data-open-href="{{ $openHref }}" data-cv-title="{{ $title }}">
    <div class="cv-project-card__preview" aria-hidden="true">
        <iframe
            class="cv-project-card__frame"
            title="Preview {{ $title }}"
            loading="lazy"
            src="{{ route('localized.resume.preview', ['lang' => $lang, 'id' => $cv->id]) }}?scale=0.28&crop=0.30"
            scrolling="no"
        ></iframe>
        <a class="cv-project-card__preview-link" href="{{ $openHref }}" aria-label="Open {{ $title }}"></a>
    </div>
    <div class="cv-project-card__footer">
        <div class="cv-project-card__meta">
            <div class="cv-project-card__title">{{ $title }}</div>
            <div class="cv-project-card__sub">Updated {{ optional($at)->format('M d, Y') }}</div>
        </div>
        <div class="cv-project-card__actions">
            <button type="button" class="cv-project-card__more" aria-haspopup="menu" aria-expanded="false" aria-label="More options">
                <span class="cv-project-card__more-icon-menu" aria-hidden="true">@include('cv.partials.svg-icon', ['name' => 'ellipsis-vertical', 'class' => 'cv-svg-icon'])</span>
                <span class="cv-project-card__more-icon-close" aria-hidden="true">@include('cv.partials.svg-icon', ['name' => 'x-mark', 'class' => 'cv-svg-icon'])</span>
            </button>
            <div class="cv-project-card__menu" role="menu" aria-label="Resume actions" hidden>
                <div class="cv-project-card__menu-body">
                    <a class="cv-project-card__menu-item" href="{{ $openHref }}" role="menuitem">
                        @include('cv.partials.svg-icon', ['name' => 'document'])
                        <span class="cv-project-card__menu-label">Open</span>
                    </a>
                    <a class="cv-project-card__menu-item" href="{{ $openHref }}" target="_blank" rel="noopener noreferrer" role="menuitem">
                        @include('cv.partials.svg-icon', ['name' => 'arrow-top-right-on-square'])
                        <span class="cv-project-card__menu-label">Open in a new tab</span>
                    </a>
                    <button type="button" class="cv-project-card__menu-item" data-action="rename" role="menuitem">
                        @include('cv.partials.svg-icon', ['name' => 'pencil-square'])
                        <span class="cv-project-card__menu-label">Rename</span>
                    </button>
                    <button type="button" class="cv-project-card__menu-item" data-action="details" role="menuitem" disabled>
                        @include('cv.partials.svg-icon', ['name' => 'info-circle'])
                        <span class="cv-project-card__menu-label">Details</span>
                        <span class="cv-project-card__soon">Coming soon</span>
                    </button>
                    <button type="button" class="cv-project-card__menu-item" data-action="duplicate" role="menuitem">
                        @include('cv.partials.svg-icon', ['name' => 'document-duplicate'])
                        <span class="cv-project-card__menu-label">Make a copy</span>
                    </button>
                    <button type="button" class="cv-project-card__menu-item" data-action="move" role="menuitem" disabled>
                        @include('cv.partials.svg-icon', ['name' => 'folder'])
                        <span class="cv-project-card__menu-label">Move</span>
                        <span class="cv-project-card__soon">Coming soon</span>
                    </button>
                    <button type="button" class="cv-project-card__menu-item" data-action="download-pdf" role="menuitem">
                        @include('cv.partials.svg-icon', ['name' => 'arrow-down-tray'])
                        <span class="cv-project-card__menu-label">{{ __('lang.CV download as PDF') }}</span>
                    </button>
                    <button type="button" class="cv-project-card__menu-item" data-action="download-png" role="menuitem" title="{{ __('lang.CV download PNG hint') }}">
                        @include('cv.partials.svg-icon', ['name' => 'document'])
                        <span class="cv-project-card__menu-label">{{ __('lang.CV download as PNG zip') }}</span>
                    </button>
                    <button type="button" class="cv-project-card__menu-item" data-action="share" role="menuitem" disabled>
                        @include('cv.partials.svg-icon', ['name' => 'share'])
                        <span class="cv-project-card__menu-label">Share</span>
                        <span class="cv-project-card__soon">Coming soon</span>
                    </button>
                    <button type="button" class="cv-project-card__menu-item" data-action="copy_link" role="menuitem">
                        @include('cv.partials.svg-icon', ['name' => 'link'])
                        <span class="cv-project-card__menu-label">Copy link</span>
                    </button>
                    <div class="cv-project-card__menu-sep" role="separator"></div>
                    <button type="button" class="cv-project-card__menu-item cv-project-card__menu-item--danger" data-action="trash" role="menuitem">
                        @include('cv.partials.svg-icon', ['name' => 'trash'])
                        <span class="cv-project-card__menu-label">Move to Trash</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</article>
