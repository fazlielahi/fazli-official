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
        <div class="row">
            @if($blogs->count() > 0)
                @foreach($blogs as $blog)
                    @include('site.partials.blog-share-modal', ['blog' => $blog])
                    <div class="wow fadeInUp blog-card-home" data-wow-delay="100ms">
                        <div class="blog-two__single">
                            <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), 'slug' => $blog->slug]) }}">
                                <div class="blog-two__img">
                                    <img
                                        src="{{ $blog->thumb && file_exists(public_path('storage/' . $blog->thumb)) ? asset('storage/' . $blog->thumb) : asset('images/blog-default.jpg') }}"
                                        alt="{{ $blog->title ?? 'Blog post thumbnail' }}"
                                    >
                                </div>
                            </a>
                            <div class="blog-two__content">
                                <div class="blog-two__meta-box blog-profile">
                                    <div class="profile-container">
                                        <a href="{{ route('localized.user-profile', ['lang' => app()->getLocale(), $blog->creater->id]) }}" class="mb-0 text-muted">
                                            <img
                                                src="{{ $blog->creater && $blog->creater->photo ? asset('images/' . $blog->creater->photo) : asset('images/default.png') }}"
                                                alt="{{ $blog->creater ? $blog->creater->name . ' profile picture' : 'Default profile picture' }}"
                                                width="100%"
                                                class="profile-pic"
                                            >
                                        </a>
                                        <div>
                                            <span class="username">
                                                <a href="{{ route('localized.user-profile', ['lang' => app()->getLocale(), $blog->creater->id]) }}">
                                                    {{ $blog->creater->name ?? __('lang.unknown') }}
                                                </a>
                                            </span>
                                            <span class="blog-time text-muted" style="font-size: 13px;">
                                                {{ $blog->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="blog-two__title">
                                    <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), 'slug' => $blog->slug]) }}">
                                        {{ Str::limit(html_entity_decode(strip_tags($blog->title)), 85) }}
                                    </a>
                                </h4>
                            </div>
                            <div class="blog-two__meta-box comment-sec">
                                <ul class="blog-two__meta list-unstyled post-interactions">
                                    <li class="like-btn" data-url="{{ route('localized.blog.like', [app()->getLocale(), $blog->id]) }}">
                                        @if(in_array($blog->id, $likedBlogIds))
                                            <i class="heart-icon fa-solid fa-heart"></i>
                                        @else
                                            <i class="heart-icon fa-regular fa-heart"></i>
                                        @endif
                                        <span class="like">{{ __('lang.Like') }} </span>
                                        <span class="like-count">{{ $blog->likes_count }}</span>
                                    </li>
                                    <li>
                                        <a href="#" data-bs-toggle="modal" class="comment-a" data-bs-target="#editModal{{ $blog->id }}">
                                            <i class="far fa-comments mx-1"></i>
                                            <span class="comment">{{ __('lang.Comments') }}</span>
                                            <span class="comment-count">({{ $blog->comments_count }})</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="share-btn"
                                           data-bs-toggle="modal"
                                           data-bs-target="#shareModalTest{{ $blog->id }}"
                                           aria-label="{{ __('lang.Share') }}">
                                            <i class="far fa-share-square mx-1" aria-hidden="true"></i>
                                            <span class="share">{{ __('lang.Share') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @include('site.partials.blog-comment-modal', ['blog' => $blog])
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <div class="no-blogs-message">
                        <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">{{ __('lang.No blogs uploaded yet') }}</h4>
                        <p class="text-muted">{{ __('lang.There are no blogs available in the selected category.') }}</p>
                    </div>
                </div>
            @endif
            <div class="text-center my-4">
                <a href="{{ route('localized.blogs', ['lang' => app()->getLocale()]) }}" class="btn btn-outline-secondary mb-3">{{ __('lang.Read More') }}</a>
            </div>
        </div>
    </div>
</section>
