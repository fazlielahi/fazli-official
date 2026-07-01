@extends('site.layout')

@section('body_class', 'page-cv-builder')

@section('title', 'Resume builder - ' . ($config['name'] ?? 'Template'))

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

    <!-- Rich text editor (Quill) -->
    <link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
    
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
        <header class="cv-builder-toolbar" aria-label="Resume builder tools">
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
                    <label class="cv-font-picker" for="cv-font-family-select">
                        <i class="fas fa-font" aria-hidden="true"></i>
                        <span class="cv-font-picker__label">Font</span>
                        <select id="cv-font-family-select" class="cv-font-picker__select">
                            <option value="classic">Classic</option>
                            <option value="georgia">Georgia</option>
                            <option value="arial">Arial</option>
                            <option value="inter">Inter</option>
                            <option value="poppins">Poppins</option>
                            <option value="roboto">Roboto</option>
                        </select>
                    </label>
                    <span class="cv-builder-toolbar__tab cv-builder-toolbar__tab--static cv-soon" tabindex="-1" data-tooltip="Coming soon">
                        <i class="fas fa-wand-magic-sparkles" aria-hidden="true"></i>
                        <span>AI Tools</span>
                    </span>
                </nav>
                
                <div class="cv-builder-toolbar__actions">
                    <div class="cv-builder-toolbar__saved">
                        @auth
                            <div class="cv-resume-dropdown" id="cv-resume-dropdown">
                                <button type="button" class="cv-resume-dropdown__trigger" id="cv-resume-trigger" aria-haspopup="dialog" aria-expanded="false">
                                    <span class="cv-resume-dropdown__trigger-text" id="cv-resume-trigger-text">Resume</span>
                                    <i class="fas fa-chevron-down cv-resume-dropdown__trigger-icon" aria-hidden="true"></i>
                                </button>

                                <select id="load-cv-select" class="cv-builder-toolbar__select cv-resume-dropdown__native" aria-hidden="true" tabindex="-1">
                                    <option value="">-- MY RESUMES --</option>
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
                                    <div class="cv-resume-dropdown__feedback" id="cv-resume-dropdown-feedback" role="status" aria-live="polite" hidden aria-hidden="true"></div>
                                    <div class="cv-resume-dropdown__list" id="cv-resume-list">
                                        <div class="cv-resume-dropdown__empty">No resumes yet</div>
                                    </div>
                                    <div class="cv-resume-dropdown__footer cv-resume-dropdown__footer--split" id="cv-resume-loadall-footer" hidden>
                                        <a class="cv-resume-dropdown__add" href="{{ route('localized.cv.projects', ['lang' => app()->getLocale()]) }}">
                                            <i class="fas fa-folder-open cv-resume-dropdown__add-icon" aria-hidden="true"></i>
                                            <span>Load All</span>
                                        </a>
                                        <a class="cv-resume-dropdown__add cv-resume-dropdown__add--sub" href="{{ route('localized.cv.trash', ['lang' => app()->getLocale()]) }}">
                                            <i class="far fa-trash-can cv-resume-dropdown__add-icon" aria-hidden="true"></i>
                                            <span>Trash</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <button type="button" class="cv-resume-dropdown__trigger" id="cv-guest-save-trigger">
                                <span class="cv-resume-dropdown__trigger-text">Save resume</span>
                                <i class="fas fa-floppy-disk cv-resume-dropdown__trigger-icon" aria-hidden="true"></i>
                            </button>
                        @endauth
                    </div>
                    <div class="cv-builder-toolbar__import-wrap cv-soon" data-tooltip="Coming soon">
                        <button type="button" id="cv-import-resume-trigger-toolbar" class="cv-builder-toolbar__import" disabled aria-disabled="true" tabindex="-1">
                            <i class="fas fa-cloud-arrow-up cv-builder-toolbar__import-icon" aria-hidden="true"></i>
                            <span class="cv-builder-toolbar__import-text">Import Resume</span>
                        </button>
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
                    $resumeShowEmail = ! array_key_exists('resume_show_email', $data ?? []) ? true : filter_var($data['resume_show_email'], FILTER_VALIDATE_BOOLEAN);
                    $resumeShowPhone = ! array_key_exists('resume_show_phone', $data ?? []) ? true : filter_var($data['resume_show_phone'], FILTER_VALIDATE_BOOLEAN);
                    $resumeShowLocation = ! array_key_exists('resume_show_location', $data ?? []) ? true : filter_var($data['resume_show_location'], FILTER_VALIDATE_BOOLEAN);
                @endphp
                <!-- Personal details: view mode -->
                <section class="cv-personal-view-card" id="cv-personal-view" aria-label="Personal details">
                    <div class="cv-personal-view-card__inner">
                        <div class="cv-personal-view-card__main">
                            <div class="cv-personal-view-card__name" id="cv-personal-view-name">Your Name</div>
                            <div class="cv-personal-view-card__title" id="cv-personal-view-title">Professional title</div>
                            <div class="cv-personal-view-card__meta">
                                <div class="cv-personal-view-card__meta-item" id="cv-personal-view-email-wrap" hidden>
                                    <i class="far fa-envelope" aria-hidden="true"></i>
                                    <span id="cv-personal-view-email" class="cv-personal-view-card__meta-text"></span>
                                    <div class="cv-personal-view-card__hidden-tooltip" role="tooltip" aria-hidden="true">
                                        <p class="cv-personal-view-card__hidden-tooltip__msg">This field is hidden and won&rsquo;t be shown in the resume.</p>
                                        <button type="button" class="cv-personal-view-card__unhide" id="cv-personal-view-email-unhide" aria-label="Unhide email in resume and open editor">Unhide</button>
                                    </div>
                                </div>
                                <div class="cv-personal-view-card__meta-item" id="cv-personal-view-phone-wrap" hidden>
                                    <i class="fas fa-phone" aria-hidden="true"></i>
                                    <span id="cv-personal-view-phone" class="cv-personal-view-card__meta-text"></span>
                                    <div class="cv-personal-view-card__hidden-tooltip" role="tooltip" aria-hidden="true">
                                        <p class="cv-personal-view-card__hidden-tooltip__msg">This field is hidden and won&rsquo;t be shown in the resume.</p>
                                        <button type="button" class="cv-personal-view-card__unhide" id="cv-personal-view-phone-unhide" aria-label="Unhide phone in resume and open editor">Unhide</button>
                                    </div>
                                </div>
                                <div class="cv-personal-view-card__meta-item" id="cv-personal-view-location-wrap" hidden>
                                    <i class="fas fa-location-dot" aria-hidden="true"></i>
                                    <span id="cv-personal-view-location" class="cv-personal-view-card__meta-text"></span>
                                    <div class="cv-personal-view-card__hidden-tooltip" role="tooltip" aria-hidden="true">
                                        <p class="cv-personal-view-card__hidden-tooltip__msg">This field is hidden and won&rsquo;t be shown in the resume.</p>
                                        <button type="button" class="cv-personal-view-card__unhide" id="cv-personal-view-location-unhide" aria-label="Unhide location in resume and open editor">Unhide</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cv-personal-view-card__photo">
                            <div class="cv-personal-view-card__photo-circle" id="cv-personal-view-photo">
                                <img id="cv-personal-view-photo-img" alt="" hidden>
                                <i class="fas fa-camera" id="cv-personal-view-photo-icon" aria-hidden="true"></i>
                            </div>
                        </div>
                        <button type="button" class="cv-personal-view-card__edit" id="cv-personal-view-edit" aria-label="Edit personal details">
                            <i class="fas fa-pen" aria-hidden="true"></i>
                        </button>
                    </div>
                </section>

                <!-- Personal details: edit mode -->
                <section class="cv-personal-card is-hidden" id="cv-personal-edit" aria-labelledby="cv-personal-card-title">
                    <div class="cv-personal-card__header">
                        <div class="cv-personal-card__header-start">
                            <button type="button" class="cv-personal-card__toggle" id="cv-personal-card-toggle" aria-expanded="true" aria-controls="cv-personal-card-body" aria-label="{{ __('lang.CV form toggle personal') }}">
                                <span class="cv-personal-card__toggle-icon" aria-hidden="true"><i class="fas fa-chevron-up"></i></span>
                            </button>
                            <h2 class="cv-personal-card__title" id="cv-personal-card-title">{{ __('lang.CV form personal section title') }}</h2>
                        </div>
                        <div class="cv-personal-card__header-actions">
                            {{-- Manual save UI removed: drafts autosave locally; account save happens on login/download flow --}}
                        </div>
                    </div>
                    <div class="cv-personal-card__body" id="cv-personal-card-body">
                        <div class="cv-personal-card__top">
                            <div class="cv-personal-card__col cv-personal-card__col--fields">
                                <div class="cv-field">
                                    <label class="cv-field__label" for="cv-input-name">{{ __('lang.CV form full name') }}</label>
                                    <input class="cv-field__input" type="text" id="cv-input-name" name="name" value="{{ $data['name'] ?? '' }}" placeholder=" " autocomplete="name">
                                </div>
                                <div class="cv-field">
                                    <label class="cv-field__label" for="cv-input-job-title">{{ __('lang.CV form professional title') }}</label>
                                    <input class="cv-field__input" type="text" id="cv-input-job-title" name="job_title" value="{{ $data['job_title'] ?? '' }}" placeholder=" " data-placeholder="{{ __('lang.CV form professional title placeholder') }}" autocomplete="organization-title">
                                </div>
                            </div>
                            <div class="cv-personal-card__col cv-personal-card__col--photo">
                                <span class="cv-field__label">{{ __('lang.CV form photo label') }}</span>
                                <div class="cv-photo-upload">
                                    <input type="file" id="photo-upload" name="photo" class="cv-photo-upload__input" accept="image/*" tabindex="-1" aria-label="{{ __('lang.CV form photo label') }}">
                                    <div class="cv-photo-upload__circle" role="button" tabindex="0" aria-label="{{ __('lang.CV form photo label') }}">
                                        <div id="photo-preview-container" class="cv-photo-upload__preview-wrap" hidden>
                                            <img id="photo-preview" src="" alt="">
                                        </div>
                                        <button type="button" id="remove-photo" class="cv-photo-upload__remove" hidden aria-label="{{ __('lang.CV form remove photo') }}">&times;</button>
                                        <div class="cv-photo-upload__placeholder" id="photo-placeholder" aria-hidden="true">
                                            <i class="fas fa-camera"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="cv-personal-card__extra">
                            <button type="button" class="cv-personal-card__see-more" id="cv-personal-extra-expand" aria-expanded="false" aria-controls="cv-personal-extra-panel">
                                {{ __('lang.CV form see more fields') }}
                            </button>
                            <div class="cv-personal-card__extra-panel" id="cv-personal-extra-panel" hidden>
                                <div class="cv-field cv-field--row">
                                    <label class="cv-field__label" for="cv-input-email">{{ __('lang.CV form email label') }}</label>
                                    <div class="cv-field__control cv-field__control--with-resume-toggle">
                                        <input class="cv-field__input" type="email" id="cv-input-email" name="email" value="{{ $data['email'] ?? '' }}" placeholder=" " data-placeholder="{{ __('lang.CV form email placeholder') }}" autocomplete="email">
                                        <input type="hidden" id="cv-resume-show-email" value="{{ $resumeShowEmail ? '1' : '0' }}" autocomplete="off" aria-hidden="true">
                                        <button type="button" class="cv-field__resume-visibility-toggle" id="cv-toggle-resume-email" aria-controls="cv-resume-show-email" aria-pressed="{{ $resumeShowEmail ? 'true' : 'false' }}" title="{{ $resumeShowEmail ? 'Shown in resume preview' : 'Hidden from resume preview' }}" aria-label="{{ $resumeShowEmail ? 'Email shown in resume preview. Click to hide.' : 'Email hidden from resume preview. Click to show.' }}">
                                            <i class="fas {{ $resumeShowEmail ? 'fa-eye' : 'fa-eye-slash' }}" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="cv-field cv-field--row">
                                    <label class="cv-field__label" for="cv-input-location">{{ __('lang.CV form location') }}</label>
                                    <div class="cv-field__control cv-field__control--with-resume-toggle">
                                        <input class="cv-field__input" type="text" id="cv-input-location" name="city" value="{{ $locationDefault }}" placeholder=" " data-placeholder="{{ __('lang.CV form location placeholder') }}" autocomplete="address-level2">
                                        <input type="hidden" id="cv-resume-show-location" value="{{ $resumeShowLocation ? '1' : '0' }}" autocomplete="off" aria-hidden="true">
                                        <button type="button" class="cv-field__resume-visibility-toggle" id="cv-toggle-resume-location" aria-controls="cv-resume-show-location" aria-pressed="{{ $resumeShowLocation ? 'true' : 'false' }}" title="{{ $resumeShowLocation ? 'Shown in resume preview' : 'Hidden from resume preview' }}" aria-label="{{ $resumeShowLocation ? 'Location shown in resume preview. Click to hide.' : 'Location hidden from resume preview. Click to show.' }}">
                                            <i class="fas {{ $resumeShowLocation ? 'fa-eye' : 'fa-eye-slash' }}" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="cv-field cv-field--row">
                                    <label class="cv-field__label" for="cv-input-phone">{{ __('lang.CV form phone label') }}</label>
                                    <div class="cv-field__control cv-field__control--with-resume-toggle">
                                        <input class="cv-field__input" type="tel" id="cv-input-phone" name="phone" value="{{ $data['phone'] ?? '' }}" placeholder=" " data-placeholder="{{ __('lang.CV form phone placeholder') }}" autocomplete="tel">
                                        <input type="hidden" id="cv-resume-show-phone" value="{{ $resumeShowPhone ? '1' : '0' }}" autocomplete="off" aria-hidden="true">
                                        <button type="button" class="cv-field__resume-visibility-toggle" id="cv-toggle-resume-phone" aria-controls="cv-resume-show-phone" aria-pressed="{{ $resumeShowPhone ? 'true' : 'false' }}" title="{{ $resumeShowPhone ? 'Shown in resume preview' : 'Hidden from resume preview' }}" aria-label="{{ $resumeShowPhone ? 'Phone shown in resume preview. Click to hide.' : 'Phone hidden from resume preview. Click to show.' }}">
                                            <i class="fas {{ $resumeShowPhone ? 'fa-eye' : 'fa-eye-slash' }}" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="cv-field cv-field--summary">
                                    <label class="cv-field__label" for="cv-input-summary">{{ __('lang.CV form professional summary') }}</label>
                                    <textarea class="cv-field__input cv-field__input--textarea" id="cv-input-summary" name="summary" rows="4" placeholder=" " data-placeholder="{{ __('lang.CV form professional summary placeholder') }}">{{ $data['summary'] ?? '' }}</textarea>
                                </div>
                                <div class="cv-personal-card__extra-footer">
                                    <button type="button" class="cv-personal-card__view-less" id="cv-personal-extra-collapse" aria-controls="cv-personal-extra-panel">
                                        {{ __('lang.CV form view less') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cv-personal-card__footer">
                        <button type="button" class="cv-personal-card__done cv-personal-card__done--cta" id="cv-personal-done">
                            <i class="fas fa-check" aria-hidden="true"></i>
                            <span>Done</span>
                        </button>
                    </div>
                </section>
                
                <!-- Add More Sections Button -->
                <button type="button" id="btn-add-sections" class="btn-add-entry" style="margin-top: 20px;">
                    <span class="btn-add-content__icon" aria-hidden="true">+</span>
                    <span class="btn-add-content__text">Add Content</span>
                </button>
                
                <!-- Keep a hidden title input for JS save/load logic (title UI moved to toolbar popover) -->
                <input type="text" id="cv-title" class="form-control" hidden aria-hidden="true">
                <div id="save-message" hidden aria-hidden="true"></div>
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
                <div class="add-sections-modal__header">
                    <div class="add-sections-modal__heading">
                        <h3>Add More Sections to Your Resume</h3>
                        <p class="add-sections-modal__subtitle">Select the sections you want to add to your resume:</p>
                    </div>
                    <button type="button" class="add-sections-modal__close" id="add-sections-modal-close" aria-label="Close">
                        <i class="fas fa-xmark" aria-hidden="true"></i>
                    </button>
                    <div class="add-sections-modal__quickstart cv-soon" aria-label="Quick start" data-tooltip="Coming soon">
                        <span class="add-sections-modal__quickstart-label">Quick start:</span>
                        <button type="button" class="add-sections-modal__quickstart-btn" id="cv-import-resume-trigger" disabled aria-disabled="true" tabindex="-1">
                            <i class="fas fa-cloud-arrow-up" aria-hidden="true"></i>
                            <span>Import Resume</span>
                        </button>
                        <input
                            type="file"
                            id="cv-import-resume-input"
                            accept=".pdf,.docx,image/*"
                            hidden
                            aria-hidden="true"
                            tabindex="-1"
                        >
                    </div>
                </div>
                
                <div class="sections-list" id="sections-list">
                    <!-- Sections will be populated by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Delete section confirmation modal -->
        <div class="cv-delete-section-modal" id="cv-delete-section-modal" aria-hidden="true" hidden>
            <div class="cv-delete-section-modal__backdrop" id="cv-delete-section-backdrop"></div>
            <div class="cv-delete-section-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="cv-delete-section-title">
                <button type="button" class="cv-delete-section-modal__close" id="cv-delete-section-close" aria-label="Close">
                    <i class="fas fa-xmark" aria-hidden="true"></i>
                </button>
                <div class="cv-delete-section-modal__title" id="cv-delete-section-title">Delete section?</div>
                <div class="cv-delete-section-modal__desc">
                    This will permanently delete this section and all its entries.<br>
                    This action can't be undone.
                </div>
                <label class="cv-delete-section-modal__check">
                    <input type="checkbox" id="cv-delete-section-confirm-check">
                    <span>I understand, continue.</span>
                </label>
                <div class="cv-delete-section-modal__actions">
                    <button type="button" class="cv-delete-section-modal__btn cv-delete-section-modal__btn--cancel" id="cv-delete-section-cancel">Cancel</button>
                    <button type="button" class="cv-delete-section-modal__btn cv-delete-section-modal__btn--danger" id="cv-delete-section-confirm" disabled aria-disabled="true">Delete Section</button>
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
                <div class="cv-unsaved-modal__desc" id="cv-unsaved-desc">You have changes that are only stored in this browser. Sign in to keep them in your account, discard them, or stay here.</div>
                <div class="cv-unsaved-modal__actions">
                    <button type="button" class="cv-unsaved-modal__btn cv-unsaved-modal__btn--ghost" id="cv-unsaved-cancel">Cancel</button>
                    <button type="button" class="cv-unsaved-modal__btn cv-unsaved-modal__btn--ghost" id="cv-unsaved-discard">Don't save</button>
                    <button type="button" class="cv-unsaved-modal__btn cv-unsaved-modal__btn--primary" id="cv-unsaved-save">Login &amp; save</button>
                </div>
            </div>
        </div>

        <!-- Auth required modal -->
        <div id="cv-auth-required-modal" class="cv-unsaved-modal" aria-hidden="true">
            <div class="cv-unsaved-modal__backdrop" id="cv-auth-required-backdrop"></div>
            <div class="cv-unsaved-modal__dialog" role="dialog" aria-modal="true" aria-label="Login required">
                <div class="cv-unsaved-modal__title" id="cv-auth-required-title">Login required</div>
                <div class="cv-unsaved-modal__desc" id="cv-auth-required-desc">Sign in to download your PDF and save this resume to your account.</div>
                <div class="cv-unsaved-modal__actions">
                    <button type="button" class="cv-unsaved-modal__btn cv-unsaved-modal__btn--ghost" id="cv-auth-required-cancel">Cancel</button>
                    <button type="button" class="cv-unsaved-modal__btn cv-unsaved-modal__btn--primary" id="cv-auth-required-login">Login</button>
                </div>
            </div>
        </div>

        <!-- Draft found modal (guest restore prompt) -->
        <div id="cv-draft-found-modal" class="cv-unsaved-modal cv-draft-found-modal" aria-hidden="true">
            <div class="cv-unsaved-modal__backdrop" id="cv-draft-found-backdrop"></div>
            <div class="cv-unsaved-modal__dialog cv-draft-found-modal__dialog" role="dialog" aria-modal="true" aria-label="Draft found">
                <div class="cv-draft-found-modal__header">
                    <div class="cv-draft-found-modal__badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15V8a2 2 0 0 0-2-2h-5l-2-2H5a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h9" />
                            <path d="M16 19h6" />
                            <path d="M19 16v6" />
                        </svg>
                    </div>
                    <div class="cv-draft-found-modal__heading">
                        <div class="cv-unsaved-modal__title">Draft found</div>
                        <div class="cv-unsaved-modal__desc" id="cv-draft-found-desc">We found an unsaved draft. What would you like to do?</div>
                    </div>
                </div>

                <div class="cv-draft-found-modal__grid" role="group" aria-label="Draft actions">
                    <button type="button" class="cv-draft-found-modal__action cv-draft-found-modal__action--primary" id="cv-draft-found-continue">
                        <span class="cv-draft-found-modal__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 12a8 8 0 1 1-2.34-5.66" />
                                <path d="M20 4v6h-6" />
                            </svg>
                        </span>
                        <span class="cv-draft-found-modal__label">Continue draft</span>
                    </button>

                    <button type="button" class="cv-draft-found-modal__action" id="cv-draft-found-startnew">
                        <span class="cv-draft-found-modal__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <path d="M14 2v6h6" />
                                <path d="M12 18v-6" />
                                <path d="M9 15h6" />
                            </svg>
                        </span>
                        <span class="cv-draft-found-modal__label">Start new</span>
                    </button>

                    <button type="button" class="cv-draft-found-modal__action" id="cv-draft-found-login-save">
                        <span class="cv-draft-found-modal__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2a5 5 0 0 0-5 5v4" />
                                <rect x="4" y="11" width="16" height="11" rx="2" />
                                <path d="M8 16h8" />
                            </svg>
                        </span>
                        <span class="cv-draft-found-modal__label">Login to save</span>
                    </button>
                </div>

                <button type="button" class="cv-draft-found-modal__discard" id="cv-draft-found-discard">
                    <span class="cv-draft-found-modal__discard-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18" />
                            <path d="M8 6V4h8v2" />
                            <path d="M19 6l-1 14H6L5 6" />
                            <path d="M10 11v6" />
                            <path d="M14 11v6" />
                        </svg>
                    </span>
                    Discard draft
                </button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Bootstrap JS (Required for header dropdowns and mobile menu) -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    
    
    
    <script src="{{ asset('assets/js/script.js') }}"></script>
    
    <!-- Rich text editor (Quill) + sanitizer (DOMPurify) -->
    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dompurify@3.0.9/dist/purify.min.js"></script>

    <!-- CV Builder JavaScript -->
    <script src="{{ asset('cv/js/cv-builder.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize CV Builder with configuration
            if (typeof window.CVBuilder !== 'undefined') {
                window.CVBuilder.init({
                    templateSlug: '{{ $templateSlug }}',
                    isAuthenticated: @json(auth()->check()),
                    routes: {
                        saved: '{{ route("localized.cv.saved", ["lang" => app()->getLocale()]) }}',
                        load: '{{ route("localized.cv.load", ["lang" => app()->getLocale(), "id" => "CV_ID"]) }}',
                        save: '{{ route("localized.cv.save", ["lang" => app()->getLocale()]) }}',
                        login: '{{ route("localized.login", ["lang" => app()->getLocale()]) }}',
                        importUpload: '{{ route("localized.cv.import.upload", ["lang" => app()->getLocale()]) }}',
                        importExtract: '{{ route("localized.cv.import.extract", ["lang" => app()->getLocale(), "importId" => "IMPORT_ID"]) }}',
                        importParse: '{{ route("localized.cv.import.parse", ["lang" => app()->getLocale(), "importId" => "IMPORT_ID"]) }}',
                        updateTitle: '{{ route("localized.cv.updateTitle", ["lang" => app()->getLocale(), "id" => "CV_ID"]) }}',
                        duplicateCV: '{{ route("localized.cv.duplicate", ["lang" => app()->getLocale(), "id" => "CV_ID"]) }}',
                        deleteCV: '{{ route("localized.cv.delete", ["lang" => app()->getLocale(), "id" => "CV_ID"]) }}',
                        exportPDF: '{{ route("localized.cv.export.current.pdf", ["lang" => app()->getLocale(), "slug" => $templateSlug]) }}'
                    },
                    csrfToken: '{{ csrf_token() }}'
                });
            }

            const hasValue = (el) => {
                if (!el) return false;
                if (el.tagName === 'TEXTAREA') return (el.value || '').trim().length > 0;
                return (el.value || '').length > 0;
            };

            const wireFloatingPlaceholder = (el, hint) => {
                const resolvedHint = (hint || '').trim();
                if (!resolvedHint) return;

                // Keep placeholder blank-space so :placeholder-shown works.
                if (!hasValue(el)) el.setAttribute('placeholder', ' ');

                el.addEventListener('focus', () => {
                    el.setAttribute('placeholder', resolvedHint);
                });

                el.addEventListener('blur', () => {
                    if (!hasValue(el)) el.setAttribute('placeholder', ' ');
                });
            };

            const applyFloatingUx = (root = document) => {
                // CV personal/contact fields (explicit data-placeholder)
                root.querySelectorAll('.cv-field__input[data-placeholder]').forEach((el) => {
                    wireFloatingPlaceholder(el, el.getAttribute('data-placeholder'));
                });

                // Dynamic section editor fields (.entry-container .form-group)
                root.querySelectorAll('.entry-container .form-group').forEach((group) => {
                    const input = group.querySelector('input:not([type="hidden"]), textarea');
                    const label = group.querySelector('label');
                    if (!input || !label) return;

                    const hint = input.getAttribute('data-placeholder')
                        || input.getAttribute('placeholder')
                        || label.textContent
                        || '';

                    // Ensure :placeholder-shown works and label can sit "inside"
                    if (!input.hasAttribute('data-placeholder')) {
                        input.setAttribute('data-placeholder', (hint || '').trim());
                    }

                    wireFloatingPlaceholder(input, hint);
                });
            };

            applyFloatingUx(document);

            // Sections are added dynamically; keep applying on new nodes.
            const observer = new MutationObserver((mutations) => {
                for (const m of mutations) {
                    for (const node of m.addedNodes || []) {
                        if (!(node instanceof HTMLElement)) continue;
                        applyFloatingUx(node);
                    }
                }
            });
            observer.observe(document.body, { childList: true, subtree: true });
        });
    </script>
@endsection

