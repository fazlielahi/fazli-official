@extends('site.layout')

@section('title', __('lang.Blogs'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
@endsection

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
@endsection

@section('content')
    <!--Page Header Start-->
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url('{{ asset('assets/images/shapes/page-header-bg-shape.png') }}');"></div>
        <div class="page-header__shape-4">
            <img src="{{ asset('assets/images/shapes/page-header-shape-4.png') }}" alt="">
        </div>
        <div class="page-header__shape-5">
            <img src="{{ asset('assets/images/shapes/page-header-shape-5.png') }}" alt="">
        </div>
        <div class="container">
            <div class="page-header__inner">
                <div class="page-header__img">
                    <img src="{{ asset('assets/images/resources/page-header-img-1.png') }}" alt="">
                    <div class="page-header__shape-1">
                        <img src="{{ asset('assets/images/shapes/page-header-shape-1.png') }}" alt="">
                    </div>
                    <div class="page-header__shape-2">
                        <img src="{{ asset('assets/images/shapes/page-header-shape-2.png') }}" alt="">
                    </div>
                    <div class="page-header__shape-3">
                        <img src="{{ asset('assets/images/shapes/page-header-shape-3.png') }}" alt="">
                    </div>
                </div>
                <h2>{{ __('lang.Blogs Corner') }}</h2>
                <div class="thm-breadcrumb__box">
                    <ul class="thm-breadcrumb list-unstyled">
                        <li><a href="{{ url('/') }}">{{ __('lang.Home') }}</a></li>
                        <li><span>//</span></li>
                        <li>{{ __('lang.Blofs') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--Page Header End-->

    <!--Blogs Grid Start-->
    <section class="blog-grid">
        <div class="blog-row">
            <div class="left-sidebar">
                <div class="blog-grid__left">
                    <div class="blog-grid__sidebar">
                        <div class="blog-grid__categories blog-grid__single">
                            <div class="blog-grid__title-box">
                                <h3 class="blog-grid__title">{{ __('lang.Categories') }}</h3>
                                <div class="blog-grid__title-shape-1">
                                    <img src="{{ asset('assets/images/shapes/blog-grid-title-shape-1.png') }}" alt="">
                                </div>
                            </div>
                            <ul class="list-unstyled blog-grid__list-item">
                                <li>
                                    <div class="blog-grid__list-check"></div>
                                    <p class="blog-grid__list-text">{{ __('lang.Accounting & Finance (12)') }}</p>
                                </li>
                                <li>
                                    <div class="blog-grid__list-check"></div>
                                    <p class="blog-grid__list-text">{{ __('lang.Programming & Tech (25)') }}</p>
                                </li>
                                <li>
                                    <div class="blog-grid__list-check"></div>
                                    <p class="blog-grid__list-text">{{ __('lang.Art & Design (59)') }}</p>
                                </li>
                                <li>
                                    <div class="blog-grid__list-check"></div>
                                    <p class="blog-grid__list-text">{{ __('lang.Health & Fitness (24)') }}</p>
                                </li>
                                <li>
                                    <div class="blog-grid__list-check"></div>
                                    <p class="blog-grid__list-text">{{ __('lang.Sales & Marketing (40)') }}</p>
                                </li>
                                <li>
                                    <div class="blog-grid__list-check"></div>
                                    <p class="blog-grid__list-text">{{ __('lang.User Research (40)') }}</p>
                                </li>
                                <li>
                                    <div class="blog-grid__list-check"></div>
                                    <p class="blog-grid__list-text">{{ __('lang.Business Development (30)') }}</p>
                                </li>
                            </ul>
                        </div>
                        <div class="blog-grid__discount blog-grid__single">
                            <div class="blog-grid__discount-shape-bg" style="background-image: url('{{ asset('assets/images/shapes/blog-grid-discount-shape-bg.png') }}');"></div>
                            <h4 class="blog-grid__discount-title">{{ __('lang.20% Discount') }}</h4>
                            <p class="blog-grid__discount-text">{{ __('lang.is simply dummy text of the printing') }} <br> {{ __('lang.and typesetting industry') }}</p>
                            <div class="blog-grid__discount-img">
                                <img src="{{ asset('assets/images/resources/blog-grid-discount-img-1.png') }}" alt="">
                            </div>
                            <div class="blog-grid__discount-coupon">
                                <p>{{ __('lang.Use Coupon') }}</p>
                                <h5>#FuStudy56</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="blogs-section">
                @foreach($blogs->sortByDesc('id') as $blog)
                    <!-- Share Modal -->
                    <div class="modal fade" id="shareModalTest" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered" style="max-width: 320px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('lang.Share this blog') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div id="copyMessage" style="color: #1da370; display:none; position: absolute; top: 85px; right: 27px; background: #f8f9fa; padding: 8px 12px; border-radius: 6px; font-weight: 600; box-shadow: 0 2px 8px rgba(0,0,0,0.1); z-index: 1000;">{{ __('lang.Link copied!') }}</div>

                                <div class="modal-body">
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#" onclick="copyToClipboard('{{ route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id]) }}')">
                                        <i class="fa-regular fa-copy text-secondary"></i> {{ __('lang.Copy Link') }}
                                    </a>
                                </div>
                                <div class="modal-body">
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" target="_blank" href="https://wa.me/?text={{ urlencode(route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id])) }}">
                                        <i class="fa-brands fa-whatsapp text-success"></i> {{ __('lang.Share on WhatsApp') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Blog Two Single Start -->
                    <div class="wow fadeInLeft blog-card" data-wow-delay="100ms">
                        <div class="blog-two__single">
                            <div class="blog-two__img">
                                <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id]) }}">
                                    <img src="{{ asset('storage/' . $blog->thumb) }}" alt="">
                                </a>        
                                <div class="blog-two__date">
                                    <span class="icon-calendar"></span>
                                    <p>{{ $blog->created_at->format('F d, Y h:i A')}}</p>
                                </div>
                            </div>
                            <div class="blog-two__content">
                                <div class="blog-two__meta-box blog-profile">
                                    <div class="profile-container">
                                        <a href="{{ route('localized.user-profile', ['lang' => app()->getLocale(), $blog->creater->id]) }}" class="mb-0 text-muted">
                                            <img
                                                src="{{ $blog->creater && $blog->creater->photo ? asset('images/' . $blog->creater->photo) : asset('assets/img/user-image.png') }}"
                                                alt="img" width="100%" class="profile-pic">
                                        </a>
                                        <span class="username">
                                            <a href="{{ route('localized.user-profile', ['lang' => app()->getLocale(), $blog->creater->id]) }}">
                                                {{ $blog->creater->name ?? "unknown"}}
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <h4 class="blog-two__title">
                                    <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id]) }}">{{ $blog->title }}</a>
                                </h4>
                                <p class="blog-two__text"> 
                                    {{ Str::limit(html_entity_decode(strip_tags($blog->content)), 50) }} 
                                    <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id]) }}" class="link-btn">
                                        Read! <span class="icon-clock"></span>
                                    </a>
                                </p>
                            </div>
                            <div class="blog-two__meta-box comment-sec">
                                <ul class="blog-two__meta list-unstyled">
                                    <li class="like-btn" data-url="{{ route('localized.blog.like', [app()->getLocale(), $blog->id]) }}">
                                        @if(App\Models\Likes::where('blog_id', $blog->id)->exists())
                                            <i class="heart-icon fa-solid fa-heart" style="color: #1da370;"></i>
                                        @else
                                            <i class="heart-icon fa-regular fa-heart" style="color: #1da370;"></i>
                                        @endif 
                                        Like <span class="like-count">{{ $blog->likes->count() }}</span>
                                    </li>
                                    <li>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $blog->id }}">
                                            <span class="icon-comments"></span>Comments
                                        </a>
                                    </li>
                                    <li data-bs-toggle="modal" class="share-btn" data-bs-target="#shareModalTest">
                                        {{__('lang.Share')}} <i class="far fa-share-square" style="color: #1da370;"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Comment Modal -->
                    <div class="modal fade comment-modal" id="editModal{{ $blog->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" style="max-width: 44% !important; height: 770px; overflow: auto; scroll-behavior: smooth; border-radius: 20px">
                            <form id="comment-form-{{ $blog->id }}" class="ajax-comment-form" method="POST" action="{{ route('localized.blog.comment', ['lang' => app()->getLocale(), $blog->id]) }}">
                                @csrf
                                <div class="modal-content bg-dark text-light">
                                    <div class="modal-header pb-0 bg-dark text-light border-secondary">
                                        <div class="blog-two__single">
                                            <div class="blog-two__img" id="blog-image-{{ $blog->id }}">
                                                <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id]) }}">
                                                    <img src="{{ asset('storage/' . $blog->thumb) }}" alt="">
                                                </a>        
                                                <div class="blog-two__date">
                                                    <span class="icon-calendar"></span>
                                                    <p>{{ $blog->created_at->format('F d, Y h:i A')}}</p>
                                                </div>
                                            </div>
                                            <div class="blog-two__content">
                                                <div class="blog-two__meta-box blog-profile">
                                                    <div class="profile-container">
                                                        <a href="{{ route('localized.user-profile', ['lang' => app()->getLocale(), $blog->creater->id]) }}" class="mb-0 text-muted">
                                                            <img
                                                                src="{{ $blog->creater && $blog->creater->photo ? asset('images/' . $blog->creater->photo) : asset('assets/img/user-image.png') }}"
                                                                alt="img" width="100%" class="profile-pic">
                                                        </a>
                                                        <span class="username">
                                                            <a href="{{ route('localized.user-profile', ['lang' => app()->getLocale(), $blog->creater->id]) }}">
                                                                {{ $blog->creater->name ?? "unknown"}}
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <h4 class="blog-two__title">
                                                    <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id]) }}">{{ $blog->title }}</a>
                                                </h4>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body bg-dark text-light">
                                        @php 
                                            $user = session()->has('user_id') ? \App\Models\User::find(session('user_id')) : null;
                                        @endphp
                                        
                                        @if((!isset($user) || !$user) && (!Cookie::get('visiter_token') || !\App\Models\Comment::where('visiter_token', Cookie::get('visiter_token'))->exists()))
                                            <div class="mb-3">
                                                <label for="title{{ $blog->id }}" class="form-label text-light">{{__('lang.Your Name')}}</label>
                                                <input type="text" class="form-control bg-secondary text-light border-0" name="name" value="{{ old('name') }}" required>
                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            <textarea class="form-control bg-secondary text-light border-0" name="comment" rows="4" placeholder="{{__('lang.Add a comment')}}" required>{{ old('comment') }}</textarea>
                                        </div>
                                        <div class="ajax-comment-error text-danger"></div>
                                    </div>
                                    <div class="modal-footer bg-dark border-secondary">
                                        @if($blog->comments->count() < 1)
                                            <span class="text-light">{{__('lang.Be the first to comment!')}}</span>
                                        @else
                                            <div class="read-comments-wrapper">
                                                <a class="read-comments-btn" href="#show-comments-{{ $blog->id }}" data-blog-id="{{ $blog->id }}" style="color: #FFC224;">
                                                    {{__('lang.Read all comments')}} <i class="fa-solid fa-arrow-down-wide-short" style="color: #FFC224;"></i>
                                                </a>
                                            </div>
                                        @endif
                                        <div>
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{__('lang.Cancel')}}</button>
                                            <button type="submit" class="btn btn-sm text-light" style="background-color: var(--fistudy-base);">{{__('lang.Comment')}}</button>
                                        </div>
                                    </div>

                                    <div class="comments-list m-2" id="show-comments-{{ $blog->id }}">
                                        @if($blog->comments->count() < 1)
                                            <div class="no-comments">{{__('lang.Be the first to comment!')}}</div>
                                        @else
                                            @foreach($blog->comments->sortByDesc('created_at') as $comment)
                                                @php $user = $comment->user; @endphp
                                                <div class="comment-card">
                                                    <img
                                                        src="{{ $user && $user->photo ? asset('images/' . $user->photo) : asset('assets/img/user-image.png') }}"
                                                        alt="img" class="user-image">
                                                    <div class="comment-content">
                                                        <span class="username">{{ $comment->name }}</span>
                                                        <span class="timestamp">{{ $comment->created_at->diffForHumans() }}</span>
                                                        <div class="comment-text">{{ $comment->comment }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--Blog Grid End-->
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
