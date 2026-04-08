@extends('site.layout')

@section('body_class', 'page-cv-builder')

@section('title', 'CV Builder - ' . ($config['name'] ?? 'Template'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
@endsection

@section('head')

    <!-- Bootstrap CSS (Required for header) -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    
    <!-- Font Awesome (Required for header icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
     
    <!-- Main styles -->
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Allura&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Template styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />
    
    <!-- Theme styles -->
    
    <!-- CV Builder CSS -->
    <link rel="stylesheet" href="{{ asset('cv/css/cv-builder.css') }}">
    <link rel="stylesheet" href="{{ asset('cv/css/cv-templates.css') }}">
    
    <!-- Template-specific CSS -->
    @if(file_exists(public_path('cv-templates/assets/' . $templateSlug . '/style.css')))
        <link rel="stylesheet" href="{{ asset('cv-templates/assets/' . $templateSlug . '/style.css') }}">
    @elseif(file_exists(resource_path('views/cv/templates/' . $templateSlug . '/style.css')))
        <style>
            {!! file_get_contents(resource_path('views/cv/templates/' . $templateSlug . '/style.css')) !!}
        </style>
    @endif
@endsection

@section('content')
    <div class="cv-builder">
        <header class="cv-builder-toolbar" aria-label="CV builder tools">
            <div class="cv-builder-toolbar__inner">
                <nav class="cv-builder-toolbar__breadcrumb" aria-label="{{ __('lang.CV breadcrumb nav label') }}">
                    <ol class="cv-builder-breadcrumb">
                        <li class="cv-builder-breadcrumb__item">
                            <a class="cv-builder-breadcrumb__link" href="{{ route('localized.home', ['lang' => app()->getLocale()]) }}">{{ __('lang.Home') }}</a>
                        </li>
                        <li class="cv-builder-breadcrumb__item">
                            <a class="cv-builder-breadcrumb__link" href="{{ route('localized.cv.gallery', ['lang' => app()->getLocale()]) }}">{{ __('lang.CV Templates') }}</a>
                        </li>
                        <li class="cv-builder-breadcrumb__item cv-builder-breadcrumb__item--current" aria-current="page">
                            <span class="cv-builder-breadcrumb__text">{{ $config['name'] ?? __('lang.CV breadcrumb builder') }}</span>
                        </li>
                    </ol>
                </nav>
                <nav class="cv-builder-toolbar__tabs" aria-label="Builder sections">
                    <div class="cv-template-switcher" id="cv-template-switcher">
                        <button type="button" class="cv-builder-toolbar__tab cv-template-switcher__trigger" id="cv-template-switcher-trigger" aria-haspopup="dialog" aria-expanded="false" aria-controls="cv-template-modal">
                            <i class="fas fa-layer-group" aria-hidden="true"></i>
                            <span class="cv-template-switcher__label">{{ $config['name'] ?? 'Templates' }}</span>
                            <i class="fas fa-chevron-down cv-template-switcher__chev" aria-hidden="true"></i>
                        </button>
                    </div>
                    <span class="cv-builder-toolbar__tab is-active" aria-current="page">
                        <i class="fas fa-file-lines" aria-hidden="true"></i>
                        <span>Content</span>
                    </span>
                    <span class="cv-builder-toolbar__tab cv-builder-toolbar__tab--static cv-soon" tabindex="-1" data-tooltip="Coming soon">
                        <i class="fas fa-palette" aria-hidden="true"></i>
                        <span>Customize</span>
                    </span>
                    <span class="cv-builder-toolbar__tab cv-builder-toolbar__tab--static cv-soon" tabindex="-1" data-tooltip="Coming soon">
                        <i class="fas fa-wand-magic-sparkles" aria-hidden="true"></i>
                        <span>AI Tools</span>
                    </span>
                </nav>
                <div class="cv-builder-toolbar__actions">
                    <div class="cv-builder-toolbar__saved">
                        <div class="cv-resume-dropdown" id="cv-resume-dropdown">
                            <button type="button" class="cv-resume-dropdown__trigger" id="cv-resume-trigger" aria-haspopup="dialog" aria-expanded="false">
                                <span class="cv-resume-dropdown__trigger-text" id="cv-resume-trigger-text">Resume</span>
                                <i class="fas fa-chevron-down cv-resume-dropdown__trigger-icon" aria-hidden="true"></i>
                            </button>

                            <select id="load-cv-select" class="cv-builder-toolbar__select cv-resume-dropdown__native" aria-hidden="true" tabindex="-1">
                                <option value="">-- MY CVs/RESUMES --</option>
                            </select>

                            <div class="cv-resume-dropdown__panel" id="cv-resume-panel" role="dialog" aria-label="My Resumes">
                                <div class="cv-resume-dropdown__header">
                                    <span class="cv-resume-dropdown__header-title">My Resumes</span>
                                    <div class="cv-resume-dropdown__header-create-wrap">
                                        <button type="button" class="cv-resume-dropdown__header-create" id="cv-header-create-trigger" aria-expanded="false" aria-haspopup="menu" aria-controls="cv-resume-create-popover" aria-label="{{ __('lang.Create new resume') }}">
                                            <i class="fas fa-plus" aria-hidden="true"></i>
                                        </button>
                                        <div class="cv-resume-create-popover" id="cv-resume-create-popover" role="menu" hidden aria-hidden="true">
                                            <button type="button" role="menuitem" class="cv-resume-create-popover__item cv-resume-create-popover__item--resume" data-href="{{ route('localized.cv.gallery', ['lang' => app()->getLocale()]) }}">
                                                <i class="fas fa-file-lines cv-resume-create-popover__icon" aria-hidden="true"></i>
                                                <span class="cv-resume-create-popover__label">{{ __('lang.CV create option resume') }}</span>
                                            </button>
                                            <button type="button" role="menuitem" class="cv-resume-create-popover__item cv-resume-create-popover__item--soon" disabled aria-disabled="true">
                                                <i class="fas fa-envelope-open-text cv-resume-create-popover__icon" aria-hidden="true"></i>
                                                <span class="cv-resume-create-popover__label">{{ __('lang.CV create option cover letter') }}</span>
                                                <span class="cv-resume-create-popover__badge">{{ __('lang.Coming soon') }}</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="cv-resume-dropdown__list" id="cv-resume-list">
                                    <div class="cv-resume-dropdown__empty">No resumes yet</div>
                                </div>
                                <div class="cv-resume-dropdown__footer" id="cv-resume-loadall-footer" hidden>
                                    <a class="cv-resume-dropdown__add" href="{{ route('localized.cv.projects', ['lang' => app()->getLocale()]) }}">
                                        <i class="fas fa-folder-open cv-resume-dropdown__add-icon" aria-hidden="true"></i>
                                        <span>Load All</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cv-builder-toolbar__download-wrap">
                        <button type="button" id="btn-export-pdf" class="cv-builder-toolbar__download">
                            <span class="cv-builder-toolbar__download-text">Download</span>
                            <i class="fas fa-file-arrow-down cv-builder-toolbar__download-icon" aria-hidden="true"></i>
                        </button>
                        <div id="export-message" class="cv-builder-toolbar__export-msg" aria-live="polite"></div>
                    </div>
                    <button type="button" class="cv-builder-toolbar__more cv-builder-toolbar__more--static cv-soon" aria-label="More options" aria-disabled="true" tabindex="-1" data-tooltip="Coming soon">
                        <i class="fas fa-ellipsis-vertical" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div id="load-message" class="cv-toast" role="status" aria-live="polite" aria-atomic="true" style="display:none;">
                <span class="cv-toast__text" id="load-message-text"></span>
                <button type="button" class="cv-toast__close" id="cv-toast-close" aria-label="Close message">&times;</button>
            </div>
        </header>

        <div class="cv-builder__main">
        <!-- Left Panel: Form -->
        <div class="builder-form-panel">
            <form id="cv-form">
                @php
                    $locationDefault = trim(
                        ($data['city'] ?? '')
                        . ((isset($data['city']) && $data['city'] !== '' && isset($data['country']) && $data['country'] !== '') ? ', ' : '')
                        . ($data['country'] ?? '')
                    );
                @endphp
                <section class="cv-personal-card" aria-labelledby="cv-personal-card-title">
                    <div class="cv-personal-card__header">
                        <h2 class="cv-personal-card__title" id="cv-personal-card-title">{{ __('lang.CV form personal section title') }}</h2>
                        <div class="cv-personal-card__header-actions">
                            <button type="button" class="cv-personal-card__tips" id="cv-personal-get-tips" aria-label="{{ __('lang.CV form get tips') }}" title="{{ __('lang.CV form get tips hint') }}" data-hint="{{ e(__('lang.CV form get tips hint')) }}">
                                <i class="fas fa-lightbulb" aria-hidden="true"></i>
                                <span>{{ __('lang.CV form get tips') }}</span>
                            </button>
                            <button type="button" class="cv-personal-card__toggle" id="cv-personal-card-toggle" aria-expanded="true" aria-controls="cv-personal-card-body" aria-label="{{ __('lang.CV form toggle personal') }}">
                                <span class="cv-personal-card__toggle-icon" aria-hidden="true"><i class="fas fa-chevron-up"></i></span>
                            </button>
                        </div>
                    </div>
                    <div class="cv-personal-card__body" id="cv-personal-card-body">
                        <div class="cv-personal-card__top">
                            <div class="cv-personal-card__col cv-personal-card__col--fields">
                                <div class="cv-field">
                                    <label class="cv-field__label" for="cv-input-name">{{ __('lang.CV form full name') }}</label>
                                    <input class="cv-field__input" type="text" id="cv-input-name" name="name" value="{{ $data['name'] ?? '' }}" placeholder="" autocomplete="name">
                                </div>
                                <div class="cv-field">
                                    <label class="cv-field__label" for="cv-input-job-title">{{ __('lang.CV form professional title') }}</label>
                                    <input class="cv-field__input" type="text" id="cv-input-job-title" name="job_title" value="{{ $data['job_title'] ?? '' }}" placeholder="{{ __('lang.CV form professional title placeholder') }}" autocomplete="organization-title">
                                </div>
                            </div>
                            <div class="cv-personal-card__col cv-personal-card__col--photo">
                                <span class="cv-field__label">{{ __('lang.CV form photo label') }}</span>
                                <div class="cv-photo-upload">
                                    <input type="file" id="photo-upload" name="photo" class="cv-photo-upload__input" accept="image/*" tabindex="-1" aria-label="{{ __('lang.CV form photo label') }}">
                                    <div class="cv-photo-upload__circle" role="button" tabindex="0" aria-label="{{ __('lang.CV form photo label') }}">
                                        <div id="photo-preview-container" class="cv-photo-upload__preview-wrap" hidden>
                                            <img id="photo-preview" src="" alt="">
                                            <button type="button" id="remove-photo" class="cv-photo-upload__remove" aria-label="{{ __('lang.CV form remove photo') }}">&times;</button>
                                        </div>
                                        <div class="cv-photo-upload__placeholder" id="photo-placeholder" aria-hidden="true">
                                            <i class="fas fa-camera"></i>
                                        </div>
                                    </div>
                                    <p class="cv-photo-upload__hint">{{ __('lang.CV form photo hint') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="cv-field cv-field--row">
                            <label class="cv-field__label" for="cv-input-email">{{ __('lang.CV form email label') }}</label>
                            <div class="cv-field__control">
                                <input class="cv-field__input" type="email" id="cv-input-email" name="email" value="{{ $data['email'] ?? '' }}" placeholder="{{ __('lang.CV form email placeholder') }}" autocomplete="email">
                                <span class="cv-field__grip" aria-hidden="true" title=""><i class="fas fa-arrows-up-down"></i></span>
                            </div>
                        </div>
                        <div class="cv-field cv-field--row">
                            <label class="cv-field__label" for="cv-input-location">{{ __('lang.CV form location') }}</label>
                            <div class="cv-field__control">
                                <input class="cv-field__input" type="text" id="cv-input-location" name="city" value="{{ $locationDefault }}" placeholder="{{ __('lang.CV form location placeholder') }}" autocomplete="address-level2">
                                <span class="cv-field__grip" aria-hidden="true"><i class="fas fa-arrows-up-down"></i></span>
                            </div>
                        </div>
                        <div class="cv-field cv-field--row">
                            <label class="cv-field__label" for="cv-input-phone">{{ __('lang.CV form phone label') }}</label>
                            <div class="cv-field__control">
                                <input class="cv-field__input" type="tel" id="cv-input-phone" name="phone" value="{{ $data['phone'] ?? '' }}" placeholder="{{ __('lang.CV form phone placeholder') }}" autocomplete="tel">
                                <span class="cv-field__grip" aria-hidden="true"><i class="fas fa-arrows-up-down"></i></span>
                            </div>
                        </div>
                        <div class="cv-field cv-field--summary">
                            <label class="cv-field__label" for="cv-input-summary">{{ __('lang.CV form professional summary') }}</label>
                            <textarea class="cv-field__input cv-field__input--textarea" id="cv-input-summary" name="summary" rows="4" placeholder="{{ __('lang.CV form professional summary placeholder') }}">{{ $data['summary'] ?? '' }}</textarea>
                        </div>
                    </div>
                </section>
                
                <!-- Add More Sections Button -->
                <button type="button" id="btn-add-sections" class="btn-add-entry" style="background: #17a2b8; margin-top: 20px;">
                    ➕ Add More Sections
                </button>
                
                <!-- Save CV Section -->
                <div class="form-group" style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #2563eb;">
                    <label for="cv-title">CV Title (Optional)</label>
                    <input type="text" id="cv-title" class="form-control" placeholder="e.g., My Professional CV, Updated CV 2024">
                    <small class="form-text text-muted">Give your CV a name to identify it later</small>
                </div>
                <div class="form-group">
                    <button type="button" id="btn-save-cv" class="btn-save-cv">💾 Save CV</button>
                    <div id="save-message" style="margin-top: 10px;"></div>
                </div>
            </form>
        </div>
        
        <!-- Right Panel: Preview -->
        <div class="builder-preview-panel">
            <div class="cv-preview-container" id="cv-preview">
                <div class="cv-pages-wrapper">
                    @if(isset($templateExists) && $templateExists)
                        @include('cv.templates.' . $templateSlug . '.template', ['data' => $data])
                    @else
                        <div style="padding: 40px; text-align: center; color: #999;">
                            <h3>Template Files Not Found</h3>
                            <p>The template folder and files need to be created in:</p>
                            <code style="display: block; margin: 20px 0; padding: 10px; background: #f5f5f5; border-radius: 4px;">
                                resources/views/cv/templates/{{ $templateSlug }}/
                            </code>
                            <p>Required files:</p>
                            <ul style="text-align: left; display: inline-block;">
                                <li>template.blade.php</li>
                                <li>config.json (optional - can use database config)</li>
                                <li>style.css (optional)</li>
                            </ul>
                            <p style="margin-top: 20px;">
                                <small>Note: Template was created in admin panel, but template files need to be added manually.</small>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        </div>
        
        <!-- Add More Sections Modal -->
        <div id="add-sections-modal" class="modal-overlay">
            <div class="add-sections-modal">
                <h3>Add More Sections to Your CV</h3>
                <p style="margin-bottom: 20px; color: #666;">Select the sections you want to add to your CV:</p>
                
                <div class="sections-list" id="sections-list">
                    <!-- Sections will be populated by JavaScript -->
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn-modal btn-modal-secondary" id="btn-close-modal">Cancel</button>
                    <button type="button" class="btn-modal btn-modal-primary" id="btn-add-selected-sections">Add Selected</button>
                </div>
            </div>
        </div>

        <!-- Apply template modal -->
        <div id="cv-template-modal" class="cv-template-modal" aria-hidden="true">
            <div class="cv-template-modal__backdrop" tabindex="-1"></div>
            <div class="cv-template-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="cv-template-modal-title">
                <div class="cv-template-modal__header">
                    <h2 class="cv-template-modal__title" id="cv-template-modal-title">{{ __('lang.CV apply design template') }}</h2>
                    <button type="button" class="cv-template-modal__close" id="cv-template-modal-close" aria-label="{{ __('lang.Close') }}">
                        <i class="fas fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>
                @php $cvModalTabsRtl = app()->getLocale() === 'ar'; @endphp
                <div class="cv-template-modal__body">
                    <div class="templates-showcase cv-template-modal__showcase">
                        <div class="cv-template-tabs-wrap{{ $cvModalTabsRtl ? ' cv-template-tabs-wrap--rtl' : '' }}">
                            <button type="button" class="cv-template-tabs__nav cv-template-tabs__nav--prev cv-template-tabs__nav--concealed" id="cv-template-modal-tabs-prev" aria-controls="cv-template-modal-tabs-scroll" aria-label="{{ __('lang.CV tabs scroll prev') }}" aria-hidden="true" disabled>
                                <i class="fas fa-chevron-left" aria-hidden="true"></i>
                            </button>
                            <div class="cv-template-tabs-scroll" id="cv-template-modal-tabs-scroll" dir="ltr">
                                <div class="cv-template-tabs{{ $cvModalTabsRtl ? ' cv-template-tabs--rtl' : '' }}" role="tablist" aria-label="{{ __('lang.CV Templates') }}">
                                    <button type="button" class="cv-template-tabs__btn is-active" role="tab" aria-selected="true" data-tab="all" id="cv-modal-tab-all">
                                        <i class="fas fa-table-cells" aria-hidden="true"></i>
                                        <span>{{ __('lang.All') }}</span>
                                    </button>
                                    <button type="button" class="cv-template-tabs__btn" role="tab" aria-selected="false" data-tab="popular" id="cv-modal-tab-popular">
                                        <i class="far fa-star" aria-hidden="true"></i>
                                        <span>{{ __('lang.CV filter Popular') }}</span>
                                    </button>
                                    <button type="button" class="cv-template-tabs__btn" role="tab" aria-selected="false" data-tab="simple" id="cv-modal-tab-simple">
                                        <i class="fas fa-briefcase" aria-hidden="true"></i>
                                        <span>{{ __('lang.CV filter Simple') }}</span>
                                    </button>
                                    <button type="button" class="cv-template-tabs__btn" role="tab" aria-selected="false" data-tab="modern" id="cv-modal-tab-modern">
                                        <i class="fas fa-cube" aria-hidden="true"></i>
                                        <span>{{ __('lang.CV filter Modern') }}</span>
                                    </button>
                                    <button type="button" class="cv-template-tabs__btn" role="tab" aria-selected="false" data-tab="creative" id="cv-modal-tab-creative">
                                        <i class="fas fa-palette" aria-hidden="true"></i>
                                        <span>{{ __('lang.CV filter Creative') }}</span>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="cv-template-tabs__nav cv-template-tabs__nav--next" id="cv-template-modal-tabs-next" aria-controls="cv-template-modal-tabs-scroll" aria-label="{{ __('lang.CV tabs scroll next') }}" disabled>
                                <i class="fas fa-chevron-right" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="templates-grid" id="cv-template-modal-grid" role="tabpanel" aria-labelledby="cv-modal-tab-all">
                            @forelse(($templateFolders ?? []) as $template)
                                @php
                                    $isCurrent = ($template['slug'] ?? '') === ($templateSlug ?? '');
                                    $builderHref = route('localized.cv.builder', ['lang' => app()->getLocale(), 'slug' => $template['slug']]);
                                @endphp
                                <article class="template-card template-card--clickable{{ $isCurrent ? ' template-card--current' : '' }}" data-tab="{{ $template['tab'] }}">
                                    <a href="{{ $builderHref }}" class="cv-template-modal__pick template-card__link" aria-label="{{ __('lang.Use Template') }}: {{ $template['name'] }}">
                                        <div class="template-preview">
                                            <div class="template-preview__frame">
                                                @if(!empty($template['preview_path']))
                                                    <img src="{{ $template['preview_path'] }}" alt="" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                    <div class="template-preview-placeholder" style="display: none;">Preview</div>
                                                @else
                                                    <div class="template-preview-placeholder">Preview</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="template-info">
                                            <h3 class="template-info__title">{{ $template['name'] }}</h3>
                                        </div>
                                    </a>
                                </article>
                            @empty
                                <div class="cv-templates-grid-empty cv-templates-grid-empty--initial">
                                    <div class="cv-templates-empty-banner" role="status" aria-live="polite">
                                        <img src="{{ asset('cv-templates/images/cv-templates-placeholder.png') }}" alt="" loading="lazy">
                                    </div>
                                </div>
                            @endforelse
                            <div class="cv-templates-tab-empty" id="cv-templates-modal-tab-empty" hidden>
                                <div class="cv-templates-empty-banner" role="status" aria-live="polite">
                                    <img src="{{ asset('cv-templates/images/cv-templates-placeholder.png') }}" alt="" loading="lazy">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unsaved changes modal -->
        <div id="cv-unsaved-modal" class="cv-unsaved-modal" aria-hidden="true">
            <div class="cv-unsaved-modal__backdrop"></div>
            <div class="cv-unsaved-modal__dialog" role="dialog" aria-modal="true" aria-label="Unsaved changes">
                <div class="cv-unsaved-modal__title">Unsaved changes</div>
                <div class="cv-unsaved-modal__desc">You have unsaved changes. Save before continuing?</div>
                <div class="cv-unsaved-modal__actions">
                    <button type="button" class="cv-unsaved-modal__btn cv-unsaved-modal__btn--ghost" id="cv-unsaved-cancel">Cancel</button>
                    <button type="button" class="cv-unsaved-modal__btn cv-unsaved-modal__btn--ghost" id="cv-unsaved-discard">Don't save</button>
                    <button type="button" class="cv-unsaved-modal__btn cv-unsaved-modal__btn--primary" id="cv-unsaved-save">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Bootstrap JS (Required for header dropdowns and mobile menu) -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    
    
    
    <script src="{{ asset('assets/js/script.js') }}"></script>
    
    <!-- CV Builder JavaScript -->
    <script src="{{ asset('cv/js/cv-builder.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize CV Builder with configuration
            if (typeof window.CVBuilder !== 'undefined') {
                window.CVBuilder.init({
                    templateSlug: '{{ $templateSlug }}',
                    routes: {
                        saved: '{{ route("localized.cv.saved", ["lang" => app()->getLocale()]) }}',
                        load: '{{ route("localized.cv.load", ["lang" => app()->getLocale(), "id" => "CV_ID"]) }}',
                        save: '{{ route("localized.cv.save", ["lang" => app()->getLocale()]) }}',
                        updateTitle: '{{ route("localized.cv.updateTitle", ["lang" => app()->getLocale(), "id" => "CV_ID"]) }}',
                        duplicateCV: '{{ route("localized.cv.duplicate", ["lang" => app()->getLocale(), "id" => "CV_ID"]) }}',
                        deleteCV: '{{ route("localized.cv.delete", ["lang" => app()->getLocale(), "id" => "CV_ID"]) }}',
                        exportPDF: '{{ route("localized.cv.export.current.pdf", ["lang" => app()->getLocale(), "slug" => $templateSlug]) }}'
                    },
                    csrfToken: '{{ csrf_token() }}'
                });
            }
        });
    </script>
@endsection

