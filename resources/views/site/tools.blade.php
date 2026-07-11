@extends('site.layout')
@section('body_class', 'page-home-tools page-tools')
@section('title', __('lang.Tools page meta title'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{{ __('lang.Tools page meta description') }}" />
    <meta name="keywords" content="resume builder, bulk email, CV tools, job search, career tools, blog platform, free online tools" />

    <meta property="og:title" content="{{ __('lang.Tools page meta title') }}" />
    <meta property="og:description" content="{{ __('lang.Tools page meta description') }}" />
    <meta property="og:image" content="https://thefazli.com/images/tfc-tools-page-preview.png" />
    <meta property="og:url" content="https://thefazli.com/{{ $locale }}/tools" />
    <meta property="og:type" content="website" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@fazlielahi" />
    <meta name="twitter:title" content="{{ __('lang.Tools page meta title') }}" />
    <meta name="twitter:description" content="{{ __('lang.Tools page meta description') }}" />
    <meta name="twitter:image" content="https://thefazli.com/images/tfc-tools-page-preview.png" />

    <meta name="author" content="TFC - The Fazli Community" />
    <meta name="robots" content="index, follow, max-image-preview:large">

    <link rel="canonical" href="https://thefazli.com/{{ $locale }}/tools" />
@endsection

@section('structured_data')
    @php
        $toolsPageUrl = 'https://thefazli.com/' . $locale . '/tools';
        $toolListElements = [];

        foreach ($tools as $index => $tool) {
            $entry = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => __('lang.' . $tool['title']),
            ];

            if (! empty($tool['url'])) {
                $entry['url'] = $tool['url'];
            }

            $toolListElements[] = $entry;
        }
    @endphp
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => 'https://thefazli.com/' . $locale,
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => __('lang.Tools'),
                'item' => $toolsPageUrl,
            ],
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => __('lang.Tools page meta title'),
        'description' => __('lang.Tools page meta description'),
        'url' => $toolsPageUrl,
        'isPartOf' => [
            '@type' => 'WebSite',
            'name' => 'TFC - The Fazli Community',
            'url' => 'https://thefazli.com/' . $locale,
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'name' => __('lang.Main TFC tools'),
        'itemListElement' => $toolListElements,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endsection

@section('head')
    <link rel="preload" href="{{ asset('styles/home-tools.css') }}" as="style" />
    <link rel="preload" href="{{ asset('styles/tools.css') }}" as="style" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/home-tools.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/tools.css') }}" />
@endsection

@section('content')
    <main class="home-tools tools-page">
        <div class="home-tools__shell">
            <header class="tools-page__header">
                <span class="home-tools__eyebrow">{{ __('lang.Tools') }}</span>
                <h1 class="tools-page__title">{{ __('lang.Tools page title') }} {{ __('lang.Tools page title highlight') }}</h1>
                <p class="tools-page__intro">{{ __('lang.Tools page intro') }}</p>
            </header>

            <div class="home-tools__grid tools-page__grid" aria-label="{{ __('lang.Main TFC tools') }}">
                @foreach ($tools as $tool)
                    <article class="home-tool-card tools-card {{ !empty($tool['coming_soon']) ? 'home-tool-card--soon' : '' }}">
                        @if (!empty($tool['url']))
                            <a class="home-tool-card__surface tools-card__surface" href="{{ $tool['url'] }}">
                                <div class="home-tool-card__media" aria-hidden="true">
                                    @if (!empty($tool['badge']))
                                        <span class="home-tool-card__badge">
                                            {{ __('lang.' . $tool['badge']) }}
                                        </span>
                                    @endif
                                    <span class="home-tool-card__media-icon">
                                        @include('cv.partials.svg-icon', ['name' => $tool['icon']])
                                    </span>
                                </div>
                                <div class="home-tool-card__body">
                                    <h2>{{ __('lang.' . $tool['title']) }}</h2>
                                    <p>{{ __('lang.' . $tool['description']) }}</p>
                                    <span class="home-tools__btn home-tools__btn--primary tools-card__action">{{ __('lang.Open Tool') }}</span>
                                </div>
                            </a>
                        @else
                            <div class="home-tool-card__media" aria-hidden="true">
                                @if (!empty($tool['badge']))
                                    <span class="home-tool-card__badge {{ !empty($tool['coming_soon']) ? 'home-tool-card__badge--ribbon' : '' }}">
                                        {{ __('lang.' . $tool['badge']) }}
                                    </span>
                                @endif
                                <span class="home-tool-card__media-icon">
                                    @include('cv.partials.svg-icon', ['name' => $tool['icon']])
                                </span>
                            </div>
                            <div class="home-tool-card__body">
                                <h2>{{ __('lang.' . $tool['title']) }}</h2>
                                <p>{{ __('lang.' . $tool['description']) }}</p>
                                <span class="home-soon-tip" data-tip="{{ __('lang.Coming soon') }}">
                                    <span class="home-tools__btn home-tools__btn--secondary tools-card__action tools-card__action--disabled" aria-label="{{ __('lang.' . $tool['title']) }} — {{ __('lang.Coming soon') }}">
                                        {{ __('lang.Coming soon') }}
                                    </span>
                                </span>
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('js/menu.js') }}" defer></script>
@endsection
