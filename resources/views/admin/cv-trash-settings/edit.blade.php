@extends('admin.layout')

@section('title', 'Trash retention')

@section('content')
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2>Trash retention</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('localized.admin.dashboard', ['lang' => app()->getLocale()]) }}"><i class="fa fa-dashboard"></i></a></li>
                        <li class="breadcrumb-item active">Trash retention</li>
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
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Resume Trash retention</h2>
                    </div>
                    <div class="body">
                        <p class="text-muted">Resumes in Trash will be permanently deleted after this many days.</p>

                        <form action="{{ route('localized.admin.cv-trash-settings.update', ['lang' => app()->getLocale()]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="trash_retention_days">Retention (days)</label>
                                <input
                                    type="number"
                                    class="form-control @error('trash_retention_days') is-invalid @enderror"
                                    id="trash_retention_days"
                                    name="trash_retention_days"
                                    min="1"
                                    max="365"
                                    value="{{ old('trash_retention_days', $days) }}"
                                    required
                                >
                                @error('trash_retention_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
