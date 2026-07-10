@extends('site.profile')

@section('body_class', 'page-blogs')

@section('page_title')
    {{ __('lang.Draft') }}
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
    <link rel="stylesheet" href="{{ asset('styles/profile-blogs.css') }}" />
@endsection

@section('content')
    <div class="blogs-section profile-blogs-section">
        <div class="profile-blogs-grid">
            @include('site.partials.profile-draft-results', [
                'blogs' => $blogs,
                'user' => $user,
                'selectedCategory' => $selectedCategory ?? null,
            ])
        </div>
    </div>
@endsection
