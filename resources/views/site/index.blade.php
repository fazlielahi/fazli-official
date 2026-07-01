@extends('site.layout')

@section('body_class', 'page-home-tools')

@section('title', 'TFC Tools for Career and Business Growth')

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

                    <span class="home-tools__eyebrow">Resume Builder</span>
                    <h1 id="home-tools-title">Create a professional resume in minutes with beautiful templates and live preview.</h1>

                    <ul class="home-tools__intro-list">
                        <li>Multiple Templates</li>
                        <li>Live Preview</li>
                        <li>Export PDF</li>
                    </ul>

                    <div class="home-tools__actions">
                        <a class="home-tools__btn home-tools__btn--primary" href="{{ route('localized.cv.gallery', ['lang' => app()->getLocale()]) }}">
                            Create Resume
                        </a>
                    </div>
                </div>

                <aside class="home-tools__highlight" aria-label="Career support highlight">
                    <span class="home-tools__highlight-badge home-tools__highlight-badge--ribbon">Coming Soon</span>

                    <div>
                        <h2>Send Emails to <span>Thousands in Minutes.</span></h2>
                        <p>
                            Upload your contacts or choose from our verified lists and send
                            personalized emails that get opened.
                        </p>
                    </div>

                    <div class="home-tools__highlight-features">
                        <div class="home-tools__highlight-feature">
                            <span class="home-tools__highlight-feature-icon">
                                @include('cv.partials.svg-icon', ['name' => 'user'])
                            </span>
                            <span>
                                <strong>High Deliverability</strong>
                                <span>Better inbox placement</span>
                            </span>
                        </div>

                        <div class="home-tools__highlight-feature">
                            <span class="home-tools__highlight-feature-icon">
                                @include('cv.partials.svg-icon', ['name' => 'briefcase'])
                            </span>
                            <span>
                                <strong>Real-time Reports</strong>
                                <span>Track performance</span>
                            </span>
                        </div>

                        <div class="home-tools__highlight-feature">
                            <span class="home-tools__highlight-feature-icon">
                                @include('cv.partials.svg-icon', ['name' => 'check'])
                            </span>
                            <span>
                                <strong>Secure & Reliable</strong>
                                <span>Your data is safe</span>
                            </span>
                        </div>
                    </div>

                    <div class="home-tools__highlight-actions">
                        <a class="home-tools__btn home-tools__btn--primary" href="{{ route('localized.jobs', ['lang' => app()->getLocale()]) }}">
                            Get Started Free
                        </a>
                        <a class="home-tools__btn home-tools__btn--secondary" href="{{ route('localized.cv.gallery', ['lang' => app()->getLocale()]) }}">
                            <span class="home-tools__btn-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8 5.75v12.5L18 12 8 5.75Z" />
                                </svg>
                            </span>
                            Watch Demo
                        </a>
                    </div>

                    <div class="home-tools__highlight-checks">
                        <span>No credit card required</span>
                        <span>14-day free trial</span>
                        <span>Cancel anytime</span>
                    </div>
                </aside>
            </section>

            <section class="home-tools__grid" aria-label="Main TFC tools">
                <article class="home-tool-card">
                    <a class="home-tool-card__media" href="{{ route('localized.cv.gallery', ['lang' => app()->getLocale()]) }}">
                        <span class="home-tool-card__badge">New</span>
                        <span class="home-tool-card__media-icon">
                            @include('cv.partials.svg-icon', ['name' => 'document'])
                        </span>
                    </a>
                    <div class="home-tool-card__body">
                        <h2>Create Your Resume</h2>
                        <p>Choose a CV template, build your resume, save your work, and export PDF.</p>
                    </div>
                </article>

                <article class="home-tool-card">
                    <a class="home-tool-card__media" href="{{ route('localized.jobs', ['lang' => app()->getLocale()]) }}">
                        <span class="home-tool-card__badge home-tool-card__badge--ribbon">Coming Soon</span>
                        <span class="home-tool-card__media-icon">
                            @include('cv.partials.svg-icon', ['name' => 'briefcase'])
                        </span>
                    </a>
                    <div class="home-tool-card__body">
                        <h2>Send Your CV</h2>
                        <p>Reach more companies, recruiters, and career opportunities faster.</p>
                    </div>
                </article>

                <article class="home-tool-card">
                    <a class="home-tool-card__media" href="{{ route('localized.blogs', ['lang' => app()->getLocale()]) }}">
                        <span class="home-tool-card__media-icon">
                            @include('cv.partials.svg-icon', ['name' => 'rss'])
                        </span>
                    </a>
                    <div class="home-tool-card__body">
                        <h2>Read or Post Blogs</h2>
                        <p>Read TFC articles, share knowledge, and build your public profile.</p>
                    </div>
                </article>

                <article class="home-tool-card">
                    <a class="home-tool-card__media" href="{{ route('localized.services', ['lang' => app()->getLocale()]) }}">
                        <span class="home-tool-card__media-icon">
                            @include('cv.partials.svg-icon', ['name' => 'user'])
                        </span>
                    </a>
                    <div class="home-tool-card__body">
                        <h2>Get More Services</h2>
                        <p>Find support for websites, SEO, marketing, development, and growth.</p>
                    </div>
                </article>
            </section>
        </div>
    </main>
@endsection