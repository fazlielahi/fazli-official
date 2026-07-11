<section class="blog-one">
    <div class="container">
        <div class="section-title text-center sec-title-animation animation-style1">
            <div class="section-title__tagline-box">
                <div class="section-title__tagline-shape"></div>
                <span class="section-title__tagline" id="portfolio-sec">{{ __('lang.Portfolio') }}</span>
            </div>
            <h2 class="section-title__title {{ $locale == 'en' ? 'title-animation' : '' }}">{{ __('lang.From Concepts to Live Projects') }} <br> {!! __('lang.See What I\'ve Built.') !!} <img src="{{ asset('assets/images/shapes/section-title-shape-1.png') }}" alt="" role="presentation" aria-hidden="true"></h2>
        </div>
        <div class="blog-one__carousel owl-theme owl-carousel">
            @foreach ($portfolioItems as $project)
                <div class="item">
                    <div class="blog-one__single">
                        <div class="blog-one__img">
                            <img src="{{ asset('assets/images/' . $project['image']) }}" alt="{{ $project['image_alt'] }}">
                        </div>
                        <div class="blog-one__content">
                            <ul class="blog-one__meta list-unstyled">
                                <li>
                                    <span><span class="icon-calendar"></span>{{ __('lang.' . $project['date_key']) }}</span>
                                </li>
                                <li>
                                    <span class="mx-2"><span class="icon-comment"></span> {{ __('lang.' . $project['status_key']) }}</span>
                                </li>
                            </ul>
                            <h3 class="blog-one__title">
                                <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer">{{ __('lang.' . $project['title_key']) }}</a>
                            </h3>
                            <p class="blog-one__text">{{ __('lang.' . $project['desc_key']) }}</p>
                            @if (!empty($project['read_more']))
                                <div class="blog-one__btn-and-user-box">
                                    <div class="blog-one__btn-box">
                                        <a href="{{ $project['url'] }}" class="thm-btn" target="_blank" rel="noopener noreferrer">
                                            <span class="icon-angles-right"></span>{{ __('lang.Read More') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
