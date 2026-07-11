@extends('site.layout')

@section('body_class', 'page-home-tools')

@section('title', __('lang.Home page meta title'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{{ __('lang.Home page meta description') }}" />
    <meta name="keywords" content="resume builder, CV templates, career tools, TFC tools, professional resume, PDF export, blogs, business growth" />

    <meta property="og:title" content="{{ __('lang.Home page meta title') }}" />
    <meta property="og:description" content="{{ __('lang.Home page meta description') }}" />
    <meta property="og:image" content="https://thefazli.com/images/tfc-the-fazli-community-home-page-preview.png" />
    <meta property="og:url" content="https://thefazli.com/{{ $locale }}" />
    <meta property="og:type" content="website" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@fazlielahi" />
    <meta name="twitter:title" content="{{ __('lang.Home page meta title') }}" />
    <meta name="twitter:description" content="{{ __('lang.Home page meta description') }}" />
    <meta name="twitter:image" content="https://thefazli.com/images/tfc-the-fazli-community-home-page-preview.png" />

    <meta name="author" content="TFC - The Fazli Community" />
    <meta name="robots" content="index, follow, max-image-preview:large" />

    <link rel="canonical" href="https://thefazli.com/{{ $locale }}" />
@endsection

@section('structured_data')
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        '@id' => 'https://thefazli.com/#organization',
        'name' => 'TFC - The Fazli Community',
        'alternateName' => 'The Fazli Community',
        'url' => 'https://thefazli.com/' . $locale,
        'logo' => 'https://thefazli.com/images/dark-tfc-header-logo.png',
        'description' => __('lang.Home page meta description'),
        'sameAs' => [
            'https://www.linkedin.com/company/thefazli/',
            'https://twitter.com/fazlielahi',
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'TFC - The Fazli Community',
        'alternateName' => 'The Fazli Community',
        'url' => 'https://thefazli.com/' . $locale,
        'description' => __('lang.Home page meta description'),
        'publisher' => [
            '@id' => 'https://thefazli.com/#organization',
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endsection

@section('head')
    <link rel="preload" href="{{ asset('styles/home-tools.css') }}" as="style" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/home-tools.css') }}" />
@endsection

@section('content')
    <main class="home-tools">
        <div class="home-tools__shell">
            <section class="home-tools__hero" aria-labelledby="home-tools-title">
                <div class="home-tools__intro">
                    <div class="home-tools__intro-top">
                        <span class="home-tools__intro-icon">
                            @include('cv.partials.svg-icon', ['name' => 'document'])
                        </span>
                    </div>

                    <span class="home-tools__eyebrow">{{ __('lang.Resume Builder') }}</span>
                    <h1 id="home-tools-title">{{ __('lang.Home resume hero title') }}</h1>

                    <ul class="home-tools__intro-list">
                        <li>{{ __('lang.Multiple Templates') }}</li>
                        <li>{{ __('lang.Live Preview') }}</li>
                        <li>{{ __('lang.Export PDF') }}</li>
                    </ul>

                    <div class="home-tools__actions">
                        <a class="home-tools__btn home-tools__btn--primary" href="{{ route('localized.resume.gallery', ['lang' => app()->getLocale()]) }}">
                            {{ __('lang.Create Resume') }}
                        </a>
                    </div>
                </div>

                <aside class="home-tools__highlight" aria-label="{{ __('lang.Home career support highlight') }}">
                    <span class="home-tools__highlight-badge home-tools__highlight-badge--ribbon">{{ __('lang.Coming soon') }}</span>

                    <div>
                        <h2>{!! __('lang.Send Emails to Thousands in Minutes') !!}</h2>
                        <p>
                            {{ __('lang.Home bulk email description') }}
                        </p>
                    </div>

                    <div class="home-tools__highlight-features">
                        <div class="home-tools__highlight-feature">
                            <span class="home-tools__highlight-feature-icon">
                                @include('cv.partials.svg-icon', ['name' => 'user'])
                            </span>
                            <span>
                                <strong>{{ __('lang.High Deliverability') }}</strong>
                                <span>{{ __('lang.Better inbox placement') }}</span>
                            </span>
                        </div>

                        <div class="home-tools__highlight-feature">
                            <span class="home-tools__highlight-feature-icon">
                                @include('cv.partials.svg-icon', ['name' => 'briefcase'])
                            </span>
                            <span>
                                <strong>{{ __('lang.Real-time Reports') }}</strong>
                                <span>{{ __('lang.Track performance') }}</span>
                            </span>
                        </div>

                        <div class="home-tools__highlight-feature">
                            <span class="home-tools__highlight-feature-icon">
                                @include('cv.partials.svg-icon', ['name' => 'check'])
                            </span>
                            <span>
                                <strong>{{ __('lang.Secure & Reliable') }}</strong>
                                <span>{{ __('lang.Your data is safe') }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="home-tools__highlight-actions">
                        <span class="home-soon-tip home-tools__btn-wrap" data-tip="{{ __('lang.Coming soon') }}">
                            <button type="button" class="home-tools__btn home-tools__btn--primary" disabled aria-label="{{ __('lang.Get Started Free') }} — {{ __('lang.Coming soon') }}">
                                {{ __('lang.Get Started Free') }}
                            </button>
                        </span>
                        <span class="home-soon-tip home-tools__btn-wrap" data-tip="{{ __('lang.Coming soon') }}">
                            <button type="button" class="home-tools__btn home-tools__btn--secondary" disabled aria-label="{{ __('lang.Watch Demo') }} — {{ __('lang.Coming soon') }}">
                                <span class="home-tools__btn-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M8 5.75v12.5L18 12 8 5.75Z" />
                                    </svg>
                                </span>
                                {{ __('lang.Watch Demo') }}
                            </button>
                        </span>
                    </div>

                    <div class="home-tools__highlight-checks">
                        <span>{{ __('lang.Home bulk email launching soon') }}</span>
                        <span>{{ __('lang.Home bulk email built for') }}</span>
                        <span>{{ __('lang.Home bulk email stay tuned') }}</span>
                    </div>
                </aside>
            </section>

            <section class="home-tools__grid" aria-label="{{ __('lang.Main TFC tools') }}">
                <article class="home-tool-card">
                    <a class="home-tool-card__surface" href="{{ route('localized.resume.gallery', ['lang' => app()->getLocale()]) }}">
                        <div class="home-tool-card__media">
                            <span class="home-tool-card__badge">{{ __('lang.New') }}</span>
                            <span class="home-tool-card__media-icon">
                                @include('cv.partials.svg-icon', ['name' => 'document'])
                            </span>
                        </div>
                        <div class="home-tool-card__body">
                            <h2>{{ __('lang.Create Your Resume') }}</h2>
                            <p>{{ __('lang.Home create resume card description') }}</p>
                        </div>
                    </a>
                </article>

                <article class="home-tool-card home-tool-card--soon">
                    <span class="home-soon-tip home-tool-card__wrap" data-tip="{{ __('lang.Coming soon') }}">
                        <span class="home-tool-card__surface home-tool-card__surface--disabled" role="group" aria-label="{{ __('lang.Send Your CV') }} — {{ __('lang.Coming soon') }}">
                            <div class="home-tool-card__media">
                                <span class="home-tool-card__badge home-tool-card__badge--ribbon">{{ __('lang.Coming soon') }}</span>
                                <span class="home-tool-card__media-icon">
                                    @include('cv.partials.svg-icon', ['name' => 'briefcase'])
                                </span>
                            </div>
                            <div class="home-tool-card__body">
                                <h2>{{ __('lang.Send Your CV') }}</h2>
                                <p>{{ __('lang.Home send cv card description') }}</p>
                            </div>
                        </span>
                    </span>
                </article>

                <article class="home-tool-card">
                    <a class="home-tool-card__surface" href="{{ route('localized.blogs', ['lang' => app()->getLocale()]) }}">
                        <div class="home-tool-card__media">
                            <span class="home-tool-card__media-icon">
                                @include('cv.partials.svg-icon', ['name' => 'rss'])
                            </span>
                        </div>
                        <div class="home-tool-card__body">
                            <h2>{{ __('lang.Read or Post Blogs') }}</h2>
                            <p>{{ __('lang.Home blogs card description') }}</p>
                        </div>
                    </a>
                </article>

                <article class="home-tool-card">
                    <a class="home-tool-card__surface" href="{{ route('localized.tools', ['lang' => app()->getLocale()]) }}">
                        <div class="home-tool-card__media">
                            <span class="home-tool-card__media-icon">
                                @include('cv.partials.svg-icon', ['name' => 'grid'])
                            </span>
                        </div>
                        <div class="home-tool-card__body">
                            <h2>{{ __('lang.Tools') }}</h2>
                            <p>{{ __('lang.Tools page intro') }}</p>
                        </div>
                    </a>
                </article>
            </section>
        </div>
    </main>
@endsection

@section('script')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/menu.js') }}"></script>
    <script>
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
            new bootstrap.Tooltip(el);
        });
    </script>
@endsection
