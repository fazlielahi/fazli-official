<section class="blog-two one-page-two-blog" id="blog-section-home">
    <div class="container">
        <div class="section-title-two text-center sec-title-animation animation-style1">
            <div class="section-title__tagline-box">
                <div class="section-title__tagline-shape"></div>
                <span class="section-title__tagline">{{ __('lang.Blogs') }}</span>
            </div>
            <h2 class="section-title-two__title">{{ __('lang.Knowledge That Powers Growth -') }} <br> {{ __('lang.Our') }}
                <span class="about-accent-text">{{ __('lang.Blog Corner') }}</span>
            </h2>
            <p class="cv-templates-section__subtitle">{{ __('lang.About blogs preview description') }}</p>
        </div>

        <div class="blogs-results about-blogs-preview__grid" aria-live="polite">
            @if($blogs->count() > 0)
                @foreach($blogs as $blog)
                    @include('site.partials.blog-card', [
                        'blog' => $blog,
                        'likedBlogIds' => $likedBlogIds,
                        'wowAnimation' => 'fadeInUp',
                    ])
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <div class="no-blogs-message">
                        <i class="fas fa-blog fa-3x mb-3" aria-hidden="true"></i>
                        <h4>{{ __('lang.No blogs uploaded yet') }}</h4>
                        <p>{{ __('lang.There are no blogs available in the selected category.') }}</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="text-center about-blogs-preview__cta">
            <a href="{{ route('localized.blogs', ['lang' => app()->getLocale()]) }}" class="blogs-toolbar__btn">{{ __('lang.Read More') }}</a>
        </div>
    </div>
</section>
