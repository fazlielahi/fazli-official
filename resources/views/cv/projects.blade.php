@extends('site.layout')

@section('body_class', 'page-cv-projects')

@section('title', 'Projects - ' . __('lang.DEFAULT_TITLE'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/theme.css') }}" />

    <!-- Template base styles (needed for consistent header layout) -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />

    <link rel="stylesheet" href="{{ asset('cv/css/cv-side-menu.css') }}" />
    <link rel="stylesheet" href="{{ asset('cv/css/cv-projects.css') }}" />
@endsection

@section('content')
    <div class="cv-projects">
        <div class="container">
            <aside class="cv-side-menu" aria-label="Quick menu">
                <a class="cv-side-menu__item" href="{{ route('localized.cv.gallery', ['lang' => app()->getLocale()]) }}">
                    <span class="cv-side-menu__icon"><i class="fas fa-plus" aria-hidden="true"></i></span>
                    <span class="cv-side-menu__label">Create</span>
                </a>
                <a class="cv-side-menu__item" href="{{ route('localized.home', ['lang' => app()->getLocale()]) }}">
                    <span class="cv-side-menu__icon"><i class="fas fa-house" aria-hidden="true"></i></span>
                    <span class="cv-side-menu__label">Home</span>
                </a>
                <a class="cv-side-menu__item is-active" href="{{ route('localized.cv.projects', ['lang' => app()->getLocale()]) }}" aria-current="page">
                    <span class="cv-side-menu__icon"><i class="far fa-folder" aria-hidden="true"></i></span>
                    <span class="cv-side-menu__label">Projects</span>
                </a>
                <a class="cv-side-menu__item" href="{{ route('localized.cv.gallery', ['lang' => app()->getLocale()]) }}">
                    <span class="cv-side-menu__icon"><i class="fas fa-layer-group" aria-hidden="true"></i></span>
                    <span class="cv-side-menu__label">Templates</span>
                </a>
                <a class="cv-side-menu__item" href="#" tabindex="-1" aria-disabled="true">
                    <span class="cv-side-menu__icon"><i class="fas fa-crown" aria-hidden="true"></i></span>
                    <span class="cv-side-menu__label">Brand</span>
                </a>
                <a class="cv-side-menu__item" href="#" tabindex="-1" aria-disabled="true">
                    <span class="cv-side-menu__icon"><i class="fas fa-wand-magic-sparkles" aria-hidden="true"></i></span>
                    <span class="cv-side-menu__label">Canva AI</span>
                </a>
                <a class="cv-side-menu__item" href="#" tabindex="-1" aria-disabled="true">
                    <span class="cv-side-menu__icon"><i class="fas fa-ellipsis" aria-hidden="true"></i></span>
                    <span class="cv-side-menu__label">More</span>
                </a>
            </aside>

            <section class="cv-projects-panel" aria-label="Projects">
                <div class="cv-projects-panel__tabs" role="tablist" aria-label="Project filters">
                    <button type="button" class="cv-projects-tab is-active" data-tab="all" role="tab" aria-selected="true">
                        <i class="fas fa-table-cells" aria-hidden="true"></i>
                        <span>All</span>
                    </button>
                    <button type="button" class="cv-projects-tab" data-tab="resumes" role="tab" aria-selected="false">
                        <i class="fas fa-file-lines" aria-hidden="true"></i>
                        <span>Resumes</span>
                    </button>
                    <button type="button" class="cv-projects-tab cv-projects-tab--soon" data-tab="cover" role="tab" aria-selected="false" data-tooltip="Coming soon">
                        <i class="far fa-envelope" aria-hidden="true"></i>
                        <span>Cover letters</span>
                    </button>
                    <button type="button" class="cv-projects-tab cv-projects-tab--soon" data-tab="more" role="tab" aria-selected="false" data-tooltip="Coming soon">
                        <i class="fas fa-ellipsis" aria-hidden="true"></i>
                        <span>More</span>
                    </button>
                </div>

                <div class="cv-projects-panel__body">
                    <div class="cv-projects-pane" data-pane="all">
                        <div class="cv-projects-grid">
                            @forelse($cvs as $cv)
                                <article class="cv-project-card">
                                    <div class="cv-project-card__meta">
                                        <div class="cv-project-card__title">{{ $cv->title ?? 'Untitled CV' }}</div>
                                        <div class="cv-project-card__sub">Updated {{ optional($cv->updated_at)->format('M d, Y') }}</div>
                                    </div>
                                    <div class="cv-project-card__actions">
                                        <a class="cv-project-card__btn" href="{{ route('localized.cv.builder', ['lang' => app()->getLocale(), 'slug' => $cv->template_slug]) }}">Open</a>
                                    </div>
                                </article>
                            @empty
                                <div class="cv-projects-empty">
                                    <img src="{{ asset('cv-templates/images/cv-templates-placeholder.png') }}" alt="No projects yet" loading="lazy">
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="cv-projects-pane" data-pane="resumes" hidden>
                        <div class="cv-projects-grid">
                            @forelse($cvs as $cv)
                                <article class="cv-project-card">
                                    <div class="cv-project-card__meta">
                                        <div class="cv-project-card__title">{{ $cv->title ?? 'Untitled CV' }}</div>
                                        <div class="cv-project-card__sub">Updated {{ optional($cv->updated_at)->format('M d, Y') }}</div>
                                    </div>
                                    <div class="cv-project-card__actions">
                                        <a class="cv-project-card__btn" href="{{ route('localized.cv.builder', ['lang' => app()->getLocale(), 'slug' => $cv->template_slug]) }}">Open</a>
                                    </div>
                                </article>
                            @empty
                                <div class="cv-projects-empty">
                                    <img src="{{ asset('cv-templates/images/cv-templates-placeholder.png') }}" alt="No resumes yet" loading="lazy">
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="cv-projects-pane" data-pane="cover" hidden>
                        <div class="cv-projects-empty">
                            <img src="{{ asset('cv-templates/images/cv-templates-placeholder.png') }}" alt="Coming soon" loading="lazy">
                        </div>
                    </div>

                    <div class="cv-projects-pane" data-pane="more" hidden>
                        <div class="cv-projects-empty">
                            <img src="{{ asset('cv-templates/images/cv-templates-placeholder.png') }}" alt="Coming soon" loading="lazy">
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        (function () {
            const tabs = document.querySelectorAll('.cv-projects-tab');
            const panes = document.querySelectorAll('.cv-projects-pane');

            function setActive(tabKey) {
                tabs.forEach(t => {
                    const isActive = t.dataset.tab === tabKey;
                    t.classList.toggle('is-active', isActive);
                    t.setAttribute('aria-selected', isActive ? 'true' : 'false');
                });
                panes.forEach(p => {
                    const show = p.dataset.pane === tabKey;
                    p.hidden = !show;
                });
            }

            tabs.forEach(t => {
                t.addEventListener('click', () => {
                    if (t.classList.contains('cv-projects-tab--soon')) return;
                    setActive(t.dataset.tab);
                });
            });

            // simple tooltip for coming soon tabs
            let ttTimer = null;
            tabs.forEach(t => {
                if (!t.classList.contains('cv-projects-tab--soon')) return;
                t.addEventListener('click', () => {
                    t.classList.add('is-tooltip-open');
                    clearTimeout(ttTimer);
                    ttTimer = setTimeout(() => t.classList.remove('is-tooltip-open'), 1400);
                });
                t.addEventListener('mouseleave', () => t.classList.remove('is-tooltip-open'));
            });
        })();
    </script>
@endsection

