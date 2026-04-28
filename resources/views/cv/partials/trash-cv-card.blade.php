@php
    $lang = app()->getLocale();
    $title = $cv->title ?? 'Untitled resume';
    $retentionDays = isset($trashRetentionDays) ? (int) $trashRetentionDays : null;
@endphp
<article class="cv-project-card cv-trash-card" data-cv-id="{{ $cv->id }}" data-cv-title="{{ $title }}" tabindex="-1">
    {{-- Preview is display-only: no overlay link, iframe already pointer-events none in CSS --}}
    <div class="cv-project-card__preview cv-trash-card__preview" aria-hidden="true">
        <iframe
            class="cv-project-card__frame"
            title="Preview {{ $title }}"
            loading="lazy"
            tabindex="-1"
            src="{{ route('localized.cv.preview', ['lang' => $lang, 'id' => $cv->id]) }}?scale=0.28&crop=0.30"
            scrolling="no"
        ></iframe>
    </div>
    <div class="cv-project-card__footer cv-trash-card__footer">
        <div class="cv-project-card__meta">
            <div class="cv-project-card__title">{{ $title }}</div>
            <div class="cv-project-card__sub cv-trash-card__sub">
                @if($cv->deleted_at)
                    Removed {{ $cv->deleted_at->diffForHumans() }}
                    @if($retentionDays)
                        <span class="cv-trash-card__purge-at">• Deleted permanently after {{ $cv->deleted_at->copy()->addDays($retentionDays)->format('M d, Y') }}</span>
                    @endif
                @endif
            </div>
        </div>
        <div class="cv-trash-card__actions">
            <button type="button" class="cv-trash-card__btn cv-trash-card__btn--restore" data-action="restore">
                @include('cv.partials.svg-icon', ['name' => 'arrow-uturn-left', 'class' => 'cv-svg-icon'])
                <span>Restore</span>
            </button>
            <button type="button" class="cv-trash-card__btn cv-trash-card__btn--purge" data-action="purge">
                @include('cv.partials.svg-icon', ['name' => 'trash', 'class' => 'cv-svg-icon'])
                <span>Delete permanently</span>
            </button>
        </div>
    </div>
</article>
