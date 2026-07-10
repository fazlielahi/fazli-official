@extends('site.profile')

@section('body_class', 'page-blogs')

@section('page_title')
    {{ __('lang.Published') }}
@endsection

@section('page_header_actions')
    <a href="{{ route('localized.blog-create', ['lang' => app()->getLocale(), 'return' => url()->full()]) }}"
       class="profile-new-post-btn"
       title="{{ __('lang.New Post') }}"
       aria-label="{{ __('lang.Create Blog') }}">
        <i class="fa-solid fa-plus" aria-hidden="true"></i>
        <span>{{ __('lang.New Post') }}</span>
    </a>
@endsection

@section('head')
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/blog.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-blog.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/blogs.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/blogs-comment-modal.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/profile-blogs.css') }}" />
@endsection
@section('content')
    <div class="blogs-section profile-blogs-section">
        <div class="profile-blogs-grid">
            @include('site.partials.blogs-results', [
                'blogs' => $blogs,
                'likedBlogIds' => $likedBlogIds ?? [],
                'search' => $search ?? '',
                'hideExcerpt' => true,
                'profileGrid' => true,
                'emptyTitle' => !empty($selectedCategory)
                    ? __('lang.There are no blogs available in the selected category.')
                    : __('lang.Profile no published blogs'),
                'emptyHint' => !empty($selectedCategory) ? null : __('lang.Profile published empty hint'),
            ])
        </div>
    </div>
@endsection

@section('script')
    <script>
        window.TFC_BLOG_COMMENTS = {
            readAllLabel: @json(__('lang.Read all comments')),
            noCommentsLabel: @json(__('lang.No comments yet')),
            commentLabel: @json(__('lang.Comment')),
            commentsLabel: @json(__('lang.Comments'))
        };
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $(document).on('click', '.emoji-toggle-btn', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var $panel = $(this).siblings('.emoji-panel');
                $('.emoji-panel').not($panel).hide();
                $panel.toggle();
            });

            $(document).on('click', function (e) {
                if (!$(e.target).closest('.emoji-picker-container').length) {
                    $('.emoji-panel').hide();
                }
            });

            $(document).on('click', '.emoji-btn', function (e) {
                e.preventDefault();
                var emoji = $(this).data('emoji');
                var $textarea = $(this).closest('.comment-modal__composer-box, .comment-textarea-wrap, .mb-3').find('textarea').first();
                if (!$textarea.length) {
                    return;
                }
                var cursorPos = $textarea[0].selectionStart;
                var textBefore = $textarea.val().substring(0, cursorPos);
                var textAfter = $textarea.val().substring(cursorPos);
                $textarea.val(textBefore + emoji + textAfter);
                var newCursorPos = cursorPos + emoji.length;
                $textarea[0].setSelectionRange(newCursorPos, newCursorPos);
                $textarea.focus();
                $('.emoji-panel').hide();
            });
        });
    </script>
@endsection
