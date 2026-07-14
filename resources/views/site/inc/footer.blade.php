@php
    $locale = app()->getLocale();
    $langParam = ['lang' => $locale];
    $socialLinks = [
        [
            'label' => __('lang.Linkedin'),
            'url' => 'https://www.linkedin.com/company/thefazli/',
            'icon' => 'linkedin',
        ],
        [
            'label' => 'X',
            'url' => 'https://x.com/thefazli_dotcom',
            'icon' => 'x-twitter',
        ],
        [
            'label' => __('lang.Facebook'),
            'url' => 'https://www.facebook.com/thefazli/',
            'icon' => 'facebook',
        ],
        [
            'label' => __('lang.Instagram'),
            'url' => 'https://www.instagram.com/thefazlicommunity/',
            'icon' => 'instagram',
        ],
        [
            'label' => __('lang.Whatsapp'),
            'url' => 'https://wa.me/966592304816',
            'icon' => 'whatsapp',
        ],
    ];
@endphp

<footer class="site-footer" role="contentinfo" aria-label="{{ __('lang.FOOTER_SITE') }}">
    <div class="site-footer__top">
        <div class="site-footer__container">
            <div class="site-footer__grid">
                <div class="site-footer__brand">
                    <a href="{{ route('localized.home', $langParam) }}" class="site-footer__logo-link">
                        <img src="{{ asset('images/light-tfc-header-logo.png') }}" alt="TFC - The Fazli Community" class="site-footer__logo logo-light" width="120" height="40">
                        <img src="{{ asset('images/dark-tfc-header-logo.png') }}" alt="TFC - The Fazli Community" class="site-footer__logo logo-dark" width="120" height="40">
                    </a>
                    <p class="site-footer__tagline">{{ __('lang.FOOTER_TAGLINE') }}</p>
                    <div class="site-footer__social" aria-label="{{ __('lang.FOOTER_FOLLOW_US') }}">
                        @foreach ($socialLinks as $social)
                            <a href="{{ $social['url'] }}"
                               class="site-footer__social-link"
                               target="_blank"
                               rel="noopener noreferrer"
                               aria-label="{{ $social['label'] }}">
                                @include('cv.partials.svg-icon', ['name' => $social['icon'], 'class' => 'site-footer__social-icon'])
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="site-footer__column">
                    <h3 class="site-footer__heading">{{ __('lang.FOOTER_EXPLORE') }}</h3>
                    <ul class="site-footer__links-list">
                        <li><a href="{{ route('localized.home', $langParam) }}">{{ __('lang.Home') }}</a></li>
                        <li><a href="{{ route('localized.about-tfc', $langParam) }}">{{ __('lang.About TFC') }}</a></li>
                        <li><a href="{{ route('localized.services', $langParam) }}">{{ __('lang.Services') }}</a></li>
                        <li><a href="{{ route('localized.founder-profile', $langParam) }}">{{ __('lang.Founder') }}</a></li>
                        <li><a href="{{ route('localized.contact', $langParam) }}">{{ __('lang.Contact') }}</a></li>
                    </ul>
                </div>

                <div class="site-footer__column">
                    <h3 class="site-footer__heading">{{ __('lang.FOOTER_TOOLS') }}</h3>
                    <ul class="site-footer__links-list">
                        <li><a href="{{ route('localized.tools', $langParam) }}">{{ __('lang.All Tools') }}</a></li>
                        <li><a href="{{ route('localized.resume.gallery', $langParam) }}">{{ __('lang.CV Create') }}</a></li>
                        <li><a href="{{ route('localized.jobs', $langParam) }}">{{ __('lang.Explore Jobs') }}</a></li>
                    </ul>
                </div>

                <div class="site-footer__column">
                    <h3 class="site-footer__heading">{{ __('lang.FOOTER_RESOURCES') }}</h3>
                    <ul class="site-footer__links-list">
                        <li><a href="{{ route('localized.blogs', $langParam) }}">{{ __('lang.Blogs') }}</a></li>
                        <li><a href="{{ route('localized.books', $langParam) }}">{{ __('lang.Books') }}</a></li>
                    </ul>
                </div>

                <div class="site-footer__column site-footer__contact">
                    <h3 class="site-footer__heading">{{ __('lang.FOOTER_CONTACT') }}</h3>
                    <ul class="site-footer__contact-info-list">
                        <li>
                            <span class="site-footer__contact-info-icon" aria-hidden="true">
                                @include('cv.partials.svg-icon', ['name' => 'envelope', 'class' => 'site-footer__contact-icon'])
                            </span>
                            <a href="mailto:info@thefazli.com">info@thefazli.com</a>
                        </li>
                        <li>
                            <span class="site-footer__contact-info-icon" aria-hidden="true">
                                @include('cv.partials.svg-icon', ['name' => 'whatsapp', 'class' => 'site-footer__contact-icon'])
                            </span>
                            <a href="https://wa.me/966592304816" target="_blank" rel="noopener noreferrer">+966 59 230 4816</a>
                        </li>
                        <li>
                            <span class="site-footer__contact-info-icon" aria-hidden="true">
                                @include('cv.partials.svg-icon', ['name' => 'globe', 'class' => 'site-footer__contact-icon'])
                            </span>
                            <span>{{ __('lang.CONTACT_ADDRESS_VALUE') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="site-footer__bottom">
        <div class="site-footer__container site-footer__bottom-inner">
            <p class="site-footer__copyright">{{ __('lang.COPYRIGHT') }}</p>
            <p class="site-footer__availability">{{ __('lang.OPEN_TO_OPPORTUNITIES') }}</p>
            <div class="site-footer__bottom-meta">
                <nav class="site-footer__lang-nav" aria-label="{{ __('lang.Language') }}">
                    <a href="{{ route('lang.switch', 'en') }}" @class(['site-footer__lang-link', 'is-active' => $locale === 'en'])>{{ __('lang.English') }}</a>
                    <span class="site-footer__lang-sep" aria-hidden="true">·</span>
                    <a href="{{ route('lang.switch', 'ar') }}" @class(['site-footer__lang-link', 'is-active' => $locale === 'ar'])>{{ __('lang.Arabic') }}</a>
                    <span class="site-footer__lang-sep" aria-hidden="true">·</span>
                    <a href="{{ route('lang.switch', 'ur') }}" @class(['site-footer__lang-link', 'is-active' => $locale === 'ur'])>{{ __('lang.Urdu') }}</a>
                </nav>
                <span class="site-footer__author">{{ __('lang.MADE_BY') }}</span>
            </div>
        </div>
    </div>
</footer>
