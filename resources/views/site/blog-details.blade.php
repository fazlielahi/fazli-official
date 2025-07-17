@extends('site.layout')

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

    <!-- responsive design -->
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-blog-details.css') }}" />

    <style>
        body{
            background-image: none;
            background: black;
        }
        
        .extra-comment { display: none; }

        .categ-btn{
            text-align: right;
        }

    </style>

@endsection

@section('content')

<div class="page-wrapper">

    <!--Page Header Start-->
    <section class="page-header">
    <div class="breadcrumb-wrapper bg-cover">
                <div class="container">
                    <div class="page-heading">
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ __('lang.Explore This Post') }}</h1>
                        <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                            <li>
                                <a href="{{ route('localized.blogs', ['lang' => app()->getLocale()])}}">
                                    {{ __('lang.Blogs')}}
                                </a>
                            </li>
                            <li>
                                <i class="fas fa-chevron-right"></i>
                            </li>
                            <li>
                                {{ __('lang.Blog Details')}}
                            </li>
                        </ul>
                    </div>
                    <div class="blog-image-container">
                        <img src="{{asset('storage/' . $blog->image)}}" width="100%"/>
                    </div>
                </div>
            </div>
    </section>
    <!--Page Header End-->

<!--Blog Details Start-->
<section class="blog-details">
    <div class="container ">
        <div class="row">
            <div class="col-xl-8 col-lg-7 blog-details-container">
                <div class="blog-details__left">
                    <div class="blog-details__content">
                        <h3 class="blog-details__title-1">{{ $blog->title }}</h3>
                        <div class="blog-details__client-and-meta">
                            <div class="blog-details__client-box">
                                <div class="blog-details__client-img">
                                <img src="{{ $blog->creater && $blog->creater->photo ? asset('images/' . $blog->creater->photo) : asset('images/default.png') }}" alt="profile" style="width:31px; height:31px; border-radius:50%; object-fit:cover; margin-right:6px; vertical-align:middle;">
                                </div>
                                <div class="blog-details__client-content">
                                    <h4>{{ $blog->creater->name ?? __('lang.unknown')}}</h4>
                                </div>
                            </div>
                            <ul class="blog-details__client-meta list-unstyled">
                                <li>
                                    <div class="icon">
                                        <span class="icon-calendar"></span>
                                    </div>
                                    <p>{{ $blog->created_at->diffForHumans() }}</p>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-comments"></span>
                                    </div>
                                    <p><a href="#comments-section">{{$blog->comments->count()}} {{ __('lang.Comments')}}</a></p>
                                </li>
                            </ul>
                        </div>
                        <div class="blog-details-contents">
                            {!! $blog->content !!} 
                        </div>
                        <div class="blog-details__tag-and-share">
                            <div class="blog-details__share share-btn" data-bs-toggle="modal" data-bs-target="#shareModalTest">
                                <span>{{ __('lang.Share') }} <i class="far fa-share-square" style="color: #1da370;"></i></span>
                            </div>
                        </div>

                        <!-- Share Modal -->
                        <div class="modal fade" id="shareModalTest" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered" style="max-width: 320px;">
                                <div class="modal-content share-modal">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('lang.Share this blog') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div id="copyMessage" style="color: green; display:none; position: absolute; top: 85px; right: 27px;">{{ __('lang.Copy Link') }}</div>
                                    <div class="modal-body share-icons-row">
                                        <a href="#" onclick="copyToClipboard('{{ route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id]) }}')" title="{{ __('lang.Copy Link') }}">
                                            <i class="fa-regular fa-copy text-secondary share-icon"></i>
                                        </a>
                                        <a target="_blank" href="https://wa.me/?text={{ urlencode(route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id])) }}" title="{{ __('lang.Share on WhatsApp') }}">
                                            <i class="fa-brands fa-whatsapp text-success share-icon"></i>
                                        </a>
                                        <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id])) }}&title={{ urlencode($blog->title) }}" title="{{ __('lang.Share on LinkedIn') }}">
                                            <i class="fa-brands fa-linkedin text-primary share-icon"></i>
                                        </a>
                                        <a href="mailto:?subject={{ urlencode($blog->title) }}&body={{ urlencode(route('localized.blog-details', ['lang' => app()->getLocale(), $blog->id])) }}" title="{{ __('lang.Share via Email') }}">
                                            <i class="fa-regular fa-envelope text-danger share-icon"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="comment-one" id="comments-section">
                            <h3 class="comment-one__title">
                                 {{ __('lang.Comments')}} 
                                </h3>
                                <div id="show-comments-{{ $blog->id }}"  class="comment-one__list-wrapper" style="max-height: 500px; overflow: auto;">
                                @foreach($blog->comments->sortByDesc('created_at')->values() as $index => $comment)
                                    @php $user = $comment->user; @endphp
                                    <div class="comment-card comment-item{{ $index >= 2 ? ' extra-comment' : '' }}" style="border-bottom: 1px solid #222222; margin-bottom: 20px; padding-bottom: 4px; align-items: flex-start;">
                                        <img
                                            src="{{ $user && $user->photo ? asset('images/' . $user->photo) : ($comment && $comment->photo ? asset('images/' . $comment->photo) : asset('images/default.png')) }}"
                                            class="user-image" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 12px;">
                                        <div class="comment-content comment-detail">
                                            <span class="username" style="font-weight: bold;">{{ $comment->name }}</span>
                                            <span class="timestamp" style="color: #888; font-size: 0.9em; margin-left: 8px;">{{ $comment->created_at->diffForHumans() }}</span>
                                            <div class="comment-text" style="margin-top: 4px;">{{ $comment->comment }}</div>
                                        </div>
                                    </div>
                                @endforeach
                                @if($blog->comments->count() > 2)
                                    <button id="toggle-comments-btn" type="button" class="show-more-btn"><i class="fa fa-chevron-down" aria-hidden="true"></i> {{ __('lang.Show More Comments') }}</button>
                                    <button id="toggle-comments-less-btn" type="button" class="show-more-btn" style="display:none;"><i class="fa fa-chevron-up" aria-hidden="true"></i> {{ __('lang.Show Less Comments') }}</button>
                                @endif
                            </div>
                        </div>
                        <div class="comment-form">
                            <form method="POST" action="{{ route('localized.blog.comment', ['lang' => app()->getLocale(), $blog->id]) }}" class="comment-form ajax-comment-form" id="comment-form-{{ $blog->id }}">
                                @csrf
                                @php 
                                    $user = session()->has('user_id') ? \App\Models\User::find(session('user_id')) : null;
                                @endphp
                                                        
                                @if((!isset($user) || !$user) && (!Cookie::get('visiter_token') || !\App\Models\Comment::where('visiter_token', Cookie::get('visiter_token'))->exists()))
                                    <div class="row">
                                        <div class="col">
                                            <div class="comment-form__input-box">
                                            <input type="text" class="form-control text-light" placeholder="{{ __('lang.Enter Your Name') }}" name="name" value="{{ old('name') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="comment-form__input-box text-message-box" style="position: relative;">
                                                <textarea name="comment" id="comment-textarea" placeholder="{{ __('lang.Add a comment')}}" style="padding-bottom: 50px; padding-right: 80px;">{{ old('comment') }}</textarea>
                                                
                                                <!-- Emoji Picker Container -->
                                                <div class="emoji-picker-container" style="position: absolute; bottom: 10px; left: 10px; z-index: 10;">
                                                    <button type="button" class="emoji-toggle-btn" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #666; padding: 5px; border-radius: 50%; transition: all 0.3s ease;">
                                                        😊
                                                    </button>
                                                    <div class="emoji-panel" style="display: none; position: absolute; bottom: 100%; left: 0; background: white; border: 1px solid #ddd; border-radius: 8px; padding: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 240px; max-height: 200px; overflow-y: auto; margin-bottom: 5px;">
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
                                                <div class="comment-btn-container" style="position: absolute; bottom: 10px; right: 10px; z-index: 10;">
                                                    <button type="submit" class="comment-btn-inside" form="comment-form-{{ $blog->id }}" onclick="console.log('Button clicked!')" style="background: linear-gradient(135deg, #1da370 0%, #0d8a5a 100%); color: white; border: none; border-radius: 20px; padding: 8px 16px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(29, 163, 112, 0.3);">
                                                        <span class="icon-arrow-circle" style="margin-right: 5px;"></span>
                                                        {{ __('lang.Comment') }}
                                                    </button>
                                                </div>

                                                <style>
                                                    .emoji-toggle-btn:hover {
                                                        background-color: rgba(0,0,0,0.1) !important;
                                                        transform: scale(1.1);
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
                                                </style>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ajax-comment-error text-danger"></div>
                            </form>
                            <div class="result"></div>
                        </div>
                    </div>
                </div>
                <div class="ads">

                </div>
            </div>
            <div class="col-xl-4 col-lg-5 categories-section">
                <div class="sidebar">
                    <div class="offcanvas offcanvas-end bg-dark text-light" tabindex="-1" id="categoriesOffcanvas" aria-labelledby="categoriesOffcanvasLabel" data-bs-backdrop="false">
                        <div class="offcanvas-header border-bottom border-secondary">
                            <h5 class="offcanvas-title text-light" id="categoriesOffcanvasLabel">{{ __('lang.What Interests You?') }}</h5>
                            <button type="button" class="btn-close-category" data-bs-dismiss="offcanvas" aria-label="{{ __('lang.Close') }}"> <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="sidebar__category-list list-unstyled">
                                <li>
                                    <a href="{{ route('localized.blogs', ['lang' => app()->getLocale()]) }}" class="{{ empty($selectedCategory) ? 'active' : '' }} text-light category-buttons">
                                        {{ __('lang.All') }}
                                        <span class="fas fa-arrow-right"></span>
                                    </a>
                                </li>
                                @foreach($categories as $category)
                                    <li class="{{ $selectedCategory == $category->id ? 'active' : '' }}">
                                        <a href="{{ route('localized.blogs', ['lang' => app()->getLocale()]) }}?category_id={{ $category->id }}" class="text-light category-buttons">
                                            {{ $category->name }}
                                            <span class="fas fa-arrow-right"></span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- Replace the sidebar category section with just the button for mobile, keep sidebar for desktop -->
                    <div class="sidebar__single sidebar__post">
                        <div class="sidebar__title-box mb-0 latest-post-box">
                              <!-- Categories Button and Offcanvas -->
                            <h3 class="sidebar__title">{{ __('lang.What’s New') }}</h3>
                            <button class="btn btn-outline-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#categoriesOffcanvas" aria-controls="categoriesOffcanvas">
                                    <i class="fa fa-list"></i> {{ __('lang.Topics') }}
                                </button>
                        </div>
                        <ul class="sidebar__post-list list-unstyled">
                        @foreach($popular_blogs as $popular_blog)
                            <ul class="sidebar__post-meta list-unstyled mt-3">
                                            <li>
                                                <p><span class="icon-tags"></span>{{ $popular_blog->category ? $popular_blog->category->name : __('lang.Development') }}</p>
                                            </li>
                                            <li>
                                                <p><span class="icon-clock"></span>{{$popular_blog->created_at->diffForHumans() }}</p>
                                            </li>
                                        </ul>
                            <li>
                                <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), $popular_blog->id]) }}">
                                    <div class="sidebar__post-image">
                                        <img src="{{ $popular_blog->thumb && file_exists(public_path('storage/' . $blog->thumb)) ? asset('storage/' . $popular_blog->thumb) : asset('images/blog-default.jpg') }}" >       
                                    </div>
                                <div class="sidebar__post-content">
                                    <h3 class="sidebar__post-title">
                                        <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), $popular_blog->id]) }}">
                                            {{ Str::limit(html_entity_decode(strip_tags($popular_blog->title)), 45) }}
                                        </a>
                                    </h3>
                                </div>
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                    <div class="sidebar__single sidebar__newsletter">
                        <div class="sidebar__title-box">
                            <div class="sidebar__title-icon">
                                <img src="assets/images/icon/sidebar-title-icon.png" alt="">
                            </div>
                            <h3 class="sidebar__title">{{ __('lang.Sponsored') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Blog Details End-->

</div><!-- /.page-wrapper -->


@endsection

@section('script')
{{-- Core JS --}}
        <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

        {{-- Plugins --}}
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

        {{-- GSAP --}}
        <script src="{{ asset('assets/js/gsap/gsap.js') }}"></script>
        <script src="{{ asset('assets/js/gsap/ScrollTrigger.js') }}"></script>
        <script src="{{ asset('assets/js/gsap/SplitText.js') }}"></script>

        {{-- Custom Template JS --}}
        <script src="{{ asset('assets/js/script.js') }}"></script>

        {{-- Heart Icon Toggle Script --}}
        <script>
            $(document).ready(function() {
                // Heart icon toggle functionality
                $('.blogs-one__heart a').on('click', function(e) {
                    e.preventDefault();
                    var $heartIcon = $(this).find('.icon-heart');
                    
                    // Toggle the active class
                    $heartIcon.toggleClass('active');
                    
                    // Optional: Add animation effect
                    if ($heartIcon.hasClass('active')) {
                        $heartIcon.addClass('heart-beat');
                        setTimeout(function() {
                            $heartIcon.removeClass('heart-beat');
                        }, 300);
                    }
                });
            });
        </script>

<script>

    // Emoji Picker Functionality
    $(document).ready(function() {
        // Emoji Picker Functionality
        $(document).on('click', '.emoji-toggle-btn', function(e) {
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
        $(document).on('click', '.emoji-btn', function(e) {
            e.preventDefault();
            var emoji = $(this).data('emoji');
            var $textarea = $('#comment-textarea');
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
</script>

<script>
function setupCommentToggle() {
    // Remove previous handlers to avoid duplicates
    $('#toggle-comments-btn').off('click').on('click', function() {
        $('.extra-comment').slideDown();
        $(this).hide();
        $('#toggle-comments-less-btn').show();
    });
    $('#toggle-comments-less-btn').off('click').on('click', function() {
        $('.extra-comment').slideUp();
        $(this).hide();
        $('#toggle-comments-btn').show();
        // Optionally scroll to the comments section
        $('html, body').animate({
            scrollTop: $('#comments-section').offset().top - 100
        }, 400);
    });
}
window.setupCommentToggle = setupCommentToggle;
$(document).ready(setupCommentToggle);
</script>


@endsection
