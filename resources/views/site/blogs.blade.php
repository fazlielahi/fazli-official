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
    
    <!-- Theme styles -->
    <link rel="stylesheet" href="{{ asset('styles/theme.css') }}" />

    
    <!-- responsive design -->
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-blog.css') }}" />

    <style>
        .blog-two__title  {
            height: 64px;
        }

        .page-header{
            margin-top: 40px !important;
        }

        .blog-grid{
            padding-top: 46px !important;
            padding-bottom: 40px !important;
            margin-bottom: 0 !important;
        }

        .blog-two__meta-box.comment-sec,
        .blog-two__meta-box.comment-sec *:not(.fa):not(.fas):not(.far):not(.fab):not(.fa-solid):not(.fa-regular):not(.fa-brands):not(.icon-comments) {
            font-family: 'Outfit', 'Roboto Serif', Arial, sans-serif !important;
            font-size: 15px; /* Adjust as needed for consistency */
            font-weight: 400; /* Adjust as needed */
            letter-spacing: 0.01em; /* Optional: for visual match */
        }

    </style>

@endsection

@section('content')

    <!--Page Header Start-->
    <section class="page-header">
    <div class="breadcrumb-wrapper bg-cover">
                <div class="container">
                    <div class="page-heading">
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ __('lang.Blogs Corner') }}</h1>
                        <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                            <li>
                                <a href="{{ route('localized.home', ['lang' => app()->getLocale()])}}">
                                    {{ __('lang.Home')}}
                                </a>
                            </li>
                            <li>
                                @if(app()->getLocale() === 'ar')
                                    <i class="fas fa-chevron-left"></i>
                                @else
                                    <i class="fas fa-chevron-right"></i>
                                @endif
                            </li>
                            <li>
                                {{ __('lang.Blogs')}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    </section>
    <!--Page Header End-->

    <!--Blogs Grid Start-->
    <section class="blog-grid">
        <div class="blog-row">
            <!-- Add this button just before the left-sidebar div -->
            <button class="categories-toggle-btn d-block d-md-none" type="button" style="margin: 16px;">
                <i class="fa fa-list"></i> {{ __('lang.Topics') }}
            </button>

            <!-- Offcanvas Sidebar -->
            <div class="left-sidebar offcanvas-sidebar">
                <div class="offcanvas-overlay"></div>
                <div class="offcanvas-content">
                    <span class="offcanvas-close">&times;</span>
                    <div class="blog-grid__left">
                        <div class="blog-grid__sidebar">
                            <div class="blog-grid__categories">
                                <div class="blog-grid__title-box">
                                    <h3 class="blog-grid__title">{{ __('lang.What Interests You?') }}</h3>
                                </div>
                                <ul class="list-unstyled blog-grid__list-item">
                                    <li>
                                        <a href="{{ route('localized.blogs', ['lang' => app()->getLocale()]) }}"
                                           class="blog-grid__list-text {{ empty($selectedCategory) ? 'active' : '' }}">
                                            <span class="blog-grid__list-check" style="margin-top: -7px;display:inline-block;width:18px;height:18px;border:1.5px solid #1da370;border-radius:4px;text-align:center;line-height:16px;font-size:14px;color:#1da370;vertical-align:middle;">
                                                @if(empty($selectedCategory))
                                                    <i class="fa fa-check"></i>
                                                @endif
                                            </span>
                                            <span>
                                                {{ __('lang.All Categories') }}
                                            </span>
                                        </a>
                                    </li>
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{ route('localized.blogs.by-category', ['lang' => app()->getLocale(), 'slug' => $category->slug]) }}"
                                                   class="blog-grid__list-text {{ (isset($selectedCategory) && $selectedCategory == $category->id) ? 'active' : '' }}">
                                                <span class="blog-grid__list-check" style="margin-top: -7px;display:inline-block;width:18px;height:18px;border:1.5px solid #1da370;border-radius:4px;text-align:center;line-height:16px;font-size:14px;color:#1da370;vertical-align:middle;">
                                                    @if(isset($selectedCategory) && $selectedCategory == $category->id)
                                                        <i class="fa fa-check"></i>
                                                    @endif
                                                </span>
                                                <span>
                                                    {{ $category->name }}
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="blog-grid__discount ads-section-laptop">
                    
                        <h4 class="sponser-header">{{ __('lang.Sponser') }}</h4>
                               
                    </div>
                </div>
            </div>
            
            <div class="blogs-section">
                @if($blogs->count() > 0)
                @foreach($blogs->sortByDesc('id') as $blog)
                    <!-- Share Modal -->
                    <div class="modal fade" id="shareModalTest" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered share-model" style="max-width: 320px;">
                            <div class="modal-content share-modal">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('lang.Share this blog') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div id="copyMessage" style="color: green; display:none; position: absolute; top: 85px; right: 27px;">
                                    Link copied!
                                </div>
                                <div class="modal-body share-icons-row">
                                    <a href="#" onclick="copyToClipboard('{{ route('localized.blog-details', ['lang' => app()->getLocale(), 'slug' => $blog->slug]) }}')" title="{{ __('lang.Copy Link') }}">
                                        <i class="fa-regular fa-copy text-secondary share-icon"></i>
                                    </a>
                                    <a target="_blank" href="https://wa.me/?text={{ urlencode(route('localized.blog-details', ['lang' => app()->getLocale(), 'slug' => $blog->slug])) }}" title="{{ __('lang.Share on WhatsApp') }}">
                                        <i class="fa-brands fa-whatsapp text-success share-icon"></i>
                                    </a>
                                    <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('localized.blog-details', ['lang' => app()->getLocale(), 'slug' => $blog->slug])) }}&title={{ urlencode($blog->title) }}" title="{{ __('lang.Share on LinkedIn') }}">
                                        <i class="fa-brands fa-linkedin text-primary share-icon"></i>
                                    </a>
                                    <a href="mailto:?subject={{ urlencode($blog->title) }}&body={{ urlencode(route('localized.blog-details', ['lang' => app()->getLocale(), 'slug' => $blog->slug])) }}" title="{{ __('lang.Share via Email') }}">
                                        <i class="fa-regular fa-envelope text-danger share-icon"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Blog Two Single Start -->
                    <div class="wow fadeInLeft blog-card-blogs" data-wow-delay="100ms">
                        <div class="blog-two__single">
                        <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), 'slug' => $blog->slug]) }}">
                            <div class="blog-two__img">
                            <img 
                                src="{{ $blog->thumb && file_exists(public_path('storage/' . $blog->thumb)) ? asset('storage/' . $blog->thumb) : asset('images/blog-default.jpg') }}" 
                                alt="{{ $blog->title ?? 'Blog post image' }}">

                            </div>
                            </a> 
                            <div class="blog-two__content">
                                <div class="blog-two__meta-box blog-profile">
                                    <div class="profile-container">
                                        <a href="{{ route('localized.user-profile', ['lang' => app()->getLocale(), $blog->creater->id]) }}" class="mb-0 text-muted">
                                        <img 
                                            src="{{ $blog->creater && $blog->creater->photo ? asset('images/' . $blog->creater->photo) : asset('images/default.png') }}" 
                                            width="100%" 
                                            class="profile-pic" 
                                            alt="{{ $blog->creater ? 'Photo of ' . $blog->creater->name : 'Default profile image' }}">

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
                                @php
                                    $textDirection = getTextDirection($blog->title);
                                @endphp
                                <h4 class="blog-two__title" style="text-align: {{ $textDirection }} !important;">
                                    <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), 'slug' => $blog->slug]) }}">
                                    {{ Str::limit(html_entity_decode(strip_tags($blog->title)), 45) }}
                                    </a>
                                </h4>   
                            </div>
                            <div class="blog-two__meta-box comment-sec">
                                <ul class="blog-two__meta list-unstyled post-interactions">
                                    <li class="like-btn" data-url="{{ route('localized.blog.like', [app()->getLocale(), $blog->id]) }}">
                                        @if(App\Models\Likes::where('blog_id', $blog->id)->exists())
                                            <i class="heart-icon fa-solid fa-heart"></i>
                                        @else
                                            <i class="heart-icon fa-regular fa-heart"></i>
                                        @endif 
                                        <span class="like">{{ __('lang.Like') }} </span>
                                        <span class="like-count">{{ $blog->likes->count() }}</span>
                                    </li>
                                    <li>
                                        <a href="#" data-bs-toggle="modal" class="comment-a"  data-bs-target="#editModal{{ $blog->id }}" >
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
                    <!-- Comment Modal -->
                    <div class="modal fade comment-modal" id="editModal{{ $blog->id }}" tabindex="-1" aria-hidden="true" style="overflow: hidden; padding-right: 0">
                        <div class="modal-dialog modal-fullscreen" style="height: 100vh;  margin: 0 auto;">
                            <form id="comment-form-{{ $blog->id }}" class="ajax-comment-form" method="POST" action="{{ route('localized.blog.comment', ['lang' => app()->getLocale(), $blog->id]) }}">
                                @csrf
                                <div class="modal-content bg-dark text-light" style="height: 100vh; display: flex; flex-direction: column;">
                                    <div class="modal-header pb-0 bg-dark text-light border-secondary">
                                        <h5 class="modal-title">{{ __('lang.Comments') }}</h5>
                                        <button type="button" class="fa-close-btn" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="far fa-times-circle"></i>
                                        </button>
                                    </div>
                                        <div class="row g-0">
                                            <!-- Left Side - Blog Post -->
                                            <div class="col-12 col-md-6 border-md-end border-secondary">
                                                <div class="p-3">
                                                    <div class="blog-two__single">
                                                        <div class="blog-two__img" id="blog-image-{{ $blog->id }}">
                                                            <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), 'slug' => $blog->slug]) }}">
                                                                <img src="{{ $blog->thumb && file_exists(public_path('storage/' . $blog->thumb)) ? asset('storage/' . $blog->thumb) : asset('images/blog-default.jpg') }}" 
                                                                alt="{{ $blog->title ?? 'Blog post image' }}"  class="img-fluid rounded">
                                                            </a>    
                                                        </div>
                                                        <div class="blog-two__content">
                                                            <div class="blog-two__meta-box blog-profile">
                                                                <div class="profile-container">
                                                                    <a href="{{ route('localized.user-profile', ['lang' => app()->getLocale(), $blog->creater->id]) }}" class="mb-0 text-muted">
                                                                    <img 
                                                                        src="{{ $blog->creater && $blog->creater->photo ? asset('images/' . $blog->creater->photo) : asset('images/default.png') }}" 
                                                                        width="100%" 
                                                                        class="profile-pic" 
                                                                        alt="{{ $blog->creater ? 'Photo of ' . $blog->creater->name : 'Default profile image' }}">
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
                                                            <h4 class="blog-two__title" style="text-align: {{ getTextDirection($blog->title) }} !important;">
                                                                <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), 'slug' => $blog->slug]) }}">
                                                                {{ Str::limit(html_entity_decode(strip_tags($blog->title)), 45) }}

                                                                </a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Right Side - Comments Section -->
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex flex-column">
                                                    <!-- Comment Form -->
                                                    <div class="pt-3 border-bottom border-secondary comment-textarea">
                                                        @php 
                                                            $user = session()->has('user_id') ? \App\Models\User::find(session('user_id')) : null;
                                                        @endphp
                                                        
                                                        @if((!isset($user) || !$user) && (!Cookie::get('visiter_token') || !\App\Models\Comment::where('visiter_token', Cookie::get('visiter_token'))->exists()))
                                                            <div class="mb-3 your-name">
                                                                <label for="title{{ $blog->id }}" class="form-label text-light">{{__('lang.Your Name')}}</label>
                                                                <input type="text" class="form-control bg-secondary text-light border-0" name="name" value="{{ old('name') }}" required>
                                                            </div>
                                                        @endif
                                                        <div class="mb-3" style="position: relative;">
                                                            <textarea class="form-control bg-secondary text-light border-0 comment-textarea" name="comment" id="comment-textarea-{{ $blog->id }}" rows="3" placeholder="{{__('lang.Add a comment')}}" required>{{ old('comment') }}</textarea>
                                                            
                                                            <div class="comment-emoji">
                                                              <!-- Emoji Picker Container -->
                                                              <div class="emoji-picker-container">
                                                                <button type="button" class="emoji-toggle-btn" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #666; padding: 5px; border-radius: 50%; transition: all 0.3s ease;">
                                                                    😊
                                                                </button>
                                                                <div class="emoji-panel" style="display: none; position: absolute; left: 0; background: white; border: 1px solid #ddd; border-radius: 8px; padding: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 240px; margin-bottom: 5px;">
                                                                    <div class="emoji-grid" style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 8px;">
                                                                        <button type="button" class="emoji-btn" data-emoji="😊">😊</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😂">😂</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😍">😍</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😎">😎</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🤔">🤔</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="👍">👍</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="👎">👎</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="❤️">❤️</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🔥">🔥</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="💯">💯</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="✨">✨</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🎉">🎉</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="👏">👏</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🙏">🙏</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😭">😭</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😡">😡</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😱">😱</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😴">😴</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🤗">🤗</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😇">😇</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🤩">🤩</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😋">😋</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🤪">🤪</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😝">😝</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🤓">🤓</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😤">😤</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😪">😪</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🤐">🤐</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😷">😷</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🤒">🤒</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🤕">🤕</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🤢">🤢</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🤮">🤮</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🤧">🤧</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😈">😈</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="👿">👿</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="👹">👹</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="👺">👺</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="💀">💀</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="☠️">☠️</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="👻">👻</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="👽">👽</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🤖">🤖</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="💩">💩</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😺">😺</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😸">😸</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😹">😹</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😻">😻</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😼">😼</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😽">😽</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="🙀">🙀</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😿">😿</button>
                                                                        <button type="button" class="emoji-btn" data-emoji="😾">😾</button>
                                                                    </div>
                                                                </div>
                                                                </div>

                                                                <!-- Comment Button Inside Textarea -->
                                                                <div class="comment-btn-container">
                                                                    <button type="submit" class="comment-btn-inside" style="background: linear-gradient(135deg, #1da370 0%, #0d8a5a 100%); color: white; border: none; border-radius: 20px; padding: 8px 16px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(29, 163, 112, 0.3);">
                                                                        <span class="icon-arrow-circle" style="margin-right: 5px;"></span>
                                                                        {{ __('lang.Comment') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                          
                                                        </div>
                                                        <div class="ajax-comment-error text-danger"></div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            @if($blog->comments->count() < 1)
                                                                <span class="text-light">{{ __('lang.Be the first to comment!') }}</span>
                                                            @else
                                                                <div class="read-comments-wrapper">
                                                                    <a class="read-comments-btn" href="#show-comments-{{ $blog->id }}" data-blog-id="{{ $blog->id }}" style="color: #FFC224;">
                                                                        {{ __('lang.Read all comments') }} <i class="fa-solid fa-arrow-down-wide-short" style="color: #FFC224;"></i>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- Comments List -->
                                                    <div class="comments-list flex-grow-1 p-3" id="show-comments-{{ $blog->id }}" style="display: none;">
                                                        @if($blog->comments->count() < 1)
                                                            <div class="no-comments">{{ __('lang.Be the first to comment!') }}</div>
                                                        @else
                                                            @foreach($blog->comments->sortByDesc('created_at') as $comment)

                                                                @php $user = $comment->user; @endphp
                                                                @if($user)
                                                                    <div class="comment-card">
                                                                    <img
                                                                        src="{{ $user && $user->photo ? asset('images/' . $user->photo) : asset('images/default.png') }}"
                                                                        class="user-image"
                                                                        alt="{{ $user ? $user->name . ' profile photo' : 'Default user profile photo' }}">
                                                                        <div class="comment-content">
                                                                            <span class="username">{{ $comment->name }}</span>
                                                                            <span class="timestamp">{{ $comment->created_at->diffForHumans() }}</span>
                                                                            <div class="comment-text">{{ $comment->comment }}</div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="comment-card">
                                                                        <img
                                                                            src="{{ $comment && $comment->photo ? asset('images/' . $comment->photo) : asset('images/default.png') }}"
                                                                            class="user-image" alt="">
                                                                        <div class="comment-content">
                                                                            <span class="username">{{ $comment->name }}</span>
                                                                            <span class="timestamp">{{ $comment->created_at->diffForHumans() }}</span>
                                                                            <div class="comment-text">{{ $comment->comment }}</div>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                            @endforeach
                                                        @endif
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
                        <h4 class="text-muted">{{ __('lang.No blogs uploaded yet') }} </h4>
                        <p class="text-muted">{{ __('lang.There are no blogs available in the selected category.') }}</p>
                    </div>
                </div>
                @endif
                <div class="ads-section-mobile">                       
                </div>
            </div>
        </div>

        <div class="no-more-blog">
            <span class="text-secondary">{{ __('lang.NoMoreBlogs') }}</span>
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

            // Emoji Picker Functionality for Blogs
            $('.emoji-toggle-btn').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var $panel = $(this).siblings('.emoji-panel');
                $('.emoji-panel').not($panel).hide();
                $panel.toggle();
            });

            // Close emoji panel when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.emoji-picker-container').length) {
                    $('.emoji-panel').hide();
                }
            });

            // Insert emoji into textarea
            $('.emoji-btn').on('click', function(e) {
                e.preventDefault();
                var emoji = $(this).data('emoji');
                var $textarea = $(this).closest('.mb-3').find('textarea');
                var cursorPos = $textarea[0].selectionStart;
                var textBefore = $textarea.val().substring(0, cursorPos);
                var textAfter = $textarea.val().substring(cursorPos);
                
                $textarea.val(textBefore + emoji + textAfter);
                
                // Set cursor position after the inserted emoji
                var newCursorPos = cursorPos + emoji.length;
                $textarea[0].setSelectionRange(newCursorPos, newCursorPos);
                $textarea.focus();
                
                // Hide the emoji panel
                $('.emoji-panel').hide();
            });

            // Emoji button hover effects
            $('.emoji-btn').on('mouseenter', function() {
                $(this).css({
                    'transform': 'scale(1.2)',
                    'transition': 'transform 0.2s ease'
                });
            }).on('mouseleave', function() {
                $(this).css({
                    'transform': 'scale(1)',
                    'transition': 'transform 0.2s ease'
                });
            });

            // Offcanvas for Categories
            const toggleBtn = document.querySelector('.categories-toggle-btn');
            const offcanvasSidebar = document.querySelector('.offcanvas-sidebar');
            const offcanvasOverlay = document.querySelector('.offcanvas-overlay');
            const offcanvasClose = document.querySelector('.offcanvas-close');

            function openOffcanvas() {
                offcanvasSidebar.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
            function closeOffcanvas() {
                offcanvasSidebar.classList.remove('active');
                document.body.style.overflow = '';
            }

            if (toggleBtn && offcanvasSidebar) {
                toggleBtn.addEventListener('click', openOffcanvas);
            }
            if (offcanvasOverlay) {
                offcanvasOverlay.addEventListener('click', closeOffcanvas);
            }
            if (offcanvasClose) {
                offcanvasClose.addEventListener('click', closeOffcanvas);
            }
        });
    </script>

    <script src="{{ asset('lib/jquery-1.11.3.min.js') }}"></script>

    <style>
        .emoji-toggle-btn:hover {
            background-color: rgba(255,255,255,0.1) !important;
            transform: scale(1.1);
        }

        
        .footer{
            position: unset;
        }
        
        .emoji-btn {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: all 0.2s ease;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .emoji-btn:hover {
            background-color: #f0f0f0;
            transform: scale(1.2);
        }
        
        .emoji-panel {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95) !important;
        }
        
        .comment-btn-inside:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(29, 163, 112, 0.4) !important;
        }
        
        @media (max-width: 768px) {
            .emoji-panel {
                min-width: 200px !important;
            }
            .emoji-grid {
                grid-template-columns: repeat(5, 1fr) !important;
                gap: 6px !important;
            }
            .emoji-btn {
                width: 25px;
                height: 25px;
                font-size: 16px;
            }
            .comment-btn-inside {
                padding: 6px 12px !important;
                font-size: 12px !important;
            }
        }

        @media (max-width: 700px) {
            .modal.comment-modal,
            .modal.comment-modal .modal-dialog,
            .modal.comment-modal .modal-content {
                overflow-y: auto !important;
                overflow-x: visible !important;
            }
            .modal.comment-modal .modal-content {
                display: block !important;
            }
            .modal.comment-modal .row.g-0 {
                flex-direction: column !important;
            }
            .modal.comment-modal .col-12 {
                border-right: none !important;
                margin: 0 !important;
                z-index: 100 !important;
            }
            .modal.comment-modal .col-12:last-child {
                border-bottom: none;
            }
        }

        .fa-close-btn {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            color: #fff; /* white for dark theme */
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            line-height: 1;
            transition: color 0.2s;
        }
        body[data-theme="light"] .fa-close-btn {
            color: #222; /* dark for light theme */
        }
        .fa-close-btn:focus {
            outline: 2px solid #18835a;
        }
    </style>
@endsection
