@extends('site.layout')
@section('body_class', 'page-blogs')

@section('title', __('lang.Explore Blogs on Web Development, AI, Career Tips & More | TFC - The Fazli Community'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Discover expert articles and insights across categories like Web Development, AI & Automation, Career Tips, UI/UX Design, Tech News, Sports, Politics, Entertainment, Science, and more at The Fazli Community blog." />
    
    <meta name="keywords" content="web development, AI automation, career tips, UI/UX design, tech news, sports, politics, entertainment, science, learning resources, projects case studies, APIs integrations, resume tips, hosting deployment" />


    <meta property="og:title" content="Explore Blogs on Web Development, AI, Career Tips & More â€“ The Fazli Community" />
    <meta property="og:description"   content="Dive into our rich collection of blog categories including Web Development, AI & Automation, Career Tips, UI/UX Design, Tech News, Sports, Politics, and more." />

    <meta property="og:image"         content="https://thefazli.com/images/tfc-blogs-page-preview.png" />
    <meta property="og:url"           content="https://thefazli.com/{{$locale}}/blogs" />
    <meta property="og:type"          content="website" />


    <meta name="twitter:card"         content="summary_large_image" />
    <meta name="twitter:site"         content="@fazlielahi" />
    <meta property="og:title" content="Explore Blogs on Web Development, AI, Career Tips & More â€“ The Fazli Community" />
    <meta property="og:description" content="Dive into our rich collection of blog categories including Web Development, AI & Automation, Career Tips, UI/UX Design, Tech News, Sports, Politics, and more." />
    <meta name="twitter:image"        content="https://thefazli.com/images/tfc-blogs-page-preview.png" />

    <meta name="author" content="TFC - The Fazli Community" />
    <meta name="robots" content="index, follow, max-image-preview:large">
    
    <link rel="canonical" href="https://thefazli.com/{{$locale}}/blogs" />
    
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/footer.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/services.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/blog.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />
    <link rel="stylesheet" href="{{ asset('styles/theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-blog.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/blogs.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/blogs-comment-modal.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
@endsection

@section('content')

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
                                            <span class="blog-grid__list-check">
                                                @if(empty($selectedCategory))
                                                    <i class="fa fa-check"></i>
                                                @endif
                                            </span>
                                            <span>
                                                {{ __('lang.All Categories') }}
                                                <span class="blog-grid__count">({{ $totalPublishedCount }})</span>
                                            </span>
                                        </a>
                                    </li>
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{ route('localized.blogs.by-category', ['lang' => app()->getLocale(), 'slug' => $category->slug]) }}"
                                                   class="blog-grid__list-text {{ (isset($selectedCategory) && $selectedCategory == $category->id) ? 'active' : '' }}">
                                                <span class="blog-grid__list-check">
                                                    @if(isset($selectedCategory) && $selectedCategory == $category->id)
                                                        <i class="fa fa-check"></i>
                                                    @endif
                                                </span>
                                                <span>
                                                    {{ $category->name }}
                                                    <span class="blog-grid__count">({{ $category->published_count }})</span>
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
                @php
                    $blogsListUrl = isset($selectedCategorySlug)
                        ? route('localized.blogs.by-category', ['lang' => app()->getLocale(), 'slug' => $selectedCategorySlug])
                        : route('localized.blogs', ['lang' => app()->getLocale()]);
                @endphp

                <div class="blogs-toolbar"
                     id="blogs-toolbar"
                     data-list-url="{{ $blogsListUrl }}"
                     data-search-url="{{ route('localized.blogs.search-preview', ['lang' => app()->getLocale()]) }}"
                     data-category-id="{{ $selectedCategory ?? '' }}"
                     data-see-all-label="{{ __('lang.Blogs see all results') }}"
                     data-no-results-label="{{ __('lang.Blogs no preview results') }}"
                     data-searching-label="{{ __('lang.Blogs searching') }}">
                    <div class="blogs-toolbar__form">
                        <div class="blogs-toolbar__search">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <input type="search"
                                   id="blogs-search-input"
                                   name="q"
                                   value="{{ $search }}"
                                   placeholder="{{ __('lang.Blogs search placeholder') }}"
                                   class="blogs-toolbar__input"
                                   autocomplete="off"
                                   aria-expanded="false"
                                   aria-controls="blogs-search-dropdown">
                            <div id="blogs-search-dropdown"
                                 class="blogs-search-dropdown"
                                 role="listbox"
                                 hidden></div>
                        </div>
                        <select id="blogs-sort-select"
                                name="sort"
                                class="blogs-toolbar__select"
                                aria-label="{{ __('lang.Filter') }}">
                            <option value="newest" @selected($sort === 'newest')>{{ __('lang.Blogs sort newest') }}</option>
                            <option value="liked" @selected($sort === 'liked')>{{ __('lang.Blogs sort liked') }}</option>
                            <option value="commented" @selected($sort === 'commented')>{{ __('lang.Blogs sort commented') }}</option>
                        </select>
                    </div>
                    <p class="blogs-toolbar__meta" id="blogs-toolbar-meta">
                        @if($blogs->total() > 0)
                            {{ __('lang.Blogs showing results', ['count' => $blogs->count(), 'total' => $blogs->total()]) }}
                        @endif
                    </p>
                </div>

                <div id="blogs-results" class="blogs-results" aria-live="polite">
                    @include('site.partials.blogs-results')
                </div>
                <div class="ads-section-mobile">                       
                </div>
            </div>
        </div>
    </section>
    <!--Blog Grid End-->
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.js') }}"></script>
    <script src="{{ asset('js/blogs-filter.js') }}"></script>
    <script>
        window.TFC_BLOG_COMMENTS = {
            readAllLabel: @json(__('lang.Read all comments')),
            noCommentsLabel: @json(__('lang.No comments yet')),
            commentLabel: @json(__('lang.Comment')),
            commentsLabel: @json(__('lang.Comments'))
        };
    </script>
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
                var $textarea = $(this).closest('.comment-modal__composer-box, .comment-textarea-wrap, .mb-3').find('textarea').first();
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
            $(document).on('mouseenter', '.emoji-btn', function() {
                $(this).css({
                    'transform': 'scale(1.2)',
                    'transition': 'transform 0.2s ease'
                });
            });

            $(document).on('mouseleave', '.emoji-btn', function() {
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

    <style>
        .footer{
            position: unset;
        }
    </style>
@endsection
