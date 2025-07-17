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
    @php
        $user = session()->has('user_id') ? \App\Models\User::find(session('user_id')) : null;
    @endphp

    <div class="col-12 @if($user && $user->type == 'admin') col-md-10 @else col-md-12 @endif" style="display: flex; flex-direction: row; flex-wrap: wrap; gap: 10px;">
        @if($blogs->count() > 0)
            @foreach($blogs->sortByDesc('id') as $blog)
                <!-- Share Modal -->
                <div class="modal fade" id="shareModalTest" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 320px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ __('lang.Share this blog') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div id="copyMessage" style="color: green; display:none; position: absolute; top: 85px; right: 27px;">Link copied!</div>

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
                                <img src="{{ $blog->thumb && file_exists(public_path('storage/' . $blog->thumb)) ? asset('storage/' . $blog->thumb) : asset('images/blog-default.jpg') }}" >
                            </a>
                            <div class="blog-two__date">
                                <span class="icon-calendar"></span>
                                <p>{{ $blog->created_at->diffForHumans() }}</p>
                            </div>
                            @php
                                $user = session()->has('user_id') ? \App\Models\User::find(session('user_id')) : null;
                            @endphp
                            @if(($user && $user->id == $blog->created_by))
                                <div class="action">
                                    <a class="btn btn-icon btn-info" href="{{ $user && $user->type === 'super_admin' ? route('localized.admin.blog.edit', ['lang' => app()->getLocale(), $blog->id]) : route('localized.admin.blog.edit', ['lang' => app()->getLocale(), $blog->id]) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    
                                    <form id="delete-form-{{ $blog->id }}" 
                                        action="{{ route('localized.admin.blog.destroy', ['lang' => app()->getLocale(), $blog->id]) }}" 
                                        method="POST" 
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete({{ $blog->id }})">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="blog-two__content">
                            <div class="blog-two__meta-box blog-profile">
                                <div class="profile-container">
                                    <a href="{{ route('localized.user-profile', ['lang' => app()->getLocale(), $blog->creater->id]) }}" class="mb-0 text-muted">
                                        <img src="{{ $blog->creater && $blog->creater->photo ? asset('images/' . $blog->creater->photo) : asset('images/default.png') }}"  width="100%" class="profile-pic">
                                    </a>
                                    <span class="username">
                                        <a href="{{ route('localized.user-profile', ['lang' => app()->getLocale(), $blog->creater->id]) }}">
                                            {{ $blog->creater->name ?? "unknown" }}
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <h4 class="blog-two__title">
                                <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id]) }}">
                                    {{ Str::limit(html_entity_decode(strip_tags($blog->title)), 45) }}
                                </a>
                            </h4>
                        </div>
                        <div class="blog-two__meta-box comment-sec">
                            <ul class="blog-two__meta list-unstyled">
                                <li class="like-btn" data-url="{{ route('localized.blog.like', [app()->getLocale(), $blog->id]) }}">
                                    @if(App\Models\Likes::where('blog_id', $blog->id)->exists())
                                        <i class="heart-icon fa-solid fa-heart" style="color: #1da370;"></i>
                                    @else
                                        <i class="heart-icon fa-regular fa-heart" style="color: #0c6164;"></i>
                                    @endif
                                    <span class="like-count">{{ $blog->likes->count() }}</span>
                                </li>
                                <li>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $blog->id }}">
                                        <span class="icon-comments"></span>
                                    </a>
                                </li>
                                <li data-bs-toggle="modal" class="share-btn" data-bs-target="#shareModalTest">
                                    <i class="far fa-share-square" style="color: #0c6164;"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Comment Modal -->
                <div class="modal fade comment-modal" id="editModal{{ $blog->id }}" tabindex="-1" aria-hidden="true" style="height: 100vh; overflow: hidden">
                    <div class="modal-dialog modal-fullscreen" style="height: 100vh; max-width: 80% !important; margin: 0 auto;">
                        <form id="comment-form-{{ $blog->id }}" class="ajax-comment-form" method="POST" action="{{ route('localized.blog.comment', ['lang' => app()->getLocale(), $blog->id]) }}">
                            @csrf
                            <div class="modal-content bg-dark text-light" style="height: 100vh; display: flex; flex-direction: column;">
                                <div class="modal-header pb-0 bg-dark text-light border-secondary">
                                    <h5 class="modal-title">{{ __('lang.Comments') }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body bg-dark text-light p-0">
                                    <div class="row g-0 h-100 comment-row">
                                        <!-- Left Side - Blog Post -->
                                        <div class="col-md-6 border-end border-secondary">
                                            <div class="p-3">
                                                <div class="blog-two__single">
                                                    <div class="blog-two__img" id="blog-image-{{ $blog->id }}">
                                                        <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id]) }}">
                                                            <img src="{{ asset('storage/' . $blog->thumb) }}" onerror="this.onerror=null;this.src='{{ asset('images/default.png') }}';" class="img-fluid rounded">
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
                                                                        src="{{ $blog->creater && $blog->creater->photo ? asset('images/' . $blog->creater->photo) : asset('images/default.png') }}"
                                                                         width="100%" class="profile-pic">
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
                                                            {{ Str::limit(html_entity_decode(strip_tags($blog->content)), 350) }} 
                                                            <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id]) }}" class="link-btn">
                                                                Read! <span class="icon-clock"></span>
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Right Side - Comments Section -->
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column h-100">
                                                <!-- Comment Form -->
                                                <div class="p-3 border-bottom border-secondary">
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
                                                        <textarea class="form-control bg-secondary text-light border-0" name="comment" rows="3" placeholder="{{__('lang.Add a comment')}}" required>{{ old('comment') }}</textarea>
                                                    </div>
                                                    <div class="ajax-comment-error text-danger"></div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        @if($blog->comments->count() < 1)
                                                            <span class="text-light">{{__('lang.Be the first to comment!')}}</span>
                                                        @else
                                                            <div class="read-comments-wrapper">
                                                                <a class="read-comments-btn" href="#show-comments-{{ $blog->id }}" data-blog-id="{{ $blog->id }}" style="color: #FFC224;">
                                                                    {{__('lang.Read all comments')}} <i class="fa-solid fa-arrow-down-wide-short" style="color: #FFC224;"></i>
                                                                </a>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-sm text-light" style="background-color: var(--fistudy-base);">{{__('lang.Comment')}}</button>
                                                    </div>
                                                </div>

                                                <!-- Comments List -->
                                                <div class="comments-list flex-grow-1 p-3" id="show-comments-{{ $blog->id }}" style="display: none;">
                                                    @if($blog->comments->count() < 1)
                                                        <div class="no-comments">{{__('lang.Be the first to comment!')}}</div>
                                                    @else
                                                        @foreach($blog->comments->sortByDesc('created_at') as $comment)
                                                            @php $user = $comment->user; @endphp
                                                            <div class="comment-card">
                                                                <img
                                                                    src="{{ $user && $user->photo ? asset('images/' . $user->photo) : asset('images/default.png') }}"
                                                                    class="user-image">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center py-5">
                <div class="no-blogs-message">
                    <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">{{ __('lang.No blogs uploaded by') }} <u> {{ explode(' ', $user->name)[0] }} </u> </h4>
                    <p class="text-muted">{{ __('lang.There are no blogs available in selected category.') }}</p>
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