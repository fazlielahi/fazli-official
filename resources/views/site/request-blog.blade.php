@extends('site.profile')

@section('title')
    {{ __('lang.Requested') }} | TFC
@endsection

@section('body_class', 'page-blogs')

@section('page_title')
    {{ __('lang.Requested') }}
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
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/blog.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/responsive-blog.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/blogs.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/profile-blogs.css') }}" />
@endsection

@section('content')
    <div class="blogs-section profile-blogs-section">
        <p class="profile-blogs-page__intro">{{ __('lang.Profile requested blogs intro') }}</p>
        <div class="profile-blogs-grid">
            @include('site.partials.profile-request-results', [
                'blogs' => $blogs,
                'user' => $user,
                'selectedCategory' => $selectedCategory ?? null,
            ])
        </div>
    </div>
@endsection
