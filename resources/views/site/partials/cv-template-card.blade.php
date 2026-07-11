@php
    $previewModalId = $previewModalId ?? 'about-cv-preview-modal';
    $wowDelay = $wowDelay ?? 0;
@endphp
<article class="template-card wow fadeInUp" @if($wowDelay) data-wow-delay="{{ $wowDelay }}ms" @endif>
    <div class="template-preview">
        <div class="template-preview__frame template-preview__frame--overlay">
            @if(!empty($template['preview_path']))
                <img src="{{ $template['preview_path'] }}" alt="{{ $template['name'] }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="template-preview-placeholder" style="display: none;">{{ __('lang.Preview') }}</div>
            @else
                <div class="template-preview-placeholder">{{ __('lang.Preview') }}</div>
            @endif
            <div class="template-preview__actions-overlay">
                <div class="template-actions">
                    <a href="{{ route('localized.resume.builder', ['lang' => app()->getLocale(), 'slug' => $template['slug']]) }}" class="btn-use-template">
                        @include('cv.partials.svg-icon', ['name' => 'check', 'class' => 'cv-svg-icon me-2'])
                        {{ __('lang.Use Template') }}
                    </a>
                    @if(!empty($template['preview_path']))
                        <button class="btn-preview"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#{{ $previewModalId }}"
                                data-preview-image="{{ $template['preview_path'] }}"
                                data-template-name="{{ $template['name'] }}"
                                data-template-slug="{{ $template['slug'] }}">
                            @include('cv.partials.svg-icon', ['name' => 'magnifying-glass', 'class' => 'cv-svg-icon me-2'])
                            {{ __('lang.Preview') }}
                        </button>
                    @else
                        <button type="button" class="btn-preview" disabled title="{{ __('lang.Preview') }}">{{ __('lang.Preview') }}</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="template-info">
        <h3 class="template-info__title">{{ $template['name'] }}</h3>
    </div>
</article>
