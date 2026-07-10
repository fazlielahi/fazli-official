@extends('site.layout')

@section('body_class', 'page-home-tools')

@section('title', __('lang.Home page title'))

@section('head')
    <!-- Header, footer, and page background styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/footer.css') }}" />

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
                        <a class="home-tools__btn home-tools__btn--primary" href="{{ route('localized.jobs', ['lang' => app()->getLocale()]) }}">
                            {{ __('lang.Get Started Free') }}
                        </a>
                        <a class="home-tools__btn home-tools__btn--secondary" href="{{ route('localized.resume.gallery', ['lang' => app()->getLocale()]) }}">
                            <span class="home-tools__btn-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8 5.75v12.5L18 12 8 5.75Z" />
                                </svg>
                            </span>
                            {{ __('lang.Watch Demo') }}
                        </a>
                    </div>

                    <div class="home-tools__highlight-checks">
                        <span>{{ __('lang.No credit card required') }}</span>
                        <span>{{ __('lang.14-day free trial') }}</span>
                        <span>{{ __('lang.Cancel anytime') }}</span>
                    </div>
                </aside>
            </section>

            <section class="home-tools__grid" aria-label="{{ __('lang.Main TFC tools') }}">
                <article class="home-tool-card">
                    <a class="home-tool-card__media" href="{{ route('localized.resume.gallery', ['lang' => app()->getLocale()]) }}">
                        <span class="home-tool-card__badge">{{ __('lang.New') }}</span>
                        <span class="home-tool-card__media-icon">
                            @include('cv.partials.svg-icon', ['name' => 'document'])
                        </span>
                    </a>
                    <div class="home-tool-card__body">
                        <h2>{{ __('lang.Create Your Resume') }}</h2>
                        <p>{{ __('lang.Home create resume card description') }}</p>
                    </div>
                </article>

                <article class="home-tool-card">
                    <a class="home-tool-card__media" href="{{ route('localized.jobs', ['lang' => app()->getLocale()]) }}">
                        <span class="home-tool-card__badge home-tool-card__badge--ribbon">{{ __('lang.Coming soon') }}</span>
                        <span class="home-tool-card__media-icon">
                            @include('cv.partials.svg-icon', ['name' => 'briefcase'])
                        </span>
                    </a>
                    <div class="home-tool-card__body">
                        <h2>{{ __('lang.Send Your CV') }}</h2>
                        <p>{{ __('lang.Home send cv card description') }}</p>
                    </div>
                </article>

                <article class="home-tool-card">
                    <a class="home-tool-card__media" href="{{ route('localized.blogs', ['lang' => app()->getLocale()]) }}">
                        <span class="home-tool-card__media-icon">
                            @include('cv.partials.svg-icon', ['name' => 'rss'])
                        </span>
                    </a>
                    <div class="home-tool-card__body">
                        <h2>{{ __('lang.Read or Post Blogs') }}</h2>
                        <p>{{ __('lang.Home blogs card description') }}</p>
                    </div>
                </article>

                <article class="home-tool-card">
                    <a class="home-tool-card__media" href="{{ route('localized.tools', ['lang' => app()->getLocale()]) }}">
                        <span class="home-tool-card__media-icon">
                            @include('cv.partials.svg-icon', ['name' => 'grid'])
                        </span>
                    </a>
                    <div class="home-tool-card__body">
                        <h2>{{ __('lang.Tools') }}</h2>
                        <p>{{ __('lang.Tools page intro') }}</p>
                    </div>
                </article>
            </section>
        </div>
    </main>
@endsection

@section('script')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        var menu = document.getElementById('navbarNav');
    </script>
    <script src="{{ asset('js/menu.js') }}"></script>
@endsection
