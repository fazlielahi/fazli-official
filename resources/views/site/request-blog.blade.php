@extends('site.profile')

@section('head')
    <!-- Preload critical CSS -->
    <link rel="preload" href="{{ asset('assets/css/style.css') }}" as="style" />
    <link rel="preload" href="{{ asset('assets/css/responsive.css') }}" as="style" />

    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" /> <!-- main heading css -->
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet" />
    <!-- Font Awesome CDN for version 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Third-party CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom-animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-all.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jarallax.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/odometer.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}" />

    <!-- Module CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/banner.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/footer.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/sliding-text.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/category.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/about.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/services.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/why-choose.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/live-class.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/video-one.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/blog.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/counter.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/team.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/newsletter.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/testimonial.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/contact.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/process.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/page-header.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/become-a-teacher.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/shop.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/faq.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/error.css') }}" />

    <!-- Template styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />

    <style>
        .blog-two__single{
            padding-bottom: 2px;
        }
    </style>
@endsection

@section('content')
    <div class="col-12" style="display: flex; flex-direction: row; flex-wrap: wrap; gap: 10px;">
        @if($blogs->count() > 0)
            @foreach($blogs->sortByDesc('created_at') as $blog)
                @if($blog->status === 'request' && $blog->created_by == $user->id)
                    <!--Blog Two Single Start -->
                    <div class="wow fadeInLeft blog-card" data-wow-delay="100ms">
                        <div class="blog-two__single">
                            <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id]) }}">
                                <div class="blog-two__img">
                                    <img src="{{ $blog->thumb && file_exists(public_path('storage/' . $blog->thumb)) ? asset('storage/' . $blog->thumb) : asset('images/blog-default.jpg') }}">
                                    @php
                                        $user = session()->has('user_id') ? \App\Models\User::find(session('user_id')) : null;
                                    @endphp
                                    @if(($user && $user->id == $blog->created_by))
                                        <div class="action">
                                            <a class="btn btn-icon btn-info" href="{{ route('localized.admin.blog.edit', ['lang' => app()->getLocale(), $blog->id]) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form id="delete-form-{{ $blog->id }}" action="{{ route('localized.admin.blog.destroy', ['lang' => app()->getLocale(), $blog->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete({{ $blog->id }})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif  
                                </div>
                            </a>
                            <div class="blog-two__content">
                                <div class="blog-two__meta-box blog-profile">
                                    <div class="profile-container">
                                        <a href="{{ route('localized.user-profile', ['lang' => app()->getLocale(), $blog->creater->id]) }}" class="mb-0 text-muted">
                                            <img src="{{ $blog->creater && $blog->creater->photo ? asset('images/' . $blog->creater->photo) : asset('images/default.png') }}" width="100%" class="profile-pic">
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
                                    <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id]) }}">
                                        {{ Str::limit(html_entity_decode(strip_tags($blog->title)), 45) }}
                                    </a>
                                </h4>
                            </div>
                            <div class="blog-two__meta-box comment-sec d-none">
                                <ul class="blog-two__meta list-unstyled post-interactions">
                                    <li class="like-btn" data-url="{{ route('localized.blog.like', [app()->getLocale(), $blog->id]) }}">
                                        @if(App\Models\Likes::where('blog_id', $blog->id)->exists())
                                            <i class="heart-icon fa-solid fa-heart"></i>
                                        @else
                                            <i class="heart-icon fa-regular fa-heart"></i>
                                        @endif 
                                        <span class="like">{{ __('lang.Like') }} </span> <span class="like-count">{{ $blog->likes->count() }}</span>
                                    </li>
                                    <li>
                                        <a href="#" data-bs-toggle="modal" class="comment-a" data-bs-target="#editModal{{ $blog->id }}">
                                            <i class="far fa-comments mx-1"></i> <span class="comment">{{ __('lang.Comments') }}</span>
                                        </a>
                                    </li>
                                    <li data-bs-toggle="modal" class="share-btn" data-bs-target="#shareModalTest">
                                        <i class="far fa-share-square mx-1"></i><span class="share">{{ __('lang.Share') }} </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <div class="col-12 text-center py-5">
                <div class="no-blogs-message">
                    <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">
                        <u>{{ explode(' ', $user->name)[0] }}</u> {{ __('lang.has not sent new Blogs for review yet') }}
                    </h4>
                    <p class="text-muted">{{ __('lang.There are no blogs been sent for review at the moment.') }}</p>
                </div>
            </div>
        @endif
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jarallax.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/odometer.min.js') }}"></script>
    <script src="{{ asset('assets/js/wNumb.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/marquee.min.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/gsap/gsap.js') }}"></script>
    <script src="{{ asset('assets/js/gsap/ScrollTrigger.js') }}"></script>
    <script src="{{ asset('assets/js/gsap/SplitText.js') }}"></script>
    <!-- template js -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.like-toggle').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    var icon = link.querySelector('i');
                    if (icon.classList.contains('fa-regular')) {
                        icon.classList.remove('fa-regular');
                        icon.classList.add('fa-solid');
                    } else {
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                    }
                });
            });
        });
    </script>
    
@endsection