@extends('admin.layout')

@section('title', __('lang.ADMIN_SITE_SETTINGS'))

@section('content')
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2>{{ __('lang.ADMIN_SITE_SETTINGS') }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('localized.admin.dashboard', ['lang' => app()->getLocale()]) }}"><i class="fa fa-dashboard"></i></a></li>
                        <li class="breadcrumb-item active">{{ __('lang.ADMIN_SITE_SETTINGS') }}</li>
                    </ul>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row clearfix mt-3">
            <div class="col-lg-9 col-md-11 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>{{ __('lang.ADMIN_SITE_SETTINGS') }}</h2>
                    </div>
                    <div class="body">
                        <p class="text-muted mb-4">{{ __('lang.ADMIN_SITE_SETTINGS_DESC') }}</p>

                        <form action="{{ route('localized.admin.settings.update', ['lang' => app()->getLocale()]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <h5 class="mb-3">{{ __('lang.ADMIN_SETTINGS_AUTH_SECTION') }}</h5>

                            <div class="form-group">
                                <label for="session_lifetime_minutes">{{ __('lang.ADMIN_SESSION_LIFETIME') }}</label>
                                <input
                                    type="number"
                                    class="form-control @error('session_lifetime_minutes') is-invalid @enderror"
                                    id="session_lifetime_minutes"
                                    name="session_lifetime_minutes"
                                    min="5"
                                    max="10080"
                                    value="{{ old('session_lifetime_minutes', $settings['session_lifetime_minutes']) }}"
                                    required
                                >
                                <small class="form-text text-muted">{{ __('lang.ADMIN_SESSION_LIFETIME_HELP') }}</small>
                                @error('session_lifetime_minutes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="remember_me_days">{{ __('lang.ADMIN_REMEMBER_ME_DAYS') }}</label>
                                <input
                                    type="number"
                                    class="form-control @error('remember_me_days') is-invalid @enderror"
                                    id="remember_me_days"
                                    name="remember_me_days"
                                    min="1"
                                    max="365"
                                    value="{{ old('remember_me_days', $settings['remember_me_days']) }}"
                                    required
                                >
                                <small class="form-text text-muted">{{ __('lang.ADMIN_REMEMBER_ME_DAYS_HELP') }}</small>
                                @error('remember_me_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="session_expire_on_close"
                                        name="session_expire_on_close"
                                        value="1"
                                        {{ old('session_expire_on_close', $settings['session_expire_on_close']) ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="session_expire_on_close">{{ __('lang.ADMIN_SESSION_EXPIRE_ON_CLOSE') }}</label>
                                </div>
                                <small class="form-text text-muted">{{ __('lang.ADMIN_SESSION_EXPIRE_ON_CLOSE_HELP') }}</small>
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3">{{ __('lang.ADMIN_SETTINGS_CV_SECTION') }}</h5>

                            <div class="form-group">
                                <label for="trash_retention_days">{{ __('lang.ADMIN_CV_TRASH_RETENTION') }}</label>
                                <input
                                    type="number"
                                    class="form-control @error('trash_retention_days') is-invalid @enderror"
                                    id="trash_retention_days"
                                    name="trash_retention_days"
                                    min="1"
                                    max="365"
                                    value="{{ old('trash_retention_days', $settings['trash_retention_days']) }}"
                                    required
                                >
                                <small class="form-text text-muted">{{ __('lang.ADMIN_CV_TRASH_RETENTION_HELP') }}</small>
                                @error('trash_retention_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('lang.Save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
