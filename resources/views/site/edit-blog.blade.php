@extends('site.profile')

@section('title')
    {{ __('lang.Edit Post') }} | TFC
@endsection

@section('body_class', 'page-blog-form')

@section('page_title')
    {{ __('lang.Edit Post') }}
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/profile-blog-form.css') }}" />
@endsection

@section('content')
    @php
        $thumbUrl = $blog->thumb && file_exists(public_path('storage/' . $blog->thumb))
            ? asset('storage/' . $blog->thumb)
            : null;
        $imageUrl = $blog->image && file_exists(public_path('storage/' . $blog->image))
            ? asset('storage/' . $blog->image)
            : null;
    @endphp

    <div class="profile-blog-form">
        <div class="profile-edit profile-blog-form__wrap">
            <div class="profile-edit__card">
                @include('site.partials.profile-blog-form-close', ['returnUrl' => $returnUrl])
                <p class="profile-edit__intro">{{ __('lang.Profile edit blog intro') }}</p>

                @if($errors->any())
                    <ul class="profile-edit__errors">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form
                    action="{{ route('localized.admin.blog.update', ['lang' => app()->getLocale(), 'id' => $blog->id]) }}"
                    method="post"
                    enctype="multipart/form-data"
                    id="profileBlogEditForm"
                    data-remove-thumb-msg="{{ __('lang.Profile image remove on save') }}"
                    data-remove-image-msg="{{ __('lang.Profile image remove on save') }}"
                >
                    @csrf
                    @method('PUT')

                    <div class="profile-blog-form__grid profile-blog-form__grid--2">
                        <div class="profile-edit__field">
                            <label class="profile-edit__label" for="title">{{ __('lang.Title') }}</label>
                            <input
                                type="text"
                                name="title"
                                id="title"
                                value="{{ old('title', $blog->title) }}"
                                class="profile-edit__input @error('title') is-invalid @enderror"
                                placeholder="{{ __('lang.Enter Blog title') }}"
                                required
                            />
                            @error('title')
                                <p class="profile-edit__field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="profile-edit__field">
                            <label class="profile-edit__label" for="category_id">{{ __('lang.Category') }}</label>
                            <select
                                name="category_id"
                                id="category_id"
                                class="profile-edit__input @error('category_id') is-invalid @enderror"
                                required
                            >
                                <option value="">{{ __('lang.Select Category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (int) old('category_id', $blog->category_id) === (int) $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="profile-edit__field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="profile-edit__field">
                            <label class="profile-edit__label" for="thumb">{{ __('lang.Change Thumbnail') }}</label>
                            <input
                                type="file"
                                name="thumb"
                                id="thumb"
                                class="profile-edit__input profile-blog-form__thumb-input @error('thumb') is-invalid @enderror"
                                accept="image/*"
                                data-invalid-msg="{{ __('lang.Please select a valid image file.') }}"
                                data-size-msg="{{ __('lang.File size must be less than 5MB.') }}"
                            />
                            <small class="profile-edit__hint">{{ __('lang.Dimensions: 600x340') }}</small>
                            @error('thumb')
                                <p class="profile-edit__field-error">{{ $message }}</p>
                            @enderror
                            <div class="profile-edit__preview" id="thumb-preview-container">
                                @if($thumbUrl)
                                    <div class="profile-edit__preview-wrap" data-existing-preview="thumb">
                                        <img src="{{ $thumbUrl }}" class="profile-edit__preview-img" alt="">
                                        <button type="button" class="profile-edit__preview-remove profile-blog-form__remove-existing" data-target="thumb" aria-label="{{ __('lang.Delete') }}">
                                            <i class="fa-solid fa-times" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="profile-edit__field">
                            <label class="profile-edit__label" for="image">{{ __('lang.Change Main Image') }}</label>
                            <input
                                type="file"
                                name="image"
                                id="image"
                                class="profile-edit__input profile-blog-form__image-input @error('image') is-invalid @enderror"
                                accept="image/*"
                                data-invalid-msg="{{ __('lang.Please select a valid image file.') }}"
                                data-size-msg="{{ __('lang.File size must be less than 5MB.') }}"
                            />
                            <small class="profile-edit__hint">{{ __('lang.Dimensions: 1920x500') }}</small>
                            @error('image')
                                <p class="profile-edit__field-error">{{ $message }}</p>
                            @enderror
                            <div class="profile-edit__preview" id="image-preview-container">
                                @if($imageUrl)
                                    <div class="profile-edit__preview-wrap" data-existing-preview="image">
                                        <img src="{{ $imageUrl }}" class="profile-edit__preview-img" alt="">
                                        <button type="button" class="profile-edit__preview-remove profile-blog-form__remove-existing" data-target="image" aria-label="{{ __('lang.Delete') }}">
                                            <i class="fa-solid fa-times" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="profile-edit__field">
                            <label class="profile-edit__label" for="status">{{ __('lang.Status') }}</label>
                            @if($blog->status === 'draft')
                                <select name="status" id="status" class="profile-edit__input @error('status') is-invalid @enderror">
                                    <option value="draft" {{ old('status', $blog->status) === 'draft' ? 'selected' : '' }}>{{ __('lang.Draft') }}</option>
                                    <option value="request" {{ old('status', $blog->status) === 'request' ? 'selected' : '' }}>{{ __('lang.Request for review') }}</option>
                                </select>
                            @elseif($blog->status === 'request')
                                <p class="profile-blog-form__alert profile-blog-form__alert--info">{{ __('lang.The blog has been requested for review!') }}</p>
                                <input type="hidden" name="status" value="request">
                            @elseif($blog->status === 'rejected')
                                <select name="status" id="status" class="profile-edit__input @error('status') is-invalid @enderror">
                                    <option value="rejected" {{ old('status', $blog->status) === 'rejected' ? 'selected' : '' }}>{{ __('lang.Keep as Rejected') }}</option>
                                    <option value="request" {{ old('status') === 'request' ? 'selected' : '' }}>{{ __('lang.Request for review') }}</option>
                                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>{{ __('lang.Draft') }}</option>
                                </select>
                            @elseif($blog->status === 'published')
                                <input type="hidden" name="status" value="published">
                                <p class="profile-edit__hint">{{ __('lang.Published') }}</p>
                            @endif
                            @error('status')
                                <p class="profile-edit__field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="profile-edit__field profile-edit__field--full">
                            <label class="profile-edit__label" for="content">{{ __('lang.Content') }}</label>
                            <textarea name="content" id="content" class="profile-edit__input @error('content') is-invalid @enderror" rows="4">{{ old('content', $blog->content) }}</textarea>
                            @error('content')
                                <p class="profile-edit__field-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="profile-blog-form__actions">
                        <a href="{{ $returnUrl }}" class="profile-blog-form__cancel">
                            {{ __('lang.Cancel') }}
                        </a>
                        <button type="submit" class="profile-edit__submit">
                            <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                            {{ __('lang.Update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script src="{{ asset('js/profile-blog-form.js') }}"></script>
    @php $locale = app()->getLocale(); @endphp
    <script>
        CKEDITOR.replace('content', {
            extraAllowedContent: 'img[width,height]{width,height}',
            removeFormatAttributes: '',
            image_prefillDimensions: true,
            allowedContent: true,
            filebrowserUploadUrl: "{{ route('localized.admin.ckeditor.upload', ['lang' => app()->getLocale()]) }}?_token={{ csrf_token() }}",
            filebrowserUploadMethod: 'xhr',
            contentsLangDirection: '{{ $locale === 'ar' ? 'rtl' : 'ltr' }}',
        });
    </script>
@endsection
