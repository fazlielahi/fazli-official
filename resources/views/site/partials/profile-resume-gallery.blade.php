@php
    $galleryLocale = $locale ?? app()->getLocale();
    $galleryUrl = route('localized.resume.gallery', ['lang' => $galleryLocale]);
@endphp

<div class="profile-resume-gallery" role="list" aria-label="{{ __('lang.My Resumes') }}">
    <a href="{{ $galleryUrl }}" class="profile-resume-gallery__item profile-resume-gallery__item--create" role="listitem">
        <div class="profile-resume-gallery__thumb">
            <span class="profile-resume-gallery__upload" aria-hidden="true">
                <i class="fa-solid fa-plus"></i>
            </span>
        </div>
        <div class="profile-resume-gallery__info">
            <span class="profile-resume-gallery__name">{{ __('lang.Create Resume') }}</span>
        </div>
    </a>

    @foreach($recentCvs as $cv)
        @php
            $openHref = route('localized.resume.builder', ['lang' => $galleryLocale, 'slug' => $cv->template_slug]) . '?cv_id=' . $cv->id;
            $title = $cv->title ?: __('lang.Untitled resume');
            $editedLabel = $cv->updated_at
                ? __('lang.Edited') . ' ' . $cv->updated_at->diffForHumans()
                : __('lang.Edited recently');
        @endphp
        <a href="{{ $openHref }}" class="profile-resume-gallery__item" role="listitem" title="{{ $title }}">
            <div class="profile-resume-gallery__thumb">
                <iframe
                    class="profile-resume-gallery__frame"
                    title="{{ __('lang.Preview') }} {{ $title }}"
                    loading="lazy"
                    src="{{ route('localized.resume.preview', ['lang' => $galleryLocale, 'id' => $cv->id]) }}?scale=0.28&crop=0.30"
                    scrolling="no"
                ></iframe>
            </div>
            <div class="profile-resume-gallery__info">
                <span class="profile-resume-gallery__name">{{ $title }}</span>
                <span class="profile-resume-gallery__meta">
                    <span class="profile-resume-gallery__format">
                        @include('cv.partials.svg-icon', ['name' => 'document', 'class' => 'profile-resume-gallery__format-icon'])
                        A4
                    </span>
                    <span class="profile-resume-gallery__dot" aria-hidden="true">•</span>
                    <span class="profile-resume-gallery__edited">{{ $editedLabel }}</span>
                </span>
            </div>
        </a>
    @endforeach
</div>
