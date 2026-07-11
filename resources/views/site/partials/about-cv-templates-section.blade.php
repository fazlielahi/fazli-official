<section class="cv-templates-section" id="cv-templates-section">
    <div class="container">
        <div class="section-title text-center sec-title-animation animation-style1">
            <div class="section-title__tagline-box">
                <div class="section-title__tagline-shape"></div>
                <span class="section-title__tagline">{{ __('lang.CV Templates') }}</span>
            </div>
            <h2 class="section-title__title {{ $locale == 'en' ? 'title-animation' : '' }}">
                {{ __('lang.Professional CV Templates') }} <br>
                <span>{{ __('lang.Build Your Perfect Resume') }} <img src="{{ asset('assets/images/shapes/section-title-shape-1.png') }}" alt="" role="presentation" aria-hidden="true"></span>
            </h2>
            <p class="cv-templates-section__subtitle">
                {{ __('lang.About cv preview description') }}
            </p>
        </div>

        @if(isset($cvTemplates) && count($cvTemplates) > 0)
            <div class="about-cv-showcase">
                <div class="templates-grid about-cv-templates-grid" id="about-cv-templates-grid">
                    @foreach($cvTemplates as $template)
                        @include('site.partials.cv-template-card', [
                            'template' => $template,
                            'wowDelay' => $loop->index * 100,
                        ])
                    @endforeach
                </div>
            </div>

            <div class="cv-templates-section__cta text-center">
                <a href="{{ route('localized.resume.gallery', ['lang' => app()->getLocale()]) }}" class="cv-templates-section__btn thm-btn">
                    <span class="icon-angles-right"></span>{{ __('lang.View All Templates') }}
                </a>
            </div>
        @else
            <div class="cv-templates-section__empty text-center">
                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                <p class="text-muted">{{ __('lang.No CV templates available yet.') }}</p>
            </div>
        @endif
    </div>
</section>

@if(isset($cvTemplates) && count($cvTemplates) > 0)
    <div class="modal fade preview-modal" id="about-cv-preview-modal" tabindex="-1" aria-labelledby="aboutCvPreviewModalLabel" aria-hidden="true" data-builder-url="{{ route('localized.resume.builder', ['lang' => app()->getLocale(), 'slug' => 'TEMPLATE_SLUG']) }}">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aboutCvPreviewModalLabel">{{ __('lang.Preview') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('lang.Close') }}"></button>
                </div>
                <div class="modal-body">
                    <img id="aboutCvPreviewModalImage" src="" alt="{{ __('lang.Preview') }}" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('lang.Close') }}</button>
                    <a id="aboutCvPreviewModalUseBtn" href="#" class="btn btn-use-from-modal">
                        @include('cv.partials.svg-icon', ['name' => 'check', 'class' => 'cv-svg-icon me-2'])
                        {{ __('lang.Use Template') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
