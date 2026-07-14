@extends('site.profile')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/profile-overview.css') }}" />
@endsection

@section('content')
    @php
        $locale = app()->getLocale();
    @endphp

    <div class="profile-overview">
        @if($isNewUser)
            <div class="profile-overview__welcome"
                 id="profileWelcomeBanner"
                 data-user-id="{{ $user->id }}"
                 hidden>
                <button type="button"
                        class="profile-overview__welcome-close"
                        id="profileWelcomeClose"
                        aria-label="{{ __('lang.Close') }}">
                    <i class="fa-solid fa-times" aria-hidden="true"></i>
                </button>
                <h3>{{ __('lang.Welcome') }}, {{ $user->name }}!</h3>
                <p>{{ __('lang.Profile welcome new intro') }}</p>
            </div>

            <div class="profile-overview__welcome-toast"
                 id="profileWelcomeToast"
                 role="status"
                 aria-live="polite"
                 hidden>
                <span class="profile-overview__welcome-toast-text">{{ __('lang.Profile welcome dismissed') }}</span>
                <button type="button" class="profile-overview__welcome-toast-undo" id="profileWelcomeUndo">
                    {{ __('lang.Undo') }}
                </button>
                <button type="button"
                        class="profile-overview__welcome-toast-close"
                        id="profileWelcomeToastClose"
                        aria-label="{{ __('lang.Close') }}">
                    <i class="fa-solid fa-times" aria-hidden="true"></i>
                </button>
            </div>
        @endif

        <section class="profile-overview__card profile-overview__card--stretch">
            <div class="profile-overview__card-head">
                <h3>{{ __('lang.My Resumes') }}</h3>
            </div>

            @include('site.partials.profile-resume-gallery', ['recentCvs' => $recentCvs, 'locale' => $locale])

            <a href="{{ route('localized.resume.projects', ['lang' => $locale]) }}" class="profile-overview__view-all">
                    {{ __('lang.View all resumes') }} <i class="fa-solid fa-arrow-right"></i>
                </a>
        </section>

        <section class="profile-overview__card profile-overview__card--stretch">
            <div class="profile-overview__card-head">
                <h3>{{ __('lang.My Blogs') }}</h3>
                    <a href="{{ route('localized.blog-create', ['lang' => $locale, 'return' => url()->full()]) }}"
                       class="profile-overview__create-btn"
                       title="{{ __('lang.New Post') }}"
                       aria-label="{{ __('lang.Create Blog') }}">
                        <i class="fa-solid fa-plus"></i>
                    </a>
                </div>

                <div class="profile-overview__stats">
                    <a href="{{ route('localized.profile-published-blogs', ['lang' => $locale]) }}" class="profile-overview__stat">
                        <span class="profile-overview__stat-value">{{ $blogCounts['published'] }}</span>
                        <span class="profile-overview__stat-label">{{ __('lang.Published') }}</span>
                    </a>
                    <a href="{{ route('localized.profile-draft-blogs', ['lang' => $locale]) }}" class="profile-overview__stat">
                        <span class="profile-overview__stat-value">{{ $blogCounts['draft'] }}</span>
                        <span class="profile-overview__stat-label">{{ __('lang.Draft') }}</span>
                    </a>
                    <a href="{{ route('localized.profile-request-blogs', ['lang' => $locale]) }}" class="profile-overview__stat">
                        <span class="profile-overview__stat-value">{{ $blogCounts['request'] }}</span>
                        <span class="profile-overview__stat-label">{{ __('lang.Requested') }}</span>
                    </a>
                    <a href="{{ route('localized.profile-rejected-blogs', ['lang' => $locale]) }}" class="profile-overview__stat">
                        <span class="profile-overview__stat-value">{{ $blogCounts['rejected'] }}</span>
                        <span class="profile-overview__stat-label">{{ __('lang.Rejected') }}</span>
                    </a>
                </div>

                @if($isNewUser)
                    <div class="profile-overview__empty mt-3">
                        <i class="fa-solid fa-pen-nib d-block"></i>
                        <p class="mb-0">{{ __('lang.No blogs uploaded yet') }}</p>
                    </div>
                @endif

                <a href="{{ route('localized.profile-published-blogs', ['lang' => $locale]) }}" class="profile-overview__view-all profile-overview__view-all--plain">
                    {{ __('lang.View all blogs') }} <i class="fa-solid fa-arrow-right"></i>
                </a>
        </section>

        <section class="profile-overview__card">
            <div class="profile-overview__card-head">
                <h3>{{ __('lang.Tools') }}</h3>
            </div>
            <div class="profile-overview__tools">
                <a href="{{ route('localized.bulk-mail.index', ['lang' => $locale]) }}" class="profile-overview__tool profile-overview__tool--link">
                    <div class="profile-overview__tool-icon"><i class="fa-solid fa-envelope"></i></div>
                    <div class="profile-overview__tool-body">
                        <h5>{{ __('lang.Bulk Email Sender') }}</h5>
                        <p>{{ __('lang.Home bulk email description') }}</p>
                    </div>
                </a>
                <div class="profile-overview__tool profile-overview__tool--soon">
                    <div class="profile-overview__tool-icon"><i class="fa-solid fa-briefcase"></i></div>
                    <div class="profile-overview__tool-body">
                        <h5>{{ __('lang.Send Your CV') }}</h5>
                        <p>{{ __('lang.Home send cv card description') }}</p>
                        <span class="profile-overview__badge">{{ __('lang.Coming soon') }}</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    @if($isNewUser)
        <script src="{{ asset('js/profile-welcome.js') }}"></script>
    @endif
@endsection
