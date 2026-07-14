@extends('bulk-mail.layout')

@section('title', __('lang.Bulk Email Sender') . ' - TFC')

@section('page_title', __('lang.Bulk Email Sender'))

@section('page_subtitle', __('lang.Bulk mail intro'))

@section('bulk_mail_content')
    @php
        $user = auth()->user();
    @endphp

    <div class="bulk-mail-dashboard">
        <section class="bulk-mail-dashboard__welcome"
                 id="bulkMailWelcomeBanner"
                 data-user-id="{{ $user->id }}"
                 hidden>
            <button type="button"
                    class="bulk-mail-dashboard__welcome-close"
                    id="bulkMailWelcomeClose"
                    aria-label="{{ __('lang.Close') }}">
                @include('cv.partials.svg-icon', ['name' => 'x-mark'])
            </button>
            <div class="bulk-mail-dashboard__welcome-icon" aria-hidden="true">
                @include('cv.partials.svg-icon', ['name' => 'envelope'])
            </div>
            <h2>{{ __('lang.Welcome') }}, {{ $user->name }}!</h2>
            <p>{{ __('lang.Bulk mail welcome hint') }}</p>
        </section>

        <div class="bulk-mail-dashboard__welcome-toast"
             id="bulkMailWelcomeToast"
             role="status"
             aria-live="polite"
             hidden>
            <span class="bulk-mail-dashboard__welcome-toast-text">{{ __('lang.Bulk mail welcome dismissed') }}</span>
            <button type="button" class="bulk-mail-dashboard__welcome-toast-undo" id="bulkMailWelcomeUndo">
                {{ __('lang.Undo') }}
            </button>
            <button type="button"
                    class="bulk-mail-dashboard__welcome-toast-close"
                    id="bulkMailWelcomeToastClose"
                    aria-label="{{ __('lang.Close') }}">
                @include('cv.partials.svg-icon', ['name' => 'x-mark'])
            </button>
        </div>

        <div class="bulk-mail-dashboard__grid">
            <article class="bulk-mail-dashboard__card">
                <div class="bulk-mail-dashboard__card-icon" aria-hidden="true">
                    @include('cv.partials.svg-icon', ['name' => 'envelope'])
                </div>
                <h3>{{ __('lang.Bulk mail verify sender') }}</h3>
                <p>{{ __('lang.Bulk mail verify sender desc') }}</p>
                <a href="{{ route('localized.bulk-mail.senders', ['lang' => $locale]) }}" class="bulk-mail-dashboard__card-link">
                    {{ __('lang.Bulk mail get started') }}
                    @include('cv.partials.svg-icon', ['name' => 'arrow-right'])
                </a>
            </article>

            <article class="bulk-mail-dashboard__card">
                <div class="bulk-mail-dashboard__card-icon" aria-hidden="true">
                    @include('cv.partials.svg-icon', ['name' => 'arrow-down-tray'])
                </div>
                <h3>{{ __('lang.Bulk mail import contacts') }}</h3>
                <p>{{ __('lang.Bulk mail import contacts desc') }}</p>
                <a href="{{ route('localized.bulk-mail.contacts', ['lang' => $locale]) }}" class="bulk-mail-dashboard__card-link">
                    {{ __('lang.Bulk mail manage contacts') }}
                    @include('cv.partials.svg-icon', ['name' => 'arrow-right'])
                </a>
            </article>

            <article class="bulk-mail-dashboard__card">
                <div class="bulk-mail-dashboard__card-icon" aria-hidden="true">
                    @include('cv.partials.svg-icon', ['name' => 'share'])
                </div>
                <h3>{{ __('lang.Bulk mail create campaign') }}</h3>
                <p>{{ __('lang.Bulk mail create campaign desc') }}</p>
                <a href="{{ route('localized.bulk-mail.campaigns', ['lang' => $locale]) }}" class="bulk-mail-dashboard__card-link">
                    {{ __('lang.Bulk mail new campaign') }}
                    @include('cv.partials.svg-icon', ['name' => 'arrow-right'])
                </a>
            </article>
        </div>
    </div>
@endsection

@section('bulk_mail_script')
    <script src="{{ asset('js/bulk-mail-welcome.js') }}"></script>
@endsection
