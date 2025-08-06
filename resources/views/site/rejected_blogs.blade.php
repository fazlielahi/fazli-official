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
@endsection

@section('content')
    <style>
        .news-card-items {
            min-height: 368px !important;
        }
        .toast{
            background: rgb(112, 24, 24) !important;
            color: #fff !important;
        }
        .modal-content{
            background: #212629;
        }
        .modal-header{
            border-color: #606060;
        }
        .modal-header .btn-close{
            color:rgb(255, 255, 255) !important;
            margin: 0 !important;
        }
        .modal-footer{
            border-color: #606060;
        }
        .blog-two__single{
            padding-bottom: 2px;
        }
    </style>

    <div class="col-12 mt-3" style="display: flex; flex-direction: row; flex-wrap: wrap; gap: 10px;">
        @if($blogs->count() > 0)
            @foreach($blogs->sortByDesc('created_at') as $blog)
                @if($blog->status === 'rejected' && $blog->created_by == $user->id)
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
                            <!-- Why Rejected Button -->
                            <div class="mt-auto">
                                <button type="button" class="btn btn-sm btn-warning w-100" data-bs-toggle="modal" data-bs-target="#whyRejectedModal{{ $blog->id }}">
                                    {{ __('lang.Why Rejected?') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Why Rejected Modal -->
                    <div class="modal fade" id="whyRejectedModal{{ $blog->id }}" tabindex="-1" aria-labelledby="whyRejectedModalLabel{{ $blog->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="whyRejectedModalLabel{{ $blog->id }}">{{ __('lang.Rejection Details') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                @php
                                    $isRtl = app()->getLocale() === 'ar';
                                @endphp
                                <div class="modal-body" style="direction: {{ $isRtl ? 'rtl' : 'ltr' }}; text-align: {{ $isRtl ? 'right' : 'left' }};">
                                    <p>
                                        <strong style="display:inline-block; min-width: 110px;">{{ __('lang.Reason:') }}</strong>
                                        <span>{{ $blog->rejection_message ?? __('lang.Unknown') }}</span>
                                    </p>
                                    <p>
                                        <strong style="display:inline-block; min-width: 110px;">{{ __('lang.Rejected By:') }}</strong>
                                        <span>{{ $blog->rejected_by_user->name ?? __('lang.Unknown') }}</span>
                                    </p>
                                    <p>
                                        <strong style="display:inline-block; min-width: 110px;">{{ __('lang.Rejected At:') }}</strong>
                                        <span>{{ $blog->updated_at ? $blog->updated_at->format('d/m/Y h:i A') : __('lang.Unknown') }}</span>
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('lang.Close') }}</button>
                                </div>
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
                        <u>{{ explode(' ', $user->name)[0] }}</u> {{ __('lang.has no rejected blogs') }}
                    </h4>
                    <p class="text-muted">{{ __('lang.There are no rejected blog posts at the moment.') }}</p>
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