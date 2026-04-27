@extends('site.layout')

@section('body_class', 'page-cv-templates')

@section('title', 'CV Templates - ' . __('lang.DEFAULT_TITLE'))

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

    <!-- Template base styles (needed for consistent header layout) -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet" />
    
    <!-- Theme styles -->
    <link rel="stylesheet" href="{{ asset('styles/theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('cv/css/cv-templates.css') }}" />
    <link rel="stylesheet" href="{{ asset('cv/css/cv-side-menu.css') }}" />
@endsection

@section('content')
    <div class="cv-gallery">
        <div class="container">
            @php $cvBreadcrumbRtl = app()->getLocale() === 'ar'; @endphp
            <div class="cv-gallery__layout">
                <aside class="cv-side-menu" aria-label="Quick menu">
                    <a class="cv-side-menu__item is-active" href="#" aria-current="page">
                        <span class="cv-side-menu__icon"><i class="fas fa-plus" aria-hidden="true"></i></span>
                        <span class="cv-side-menu__label">Create</span>
                    </a>
                    <a class="cv-side-menu__item" href="{{ route('localized.home', ['lang' => app()->getLocale()]) }}">
                        <span class="cv-side-menu__icon"><i class="fas fa-house" aria-hidden="true"></i></span>
                        <span class="cv-side-menu__label">Home</span>
                    </a>
                    <a class="cv-side-menu__item" href="{{ route('localized.cv.projects', ['lang' => app()->getLocale()]) }}">
                        <span class="cv-side-menu__icon"><i class="far fa-folder" aria-hidden="true"></i></span>
                        <span class="cv-side-menu__label">Projects</span>
                    </a>
                    <a class="cv-side-menu__item" href="{{ route('localized.cv.gallery', ['lang' => app()->getLocale()]) }}">
                        <span class="cv-side-menu__icon"><i class="fas fa-layer-group" aria-hidden="true"></i></span>
                        <span class="cv-side-menu__label">Templates</span>
                    </a>
                  
                    <a class="cv-side-menu__item" href="#" tabindex="-1" aria-disabled="true">
                        <span class="cv-side-menu__icon"><i class="fas fa-ellipsis" aria-hidden="true"></i></span>
                        <span class="cv-side-menu__label">More</span>
                    </a>
                </aside>
                
                <div class="templates-showcase">
                <div class="cv-template-tabs-wrap{{ $cvBreadcrumbRtl ? ' cv-template-tabs-wrap--rtl' : '' }}">
                    <button type="button" class="cv-template-tabs__nav cv-template-tabs__nav--prev cv-template-tabs__nav--concealed" id="cv-template-tabs-prev" aria-controls="cv-template-tabs-scroll" aria-label="{{ __('lang.CV tabs scroll prev') }}" aria-hidden="true" disabled>
                        <i class="fas fa-chevron-left" aria-hidden="true"></i>
                    </button>
                    <div class="cv-template-tabs-scroll" id="cv-template-tabs-scroll" dir="ltr">
                        <div class="cv-template-tabs{{ $cvBreadcrumbRtl ? ' cv-template-tabs--rtl' : '' }}" role="tablist" aria-label="{{ __('lang.CV Templates') }}">
                            <button type="button" class="cv-template-tabs__btn is-active" role="tab" aria-selected="true" data-tab="all" id="cv-tab-all">
                                <i class="fas fa-table-cells" aria-hidden="true"></i>
                                <span>{{ __('lang.All') }}</span>
                            </button>
                            <button type="button" class="cv-template-tabs__btn" role="tab" aria-selected="false" data-tab="popular" id="cv-tab-popular">
                                <i class="far fa-star" aria-hidden="true"></i>
                                <span>{{ __('lang.CV filter Popular') }}</span>
                            </button>
                            <button type="button" class="cv-template-tabs__btn" role="tab" aria-selected="false" data-tab="simple" id="cv-tab-simple">
                                <i class="fas fa-briefcase" aria-hidden="true"></i>
                                <span>{{ __('lang.CV filter Simple') }}</span>
                            </button>
                            <button type="button" class="cv-template-tabs__btn" role="tab" aria-selected="false" data-tab="modern" id="cv-tab-modern">
                                <i class="fas fa-cube" aria-hidden="true"></i>
                                <span>{{ __('lang.CV filter Modern') }}</span>
                            </button>
                            <button type="button" class="cv-template-tabs__btn" role="tab" aria-selected="false" data-tab="creative" id="cv-tab-creative">
                                <i class="fas fa-palette" aria-hidden="true"></i>
                                <span>{{ __('lang.CV filter Creative') }}</span>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="cv-template-tabs__nav cv-template-tabs__nav--next" id="cv-template-tabs-next" aria-controls="cv-template-tabs-scroll" aria-label="{{ __('lang.CV tabs scroll next') }}" disabled>
                        <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    </button>
                </div>
            <div class="templates-grid" id="cv-templates-grid" role="tabpanel" aria-labelledby="cv-tab-all">
                @forelse($templateFolders as $template)
                    <article class="template-card" data-tab="{{ $template['tab'] }}">
                        <div class="template-preview">
                            <div class="template-preview__frame template-preview__frame--overlay">
                            @if(!empty($template['preview_path']))
                                <img src="{{ $template['preview_path'] }}" alt="{{ $template['name'] }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="template-preview-placeholder" style="display: none;">Preview</div>
                            @else
                                <div class="template-preview-placeholder">Preview</div>
                            @endif
                                <div class="template-preview__actions-overlay">
                                    <div class="template-actions">
                                        <a href="{{ route('localized.cv.builder', ['lang' => app()->getLocale(), 'slug' => $template['slug']]) }}" class="btn-use-template">
                                            {{ __('lang.Use Template') }}
                                        </a>
                                        @if(!empty($template['preview_path']))
                                            <button class="btn-preview" 
                                                    type="button"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#previewModal"
                                                    data-preview-image="{{ $template['preview_path'] }}"
                                                    data-template-name="{{ $template['name'] }}"
                                                    data-template-slug="{{ $template['slug'] }}">
                                                {{ __('lang.Preview') }}
                                            </button>
                                        @else
                                            <button type="button" class="btn-preview" disabled title="No preview available">{{ __('lang.Preview') }}</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="template-info">
                            <h3 class="template-info__title">{{ $template['name'] }}</h3>
                        </div>
                    </article>
                @empty
                    <div class="cv-templates-grid-empty cv-templates-grid-empty--initial">
                        <div class="cv-templates-empty-banner" role="status" aria-live="polite">
                            <img src="{{ asset('cv-templates/images/cv-templates-placeholder.png') }}" alt="No templates available" loading="lazy">
                        </div>
                    </div>
                @endforelse

                <div class="cv-templates-tab-empty" id="cv-templates-tab-empty" hidden>
                    <div class="cv-templates-empty-banner" role="status" aria-live="polite">
                        <img src="{{ asset('cv-templates/images/cv-templates-placeholder.png') }}" alt="No templates in this category" loading="lazy">
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade preview-modal" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Template Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="previewModalImage" src="" alt="Template Preview" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a id="previewModalUseBtn" href="#" class="btn btn-use-from-modal">
                        <i class="fas fa-check me-2"></i>Use This Template
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Bootstrap JS (Required for header dropdowns and mobile menu) -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    
    {{-- Plugins --}}
    <script src="{{ asset('assets/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    
    {{-- GSAP --}}
    <script src="{{ asset('assets/js/gsap/gsap.js') }}"></script>
    <script src="{{ asset('assets/js/gsap/ScrollTrigger.js') }}"></script>
    <script src="{{ asset('assets/js/gsap/SplitText.js') }}"></script>
    
    {{-- Menu script --}}
    <script src="{{ asset('js/menu.js') }}"></script>
    
    <script src="{{ asset('assets/js/script.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Handle preview button click
            $('#previewModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget); // Button that triggered the modal
                const previewImage = button.data('preview-image');
                const templateName = button.data('template-name');
                const templateSlug = button.data('template-slug');
                
                // Update modal content
                const modal = $(this);
                modal.find('#previewModalLabel').text(templateName + ' - Preview');
                modal.find('#previewModalImage').attr('src', previewImage);
                modal.find('#previewModalImage').attr('alt', templateName + ' Preview');
                
                // Update "Use This Template" button link
                const useBtn = modal.find('#previewModalUseBtn');
                const useUrl = '{{ route("localized.cv.builder", ["lang" => app()->getLocale(), "slug" => "TEMPLATE_SLUG"]) }}'.replace('TEMPLATE_SLUG', templateSlug);
                useBtn.attr('href', useUrl);
            });
            
            // Handle image load error
            $('#previewModalImage').on('error', function() {
                const $img = $(this);
                // Only show error message if not already shown
                if ($img.siblings('.image-error-message').length === 0) {
                    $img.attr('src', '{{ asset("images/default.png") }}');
                    $img.after('<p class="text-muted mt-3 image-error-message">Preview image could not be loaded</p>');
                }
            });
            
            // Clear error message when modal is hidden
            $('#previewModal').on('hidden.bs.modal', function() {
                $(this).find('.image-error-message').remove();
            });

            // Template filter tabs
            var $tabBtns = $('.cv-template-tabs__btn');
            var $cards = $('#cv-templates-grid .template-card');
            var $tabEmpty = $('#cv-templates-tab-empty');

            function applyCvTabFilter(tab) {
                var visible = 0;
                if (tab === 'all') {
                    $cards.show();
                    visible = $cards.length;
                } else {
                    $cards.each(function() {
                        var $c = $(this);
                        var show = $c.data('tab') === tab;
                        $c.toggle(show);
                        if (show) visible++;
                    });
                }
                var hasInitialEmpty = $('#cv-templates-grid .cv-templates-grid-empty--initial').length > 0;
                var hasFilterableCards = $('#cv-templates-grid .template-card').length > 0;
                var shouldShowEmpty = !hasInitialEmpty && (visible === 0 && hasFilterableCards);
                $tabEmpty.prop('hidden', !shouldShowEmpty);
            }

            $tabBtns.on('click', function() {
                var tab = $(this).data('tab');
                $tabBtns.removeClass('is-active').attr('aria-selected', 'false');
                $(this).addClass('is-active').attr('aria-selected', 'true');
                $('#cv-templates-grid').attr('aria-labelledby', $(this).attr('id'));
                applyCvTabFilter(tab);
            });

            // Mobile: horizontal tab strip scroll + prev/next
            var $tabScroll = $('#cv-template-tabs-scroll');
            var $tabPrev = $('#cv-template-tabs-prev');
            var $tabNext = $('#cv-template-tabs-next');
            var tabScrollStep = 180;

            function updateCvTabScrollNav() {
                if (window.matchMedia('(min-width: 768px)').matches) {
                    $tabPrev.addClass('cv-template-tabs__nav--concealed').prop('disabled', true).attr('aria-hidden', 'true');
                    $tabNext.prop('disabled', true);
                    return;
                }
                var el = $tabScroll[0];
                if (!el) return;
                var max = el.scrollWidth - el.clientWidth;
                if (max <= 1) {
                    $tabPrev.addClass('cv-template-tabs__nav--concealed').prop('disabled', true).attr('aria-hidden', 'true');
                    $tabNext.prop('disabled', true);
                    return;
                }
                var sl = el.scrollLeft;
                var atStart = sl <= 1;
                if (atStart) {
                    $tabPrev.addClass('cv-template-tabs__nav--concealed').prop('disabled', true).attr('aria-hidden', 'true');
                } else {
                    $tabPrev.removeClass('cv-template-tabs__nav--concealed').prop('disabled', false).attr('aria-hidden', 'false');
                }
                $tabNext.prop('disabled', sl >= max - 1);
            }

            $tabPrev.on('click', function() {
                $tabScroll[0].scrollBy({ left: -tabScrollStep, behavior: 'smooth' });
            });
            $tabNext.on('click', function() {
                $tabScroll[0].scrollBy({ left: tabScrollStep, behavior: 'smooth' });
            });
            $tabScroll.on('scroll', updateCvTabScrollNav);
            $(window).on('resize', updateCvTabScrollNav);
            updateCvTabScrollNav();
        });
    </script>
@endsection