@extends('site.layout')

@section('body_class', 'page-bulk-mail')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />
    <link rel="stylesheet" href="{{ asset('cv/css/cv-templates.css') }}" />
    <link rel="stylesheet" href="{{ asset('cv/css/cv-side-menu.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/bulk-mail.css') }}" />
@endsection

@section('content')
    <div class="cv-gallery">
        <div class="container">
            <div class="cv-gallery__layout">
                @include('bulk-mail.partials.side-menu')

                <div class="templates-showcase bulk-mail-showcase">
                    @hasSection('page_title')
                        <div class="bulk-mail-showcase__header">
                            <h1 class="bulk-mail-showcase__title">@yield('page_title')</h1>
                            @hasSection('page_subtitle')
                                <p class="bulk-mail-showcase__subtitle">@yield('page_subtitle')</p>
                            @endif
                        </div>
                    @endif

                    <div class="bulk-mail-showcase__body">
                        @yield('bulk_mail_content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @yield('bulk_mail_script')
@endsection
